<?php
function getDatabaseConnection(): PDO
{
    $hosts = ['127.0.0.1', 'localhost'];
    $dbName = 'thu_vien';
    $user = 'hieu';
    $password = '';
    $charset = 'utf8mb4';
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];

    $lastException = null;

    foreach ($hosts as $host) {
        try {
            $dsn = "mysql:host={$host};dbname={$dbName};charset={$charset}";
            return new PDO($dsn, $user, $password, $options);
        } catch (PDOException $e) {
            $lastException = $e;
        }
    }

    throw $lastException ?: new PDOException('Không thể kết nối MySQL database thu_vien.');
}
