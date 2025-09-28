# Google SMTP Setup Guide

## 🚀 Automatic Email Sending with Google SMTP

Your contact form is now configured to automatically send emails using Google SMTP to `ccr1036user@gmail.com`.

## 📧 How It Works

1. **User fills contact form** → Clicks Send
2. **Email sent automatically** → Via Google SMTP
3. **Success message shown** → "Email sent successfully"
4. **No external apps** → Seamless experience

## 🔧 Deployment Options

### Option 1: Vercel (Recommended - 2 minutes)
1. Go to [vercel.com](https://vercel.com)
2. Import your GitHub repository
3. Vercel will automatically deploy the `api/send-email.js` function
4. Your contact form will work immediately

### Option 2: Netlify Functions
1. Go to [netlify.com](https://netlify.com)
2. Connect your GitHub repository
3. Deploy with Netlify Functions
4. Contact form will work automatically

### Option 3: AWS Lambda
1. Upload the `api/send-email.js` file to AWS Lambda
2. Add nodemailer dependency
3. Update the API URL in frontend

## 📋 Current Configuration

**SMTP Settings:**
- **Host**: smtp.gmail.com
- **Port**: 587
- **User**: ccr1036user@gmail.com
- **Password**: lrlujohozskfaeek (app password)
- **Recipient**: ccr1036user@gmail.com

## 🎯 What Happens When Someone Contacts You

1. **Email Subject**: "New contact from [Name]"
2. **Email Content**: 
   - Name, email, phone (if provided)
   - Full message
   - Professional HTML formatting
3. **Reply-To**: Set to the sender's email for easy replies

## ✅ Benefits

- ✅ **Automatic email sending**
- ✅ **No external apps required**
- ✅ **Professional email formatting**
- ✅ **Easy to reply to customers**
- ✅ **Reliable Google SMTP service**

## 🔍 Testing

After deployment, test the contact form:
1. Fill out the form
2. Click Send
3. Check `ccr1036user@gmail.com` inbox
4. You should receive the email automatically

## 📞 Support

If you need help with deployment, the service is ready to use with any serverless platform that supports Node.js.
