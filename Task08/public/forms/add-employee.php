<?php
    
    if( isset($_POST['inputLastName']) ){
        $sql = "INSERT INTO employee (last_name, `name`, second_name, birth_date, phone_number, cost_percent, gender) VALUES (?, ?, ?, ?, ?, ?, ?)";
        

        if($pdo->prepare($sql)->execute([
            $_POST['inputLastName'], 
            $_POST['inputName'], 
            $_POST['inputSecondName'],
            $_POST['inputBirthDate'],
            $_POST['inputPhoneNumber'],
            $_POST['inputCostPercent'],
            $_POST['inputGender']
        ])){
            $last_id = $pdo->lastInsertId();

            $arraiID = 0;
            $data = [];
            for($i = 0; $i < $_POST['inputServiceCount']; $i++){
                if( isset($_POST['inputService'.$i])){
                    $data[$arraiID] = [$last_id, $i];
                    $arraiID++;
                }
            }

            $stmt = $pdo->prepare("INSERT INTO employee_specialization (id_employee, id_service) VALUES (?,?)");
            try {
                $pdo->beginTransaction();
                foreach ($data as $row)
                {
                    $stmt->execute($row);
                }
                $pdo->commit();
            }catch (Exception $e){
                $pdo->rollback();
                throw $e;
            }
        }
    }
?>

<?php

    function get_array_of_employee_numbers( $rows ){
        $array = array( );
        for( $i = 0; $i < count( $rows ); $i++)
            $array[$i] = array($rows[$i][0], $rows[$i][1]);
        return $array;
    }

    $list_of_all_employee_query = "
        SELECT
            id, name
        FROM service
    ";

    $statement = $pdo->query( $list_of_all_employee_query );
    $rows = $statement->fetchAll();
    $statement->closeCursor();


    $employee_array = get_array_of_employee_numbers( $rows );

?>

<form role="form" action="" method="post">
  <div class="form-row">
    <div class="form-group col-md-4">
        <label for="inputLastName">Фамилия</label>
        <input type="text" class="form-control" id="inputLastName" name="inputLastName" placeholder="Фамилия" value="тест" required pattern="[А-Яа-я]{1,32}">
    </div>
    <div class="form-group col-md-4">
         <label for="inputName">Имя</label>
        <input type="text" class="form-control" id="inputName" name="inputName" placeholder="Имя" value="тест" required pattern="[А-Яа-я]{1,32}">
    </div>
    <div class="form-group col-md-4">
        <label for="inputSecondName">Отчество</label>
        <input type="text" class="form-control" id="inputSecondName" name="inputSecondName" placeholder="Отчество" value="тест" required pattern="[А-Яа-я]{1,32}">
  </div>
  </div>
  <div class="form-row">
  <div class="form-group col-md-4"></div>
  <div class="form-group col-md-4"></div>
    <div class="form-group col-md-4">
        <label for="inputBirthDate">Дата рождения</label>
        <input type="date" class="form-control" id="inputBirthDate" name="inputBirthDate" placeholder="Дата рождения" required>
    </div>
  </div>

  <div class="form-row">
  <div class="form-group col-md-4"></div>
  <div class="form-group col-md-4"></div>
    <div class="form-group col-md-4">
        <label for="inputPhoneNumber">Номер телефона</label>
        <input type="text" class="form-control" id="inputPhoneNumber" name="inputPhoneNumber" placeholder="89876806524" value="89876806524" required pattern="\8\[0-9]{3}\[0-9]{3}\[0-9]{2}\[0-9]{2}">
    </div>
  </div>

  <div class="form-row">
  <div class="form-group col-md-4"></div>
  <div class="form-group col-md-4"></div>
    <div class="form-group col-md-4">
        <label for="inputGender">Пол</label>
        <select class="form-control" id="inputGender" name="inputGender" aria-label="Default select example" required>
            <option value="М" selected>М</option>
            <option value="Ж">Ж</option>
            <option value="Другое">Другое</option>
        </select>
    </div>

  </div>


  <div class="form-row">
    <div class="form-group col-md-4"></div>
    <div class="form-group col-md-4"></div>
    <div class="form-group col-md-4">
        <script type="text/javascript">
        function enforceMinMax(el){
            if(el.value != ""){
                if(parseInt(el.value) < parseInt(el.min)){
                el.value = el.min;
                }
                if(parseInt(el.value) > parseInt(el.max)){
                el.value = el.max;
                }
            }
        }
        </script>
        <label for="inputCostPercent">Процент с заказа</label>
        <input type="number" min="0" max="100"  class="form-control" id="inputCostPercent" name="inputCostPercent" value="90" onkeyup=enforceMinMax(this) required>
    </div>
  </div>


  <p class="font-weight-bold">Услуги</p>
<?php foreach($employee_array as $s): ?>
    <div class="form-row">
  <input type="checkbox" class="form-check-input" id="inputService<?= $s[0]; ?>" name="inputService<?= $s[0]; ?>">
    <label class="form-check-label" for="inputService<?= $s[0]; ?>"><?= $s[1]; ?></label>
    </div>
<?php endforeach; ?>

<input type="hidden" value="<?= count($employee_array);?>" name="inputServiceCount">

  <button type="submit" class="btn btn-primary float-right">Отправить</button>
</form>

