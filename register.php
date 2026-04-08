<?php
require 'db.php';
session_start();
if (isset($_SESSION['user_id'])) { header(Location: clients_list.php); exit; }

$error= '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$username = trim($_POST['username']) ?? '';
	$password = $_POST['password'] ?? '';
	
	if (strlen($username) < 3 || strlen($password) < 6) {
		$error = "Логин минимум 3 символа, пароль минимум 6.";
	} else {
		require 'db.php';
		try {
			$hash = password_hash($password, PASSWORD_DEFAULT);
			$stmt = $pdo->prepare("INSERT INTO users (username, password_hash) VALUES (:username, :password_hash)");
			$stmt->execute([':username' => $username, ':password_hash' => $hash]);
			$success = "Регистрация успешна! Теперь войдите.";
		} catch (PDOException $e) {
			$error = "Такой логин уже занят.";
		}
	}
}
///*Для проверки! 
//Вывод списка имён учётных записей
$dbusers = $pdo->query("SELECT * FROM users ORDER BY id DESC");
$users = $dbusers->fetchAll();  

foreach ($users as $user) {	
	echo "<tr>";
	echo "<td> 👤 ". $user['username'] . "</td><br>";
	echo "</tr>";
}

// Удаление аккаутна из таблицы
$usernamedel = "";
$dbusersdel = $pdo->prepare("DELETE FROM users WHERE username = :usernamedel");
$dbusersdel->execute([':usernamedel' => $usernamedel]);

//*/
?>
<!DOCTYPE html>
<html lang="ru">
<head><meta charset="UTF-8"><title>Регистрация</title></head>
<body style="font-family: sans-serif; padding: 40px;">
	<h2>📝 Регистрация</h2>
	<?php if ($error): ?><p style="color:red;"><?= htmlspecialchars($error) ?></p><?php endif; ?>
	<?php if ($success): ?><p style="color: green;"><?= $success ?></p><?php endif; ?>
	
	<form method="POST">
		<p><label>Логин:</label><br>
		<input type="text" name="username" required style="padding: 5px; width: 250px;"></p>
		<p><label>Пароль:</label><br>
		<input type="password" name="password" required style="padding: 5px; width: 250px;"></p>
		<button type="submit" style="padding: 8px 16px; background: #007bff; color: white; border: none; cursor: pointer;">Создать аккаунт</button>
	</form>
	<p><small>Уже есть аккаунт? <a href="login.php">Войти</a></small></p>
</body>
</html>