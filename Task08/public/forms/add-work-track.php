<script type="text/javascript" src="jquery-3.3.1.min.js"></script>
<?php
    
    if( isset($_POST['inputStartTime']) ){
        $sql = "INSERT INTO work_track (id_employee, id_service, work_date, start_work_time, end_work_time, client_last_name, client_name, client_second_name, client_phone_number) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        

        $pdo->prepare($sql)->execute([
            $_POST['inputEmployee'],
            $_POST['inputService'],
            $_POST['inputDate'],
            $_POST['inputStartTime'],
            $_POST['inputStartTime'],
            $_POST['inputLastName'], 
            $_POST['inputName'], 
            $_POST['inputSecondName'],
            $_POST['inputPhoneNumber'],
        ]);
    }
?>

<?php

    function get_array_of_employee_numbers( $rows ){
        $array = array( );
        for( $i = 0; $i < count( $rows ); $i++)
            $array[$i] = array($rows[$i][0], $rows[$i][1], $rows[$i][2], $rows[$i][3]);
        return $array;
    }

    $list_of_all_employee_query = "
    SELECT
    e.id,
    e.name,
    e.last_name,
    e.second_name 
    FROM employee_specialization as es
    inner join employee as e on e.id = es.id_employee 
    WHERE es.id_service = 0
    ";

    $statement = $pdo->query( $list_of_all_employee_query );
    $rows = $statement->fetchAll();
    $statement->closeCursor();


    $employee_array = get_array_of_employee_numbers( $rows );

    function get_array_of_service( $rows ){
        $array = array( );
        for( $i = 0; $i < count( $rows ); $i++)
            $array[$i] = array($rows[$i][0], $rows[$i][1]);
        return $array;
    }

    $list_of_all_service_query = "
        SELECT
        id, name
        FROM service
    ";

    $statement = $pdo->query( $list_of_all_service_query );
    $rows = $statement->fetchAll();
    $statement->closeCursor();


    $service_array = get_array_of_service( $rows );

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
        <label for="inputPhoneNumber">Номер телефона</label>
        <input type="text" class="form-control" id="inputPhoneNumber" name="inputPhoneNumber" placeholder="89876806524" value="89876806524" required pattern="\8\[0-9]{3}\[0-9]{3}\[0-9]{2}\[0-9]{2}">
    </div>
  </div>

<div class="form-row">
    <div class="form-group col-md-4"></div>
    <div class="form-group col-md-4"></div>
    <div class="form-group col-md-4">
        <label for="inputService">Услуга</label>
        <select class="form-control" id="inputService" name="inputService" required>
            <?php $isActive = True;?>
            <?php foreach($service_array as $s): ?>
            <div class="form-row">
                <option value="<?= $s[0] ?>"  <?php if($isActive){ echo 'selected'; $isActive = False;}?>><?= $s[0].' '.$s[1] ?></option>
            <?php endforeach; ?>
        </select>
    </div>
  </div>


  <script type="text/javascript">
    $(document).ready(function(){


        console.log($('select[name="InputService"]'));
    
        $('#inputService').on("change", function(){

            var optionSelected = $("option:selected", this);
            var valueSelected = this.value;

                $.ajax({
                    url: 'forms/master.php',
                    method: 'post',
                    dataType: 'html',
                    data: "val="+valueSelected,
                    success: function(data){
                        $('#inputEmployee').html(data);                    }
                });
        });



    })

  </script>

<div class="form-row">
    <div class="form-group col-md-4"></div>
    <div class="form-group col-md-4"></div>
    <div class="form-group col-md-4">
        <label for="inputEmployee">Мастер</label>
        <select class="form-control" id="inputEmployee" name="inputEmployee" required>
            <?php $isActive = True;?>
            <?php foreach($employee_array as $s): ?>
            <div class="form-row">
                <option value="<?= $s[0] ?>"  <?php if($isActive){ echo 'selected'; $isActive = False;}?>><?= $s[0].' '.$s[1].' '.$s[2].' '.$s[3] ?></option>
            <?php endforeach; ?>
        </select>
    </div>
  </div>


  <div class="form-row">
  <div class="form-group col-md-4"></div>
  <div class="form-group col-md-4"></div>
    <div class="form-group col-md-4">
        <label for="inputDate">Дата работы</label>
        <input type="date" class="form-control" id="inputDate" name="inputDate" min="<?=date('Y-m-d', time())?>" required >
    </div>
  </div>

  <script type="text/javascript">

  $(document).ready(function(){
  
      $('#inputDate').on("change", function(){

          var optionSelected = $("option:selected", this);
          var valueSelected = this.value;

              $.ajax({
                  url: 'forms/time.php',
                  method: 'post',
                  dataType: 'html',
                  data: "date="+valueSelected+"&id="+$('select[name=inputEmployee] option').filter(':selected').val(),
                  success: function(data){
                      $('#date').html(data);
                        console.log(data);                  }
              });
      });

  })

</script>


<div class="form-row" id="date">

</div>



  <button type="submit" class="btn btn-primary float-right">Отправить</button>
</form>

