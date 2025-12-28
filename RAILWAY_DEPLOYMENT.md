# Railway Deployment Guide

## ✅ Configuration Complete

Your project is now configured for Railway deployment with automatic migrations.

## 📋 What's Configured

1. **nixpacks.toml** - Updated with:
   - PHP 8.2 extensions (including GD with system libraries)
   - Build commands (composer install, caching, etc.)
   - Start command

2. **railway.json** - Created with:
   - Release command that runs migrations automatically
   - Start command configuration
   - Restart policy

3. **Database Configuration** - Ready for Railway:
   - Uses `DATABASE_URL` environment variable (Railway provides this automatically)
   - Supports MySQL/PostgreSQL
   - All migrations have safety checks

3. **Migrations** - Fixed and ready:
   - All migrations check if tables exist before altering
   - Safe to run on fresh databases
   - Will run automatically during deployment

## 🚀 Deployment Steps

### 1. Connect Repository to Railway

1. Go to [Railway](https://railway.app)
2. Create a new project
3. Connect your GitHub/GitLab repository
4. Railway will detect `nixpacks.toml` automatically

### 2. Add Database Service

1. In your Railway project, click **"+ New"**
2. Select **"Database"** → **"Add MySQL"** (or PostgreSQL)
3. Railway will automatically:
   - Create the database
   - Set `DATABASE_URL` environment variable
   - Set `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`

### 3. Set Required Environment Variables

Go to your Railway service → **Variables** tab and add:

#### Application Settings
```
APP_NAME=YourAppName
APP_ENV=production
APP_KEY=base64:YOUR_APP_KEY_HERE
APP_DEBUG=false
APP_URL=https://your-app.railway.app
```

#### Database (Usually Auto-Set by Railway)
```
DB_CONNECTION=mysql
# Railway sets these automatically from DATABASE_URL:
# DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD
```

#### Cache & Sessions (Recommended for Production)
```
CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis
```

#### Redis (If using Railway Redis)
```
# Railway sets these automatically from REDIS_URL:
# REDIS_HOST, REDIS_PORT, REDIS_PASSWORD
```

#### Storage
```
FILESYSTEM_DISK=local
# OR for S3:
# FILESYSTEM_DISK=s3
# AWS_ACCESS_KEY_ID=your_key
# AWS_SECRET_ACCESS_KEY=your_secret
# AWS_DEFAULT_REGION=us-east-1
# AWS_BUCKET=your_bucket
```

#### Application-Specific (Based on your code)
```
PURCHASE_CODE=your_purchase_code
BUYER_USERNAME=your_username
SOFTWARE_ID=MzE0NDg1OTc=
SOFTWARE_VERSION=your_version
APP_MODE=live
SESSION_LIFETIME=60
```

#### Payment Gateways (If using)
```
PAYTM_ENVIRONMENT=production
PAYTM_MERCHANT_ID=your_id
# ... other payment gateway credentials
```

### 4. Deploy

Railway will automatically:
1. Build your application using `nixpacks.toml`
2. Run `composer install`
3. Generate app key (if not set)
4. Cache configuration, routes, and views
5. Create storage link
6. **Run migrations automatically** via release command (`php artisan migrate --force`)
7. Start your application

### 5. Verify Deployment

1. Check Railway deployment logs for:
   - ✅ "Running migrations" message
   - ✅ Migration success messages
   - ✅ Application started successfully

2. Visit your Railway app URL

3. Check database:
   - Tables should be created
   - Check `migrations` table to see which migrations ran

## 🔧 Manual Migration (If Needed)

If migrations don't run automatically, you can run them manually:

1. **Via Railway CLI:**
   ```bash
   railway run php artisan migrate --force
   ```

2. **Via Railway Dashboard:**
   - Go to your service → **Deployments**
   - Click on latest deployment → **View Logs**
   - Or use the **Shell** tab to run commands

## 📊 Migration Status

All migrations have been fixed with safety checks:
- ✅ Check if table exists before altering
- ✅ Check if column exists before adding/modifying
- ✅ Safe to run multiple times (idempotent)
- ✅ Won't fail if tables don't exist yet

## ⚠️ Important Notes

### Storage
Railway's filesystem is **ephemeral** (files are lost on restart). For file uploads:
- Use **AWS S3** or similar cloud storage, OR
- Use **Railway Volumes** for persistent storage

### Queue Workers
If your app uses queues, you may need:
- A separate service for queue workers, OR
- Use Railway's background services

### First Deployment
After first deployment:
- Migrations will run automatically
- If you have seeders, run them manually:
  ```bash
  railway run php artisan db:seed --force
  ```

### Custom Domain
1. Go to your Railway service → **Settings** → **Domains**
2. Add your custom domain
3. Update `APP_URL` environment variable

## 🐛 Troubleshooting

### Migrations Not Running
- Check Railway deployment logs
- Verify `DATABASE_URL` is set
- Run manually: `railway run php artisan migrate --force`

### Database Connection Errors
- Verify database service is running
- Check `DATABASE_URL` format
- Ensure database credentials are correct

### Missing Tables After Migration
- Check migration logs for errors
- Some migrations may skip if tables don't exist (by design)
- Run migrations manually to see detailed output

### Storage Issues
- Use S3 or Railway Volumes for persistent storage
- Check `storage` directory permissions

## 📝 Environment Variables Checklist

Before deploying, ensure these are set in Railway:

- [ ] `APP_NAME`
- [ ] `APP_ENV=production`
- [ ] `APP_KEY` (or let it auto-generate)
- [ ] `APP_DEBUG=false`
- [ ] `APP_URL` (your Railway domain)
- [ ] Database credentials (auto-set by Railway)
- [ ] `CACHE_DRIVER` (redis recommended)
- [ ] `SESSION_DRIVER` (redis recommended)
- [ ] Redis credentials (if using)
- [ ] Storage configuration
- [ ] Payment gateway credentials (if using)
- [ ] Email/SMS service credentials (if using)
- [ ] Application-specific variables (PURCHASE_CODE, etc.)

## ✅ Ready to Deploy!

Your project is now ready for Railway deployment. Just:
1. Push your code to GitHub/GitLab
2. Connect to Railway
3. Add database service
4. Set environment variables
5. Deploy!

Migrations will run automatically during deployment. 🚀

