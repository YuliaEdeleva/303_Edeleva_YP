<?php
require 'rb.php';

R::setup('sqlite:../data/beautysaloon.db');
R::useFeatureSet( 'novice/latest' );
$m_id = $_GET['master_id'];


// Чтение ФИО мастера
$master = R::load('master', $m_id);

$fio_1 = $master['last_name'].' '.$master['name']; 
if ($master['patronymic'] != 'NULL')
    $fio_1 = $fio_1.' '.$master['patronymic']; 


//Отображение таблицы графика работы
$shedule = R::findLike('schedule', array('master_id' => $m_id), 'ORDER BY work_date');

// Добавление элемента графика
if (isset($_POST['addSh'])) {

    $new_s_elem = R::dispense('schedule');
    $new_s_elem->work_date = $_POST['date'];
    $new_s_elem->start_time = $_POST['start_time'];
    $new_s_elem->end_time = $_POST['end_time'];
    $new_s_elem->master_id = $m_id;


    R::store($new_s_elem);
    header("Location: ".$_SERVER['REQUEST_URI']);
	
}

// Удаление элемента графика из базы
if (isset($_POST['delete_submit_sh'])) {
    $id = $_GET['id'];

    $sh = R::load('schedule', $id);
    R::trash($sh);
	header("Location: ".$_SERVER['REQUEST_URI']);
}


// Обновление записи графика работы
if (isset($_POST['edit-submit-sh'])) {
    $new_s_elem = R::dispense('schedule');

    $new_s_elem->work_date = $_POST['date'];
    $new_s_elem->start_time = $_POST['start_time'];
    $new_s_elem->end_time = $_POST['end_time'];
    $new_s_elem->master_id = $m_id;
    $new_s_elem->id = $_GET['id'];

    R::store($new_s_elem);
    header("Location: ".$_SERVER['REQUEST_URI']);
}