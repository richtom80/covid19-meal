<?php
require 'includes/preload.php';

if(!empty($_GET['start'])){

  $e = array();
  $sd = new DateTime($_GET['start']);
  $ed = new DateTime($_GET['end']);
  $colours = array("#4e73df", "#1cc88a", "#f6c23e", "#e74a3b", "#858796", "#4e73df", "#1cc88a", "#f6c23e", "#e74a3b", "#858796", "#4e73df", "#1cc88a", "#f6c23e", "#e74a3b", "#858796");

  $i = DateInterval::createFromDateString('1 day');
  $p = new DatePeriod($sd, $i, $ed);
  foreach($p as $dt){
    foreach($ms->listRoutes() as $k => $rid){
      $e[] = array(
        "title" => $rid['name']." (".$ms->getKitchen($rid['kitchen'])['name'].")",
        "start" => $dt->format("Y-m-d"),
        "allDayDefault" => true,
        "textColor" => "#fff",
        "color" => $colours[$k],
        "url" => "cal-event.php?date={$dt->format("Y-m-d")}&rid={$rid['id']}"
      );
    }
  }
  echo json_encode($e);
}
