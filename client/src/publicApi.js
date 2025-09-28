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
  // For production, use a mailto link as fallback
  if (!import.meta.env.DEV) {
    const { name, email, message } = payload;
    const subject = encodeURIComponent(`Contact from ${name}`);
    const body = encodeURIComponent(`Name: ${name}\nEmail: ${email}\n\nMessage:\n${message}`);
    const mailtoLink = `mailto:ccr1036user@gmail.com?subject=${subject}&body=${body}`;
    
    // Open mailto link
    window.open(mailtoLink);
    
    return { ok: true, note: 'Email client opened. Please send the email manually.' };
  }

  // For development, use the local API
  const res = await fetch(`${API}/contact`, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(payload || {}),
  });
  if (!res.ok) throw new Error((await res.json()).error || 'Failed to send message');
  return res.json();
}
