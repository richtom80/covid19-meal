<?php
require 'includes/preload.php';

if(!empty($_GET['start'])){

  $e = array();
  $sd = new DateTime($_GET['start']);
  $ed = new DateTime($_GET['end']);

  $i = DateInterval::createFromDateString('1 day');
  $p = new DatePeriod($sd, $i, $ed);
  foreach($p as $dt){
    foreach($ms->listRoutes() as $rid){
      $e[] = array(
        "title" => "Route: ".$rid['name'],
        "start" => $dt->format("Y-m-d"),
        "allDayDefault" => true,
        "textColor" => "#fff"
      );
    }
  }
  echo json_encode($e);
}
