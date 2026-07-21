<?php
// Mail configuration loaded from environment variables or from .env in project root.
// Do NOT store secrets in repo. Keep .env out of version control.

// Simple .env loader: parses KEY=VALUE lines and sets environment vars.
$envFile = __DIR__ . '/../.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '' || strpos($line, '#') === 0) {
            continue;
        }
        if (strpos($line, '=') === false) {
            continue;
        }
        list($name, $value) = explode('=', $line, 2);
        $name = trim($name);
        $value = trim($value);
        if ((substr($value, 0, 1) === '"' && substr($value, -1) === '"') || (substr($value, 0, 1) === "'" && substr($value, -1) === "'")) {
            $value = substr($value, 1, -1);
        }
        if (getenv($name) === false) {
            putenv($name . '=' . $value);
            $_ENV[$name] = $value;
            $_SERVER[$name] = $value;
        }
    }
}

return [
    'host' => getenv('SMTP_HOST') ?: 'smtp.gmail.com',
    'username' => getenv('SMTP_USERNAME') ?: '',
    'password' => getenv('SMTP_PASSWORD') ?: '',
    'port' => getenv('SMTP_PORT') ?: 587,
    'secure' => getenv('SMTP_SECURE') ?: 'tls',
    'from_email' => getenv('MAIL_FROM') ?: (getenv('SMTP_USERNAME') ?: ''),
    'from_name' => getenv('MAIL_FROM_NAME') ?: 'TrainHub',
];
