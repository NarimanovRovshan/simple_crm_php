<?php
require 'roles.php';
requireRole([ROLE_ADMIN]);//Только адми может удалить
require 'db.php';

// Проверяем, передан ли ID
if (isset($_GET['id'])) {
	$id = (int)$_GET['id']; // Приводим к целому числу для безопасности
	
	// Удаляем запись
	$stmt = $pdo->prepare("DELETE FROM clients WHERE id = :id");
	$stmt->execute([':id' => $id]);
}

//Перенаправляем обратно на список (PRG паттерн)
header("Location: clients_list.php");
exit;
?>