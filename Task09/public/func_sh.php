<?php

include 'db.php';

// Чтение ФИО мастера
$master_id = $_GET['master_id'];
            $sql = $pdo->prepare("SELECT id, last_name || ' ' || name || ' ' || patronymic AS 'master' FROM master
                                    WHERE id = ?");
            $sql->execute([$master_id]);
            $fio = $sql->fetchAll();

// Добавление элемента графика
if (isset($_POST['addSh'])) {

    $date = $_POST['date'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];

	$sql = ("INSERT INTO schedule (`id_master`, `work_date`,
                `start_time`, `end_time`) VALUES(?,?,?,?)");
	$query = $pdo->prepare($sql);
	$query->execute([$master_id, $date, $start_time, $end_time]);

    header("Location: ".$_SERVER['REQUEST_URI']);
	
}


//Отображение таблицы графика работы
$sql = $pdo->prepare("SELECT schedule.id AS id,
                         schedule.id_master AS id_master,
                         schedule.work_date AS date,
                         schedule.start_time AS start_time, 
                         schedule.end_time AS end_time
                      FROM schedule
                      WHERE id_master = ?
                      ORDER BY date");
$sql->execute([$master_id]);
$result = $sql->fetchAll();


// Обновление записи графика работы
if (isset($_POST['edit-submit-sh'])) {

    $date = $_POST['date'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $id = $_GET['id'];

	$sqll = "UPDATE schedule SET id_master=?, work_date=?,
                start_time=?, end_time=?
            WHERE id=?";

	$querys = $pdo->prepare($sqll);
	$querys->execute([$master_id, $date, $start_time, $end_time, $id]);

    header("Location: ".$_SERVER['REQUEST_URI']);
}

// Удаление элемента графика из базы
if (isset($_POST['delete_submit_sh'])) {
    $id = $_GET['id'];

	$sql = "DELETE FROM schedule WHERE id=?";
	$query = $pdo->prepare($sql);
	$query->execute([$id]);
	 header("Location: ".$_SERVER['REQUEST_URI']);
}