#!/bin/sh

SRC_DIR="src"
APP_DIR="$SRC_DIR/app"
OUTPUT_FILE="laravel_project_code_front.txt"

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

# Все Blade шаблоны
if [ -d "$SRC_DIR/resources/views" ]; then
    find "$SRC_DIR/resources/views" -name "*.blade.php" -type f | sort | while read file; do
        add_file_content "$file"
    done
fi

# Blade Components классы
if [ -d "$APP_DIR/View/Components" ]; then
    find "$APP_DIR/View/Components" -name "*.php" -type f | sort | while read file; do
        add_file_content "$file"
    done
fi

# JS файлы
if [ -d "$SRC_DIR/resources/js" ]; then
    find "$SRC_DIR/resources/js" -name "*.js" -type f | sort | while read file; do
        add_file_content "$file"
    done
fi

# CSS/SCSS файлы
for css_dir in "$SRC_DIR/resources/css" "$SRC_DIR/resources/sass" "$SRC_DIR/resources/scss"; do
    if [ -d "$css_dir" ]; then
        find "$css_dir" -type f \( -name "*.css" -o -name "*.scss" -o -name "*.sass" -o -name "*.less" \) | sort | while read file; do
            add_file_content "$file"
        done
    fi
done

echo "Сборка завершена: $OUTPUT_FILE"