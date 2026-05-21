<?php
// ============================================
// config.php - Database & App Configuration
// ============================================

// Database Settings
define('DB_HOST', 'localhost');
define('DB_NAME', 'CRUD');
define('DB_USER', 'root');
define('DB_PASS', '');

// App Settings
define('APP_NAME', 'CRUD Manager');
define('APP_URL',  'http://localhost/CRUD');

// Upload Settings
define('UPLOAD_DIR',      __DIR__ . '/uploads/');
define('UPLOAD_URL',      APP_URL . '/uploads/');
define('MAX_FILE_SIZE',   2 * 1024 * 1024); // 2 MB
define('ALLOWED_TYPES',   ['image/jpeg', 'image/png', 'image/gif', 'image/webp']);
define('ALLOWED_EXT',     ['jpg', 'jpeg', 'png', 'gif', 'webp']);

// Default avatar placeholder (Bootstrap icon data-uri)
define('DEFAULT_AVATAR',  APP_URL . '/assets/default_avatar.png');

// Connect to MySQL
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if (!$conn) {
    die('<div style="font-family:sans-serif;padding:30px;background:#fff0f0;color:#c00;border:1px solid #fcc;margin:20px;border-radius:8px;">
        <h3>&#9888; Database Connection Failed</h3>
        <p>' . mysqli_connect_error() . '</p>
        <p>Make sure XAMPP MySQL is running and the database <strong>' . DB_NAME . '</strong> exists.</p>
    </div>');
}
mysqli_set_charset($conn, 'utf8mb4');
?>
