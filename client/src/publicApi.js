const API = import.meta.env.DEV 
  ? '/api/public' 
  : 'https://api.amplifyapp.com'; // Use Amplify backend for production

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

  // For production, use Amplify backend API
  try {
    const res = await fetch(`${API}/contactForm`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(payload || {}),
    });
    
    if (!res.ok) {
      const errorData = await res.json();
      throw new Error(errorData.error || 'Failed to send message');
    }
    
    const result = await res.json();
    return { ok: true, message: result.message || 'Email sent successfully' };
    
  } catch (error) {
    console.error('API error:', error);
    
    // Fallback to mailto if API fails
    const { name, email, message } = payload;
    const subject = encodeURIComponent(`Contact from ${name}`);
    const body = encodeURIComponent(`Name: ${name}\nEmail: ${email}\n\nMessage:\n${message}`);
    const mailtoLink = `mailto:ccr1036user@gmail.com?subject=${subject}&body=${body}`;
    
    // Open mailto link
    window.location.href = mailtoLink;
    
    return { ok: true, note: 'API unavailable, email client opened instead.' };
  }
}
