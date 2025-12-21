#!/bin/sh

SRC_DIR="src"
APP_DIR="$SRC_DIR/app"
OUTPUT_FILE="laravel_project_code_back.txt"

> "$OUTPUT_FILE"

add_file_content() {
    local file="$1"
    
    if [ -f "$file" ]; then
        echo "листинг файла $file" >> "$OUTPUT_FILE"
        echo "" >> "$OUTPUT_FILE"
        cat "$file" >> "$OUTPUT_FILE"
        echo "" >> "$OUTPUT_FILE"
    fi
}

# Bootstrap app.php
if [ -f "$SRC_DIR/bootstrap/app.php" ]; then
    add_file_content "$SRC_DIR/bootstrap/app.php"
fi

# Маршруты
if [ -d "$SRC_DIR/routes" ]; then
    find "$SRC_DIR/routes" -name "*.php" -type f | sort | while read file; do
        add_file_content "$file"
    done
fi

# Провайдеры
if [ -d "$APP_DIR/Providers" ]; then
    find "$APP_DIR/Providers" -name "*.php" -type f | sort | while read file; do
        add_file_content "$file"
    done
fi

# Модели
if [ -d "$APP_DIR/Models" ]; then
    find "$APP_DIR/Models" -name "*.php" -type f | sort | while read file; do
        add_file_content "$file"
    done
fi

# Контроллеры
if [ -d "$APP_DIR/Http/Controllers" ]; then
    find "$APP_DIR/Http/Controllers" -name "*.php" -type f | sort | while read file; do
        add_file_content "$file"
    done
fi

# Запросы
if [ -d "$APP_DIR/Http/Requests" ]; then
    find "$APP_DIR/Http/Requests" -name "*.php" -type f | sort | while read file; do
        add_file_content "$file"
    done
fi

# Middleware (из app/Http/Middleware/)
if [ -d "$APP_DIR/Http/Middleware" ]; then
    find "$APP_DIR/Http/Middleware" -name "*.php" -type f | sort | while read file; do
        add_file_content "$file"
    done
fi

# Репозитории
for repo_dir in "$APP_DIR/Http/Repositories" "$APP_DIR/Repositories" "$APP_DIR/Repository"; do
    if [ -d "$repo_dir" ]; then
        find "$repo_dir" -name "*.php" -type f | sort | while read file; do
            add_file_content "$file"
        done
    fi
done

# Сервисы
for service_dir in "$APP_DIR/Http/Services" "$APP_DIR/Services" "$APP_DIR/Service"; do
    if [ -d "$service_dir" ]; then
        find "$service_dir" -name "*.php" -type f | sort | while read file; do
            add_file_content "$file"
        done
    fi
done

# Миграции
if [ -d "$SRC_DIR/database/migrations" ]; then
    find "$SRC_DIR/database/migrations" -name "*.php" -type f | sort | while read file; do
        add_file_content "$file"
    done
fi

echo "Сборка завершена: $OUTPUT_FILE"