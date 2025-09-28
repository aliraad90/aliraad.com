// Vercel serverless function for contact form
// Deploy this to Vercel or Netlify for automatic email sending

const nodemailer = require('nodemailer');

export default async function handler(req, res) {
  // Enable CORS
  res.setHeader('Access-Control-Allow-Origin', '*');
  res.setHeader('Access-Control-Allow-Methods', 'POST, OPTIONS');
  res.setHeader('Access-Control-Allow-Headers', 'Content-Type');

  // Handle preflight requests
  if (req.method === 'OPTIONS') {
    return res.status(200).end();
  }

  // Only allow POST requests
  if (req.method !== 'POST') {
    return res.status(405).json({ error: 'Method not allowed' });
  }

  try {
    const { name, email, message, phone } = req.body;
    
    if (!name || !email || !message) {
      return res.status(400).json({ 
        error: 'Missing required fields: name, email, message' 
      });
    }

    // SMTP configuration for Gmail
    const transporter = nodemailer.createTransporter({
      host: 'smtp.gmail.com',
      port: 587,
      secure: false,
      auth: {
        user: 'ccr1036user@gmail.com',
        pass: 'lrlujohozskfaeek'
      }
    });

    // Verify SMTP connection
    await transporter.verify();

    const emailBody = `
New contact form submission from your website:

Name: ${name}
Email: ${email}
${phone ? `Phone: ${phone}` : ''}

Message:
${message}

---
Sent from Freelancer IT & Networking Services contact form
    `;

    const info = await transporter.sendMail({
      from: 'ccr1036user@gmail.com',
      to: 'ccr1036user@gmail.com',
      subject: `New contact from ${name}`,
      replyTo: email,
      text: emailBody,
      html: `
        <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;">
          <h2 style="color: #333;">New Contact Form Submission</h2>
          <div style="background: #f5f5f5; padding: 20px; border-radius: 5px;">
            <p><strong>Name:</strong> ${name}</p>
            <p><strong>Email:</strong> ${email}</p>
            ${phone ? `<p><strong>Phone:</strong> ${phone}</p>` : ''}
            <p><strong>Message:</strong></p>
            <div style="background: white; padding: 15px; border-radius: 3px; border-left: 4px solid #007bff;">
              ${message.replace(/\n/g, '<br/>')}
            </div>
          </div>
          <hr style="margin: 20px 0;">
          <p style="color: #666; font-size: 12px;">
            Sent from Freelancer IT & Networking Services contact form
          </p>
        </div>
      `
    });

    return res.status(200).json({ 
      ok: true, 
      messageId: info.messageId,
      message: 'Email sent successfully'
    });

  } catch (error) {
    console.error('Contact form error:', error);
    return res.status(500).json({ 
      error: 'Failed to send message',
      details: error.message 
    });
  }
}
