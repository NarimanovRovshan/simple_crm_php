<?php
session_start();
require 'roles.php';

// Если уже авторизован > спазу на главное
if (isset($_SESSION['user_id'])){
	header("Location: clients_list.php");
	exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$username = trim($_POST['username'] ?? '');
	$password = $_POST['password'] ?? '';
	
	if ($username && $password){
		require 'db.php';
		$stmt = $pdo->prepare("SELECT id, password_hash, role FROM users WHERE username = :username");
		$stmt->execute([':username' => $username]);
		$user = $stmt->fetch();
		
		if ($user && password_verify($password, $user['password_hash'])) {
			//Успешный вход
			$_SESSION['user_id'] = $user['id'];
			$_SESSION['username'] = $username;
			$_SESSION['role'] = $user['role'];
			session_regenerate_id(true); // Защита от каржи сессии
			header("Location: clients_list.php");
			exit;
		} else {
			$error = "Неправельный логин или пароль";
		}
	} else {
		$error = "Заполните все поля.";
	}
}

?>
<!DOCTYPE html>
<html lang="ru">
<head><meta charset="UTF-8"><title>Вход в CRM</title></head>
<body style="font-family: sans-serif; padding: 40px;">
	<h2>🔐 Вход в систему</h2>
	<?php if ($error): ?><p style="color: red;"><?= htmlentities($error) ?></p><?php endif; ?>
	
	<form method="POST">
		<p><label>Логин:</label><br>
		<input type="text" name="username" required style="padding: 5px; width:250px;"></p>
		<p><label>Пароль:</label><br>
		<input type="password" name="password" required style="padding: 5px; width: 250px;"></p>
		<button type="submit" style="padding: 8px 16px; background: #28a745; color: whith; border: none; cursor: pointer;">Войти</button>
	</form>
	<p><small>Нет аккаунта? <a href="register.php">Зарегистрироваться</a></small></p>
	
	
</body>
</html>