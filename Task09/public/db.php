<?php
try {
	$pdo = new PDO('sqlite:..\data\beautysaloon.db');
} catch (PDOException $e) {
	die('Ошибка соединения с базой'.$e->getMessage());
}