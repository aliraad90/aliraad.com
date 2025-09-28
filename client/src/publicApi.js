const API = import.meta.env.DEV 
  ? '/api/public' 
  : 'https://your-lambda-url.amazonaws.com'; // Will be updated with actual Lambda URL

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

  // For production, use EmailJS (easier to set up)
  try {
    const emailjs = await import('@emailjs/browser');
    
    // EmailJS configuration - you can get these from emailjs.com
    const serviceId = 'service_freelancer'; // Replace with your EmailJS service ID
    const templateId = 'template_contact'; // Replace with your EmailJS template ID
    const publicKey = 'your_public_key'; // Replace with your EmailJS public key
    
    const result = await emailjs.send(
      serviceId,
      templateId,
      {
        from_name: payload.name,
        from_email: payload.email,
        from_phone: payload.phone || '',
        message: payload.message,
        to_email: 'ccr1036user@gmail.com'
      },
      publicKey
    );
    
    return { ok: true, messageId: result.text, message: 'Email sent successfully' };
    
  } catch (error) {
    console.error('EmailJS error:', error);
    
    // Fallback to mailto if EmailJS fails
    const { name, email, message } = payload;
    const subject = encodeURIComponent(`Contact from ${name}`);
    const body = encodeURIComponent(`Name: ${name}\nEmail: ${email}\n\nMessage:\n${message}`);
    const mailtoLink = `mailto:ccr1036user@gmail.com?subject=${subject}&body=${body}`;
    
    // Open mailto link
    window.location.href = mailtoLink;
    
    return { ok: true, note: 'EmailJS not configured, email client opened instead.' };
  }
}
