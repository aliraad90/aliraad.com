# Freelancer IT & Networking Services

This is Ali Raad's professional website offering IT and networking services with contact form functionality.

- Backend: Node.js (Express) + MongoDB (Mongoose)
- Frontend: React (Vite)
- Email: SMTP contact form functionality with Gmail integration

## Features
- Professional IT & Networking Services showcase
- Contact form with SMTP email delivery
- Portfolio and certifications display
- Services and pricing information
- Responsive design
- Admin dashboard for content management

## Prerequisites
- Node.js 18+
- MongoDB 6+
- Gmail account for SMTP email functionality

## Setup

1) Backend env

Create `server/.env` (copy from `.env.example`):

```
PORT=4000
JWT_SECRET=change_me
MONGODB_URI=mongodb://localhost:27017/vpn_mvp

# MikroTik CHR (RouterOS) connection
MIKROTIK_HOST=1.2.3.4
MIKROTIK_PORT=22
MIKROTIK_USERNAME=admin
MIKROTIK_PASSWORD=your_router_password
MIKROTIK_PPP_SERVICE=l2tp
MIKROTIK_PPP_PROFILE=default-encryption
```

2) Install deps

Backend:
```
cd server
npm install
```

Frontend:
```
cd client
npm install
```

3) Seed admin user
```
cd server
npm run seed
```
This creates tables and a default admin:
- email: admin@example.com
- password: admin123

4) Run services

Backend:
```
cd server
npm run dev
```

Frontend:
```
cd client
npm run dev
```

5) Login and test
- Open the frontend URL printed by Vite (usually http://localhost:5173)
- Login as Admin
- Create a company
- Download company config from Company dashboard
- View connected clients in Status

## Notes
- If MikroTik env vars are missing, the app uses a mock and returns sample data. Set env vars to activate real SSH integration.
- Storing VPN passwords in plaintext is for MVP only. Replace with a KMS or one-time download flow later.
- Subscription expiry is manual (admin sets `expires_at`); expired companies cannot login.
