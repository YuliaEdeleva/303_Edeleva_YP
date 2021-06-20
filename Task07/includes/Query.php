<?php
function list_of_services_for_employee( $pdo, $id_list, $order_query=NULL){
    $id_list = implode(',', $id_list);

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

    $statement = $pdo->query( $list_of_all_services_query.$order_query );
    $rows = $statement->fetchAll();
    draw_table($rows);
    $statement->closeCursor();
}

function get_array_of_employee_numbers( $rows ){
    $array = array( count( $rows ) );
    for( $i = 0; $i < count( $rows ); $i++)
        $array[$i] = $rows[$i][0];
    return $array;
}
?>