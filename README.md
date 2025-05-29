Laravel Live Auction Bid Platform

This is a real-time Live Auction Bid Platform built with Laravel. The platform supports two user roles: Admin and Bidder. Both users share a common login page, and the system redirects them based on their role.

👥 User Roles
- Admin
- BIdder

🎯 Bidding System

- Admin creates auction products with specific bidding start and end times.
- On the public site, auction products are displayed based on their start time.
- Products appear automatically every 30 seconds without reloading the page.
- Only logged-in users can participate in bidding.
- Bids from different users are updated every 5 seconds dynamically.
- Each product has a live countdown timer until bidding ends.

💬 Real-Time Chat (WebSocket)

- Integrated WebSocket-based chat system for live communication during auctions.
- Only available to authenticated users.

🔐 Admin Credentials

Email: admin@gmail.com  
Password: password

🛠️ Tech Stack

- Laravel – Backend framework
- MySQL – Database
- WebSocket – Real-time communication
- AJAX / JavaScript – Dynamic content updates

🔍 Check the 'My DB' folder in the project root to find the Database file.
