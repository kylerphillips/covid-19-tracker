<?php
header("Access-Control-Allow-Origin: *");

$url = $_POST['url'];
$jsonHistorial = file_get_contents($url);
$objHistorial = json_decode($jsonHistorial);
$arrayHistorial = json_decode(json_encode($objHistorial), true);

$datesCases = array_keys($arrayHistorial['timeline']['cases']);
$datesFormatted = "['".implode("','",$datesCases)."']";

$items = array();
  foreach ($datesCases as $key => $value) {
    $items[] = date("j M", strtotime($value))."";
    
  };
 
$datesFormattedShort = implode(',',$items) ;

$casesByDay = array_values($arrayHistorial['timeline']['cases']);

$deathsByDay = array_values($arrayHistorial['timeline']['deaths']);

$casesByDayFormatted = implode(",",$casesByDay);

$deathsByDayFormatted = implode(",",$deathsByDay);




print_r($casesByDayFormatted);
print_r('|');
print_r($datesFormattedShort);
print_r('|');
print_r($deathsByDayFormatted);

?>
