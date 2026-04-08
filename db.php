<?php
// Настройки подключения
$dsn = 'sqlite:' . __DIR__ . '/crm.db'; // Путь к файлу базы данных
$user = null;
$pass = null;
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Включить ошибки
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Массивы вместо объектов
];

try {
    // Создаем подключение
    $pdo = new PDO($dsn, $user, $pass, $options);
    
    // Создаем таблицу, если её нет
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS clients (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            email TEXT NOT NULL,
            phone TEXT,
            balance INTEGER DEFAULT 0,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )
    ");
	
	$pdo->exec("
		CREATE TABLE IF NOT EXISTS users (
			id INTEGER PRIMARY KEY AUTOINCREMENT,
			username TEXT UNIQUE NOT NULL,
			password_hash TEXT NOT NULL,
			created_at DATETIME DEFAULT CURRENT_TIMESTAMP
		)
	");
	
} catch (PDOException $e) {
    die("Ошибка подключения к БД: " . $e->getMessage());
}
?>