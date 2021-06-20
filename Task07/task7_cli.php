<?php

require_once('./includes/PseudoTable.php');
require_once('./includes/Query.php');
require_once('./includes/Validate.php');

try {
    $pdo = new PDO('sqlite:./data/beautysaloon.db');

    $list_of_all_employee_query = "
        SELECT
            m.id AS 'Номер мастера', 
            m.last_name || ' ' || m.name || ' ' || m.patronymic AS 'ФИО'
        FROM master AS m
    ";
    $statement = $pdo->query( $list_of_all_employee_query );
    $rows = $statement->fetchAll();
    $statement->closeCursor();
    
    draw_table($rows);
    
    $employee_number = readline("Номер мастера: ");

    if( (bool)employee_number_validation($employee_number , $rows) == True)
        list_of_services_for_employee($pdo, array($employee_number), "ORDER BY `Дата работы`");
    else if( (bool)empty($employee_number) == True)
        list_of_services_for_employee($pdo, get_array_of_employee_numbers( $rows ), "ORDER BY `ФИО`, `Дата работы`");
    else
        echo 'Мастера с данным номером не существует, очень жаль :(';

} catch (PDOException $e) {
    print "Error!: " . $e->getMessage();
    die();
}
?>