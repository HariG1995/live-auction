import './bootstrap';

import Alpine from 'alpinejs';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Alpine = Alpine;

Alpine.start();

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'mt1',
    wsHost: window.location.hostname,
    wsPort: 6001,
    forceTLS: false,
    disableStats: true,
    enabledTransports: ['ws', 'wss'],
    disableStats: true,
    authEndpoint: '/broadcasting/auth',
    auth: {
        headers: {
            'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').content,
        },
    },
});

if (window.Laravel?.userId) {
    window.Echo.private(`chat.user.${currentUserId}`)
    .listen('.new-message', (data) => {
        const isFromCurrentContact = data.message.sender_id === currentContact.id;
        const isToCurrentContact = data.message.receiver_id === currentContact.id;
        
        if (isFromCurrentContact || isToCurrentContact) {
            const messageEl = document.createElement('div');
            messageEl.style.marginBottom = '10px';
            messageEl.style.padding = '8px';
            messageEl.style.borderRadius = '4px';
            messageEl.style.backgroundColor = data.message.sender_id === currentUserId 
                ? '#e3f2fd' 
                : '#f1f1f1';
            messageEl.style.alignSelf = data.message.sender_id === currentUserId 
                ? 'flex-end' 
                : 'flex-start';
            
            messageEl.innerHTML = `
                <strong>${data.sender.name}:</strong> 
                ${data.message.message}
                <small class="text-muted d-block">
                    ${new Date(data.message.created_at).toLocaleTimeString()}
                </small>
            `;
            
            chatContent.appendChild(messageEl);
            chatContent.scrollTop = chatContent.scrollHeight;
            
            if (data.message.receiver_id === currentUserId) {
                markAsRead(data.message.id);
            }
        }
    });

    function markAsRead(messageId) {
        fetch(`/chat-messages/${messageId}/read`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
    }
}
