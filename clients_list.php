<?php
// Добовление функции
require 'auth_check.php';
require 'roles.php';
require 'functions.php';
require 'db.php'; // Подключаем БД

// Получаем всех клиентов из БД
$stmt = $pdo->query("SELECT * FROM clients ORDER BY id DESC");
$clients = $stmt->fetchAll(); 

/////
// Массив клиентов (каждый клиент - это массив с данными)
//$clients = [
//	['name' => 'Иван Иванов', 'email' => 'ivan@yandex.ru', 'phone' => '+79012345775', 'balance' => '7500'],
//	['name' => 'Ольга Петрова', 'email' => 'olga@mail.ru', 'phone' => '+79161239876', 'balance' => '32000'],
//	['name' => 'Алексей Сидоров', 'email' => 'alex@gmail.com', 'phone' => '+79268573642', 'balance' => '750'],
//];
/////

//Счётчик клиентов
$totalClients = count($clients);
$totalBalance = array_sum(array_column($clients, 'balance'));

// Вывод заголовка
echo "<h1> 📋️Список клиентов</h1>";
echo "<p>👋 Привет, <b>" . htmlspecialchars($_SESSION['username']) . "</b> | Роль: " .  htmlspecialchars($_SESSION['role']) . " | <a href='logout.php' style='color: #dc3545;'>🚪 Выйти</a></p>";
echo "<p>💵 Общий баланс: " . $totalBalance . " руб.</p>";
echo "<p><br><a href='add_client.php'>← Добавить ещё</a></p>";


//Создаем таблицу
echo "<table border='1' cellpadding='10' style='border-collapse: collapse; width: 100%;'>";
echo "<tr><th>Имя</th><th>Email</th><th>Телефон</th><th>Баланс</th><th>Скидка</th><th>Действие</th></tr>";

// Цикл для вывода каждого клиента
foreach ($clients as $client) {
	$discount = calculateDiscount($client['balance']);
	echo "<tr>";
	echo "<td> 👤 ". $client['name'] . "</td>";
	echo "<td> 📧 ". $client['email'] . "</td>";
	echo "<td> ☎️ ". $client['phone'] . "</td>";
	echo "<td> 💰️ ". $client['balance'] . " руб.</td>";
	echo "<td>🏷️ " . $discount . "%</td>";
	echo "<td>";
	if($_SESSION['role'] === ROLE_ADMIN) {
		echo "<a href='delete_client.php?id=" .$client['id'] ."'
			onclick='return confirm(\"Удалить клиента " . htmlspecialchars($client['name']) . "?\");'
			style='color: #dc3545; text-decoration: none; font-weight: bold;'>🗑️ Удалить</a>";
		echo " | <a href='edit_client.php?id=" .$client['id']. "' style='color:#007bff;'>📝 Изменить</a>";
	} else {
		echo "<span style='color: #aaa;'>🔒 Нет прав</span>";
	}
	
	echo "</td>";
	echo "</tr>";
}
echo "</table>"; 
	
?>