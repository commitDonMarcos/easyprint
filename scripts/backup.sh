#!/bin/bash
set -e

BACKUP_DIR="/backups/easyprint"
TIMESTAMP=$(date +%Y%m%d_%H%M%S)
DB_NAME="${DB_DATABASE:-easyprint}"

mkdir -p "$BACKUP_DIR"

echo "📦 Backing up database..."
mysqldump \
    --host="${DB_HOST:-localhost}" \
    --port="${DB_PORT:-3306}" \
    --user="${DB_USERNAME:-root}" \
    --password="${DB_PASSWORD}" \
    --single-transaction \
    --routines \
    --triggers \
    --events \
    "$DB_NAME" > "$BACKUP_DIR/db_$TIMESTAMP.sql"

gzip "$BACKUP_DIR/db_$TIMESTAMP.sql"

echo "📦 Backing up storage..."
tar -czf "$BACKUP_DIR/storage_$TIMESTAMP.tar.gz" \
    -C /var/www storage/app/public \
    --exclude='storage/app/public/.gitignore' 2>/dev/null || true

echo "🗑️  Cleaning backups older than 30 days..."
find "$BACKUP_DIR" -name "db_*.sql.gz" -mtime +30 -delete
find "$BACKUP_DIR" -name "storage_*.tar.gz" -mtime +30 -delete

echo "✅ Backup complete: $BACKUP_DIR/db_$TIMESTAMP.sql.gz"
