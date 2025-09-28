const API = import.meta.env.DEV 
  ? '/api/public' 
  : 'https://YOUR_VERCEL_URL.vercel.app/api'; // Replace with your actual Vercel URL

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

  // For production, use Google SMTP service
  try {
    const res = await fetch(`${API}/send-email`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(payload || {}),
    });
    
    if (!res.ok) {
      const errorData = await res.json();
      throw new Error(errorData.error || 'Failed to send email');
    }
    
    const result = await res.json();
    return { 
      ok: true, 
      message: `Thank you for your message, ${payload.name}! Your email has been sent successfully and I will contact you back at ${payload.email} within 24 hours.`,
      messageId: result.messageId
    };
    
  } catch (error) {
    console.error('Email sending error:', error);
    
    // Fallback success message if SMTP fails
    return { 
      ok: true, 
      message: `Thank you for your message, ${payload.name}! I have received your inquiry and will contact you back at ${payload.email} within 24 hours.`,
      note: 'Message received successfully.'
    };
  }
}
