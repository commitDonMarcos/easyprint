# Disaster Recovery Plan

## 1. Database Failure

### Symptoms
- 500 errors from API
- Database connection timeouts
- "Lost connection to MySQL server" errors

### Recovery Steps
1. Check Railway dashboard for MySQL service status
2. Restore from latest backup:
   ```bash
   gunzip -c backups/easyprint/db_$(date +%Y%m%d).sql.gz | mysql -h $DB_HOST -u $DB_USERNAME -p$DB_PASSWORD $DB_DATABASE
   ```
3. If Railway MySQL is unrecoverable:
   - Provision new MySQL instance on Railway
   - Update DATABASE_URL env var
   - Run migrations: `php artisan migrate --force`
   - Restore from backup

### Prevention
- Automated daily backups (see scripts/backup.sh)
- Database multi-AZ deployment
- Connection pooling enabled

## 2. Application Failure

### Symptoms
- Application not responding
- PHP-FPM crashes
- 502 Bad Gateway errors

### Recovery Steps
1. Restart the application:
   ```bash
   railway restart
   ```
2. Clear caches:
   ```bash
   php artisan optimize:clear
   php artisan optimize
   ```
3. Check logs:
   ```bash
   railway logs --tail 100
   ```
4. If persistent, rollback to previous deploy:
   ```bash
   railway rollback
   ```

### Prevention
- Health checks configured
- Auto-restart on failure
- Staged deployments via GitHub Actions

## 3. File Storage Failure

### Symptoms
- Logo uploads failing
- Missing preview images
- "File not found" errors

### Recovery Steps
1. Check Cloudinary/R2 dashboard for service status
2. Verify credentials in environment variables
3. Re-upload any missing assets from local cache
4. If service is down, fallback to local storage:
   - Set `FILESYSTEM_DISK=public`
   - Run `php artisan storage:link`

### Prevention
- Cloud storage with 99.9%+ uptime SLA
- Local fallback option configured
- Regular file system integrity checks

## 4. Security Incident

### Symptoms
- Unauthorized access detected
- Suspicious activity in logs
- Brute force attack alerts

### Response Steps
1. Revoke all API tokens
2. Rotate APP_KEY and admin password
3. Enable maintenance mode:
   ```bash
   php artisan down --secret="recovery-key"
   ```
4. Investigate logs:
   ```bash
   railway logs --service backend --tail 500
   ```
5. Apply security patch
6. Resume service:
   ```bash
   php artisan up
   ```

### Prevention
- Rate limiting on API routes
- Failed login attempt tracking
- WAF (Cloudflare) in front of API
- Regular security audits

## 5. Backup Strategy

### Schedule
- Database: Daily at 02:00 UTC
- File Storage: Daily at 03:00 UTC
- Full Application: Weekly on Sunday

### Retention
- Daily backups: 30 days
- Weekly backups: 12 weeks
- Monthly backups: 12 months

### Testing
- Restore test: First Sunday of each month
- Integrity check: Daily after backup
