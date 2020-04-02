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
  $casesByDayFormatted = implode(",",$casesByDay);

print_r($casesByDayFormatted);
print_r('|');
print_r($datesFormattedShort);

?>
