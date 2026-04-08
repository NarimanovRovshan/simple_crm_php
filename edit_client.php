<?php
require 'db.php';
require 'functions.php';

$id = $_GET['id'] ?? 0;

//Если форма отправлена → сохраняем
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$name = $_POST['name'] ?? '';
	$email = $_POST['email'] ?? '';
	$tel = $_POST['tel'] ?? '';
	$balance = $_POST['balance'] ?? 0;
	
	//Валидация телефона
	$digitsOnly = preg_replace('/\D/', '', $tel);
	if (strlen($digitsOnly) < 10) {
		$error = "Некорректный номер телефона. Введите минимум 10 цифр.";
	} else {
		// Обновляем запись в БД
		$stmt = $pdo->prepare("UPDATE clients SET name = :name, email = :email, phone = :phone, balance = :balance WHERE id = :id");
		$stmt->execute([
			':name' => $name,
			':email' => $email,
			':phone' => $tel,
			':balance' => $balance,
			':id' => $id
		]);
		header("Location: clients_list.php");
		exit;
	}
}

// Загружаем текущие данные клиента
$stmt = $pdo->prepare("SELECT * FROM clients WHERE id = :id");
$stmt->execute([':id' => $id]);
$client = $stmt->fetch();

if (!$client){
	die("Клиент не найден.");
}
?>

<h1>✏️ Редактирование клиента</h1>
<?php if (!empty($error)): ?>
    <p style="color: red;"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>



<form method="POST">
	<p><label>Имя:</label><br>
	<input type="text" name="name" value="<?= htmlspecialchars($client['name']) ?>" required style="width: 300px; padding: 5px;"></p>
	
	<p><label>Email:</label><br>
	<input type="email" name="email" value="<?= htmlspecialchars($client['email']) ?>" required style="width: 300px; padding: 5px;"></p>
	
	<p><label>Телефон:</label><br>
	<input type="tel" name="tel" value="<?= htmlspecialchars($client['phone']) ?>" required style="width: 300px; padding: 5px;"></p>
	
	<p><label>Баланс:</label><br>
	<input type="number" name="balance" value="<?= htmlspecialchars($client['balance']) ?>" required style="width: 300px; padding: 5px;"></p>
	
	<p><button type="submit" style="padding: 10px 20px; background: #007bff; color: white; border: none; cursor:pointer;">💾 Сохранить</button></p>
</form>
<p><a href="clients_list.php">← Назад к списку</a></p>