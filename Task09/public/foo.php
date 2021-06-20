<?php
include 'db.php';

// Read specialization
$sql = $pdo->prepare("SELECT * FROM `specialization`");
$sql->execute();
$spec_all = $sql->fetchAll();

// Добавление мастера в БД
if (isset($_POST['add'])) {

    $gender_dict = array(
        "Male" => "М",
        "Female" => "Ж"
    );

    $name = $_POST['name'];
    $last_name = $_POST['last_name'];
    $patronymic = $_POST['patronymic'];
    $spec_id = $_POST['specialization'];
    $percent = $_POST['percent'];
    $gender = $gender_dict[$_POST['gender']];

	$sql = ("INSERT INTO `master`(`name`, `last_name`, `patronymic`, 
                `id_specialization`, `percent_`, `gender`) VALUES(?,?,?,?,?,?)");
	$query = $pdo->prepare($sql);
	$query->execute([$name, $last_name, $patronymic, $spec_id, $percent, $gender]);

    header("Location: ".$_SERVER['REQUEST_URI']);
	
}

// Отображение таблицы мастеров
$sql = $pdo->prepare("SELECT DISTINCT master.id AS id,
                        master.name AS name,
                        master.last_name AS last_name,
                        master.patronymic AS patronymic,
                        master.percent_ AS percent,
                        master.gender AS gender,
                        specialization.name AS spec,
                        specialization.id AS spec_id
                     FROM `master` INNER JOIN `specialization`
                      ON master.id_specialization = `specialization`.id
                    ");
$sql->execute();
$result = $sql->fetchAll();


// Обновление записи о мастере
if (isset($_POST['edit-submit'])) {

    $gender_dict = array(
        "Male" => "М",
        "Female" => "Ж"
    );

    $name = $_POST['edit_name'];
    $last_name = $_POST['edit_last_name'];
    $patronymic = $_POST['edit_patronymic'];
    $spec_id = $_POST['edit_specialization'];
    $percent = $_POST['edit_percent'];
    $gender = $gender_dict[$_POST['edit_gender']];
    $id = $_GET['id'];


	$sqll = "UPDATE master SET name=?, last_name=?, patronymic=?,
                id_specialization=?, percent_=?, gender=?
            WHERE id=?";

	$querys = $pdo->prepare($sqll);
	$querys->execute([$name, $last_name, $patronymic, $spec_id, $percent, 
                        $gender, $id]);

    header("Location: ".$_SERVER['REQUEST_URI']);
}


// Удаление мастера из базы
if (isset($_POST['delete_submit'])) {
    $id = $_GET['id'];

	$sql = "DELETE FROM master WHERE id=?";
	$query = $pdo->prepare($sql);
	$query->execute([$id]);
	 header("Location: ".$_SERVER['REQUEST_URI']);
}