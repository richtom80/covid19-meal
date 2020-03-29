<?php

class meal_system {

  private $user;
  protected $dbh;

  public function __construct($user, $db){
    $this->user = $user;
    $this->company_id = $user['company_id'];
    $this->dbh = $db;
  }

  public function listUsers(){
    return $this->dbh->query("SELECT * FROM `phpauth_users`")->fetchAll();
  }

  public function listKitchens(){
    return $this->dbh->query("SELECT * FROM `kitchen`")->fetchAll();
  }

  public function getKitchen($k){
    return $this->dbh->query("SELECT * FROM `kitchen` WHERE `id` = $k")->fetch();
  }

  public function listRoutes(){
    return $this->dbh->query("SELECT * FROM `routes`")->fetchAll();
  }

  public function listVolunteers(){
    return $this->dbh->query("SELECT * FROM `volunteers`")->fetchAll();
  }

  public function getVolunteer($v){
    return $this->dbh->query("SELECT * FROM `volunteers` WHERE `id` = $v")->fetch();
  }

  public function listSites(){
    return $this->dbh->query("SELECT * FROM `sites`")->fetchAll();
  }

  public function getSite($s){
    return $this->dbh->query("SELECT * FROM `sites` WHERE `id` = $s")->fetch();
  }
  public function searchSites($term){
    return $this->dbh->query("SELECT * FROM `sites` WHERE MATCH(`name`, `surname`, `postcode`) AGAINST('$term' IN NATURAL LANGUAGE MODE)")->fetchAll();
  }

  public function mealTotal(){
    return $this->dbh->query("SELECT SUM(`std_meal`) AS `std_meal_count`, SUM(`veg_meal`) AS `veg_meal_count`  FROM `sites`;")->fetch();
  }

  public function formatAddress($address, $output = "inline"){
    $o = "";
    foreach($address as $line){
      if(!empty($line)){
        if($output == "inline"){
          $o .= trim($line).", ";
        }
        if($output == "block"){
          $o .= trim($line)."\n";
        }
        if($output == "html_block"){
          $o .= trim($line).",<br/>";
        }
      }
    }
    if($output == "inline"){ $o = substr($o, 0, -2); }
    if($output == "html_block"){ $o = "<address>".substr($o, 0, -6)."</address>"; }
    return $o;
  }

  public function formatUserLevel($level){
    if($level == 1){ return "Admin"; }
    if($level == 2){ return "Dashboard"; }
    if($level == 3){ return "Register"; }
  }
  public function dowOut($data){
    $out = "";
    $all = true;
    $week = true; $part_week = false;
    $weekend = true; $part_weekend = false;
    if($data['mon'] == 1){ $out .= "Mo, "; $part_week = true; } elseif ($data['mon'] != 1) { $all = false; $week = false; }
    if($data['tue'] == 1){ $out .= "Tu, "; $part_week = true; } elseif ($data['tue'] != 1) { $all = false; $week = false; }
    if($data['wed'] == 1){ $out .= "We, "; $part_week = true; } elseif ($data['wed'] != 1) { $all = false; $week = false; }
    if($data['thu'] == 1){ $out .= "Th, "; $part_week = true; } elseif ($data['thu'] != 1) { $all = false; $week = false; }
    if($data['fri'] == 1){ $out .= "Fr, "; $part_week = true;  } elseif ($data['fri'] != 1) { $all = false; $week = false; }
    if($data['sat'] == 1){ $out .= "Sa, "; $part_weekend = true; } elseif ($data['sat'] != 1) { $all = false; $weekend = false; }
    if($data['sun'] == 1){ $out .= "Su, "; $part_weekend = true;  } elseif ($data['sun'] != 1) { $all = false; $weekend = false; }
    if($all){
      return "All Days";
    } elseif($week && !$part_weekend) {
      return "Mid Week";
    } elseif($weekend && !$part_week) {
      return "Weekends";
    } else {
      return substr($out,0,-2);
    }
  }

  public function lookupUser($uid, $out = 'short'){
    $user = $this->dbh->query("SELECT `email`, `name`, `phone`, `level` FROM `phpauth_users` WHERE `id` = $uid;")->fetch();
    if($out == 'short'){
      return "<a href='mailto:{$user['email']}' title='Phone: {$user['phone']}'>{$user['name']}</a>";
    } else {
      return $user;
    }
  }

}
