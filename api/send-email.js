// Google SMTP Email Service
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

    // Google SMTP configuration
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
        <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px;">
          <h2 style="color: #333; border-bottom: 2px solid #007bff; padding-bottom: 10px;">
            New Contact Form Submission
          </h2>
          <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin: 20px 0;">
            <p style="margin: 10px 0;"><strong style="color: #495057;">Name:</strong> ${name}</p>
            <p style="margin: 10px 0;"><strong style="color: #495057;">Email:</strong> ${email}</p>
            ${phone ? `<p style="margin: 10px 0;"><strong style="color: #495057;">Phone:</strong> ${phone}</p>` : ''}
          </div>
          <div style="background: white; padding: 20px; border-radius: 8px; border-left: 4px solid #007bff; margin: 20px 0;">
            <h3 style="color: #333; margin-top: 0;">Message:</h3>
            <p style="line-height: 1.6; color: #333;">${message.replace(/\n/g, '<br/>')}</p>
          </div>
          <hr style="border: none; border-top: 1px solid #dee2e6; margin: 30px 0;">
          <p style="color: #6c757d; font-size: 12px; text-align: center; margin: 0;">
            Sent from Freelancer IT & Networking Services contact form
          </p>
        </div>
      `
    });

    return res.status(200).json({ 
      ok: true, 
      messageId: info.messageId,
      message: 'Email sent successfully to ccr1036user@gmail.com'
    });

  } catch (error) {
    console.error('SMTP error:', error);
    return res.status(500).json({ 
      error: 'Failed to send email',
      details: error.message 
    });
  }
}
