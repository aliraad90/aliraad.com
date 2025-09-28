import 'dotenv/config';
import express from 'express';
import cors from 'cors';
import helmet from 'helmet';
import morgan from 'morgan';
import { connectDB, closeDB } from './lib/db.js';
import authRoutes from './routes/auth.js';
import companyRoutes from './routes/companies.js';
import statusRoutes from './routes/status.js';
import publicRoutes from './routes/public.js';

const app = express();
app.set('trust proxy', 1);
// Helmet: relaxed CSP in development; strict defaults in production
if (process.env.NODE_ENV !== 'production') {
  app.use(helmet({
    contentSecurityPolicy: {
      useDefaults: true,
      directives: {
        "default-src": ["'self'"],
        "connect-src": [
          "'self'",
          "http://localhost:5173",
          "http://localhost:4000",
          "ws:",
          "wss:"
        ],
        "img-src": ["'self'", "data:", "blob:"],
        "font-src": ["'self'", "https://fonts.gstatic.com", "data:"],
        "style-src": ["'self'", "'unsafe-inline'", "https://fonts.googleapis.com"],
        "script-src": ["'self'"]
      }
    }
  }));
} else {
  app.use(helmet());
}
// CORS: In production, restrict to ALLOWED_ORIGINS (comma-separated). In dev, allow all.
const allowedOrigins = (process.env.ALLOWED_ORIGINS || '')
  .split(',')
  .map((s) => s.trim())
  .filter(Boolean);

app.use(
  cors({
    origin: (origin, cb) => {
      if (process.env.NODE_ENV !== 'production') return cb(null, true);
      if (!origin) return cb(null, true); // allow non-browser clients
      const ok = allowedOrigins.length === 0 || allowedOrigins.includes(origin);
      return cb(ok ? null : new Error('Not allowed by CORS'), ok);
    },
    credentials: true,
  })
);
app.use(express.json({ limit: '1mb' }));
app.use(morgan('dev'));

// Friendly root route to avoid 404s at /
app.get('/', (req, res) => {
  res.type('text').send('Freelancer IT & Networking Services API is running. Try GET /api/health');
});

app.get('/api/health', async (req, res) => {
  try {
    res.json({ ok: true });
  } catch (e) {
    res.status(500).json({ ok: false, error: e.message });
  }
});

app.use('/api/auth', authRoutes);
app.use('/api/companies', companyRoutes);
app.use('/api/status', statusRoutes);
app.use('/api/public', publicRoutes);

const PORT = process.env.PORT || 4000;

async function start() {
  await connectDB();
  const server = app.listen(PORT, () => {
    console.log(`API listening on http://localhost:${PORT}`);
  });

  // Graceful shutdown
  const shutdown = async (signal) => {
    try {
      console.log(`\nReceived ${signal}. Shutting down gracefully...`);
      await closeDB();
      server.close(() => {
        console.log('HTTP server closed');
        process.exit(0);
      });
      // Fallback exit if close hangs
      setTimeout(() => {
        console.warn('Force exiting after timeout');
        process.exit(1);
      }, 10000).unref();
    } catch (e) {
      console.error('Error during shutdown:', e);
      process.exit(1);
    }
  };

  process.on('SIGINT', () => shutdown('SIGINT'));
  process.on('SIGTERM', () => shutdown('SIGTERM'));

  return server;
}

// Only start server if not running in serverless environment
if (process.env.NODE_ENV !== 'production' || !process.env.AWS_LAMBDA_FUNCTION_NAME) {
  start().catch((e) => {
    console.error('Failed to start server:', e);
    process.exit(1);
  });
}

export default app;

// 404 handler (after routes)
app.use((req, res, next) => {
  res.status(404).json({ error: 'Not Found' });
});

// Centralized error handler
// eslint-disable-next-line no-unused-vars
app.use((err, req, res, next) => {
  console.error('Unhandled error:', err);
  const status = err.status || 500;
  res.status(status).json({ error: err.message || 'Internal Server Error' });
});

// Global process-level handlers
process.on('unhandledRejection', (reason) => {
  console.error('Unhandled Rejection:', reason);
});
process.on('uncaughtException', (err) => {
  console.error('Uncaught Exception:', err);
});
