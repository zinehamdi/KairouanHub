# KairouanHub Deployment Guide - Hostinger

## 📋 Pre-Deployment Checklist

- [ ] All features tested locally
- [ ] CSS compiled (`npm run build`)
- [ ] Database migrations tested
- [ ] `.env` configured for production
- [ ] Git repository up to date

---

## 🚀 Step 1: Push to GitHub

```bash
# Navigate to project
cd /Users/zinehamdi/Sites/localhost/kairouanhubNV

# Check current status
git status

# Add all changes
git add .

# Commit changes
git commit -m "feat: Admin provider management, navbar redesign, floating buttons, chatbot improvements"

# Push to GitHub
git push origin main
```

---

## 🌐 Step 2: Hostinger Setup

### 2.1 Create Database

1. Log in to Hostinger hPanel
2. Go to **Databases** → **MySQL Databases**
3. Click **Create New Database**
4. Database Name: `u123456789_kairouanhub` (example)
5. Username: `u123456789_admin` (example)
6. Password: Generate strong password
7. **Save credentials securely!**

### 2.2 Access File Manager or SSH

**Option A: File Manager (Easier)**
1. Go to **Files** → **File Manager**
2. Navigate to `public_html` folder
3. Delete default files if needed

**Option B: SSH (Recommended for Laravel)**
1. Enable SSH in hPanel: **Advanced** → **SSH Access**
2. Connect via terminal:
   ```bash
   ssh u123456789@yourdomain.com
   ```

---

## 📦 Step 3: Upload Laravel Project

### Via Git (Recommended)

```bash
# SSH into your server
ssh u123456789@yourdomain.com

# Navigate to home directory
cd ~

# Clone repository
git clone https://github.com/zinehamdi/KairouanHub.git kairouanhub

# Move to public_html (adjust path based on your setup)
# Option 1: Entire project in public_html
mv kairouanhub/* public_html/

# Option 2: Project outside public_html (more secure)
# Keep project in ~/kairouanhub
# Create symlink for public folder
ln -s ~/kairouanhub/public ~/public_html
```

### Directory Structure (Recommended)

```
/home/u123456789/
├── kairouanhub/              # Laravel root (private)
│   ├── app/
│   ├── bootstrap/
│   ├── config/
│   ├── database/
│   ├── public/               # Public files
│   ├── resources/
│   ├── routes/
│   ├── storage/
│   ├── vendor/
│   ├── .env
│   └── artisan
└── public_html/              # Web root (symlink to kairouanhub/public)
    └── index.php → ../kairouanhub/public/index.php
```

---

## ⚙️ Step 4: Configure Environment

### 4.1 Create .env File

```bash
cd ~/kairouanhub  # or your project path
cp .env.example .env
nano .env
```

### 4.2 Update .env Values

```env
APP_NAME=KairouanHub
APP_ENV=production
APP_KEY=  # Will generate in next step
APP_DEBUG=false
APP_TIMEZONE=Africa/Tunis
APP_URL=https://yourdomain.com

# Database
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=u123456789_kairouanhub
DB_USERNAME=u123456789_admin
DB_PASSWORD=your_secure_password

# Logging
LOG_CHANNEL=daily
LOG_LEVEL=error

# OpenAI
OPENAI_API_KEY=your_actual_openai_key
OPENAI_MODEL=gpt-4o-mini

# Session
SESSION_DRIVER=database
SESSION_LIFETIME=120

# Cache
CACHE_STORE=database

# Queue
QUEUE_CONNECTION=database

# Mail (configure based on your email provider)
MAIL_MAILER=smtp
MAIL_HOST=smtp.hostinger.com
MAIL_PORT=587
MAIL_USERNAME=noreply@yourdomain.com
MAIL_PASSWORD=your_email_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="${APP_NAME}"
```

Save and exit (`Ctrl+X`, then `Y`, then `Enter`)

---

## 🔧 Step 5: Install Dependencies

```bash
# Navigate to project
cd ~/kairouanhub

# Install Composer dependencies (production only)
composer install --optimize-autoloader --no-dev

# Generate application key
php artisan key:generate

# Set proper permissions
chmod -R 755 storage bootstrap/cache
chown -R $USER:$USER storage bootstrap/cache
```

---

## 🗄️ Step 6: Database Migration

```bash
# Run migrations
php artisan migrate --force

# Seed database (categories, services, admin user)
php artisan db:seed --force

# OR run migration with seed in one command
php artisan migrate:fresh --seed --force
```

**Default Admin Credentials:**
- Email: `admin@example.com`
- Password: `password`

**⚠️ IMPORTANT:** Change admin password immediately after first login!

---

## 🎨 Step 7: Compile Assets

If you have Node.js on server:

```bash
# Install npm dependencies
npm install

# Build production assets
npm run build

# Clean up (optional)
rm -rf node_modules
```

If Node.js not available, ensure `public/build/` folder from local is uploaded.

---

## 🚀 Step 8: Optimize Laravel

```bash
# Cache configuration
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache

# Optimize autoloader
composer dump-autoload --optimize
```

---

## 🔒 Step 9: Security Configuration

### 9.1 Update .htaccess (if in subdirectory)

If project is in `public_html/kairouanhub`:

```apache
# public_html/.htaccess
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ kairouanhub/public/$1 [L]
</IfModule>
```

### 9.2 Protect Sensitive Files

Create `.htaccess` in root:

```apache
# ~/kairouanhub/.htaccess
<FilesMatch "^\.">
    Order allow,deny
    Deny from all
</FilesMatch>

# Protect .env
<Files .env>
    Order allow,deny
    Deny from all
</Files>
```

### 9.3 Set Proper Permissions

```bash
# Files: 644
find ~/kairouanhub -type f -exec chmod 644 {} \;

# Directories: 755
find ~/kairouanhub -type d -exec chmod 755 {} \;

# Storage and cache: 775
chmod -R 775 ~/kairouanhub/storage
chmod -R 775 ~/kairouanhub/bootstrap/cache
```

---

## 🌐 Step 10: Configure Domain

### 10.1 Set Document Root

In Hostinger hPanel:
1. Go to **Domains**
2. Select your domain
3. Click **Manage**
4. Set **Document Root** to:
   - If using symlink: `/public_html`
   - If project in subdirectory: `/public_html/kairouanhub/public`

### 10.2 Force HTTPS

Add to `public/.htaccess` (top of file):

```apache
# Force HTTPS
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{HTTPS} off
    RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
</IfModule>
```

---

## ✅ Step 11: Verify Deployment

### 11.1 Test Website

1. Visit: `https://yourdomain.com`
2. Check homepage loads
3. Test navigation links
4. Verify chatbot appears

### 11.2 Test Admin Panel

1. Go to: `https://yourdomain.com/login`
2. Login with: `admin@example.com` / `password`
3. Test provider management:
   - Create new provider
   - View providers list
   - Edit/Delete providers

### 11.3 Check for Errors

```bash
# View Laravel logs
tail -f ~/kairouanhub/storage/logs/laravel.log

# Check PHP error log
tail -f ~/public_html/error_log
```

---

## 🔄 Step 12: Update Workflow (Future Deployments)

### Quick Update Process

```bash
# On server via SSH
cd ~/kairouanhub

# Pull latest changes
git pull origin main

# Update dependencies
composer install --optimize-autoloader --no-dev

# Run new migrations
php artisan migrate --force

# Clear caches
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Rebuild assets (if needed)
npm run build
```

---

## 📊 Step 13: Setup Cron Jobs (Optional)

For Laravel scheduler:

1. Go to hPanel → **Advanced** → **Cron Jobs**
2. Add new cron job:
   ```
   * * * * * cd /home/u123456789/kairouanhub && php artisan schedule:run >> /dev/null 2>&1
   ```

---

## 🐛 Troubleshooting

### Error: 500 Internal Server Error

**Solution:**
```bash
# Check permissions
chmod -R 755 storage bootstrap/cache

# Check .env file exists
ls -la .env

# Check Laravel logs
tail -50 storage/logs/laravel.log

# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

### Error: Database Connection Failed

**Solution:**
1. Verify database credentials in `.env`
2. Check database exists in hPanel
3. Ensure database user has permissions
4. Try connecting via phpMyAdmin

### Error: 404 on Routes

**Solution:**
```bash
# Regenerate route cache
php artisan route:clear
php artisan route:cache

# Check .htaccess exists in public folder
ls -la public/.htaccess
```

### Error: CSS/JS Not Loading

**Solution:**
1. Check `APP_URL` in `.env` matches your domain
2. Verify `public/build/` folder exists
3. Check file permissions: `chmod -R 755 public/build`
4. Clear browser cache

### Error: Storage Link Broken

**Solution:**
```bash
# Create storage link
php artisan storage:link

# Set permissions
chmod -R 755 storage/app/public
```

---

## 🔐 Security Best Practices

1. **Change Default Admin Password**
   ```bash
   php artisan tinker
   $user = User::where('email', 'admin@example.com')->first();
   $user->password = Hash::make('new_secure_password');
   $user->save();
   exit
   ```

2. **Disable Directory Listing**
   Add to `public/.htaccess`:
   ```apache
   Options -Indexes
   ```

3. **Hide Laravel Version**
   Add to `public/.htaccess`:
   ```apache
   <IfModule mod_headers.c>
       Header unset X-Powered-By
       Header always unset X-Powered-By
   </IfModule>
   ```

4. **Enable CSRF Protection** (Already enabled in Laravel)

5. **Setup Backup**
   - Use Hostinger's backup feature
   - Or install Laravel Backup package
   ```bash
   composer require spatie/laravel-backup
   ```

---

## 📈 Performance Optimization

### Enable OPcache

Check if enabled in hPanel → **PHP Configuration** → **OPcache**

### Enable Gzip Compression

Add to `public/.htaccess`:
```apache
<IfModule mod_deflate.c>
    AddOutputFilterByType DEFLATE text/html text/plain text/xml text/css text/javascript application/javascript
</IfModule>
```

### Browser Caching

Add to `public/.htaccess`:
```apache
<IfModule mod_expires.c>
    ExpiresActive On
    ExpiresByType image/jpg "access plus 1 year"
    ExpiresByType image/jpeg "access plus 1 year"
    ExpiresByType image/gif "access plus 1 year"
    ExpiresByType image/png "access plus 1 year"
    ExpiresByType text/css "access plus 1 month"
    ExpiresByType application/pdf "access plus 1 month"
    ExpiresByType text/javascript "access plus 1 month"
    ExpiresByType application/javascript "access plus 1 month"
</IfModule>
```

---

## 📞 Support Resources

- **Hostinger Support:** https://support.hostinger.com
- **Laravel Docs:** https://laravel.com/docs
- **Project Repository:** https://github.com/zinehamdi/KairouanHub

---

## ✅ Deployment Checklist Summary

- [ ] GitHub repository updated
- [ ] Database created on Hostinger
- [ ] Project uploaded to server
- [ ] `.env` configured with production values
- [ ] Dependencies installed
- [ ] Database migrated and seeded
- [ ] Assets compiled
- [ ] Laravel optimized (caches)
- [ ] Permissions set correctly
- [ ] Domain configured
- [ ] HTTPS enabled
- [ ] Admin password changed
- [ ] Website tested
- [ ] Errors checked

**Status:** Ready for Production ✅

---

**Deployment Date:** _______________  
**Deployed By:** _______________  
**Version:** 1.0.0
