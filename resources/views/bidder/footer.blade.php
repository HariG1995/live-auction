        <footer>
            <p class="text-muted mb-0">&copy; 2025 BidNow Auctions.</p>
        </footer>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>

@auth
    <div id="chat-widget">
        <button id="chat-toggle">
            <i class="fas fa-comments"></i>
        </button>
        
        <div id="chat-container">
            <div id="live-support">
                <h5 style="margin: 0;">Live Support</h5>
                <button id="chat-close">×</button>
            </div>
            <div id="chat-content"></div>
            <div style="padding: 10px; border-top: 1px solid #eee;">
                <input type="text" id="chat-message" placeholder="Type your message...">
                <button id="chat-send">Send</button>
            </div>
        </div>
    </div>
@endauth

<script>
    const currentUserId = {{ auth()->id() }};
</script>

@vite('resources/js/app.js')

<script>
document.addEventListener('DOMContentLoaded', function() {
    const chatToggle = document.getElementById('chat-toggle');
    const chatContainer = document.getElementById('chat-container');
    const chatClose = document.getElementById('chat-close');
    const chatContent = document.getElementById('chat-content');
    const chatMessage = document.getElementById('chat-message');
    const chatSend = document.getElementById('chat-send');
    
    let currentContact = null;

    if (chatToggle) {
        chatToggle.addEventListener('click', function() {
            chatContainer.style.display = chatContainer.style.display === 'none' ? 'block' : 'none';

            if (chatContainer.style.display === 'block') {
                loadContacts();
            }
        });

        chatClose.addEventListener('click', function() {
            chatContainer.style.display = 'none';
        });

        function loadContacts() {
            fetch('chat-contacts')
                .then(response => response.json())
                .then(contacts => {
                    chatContent.innerHTML = '<h6>Select a contact:</h6>';
                    contacts.forEach(contact => {
                        const contactEl = document.createElement('div');
                        contactEl.style.padding = '8px';
                        contactEl.style.borderBottom = '1px solid #eee';
                        contactEl.style.cursor = 'pointer';
                        contactEl.textContent = contact.name;
                        contactEl.addEventListener('click', () => {
                            currentContact = contact;
                            loadMessages(contact.id);
                        });
                        chatContent.appendChild(contactEl);
                    });
                });
        }

        function loadMessages(contactId) {
            fetch(`/chat-messages/${contactId}`)
                .then(response => response.json())
                .then(messages => {
                    chatContent.innerHTML = '';
                    messages.forEach(message => {
                        const messageEl = document.createElement('div');
                        messageEl.innerHTML = `
                            <strong>${message.sender.name}:</strong> 
                            ${message.message}
                            <small class="text-muted d-block">
                                ${new Date(message.created_at).toLocaleTimeString()}
                            </small>
                        `;
                        chatContent.appendChild(messageEl);
                    });
                    chatContent.scrollTop = chatContent.scrollHeight;
                    
                    if (messages.length > 0) {
                        const unreadIds = messages
                            .filter(m => !m.read && m.receiver_id === currentUserId)
                            .map(m => m.id);
                        
                        if (unreadIds.length > 0) {
                            fetch('/chat-messages/mark-read', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                },
                                body: JSON.stringify({message_ids: unreadIds})
                            });
                        }
                    }
                });
        }

        chatSend.addEventListener('click', function() {
            if (!currentContact || !chatMessage.value.trim()) return;
            
            fetch('/chat-send', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    receiver_id: currentContact.id,
                    message: chatMessage.value
                })
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => { throw err; });
                }
                return response.json();
            })
            .then(data => {
                if(data.status === 'success') {
                    chatMessage.value = '';
                    const messageEl = document.createElement('div');
                    messageEl.innerHTML = `
                        <strong>You:</strong> ${data.message.message}
                    `;
                    chatContent.appendChild(messageEl);
                    chatContent.scrollTop = chatContent.scrollHeight;
                } else {
                    alert('Error: ' + (data.error || data.message));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to send message. Please try again.');
            });
        });
    }
});
</script>