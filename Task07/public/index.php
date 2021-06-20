<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task07</title>
</head>
<body>

<?php
function get_array_of_employee_numbers( $rows ){
    $array = array( count( $rows ) );
    for( $i = 0; $i < count( $rows ); $i++)
        $array[$i] = $rows[$i][0];
    return $array;
}

$pdo = new PDO('sqlite:../data/beautysaloon.db');

$list_of_all_employee_query = "
    SELECT
        m.id
    FROM master AS m
";
$statement = $pdo->query( $list_of_all_employee_query );
$rows = $statement->fetchAll();
$statement->closeCursor();

$employee_array = get_array_of_employee_numbers( $rows );

$option_selected_id = -1;
if( isset( $_POST['employeeId'] ) )
    if( $_POST['employeeId'] != '' )
        $option_selected_id = $_POST['employeeId'];
?>
    

<h1>Номер мастера: </h1>
<form action="" method="POST">
    <label>
        <select style="width: 200px;" name="employeeId">
            <option value=<?= null ?>></option>
            <?php
                foreach($employee_array as $id): 
                    $selected = '';
                    if( $id == $option_selected_id)
                        $selected = 'selected';
            ?>
                <option value=<?= $id ?> <?= $selected ?>>
                    <?= $id ?>
                </option>
            <?php endforeach; ?>
        </select>
    </label>
    <button type="submit">Найти</button>
</form>

<?php

if( isset( $_POST['employeeId'] ) ):
    $id_list = $_POST['employeeId'] === '' ? implode(',', $employee_array) : $_POST['employeeId'];

    $list_of_all_services_query = "
    SELECT 
        m.id AS 'Номер мастера', 
        m.last_name || ' ' || m.name || ' ' || m.patronymic AS 'ФИО',
        w.date AS 'Дата работы',
        s.service_name AS 'Услуга',
        s.price AS 'Стоимость'
    FROM work_info AS w
    INNER JOIN master AS m ON w.id_master = m.id
    INNER JOIN service AS s ON w.id_service = s.id
    WHERE m.id IN (".$id_list.")
    ";

    $statement = $pdo->query( $list_of_all_services_query."ORDER BY `ФИО`, `Дата работы`" );
    $works = $statement->fetchAll();
    $statement->closeCursor();

    if( count($works) > 0):
?>
        <table class="doctors-table">
            <tr class="table-header">
                <th>Номер мастера</th>
                <th>ФИО</th>
                <th>Дата работы</th>
                <th>Услуга</th>
                <th>Стоимость</th>
            </tr>
            <?php foreach($works as $work): ?>
                <tr>
                    <td><?= $work[0] ?></td>
                    <td><?= $work[1] ?></td>
                    <td><?= $work[2] ?></td>
                    <td><?= $work[3] ?></td>
                    <td><?= $work[4] ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
<?php 
    endif;
endif;
?>

</body>
</html>

<style>
    table {
       border: 1px solid #ccc;
       border-spacing: 3px;
    }
            
    td, th{
       border: solid 1px #ccc;
    }
    .collapsed{
      border-collapse: collapse;
    }
    .separated{
       border-collapse: separate;
    }
</style>