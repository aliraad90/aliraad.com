const API = import.meta.env.DEV 
  ? '/api/public' 
  : '/.netlify/functions'; // Use Netlify functions for production

export async function getPlans() {
  const res = await fetch(`${API}/plans`);
  if (!res.ok) throw new Error('Failed to load plans');
  return res.json();
}

export async function createCheckout(payload) {
  const res = await fetch(`${API}/checkout`, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(payload || {}),
  });
  if (!res.ok) throw new Error((await res.json()).error || 'Checkout failed');
  return res.json();
}

export async function sendContact(payload) {
  // For development, use the local API
  if (import.meta.env.DEV) {
    const res = await fetch(`${API}/contact`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(payload || {}),
    });
    if (!res.ok) throw new Error((await res.json()).error || 'Failed to send message');
    return res.json();
  }

  // For production, create a better user experience
  const { name, email, message } = payload;
  
  // Show user-friendly message first
  const userMessage = `Thank you for your message, ${name}! 
  
Your message has been prepared. Please choose how you'd like to send it:

1. Click "Open Email" to open your email client
2. Or copy the message below and send it manually to: ccr1036user@gmail.com

Your Message:
From: ${name} (${email})
Message: ${message}`;

  // Show the message to the user
  alert(userMessage);
  
  // Then open the email client
  const subject = encodeURIComponent(`Contact from ${name}`);
  const body = encodeURIComponent(`Name: ${name}\nEmail: ${email}\n\nMessage:\n${message}`);
  const mailtoLink = `mailto:ccr1036user@gmail.com?subject=${subject}&body=${body}`;
  
  // Open mailto link
  window.location.href = mailtoLink;
  
  return { ok: true, note: 'Email client opened with your message ready to send.' };
}
