<?

return [
    'paths' => ['*'],
    'allowed_methods' => ['*'],
    'allowed_origins' => ['db-coursework-php-fpm-1:5173'], // Добавьте ваш фронтенд-адрес
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => false,
];
