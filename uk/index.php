<?php

        ini_set("allow_url_fopen", 1);

$json = file_get_contents('https://corona.lmao.ninja/all');
$obj = json_decode($json);

$jsonHistorial = file_get_contents('https://corona.lmao.ninja/v2/historical/all');
$objHistorial = json_decode($jsonHistorial);
$arrayHistorial = json_decode(json_encode($objHistorial), true);


$yesterdayCases = end($arrayHistorial['cases']);
$totalCases = ($obj-> cases);

$yesterdayDeaths = end($arrayHistorial['deaths']);
$totalDeaths = ($obj-> deaths);

$yesterdayRecoveries = end($arrayHistorial['recovered']);
$totalRecoveries= ($obj-> recovered);

$activeCases = ($obj-> active);
$activeYesterday = ($yesterdayCases - $yesterdayDeaths - $yesterdayRecoveries);


  function getPercentageChange($oldNumber, $newNumber){
    $decreaseValue = $newNumber - $oldNumber;
    $percentage = round(($decreaseValue / $oldNumber) * 100);
    $output = "";

    if ($percentage > 0) {
      $output = $percentage . "% increase";
    } elseif ($percentage < 0) {
      $output = $percentage . "% decrease";
    } else {
      $output = $percentage . "% increase";
    }

    return $output;
  }

  function getBadgeClass($percentage){
    $output = "";

    if ($percentage > 0) {
      $output = "badge-danger";
    } elseif ($percentage < 0) {
      $output = "badge-success";
    } else {
      $output = "badge-info";
    }

    return $output;
  }

function thousandsCurrencyFormat($num) {

  if($num>1000) {

        $x = round($num);
        $x_number_format = number_format($x);
        $x_array = explode(',', $x_number_format);
        $x_parts = array('k', 'm', 'b', 't');
        $x_count_parts = count($x_array) - 1;
        $x_display = $x;
        $x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
        $x_display .= $x_parts[$x_count_parts - 1];

        return $x_display;

  }

  return $num;
}


?>

<!doctype html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <title>COVID-19 Tracker - UK Data</title>
    <meta name="description" content="Track the spread of the Coronavirus Covid-19 outbreak">

    <link rel="stylesheet" href="../assets/css/tachyons.min.css">
    <link rel="stylesheet" href="../assets/css/site.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js">
      
    </script>
    <script src="../assets/js/jput.min.js">
    </script>
    
    <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-162093056-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-162093056-1');
</script>

<link rel="apple-touch-icon" sizes="57x57" href="../assets/favicon/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="../assets/favicon//apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="../assets/favicon//apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="../assets/favicon//apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="../assets/favicon//apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="../assets/favicon//apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="../assets/favicon//apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="../assets/favicon//apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="../assets/favicon//apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192"  href="../assets/favicon//android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="../assets/favicon//favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="../assets/favicon//favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="../assets/favicon//favicon-16x16.png">
<link rel="manifest" href="../assets/favicon//manifest.json">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="../assets/favicon//ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:url" content="https://viruscovid.tech">
<meta property="og:title" content="🦠COVID-19 Tracker">
<meta property="og:description" content="Track the spread of the Coronavirus Covid-19 outbreak">
<meta property="og:image" content="https://viruscovid.tech/assets/img/meta-tags-16a33a6a8531e519cc0936fbba0ad904e52d35f34a46c97a2c9f6f7dd7d336f2.png">

<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="https://viruscovid.tech">
<meta property="twitter:title" content="🦠COVID-19 Tracker">
<meta property="twitter:description" content="Track the spread of the Coronavirus Covid-19 outbreak">
<meta property="twitter:image" content="https://viruscovid.tech/assets/img/meta-tags-16a33a6a8531e519cc0936fbba0ad904e52d35f34a46c97a2c9f6f7dd7d336f2.png">

    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.js"></script>

       <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.css" />
    
</head>

<body>
    <div class="h-100 midnight-blue pa3 ph0-l pv6-l">
        <div class="center mw7">
            <article class="cf">

                <header class="header mw5 mw7-ns tl pa3">
                    <h1 class="mt0">🇬🇧 UK COVID-19 Data by County</h1>
                  <p class="lh-copy measure black-60">
                        Upper Tier Local Authorities (UTLA) and NHS Regions - <strong>Source: arcgis.com</strong>
                    </p>
                    <p class="lh-copy measure black-60">
                        
                    </p>
                </header>

            </article>
            <section class=" country-table">
                <div class="table-responsive">
  <?php 
        $json=file_get_contents("https://services1.arcgis.com/0IrmI40n5ZYxTUrV/arcgis/rest/services/CountyUAs_cases/FeatureServer/0/query?f=json&where=TotalCases%20%3C%3E%200&returnGeometry=false&spatialRel=esriSpatialRelIntersects&outFields=*&orderByFields=TotalCases%20desc&resultOffset=0&resultRecordCount=1000&cacheHint=true");
    $data =  json_decode($json);

$array = json_decode(json_encode($data), true);
                    
     
                    

                            
                    
$features = ($array['features']);
                    
                    
//print("<pre>".print_r($features,true)."</pre>");
                    
       
    
 echo '<table id="uk-table" class="table table-striped table-curved">';
echo '  <thead>
                        <tr>
                            <th>Rank</th>
                            <th>County</th>
                            <th>Total Cases</th>
                        </tr>
                    </thead>';   
    
    echo'<tbody id="tbody">';
        $index = 0;
        foreach($features as $result){
           

    
          echo '<tr>';
          echo '<td></td>';
          echo '<td>' .$features[$index]['attributes']['GSS_NM'].'</td>';
          echo '<td>' .$features[$index]['attributes']['TotalCases'].'</td>';
          echo '</tr>';
    
        $index+=1;
            
        }          
        echo'</tbody>';
        echo '</table>';   
           


?>
                    
                    </div>
            </section>
            
           
            <footer class="">
                <a class="buy" href="https://www.buymeacoffee.com/kylerphillips">
                <button class="donate-btn-round"><img src="../assets/img/coffee-buy.png"></button>
                </a>
  <div class="mt1">
    <a href="https://kyler.design" title="Kyler Phillips" class="f4 dib pr2 mid-gray dim">👨 Made by Kyler Phillips</a>
      <a href="https://github.com/NovelCOVID/API" title="Data Source" class="f4 dib pr2 mid-gray dim">📊 Data Source</a>
  </div>
</footer>
            
        </div>
    </div>

  
<script>
     $(document).ready(function() {
        
         var t = $('#uk-table').DataTable( {
        "columnDefs": [ {
            "searchable": false,
            "orderable": false,
            "targets": 0
        } ],
        "order": [[ 2, 'desc' ]],
         "bLengthChange": false,
    } );
 
    t.on( 'order.dt search.dt', function () {
        t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();

    });
   
    </script>

</body>

</html>