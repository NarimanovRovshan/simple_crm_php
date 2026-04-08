<?php
// Проверяем, была ли отправлена форма
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	// Получение данных из формы
	$name = $_POST['name'] ?? '';
	$email = $_POST['email'] ?? '';
	$tel = $_POST['tel'] ?? '';
	$balance = $_POST['balance'] ?? 0;
	
	//Простая валидация телефона (должен содержать хотя бы 10 цифр)
	$digitsOnly = preg_replace('/\D/', '', $tel);
	
	if (strlen($digitsOnly) < 10) {
		echo "<h1>❌ Ошибка!</h1>";
		echo "<p>Некорректный номер телефона. Введите минимум 10 цифр.</p>";
		echo "<br><a href='add_client.php'>← Вернуться назад</a>";
		exit;
	}

	// Подключаем БД
	require 'db.php';
	
	// Готовим запрос (INSERT) - защита от инъекций!
	$stmt = $pdo->prepare("INSERT INTO clients (name, email, phone, balance) VALUES (:name, :email, :phone, :balance)");

	
	// Выполняем запрос
	$stmt->execute([
		':name' => $name,
		':email' => $email,
		':phone' => $tel,
		':balance' => $balance
	]);
	
	// Успех
	echo "<h1>✅ Клиент добавлен в БД!</h1>";
	echo "<p>👤 Имя: <b>$name</b></p>";
	echo "<br><a href='add_client.php'>← Добавить ещё</a> | <a href='clients_list.php'>→ Смотреть список</a>";
	exit;

//////Если всё ок - Выводим подтверждение
	//echo "<h1> Клиент Добавлен!</h1>";
	//echo "<p>✅ Имя: <b>". $name ."</b></p>";
	//echo "<p>📧 Email: <b>". $email ."</b></p>";
	//echo "<p>☎️ Номер телефона: <b>". $tel . "</b></p>";
	//echo "<p>💰 Баланс: <b>". $balance . " руб.</b></p>";
	//echo "<br><a href='add_client.php'>← Добавить ещё одного</a>";
//////
} else {
	// Показываем форму
	?>
	<h1>➕ Добавить нового клиента</h1>
	<form method="POST" action="">
		<p>
			<label>Имя: </label><br>
			<input type="text" name="name" required style="width: 300px; padding: 5px;">
		</p>
		<p>
			<label>Email: </label><br>
			<input type="email" name="email" required style="width: 300px; padding: 5px;">
		</p>
		<p>
			<label>Номер телефона: </label><br>
			<input type="tel" name="tel" required style="width: 300px; padding: 5px;">
		</p>
		<p>
			<label>Баланс (руб.): </label><br>
			<input type="number" name="balance" required style="width: 300px; padding: 5px;">
		</p>
		<p>
			<button type="submit" style="padding: 10px 20px; background: #28a745; color: white; border: none; cursor: pointer;">
				Добавить клиента
			</button>
		</p>
	</form>
<?php
}
?>