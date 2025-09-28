// Simple serverless function for contact form
// Can be deployed to Vercel, Netlify, or AWS Lambda

const nodemailer = require('nodemailer');

module.exports = async (req, res) => {
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

    // SMTP configuration
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
New contact form submission:

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
        <h3>New contact form submission</h3>
        <p><strong>Name:</strong> ${name}</p>
        <p><strong>Email:</strong> ${email}</p>
        ${phone ? `<p><strong>Phone:</strong> ${phone}</p>` : ''}
        <p><strong>Message:</strong></p>
        <p>${message.replace(/\n/g, '<br/>')}</p>
        <hr>
        <p><em>Sent from Freelancer IT & Networking Services contact form</em></p>
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
};
