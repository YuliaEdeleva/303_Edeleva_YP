<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style/bootstrap.min.css">
    <style>
      .disabled{
        cursor: default !important;
      }
    </style>
    <!-- <script type="text/javascript" src="jquery-3.3.1.min.js"></script> -->
</head>
<body>

<div class="container" style="margin-top: 50px">
  <ul class="list-group">
    <li class="list-group-item active"> Меню </li>
    <li class="list-group-item"> <a class="nav-link <?php if($_GET['form'] == 'employee') echo ' disabled'?>" href="?form=employee">Добавить мастера</a> </li>
    <li class="list-group-item"> <a class="nav-link <?php if($_GET['form'] == 'work-shedule') echo ' disabled'?>" href="?form=work-shedule">Добавить время работы</a> </li>
    <li class="list-group-item"> <a class="nav-link <?php if($_GET['form'] == 'work-track') echo ' disabled'?>" href="?form=work-track">Записаться к мастеру</a> </li>
  </ul>
</div>

<?php require_once('connect.php'); ?>

<div class="container" style="margin-top: 50px; padding-bottom: 50px;">
<?php

  if( isset($_GET['form']) ){
    if( $_GET['form'] == 'employee' ) include_once('./forms/add-employee.php');
    if( $_GET['form'] == 'work-shedule' ) include_once('./forms/add-work-shedule.php');
    if( $_GET['form'] == 'work-track' ) include_once('./forms/add-work-track.php');
  }
?>
</div>

    
</body>
</html>