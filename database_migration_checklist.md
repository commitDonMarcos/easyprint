# Database Migration Checklist

## Pre-Migration
- [ ] Backup current database
- [ ] Verify MySQL connection in .env
- [ ] Check available disk space
- [ ] Review all migration files for conflicts
- [ ] Run migrations in staging first

## Migration Steps
1. Run migrations:
   ```bash
   php artisan migrate --force
   ```

2. Verify tables:
   ```bash
   php artisan db:show
   ```

3. Verify indexes:
   ```sql
   SELECT TABLE_NAME, INDEX_NAME, COLUMN_NAME 
   FROM information_schema.STATISTICS 
   WHERE TABLE_SCHEMA = 'easyprint';
   ```

4. Verify foreign keys:
   ```sql
   SELECT TABLE_NAME, COLUMN_NAME, REFERENCED_TABLE_NAME, REFERENCED_COLUMN_NAME
   FROM information_schema.KEY_COLUMN_USAGE
   WHERE TABLE_SCHEMA = 'easyprint' AND REFERENCED_TABLE_NAME IS NOT NULL;
   ```

5. Seed data if needed:
   ```bash
   php artisan db:seed --force
   ```

## Post-Migration
- [ ] Run `php artisan optimize`
- [ ] Test all API endpoints
- [ ] Verify analytics tracking works
- [ ] Monitor error logs for 24 hours

## Rollback Plan
```bash
php artisan migrate:rollback --step=1 --force
```
