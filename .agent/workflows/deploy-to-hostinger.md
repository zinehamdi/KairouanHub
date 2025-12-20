---
description: Deploy the application to Hostinger
---

# Deploy to Hostinger Workflow

This workflow guides you through deploying the KairouanHub Laravel application to Hostinger.

## Prerequisites

Before starting, ensure you have:
- SSH access to your Hostinger server
- Database credentials from Hostinger hPanel
- Your domain configured in Hostinger

## Step 1: Build Production Assets Locally

```bash
cd /Users/zinehamdi/Sites/localhost/kairouanhubNV
npm run build
```

This compiles CSS and JavaScript for production.

## Step 2: Verify Git Status

```bash
git status
git log -1 --oneline
```

Ensure all changes are committed and pushed to GitHub.

## Step 3: Connect to Hostinger via SSH

```bash
ssh u123456789@yourdomain.com
```

Replace `u123456789` with your actual Hostinger username and `yourdomain.com` with your domain.

## Step 4: Navigate to Project Directory

```bash
cd ~/kairouanhub
```

Adjust the path if your project is in a different location.

## Step 5: Pull Latest Changes from Git

// turbo
```bash
git pull origin main
```

## Step 6: Install/Update Composer Dependencies

```bash
composer install --optimize-autoloader --no-dev
```

This installs production dependencies only.

## Step 7: Run Database Migrations

```bash
php artisan migrate --force
```

The `--force` flag is required for production environments.

## Step 8: Clear and Cache Configuration

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

This optimizes Laravel for production performance.

## Step 9: Set Proper Permissions

```bash
chmod -R 755 storage bootstrap/cache
```

Ensures Laravel can write to necessary directories.

## Step 10: Create Storage Link (if needed)

```bash
php artisan storage:link
```

This creates a symbolic link for public file access.

## Step 11: Verify Deployment

Visit your website and check:
- Homepage loads correctly
- Navigation works
- Admin panel is accessible at `/login`
- No errors in browser console

## Step 12: Check Logs for Errors

```bash
tail -50 ~/kairouanhub/storage/logs/laravel.log
```

Look for any errors or warnings.

## Troubleshooting

### If you get a 500 error:
```bash
chmod -R 755 storage bootstrap/cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

### If CSS/JS not loading:
- Verify `APP_URL` in `.env` matches your domain
- Check that `public/build/` folder exists
- Clear browser cache

### If database connection fails:
- Verify database credentials in `.env`
- Check database exists in Hostinger hPanel
- Test connection via phpMyAdmin

## Quick Update (Future Deployments)

For subsequent deployments, you only need:

```bash
cd ~/kairouanhub
git pull origin main
composer install --optimize-autoloader --no-dev
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```
