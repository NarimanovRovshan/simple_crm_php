<?php
// Данные клиента (Переменные)
$name = "Иван Иванов";
$email = "ivan@yandex.ru";
$balance = 1500;
$isActive = false;

// Вывод на экран с HTML
echo "<h1>👤 Клиент: $name</h1>";
echo "<p>📧 Email: $email</p>";
echo "<p>💰️ Баланс: $balance</p>";

// Условие: статус клиента
if ($isActive) {
	echo "<p>✅ Статус: <b>Активен</b></p>";
} else {
	echo "<p>❌ Статус: <b>Заблокирован</b></p>";
}
?>