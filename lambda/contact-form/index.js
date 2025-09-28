const nodemailer = require('nodemailer');

exports.handler = async (event, context) => {
  // Enable CORS
  const headers = {
    'Access-Control-Allow-Origin': '*',
    'Access-Control-Allow-Headers': 'Content-Type',
    'Access-Control-Allow-Methods': 'POST, OPTIONS'
  };

  // Handle preflight requests
  if (event.httpMethod === 'OPTIONS') {
    return {
      statusCode: 200,
      headers,
      body: ''
    };
  }

  // Only allow POST requests
  if (event.httpMethod !== 'POST') {
    return {
      statusCode: 405,
      headers,
      body: JSON.stringify({ error: 'Method not allowed' })
    };
  }

  try {
    const { name, email, message, phone } = JSON.parse(event.body);
    
    if (!name || !email || !message) {
      return {
        statusCode: 400,
        headers,
        body: JSON.stringify({ error: 'Missing required fields: name, email, message' })
      };
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

    return {
      statusCode: 200,
      headers,
      body: JSON.stringify({ 
        ok: true, 
        messageId: info.messageId,
        message: 'Email sent successfully'
      })
    };

  } catch (error) {
    console.error('Contact form error:', error);
    return {
      statusCode: 500,
      headers,
      body: JSON.stringify({ 
        error: 'Failed to send message',
        details: error.message 
      })
    };
  }
};
