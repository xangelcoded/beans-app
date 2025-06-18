<?php
// init.php

// 1) Start session
session_start();

// 2) Database connection (moved from config.php)
try {
    $db = new PDO(
        'mysql:host=localhost;dbname=beans_app;charset=utf8mb4',
        'root',
        ''
    );
    // 3) Throw exceptions on errors
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // In production you might log this instead of echoing
    echo 'Database connection failed: ' . htmlspecialchars($e->getMessage());
    exit;
}
