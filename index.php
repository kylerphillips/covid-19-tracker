<?php
  ini_set("allow_url_fopen", 1);
  header("Access-Control-Allow-Origin: *");

  /* fetch historical API data */
  $json = file_get_contents('https://corona.lmao.ninja/v2/all');
  $obj = json_decode($json);
  $jsonHistorial = file_get_contents('https://corona.lmao.ninja/v2/historical/all?lastdays=all');
  $objHistorial = json_decode($jsonHistorial);
  $arrayHistorial = json_decode(json_encode($objHistorial), true);

  /* cases - chart[1] */
  $datesCases = array_keys($arrayHistorial['cases']);

$items = array();
  foreach ($datesCases as $key => $value) {
    $items[] = date("j M", strtotime($value))."";

  };

$datesFormattedShort = '"'.implode('","',$items).'"' ;


//print_r($datesFormattedShort);

  $datesFormatted = "".implode(",",$datesCases);

  $casesByDay = array_values($arrayHistorial['cases']);
  $casesByDayFormatted = "'".implode("','",$casesByDay)."'";

  /* deaths - chart[2] */
  $datesDeaths = array_keys($arrayHistorial['deaths']);

$itemsD = array();
$itemsDeaths = array();
  foreach ($datesDeaths as $key => $value) {
    $itemsD[] = date("j M", strtotime($value))."";

  };

$datesDeathsFormattedShort = '"'.implode('","',$itemsD).'"' ;

  $datesFormattedDeaths ="'".implode("','",$datesDeaths)."'";
  $deathsByDay = array_values($arrayHistorial['deaths']);
  $deathsByDayFormatted = "'".implode("','",$deathsByDay)."'";



  /* top card calculations */
  $yesterdayCases = end($arrayHistorial['cases']);
  $totalCases = ($obj-> cases);

  $yesterdayDeaths = end($arrayHistorial['deaths']);
  $totalDeaths = ($obj-> deaths);

  $yesterdayRecoveries = end($arrayHistorial['recovered']);
  $totalRecoveries= ($obj-> recovered);

  $activeCases = ($obj-> active);
  $activeYesterday = ($yesterdayCases - $yesterdayDeaths - $yesterdayRecoveries);

  /* calculate percentage change */
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
    if ($num > 1000) {
      $x = round($num);
      $x_number_format = number_format($x);
      $x_array = explode(',', $x_number_format);
      $x_parts = array('k', 'm', 'b', 't');
      $x_count_parts = count($x_array) - 1;
      $x_display = $x;
      $x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
      $x_display .= $x_parts[$x_count_parts - 1];

      return $x_display;
    } else {
      return $num;
    }
  }
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>COVID-19 Tracker</title>
  <meta name="description" content="Track the spread of the Coronavirus Covid-19 outbreak">

  <link rel="stylesheet" href="assets/css/tachyons.min.css">
  <link rel="stylesheet" href="assets/css/site.css?v=1">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-162093056-1"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-162093056-1');
  </script>

  <link rel="apple-touch-icon" sizes="57x57" href="assets/favicon/apple-icon-57x57.png">
  <link rel="apple-touch-icon" sizes="60x60" href="assets/favicon//apple-icon-60x60.png">
  <link rel="apple-touch-icon" sizes="72x72" href="assets/favicon//apple-icon-72x72.png">
  <link rel="apple-touch-icon" sizes="76x76" href="assets/favicon//apple-icon-76x76.png">
  <link rel="apple-touch-icon" sizes="114x114" href="assets/favicon//apple-icon-114x114.png">
  <link rel="apple-touch-icon" sizes="120x120" href="assets/favicon//apple-icon-120x120.png">
  <link rel="apple-touch-icon" sizes="144x144" href="assets/favicon//apple-icon-144x144.png">
  <link rel="apple-touch-icon" sizes="152x152" href="assets/favicon//apple-icon-152x152.png">
  <link rel="apple-touch-icon" sizes="180x180" href="assets/favicon//apple-icon-180x180.png">
  <link rel="icon" type="image/png" sizes="192x192"  href="assets/favicon//android-icon-192x192.png">
  <link rel="icon" type="image/png" sizes="32x32" href="assets/favicon//favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="96x96" href="assets/favicon//favicon-96x96.png">
  <link rel="icon" type="image/png" sizes="16x16" href="assets/favicon//favicon-16x16.png">
  <link rel="manifest" href="assets/favicon//manifest.json">
  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="msapplication-TileImage" content="assets/favicon//ms-icon-144x144.png">
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
  <!-- <script type="text/javascript" src="assets/js/Chart.bundle.min.js"></script> -->

  <!-- Datatables -->
  <script src="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.css" />
  <!-- Chart.js -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.css" />
  <!-- Select2 -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
</head>
<body class="">
  <div class="h-100 midnight-blue pa3 ph0-l pv6-l">
      <div class="center mw7">
          <nav class="db dt-l w-100 border-box pa3 ">
              <div class="switch-wrapper">
                  <img class="theme-icon" src="assets/img/moon.svg">
                  <div class="theme-switch">
                      <div class="switch"></div>
                  </div>
              </div>
          </nav>
      <article class="cf">
        <header class="header mw5 mw7-ns tl pa3">
          <div class="fl w-50-ns pa2">
          <h1 class="mt0">🦠 COVID-19 Tracker</h1>
          <p class="lh-copy measure black-60">
            Track the spread of the Coronavirus Covid-19 outbreak
          </p>
           </div>
            <div class="fl w-50-ns pa2 link">
            <a data-w-id="594c395f-00e8-cb6c-3f01-105396a0bfa3" href="https://www.producthunt.com/posts/covid-19-tracker-4" target="_blank" class="navlinkblock w-inline-block" style="">
                <div class="navbuttoniconwrapper">
                    <div class="navbuttoniconcontainer" style="display: flex;">
                        <img src="https://uploads-ssl.webflow.com/5dc1f3e07930b038a93284e3/5dc6550a11520edf8ee08b97_Icon_PH.svg" alt="" width="19">
                    </div>
                    <div class="navbuttoniconcontainerhover" style="display: none;"><img src="https://uploads-ssl.webflow.com/5dc1f3e07930b038a93284e3/5dc65b13d6571e5414baafc8_Icon_PH_Hover.svg" alt="" width="19"></div>
                </div>
                <div class="phbuttontextcontainer">
                    <div class="navlinktext phtitle" style="">Come and join on</div>
                    <div class="navlinktext phcopy" style="">Product Hunt</div>
                </div>
            </a>
            <a href="https://www.buymeacoffee.com/kylerphillips" target="_blank" class="navlinkblock w-inline-block" style=";">
                <div class="navbuttoniconwrapper coffee">
                    <div class="navbuttoniconcontainer" style="display: flex;"><img src="https://uploads-ssl.webflow.com/5dc1f3e07930b038a93284e3/5dc6534d11520efe89e08779_Icon_Coffee.svg" alt="" width="14">
                    </div>
                    <div class="navbuttoniconcontainerhover" style="display: none;"><img src="https://uploads-ssl.webflow.com/5dc1f3e07930b038a93284e3/5dc65afa2058972e4c7ac0bb_Icon_Coffee_Hover.svg" alt="" width="14">
                    </div>
                </div>
                <div class="phbuttontextcontainer">
                    <div class="navlinktext phtitle" style="">Buy me a coffee</div>
                    <div class="navlinktext phcopy" style="">Support this site</div>
                </div>
            </a>
            </div>

        </header>

        <div class="fl w-50 tc stat-card">
          <div class="card-box tilebox-one">
            <span class="icon">
              <img src="assets/img/cases.svg">
            </span>
            <h6 class="black-40 ttu tl">Total Cases</h6>
            <h3 class="black tl" data-plugin="counterup"><?php echo number_format($obj-> cases) ?></h3>
            <div class="sub-info pt3 pb4">
              <span class="badge <?php echo getBadgeClass(getPercentageChange($yesterdayCases, $totalCases));?> mr-1"><?php echo getPercentageChange($yesterdayCases, $totalCases) ?></span>
              <span class="text-muted black-40">from yesterday (<?php echo thousandsCurrencyFormat($yesterdayCases) ?>)</span>
            </div>
          </div>
        </div>
        <div class="fl w-50 tc stat-card">
          <div class="card-box tilebox-one">
            <span class="icon">
              <img src="assets/img/deaths.svg">
            </span>
            <h6 class="black-40 ttu tl">Total Deaths</h6>
            <h3 class="black tl" data-plugin="counterup"><?php echo number_format($obj-> deaths) ?></h3>
            <div class="sub-info pt3 pb4">
              <span class="badge <?php echo getBadgeClass(getPercentageChange($yesterdayDeaths, $totalDeaths));?> mr-1"><?php echo getPercentageChange($yesterdayDeaths, $totalDeaths) ?></span>
              <span class="text-muted black-40">from yesterday (<?php echo thousandsCurrencyFormat($yesterdayDeaths) ?>)</span>
            </div>
          </div>
        </div>
      </article>
      <article class="cf">
        <div class="fl w-50 tc stat-card">
          <div class="card-box tilebox-one">
            <span class="icon"><img src="assets/img/recoveries.svg"></span>
            <h6 class="black-40 ttu tl">Total Recoveries</h6>
            <h3 class="black tl" data-plugin="counterup"><?php echo number_format($obj-> recovered) ?></h3>
            <div class="sub-info pt3 pb4">
              <span class="badge <?php echo getBadgeClass(getPercentageChange($totalRecoveries, $yesterdayRecoveries));?> mr-1"><?php echo getPercentageChange($yesterdayRecoveries, $totalRecoveries) ?></span>
              <span class="text-muted black-40">from yesterday (<?php echo thousandsCurrencyFormat($yesterdayRecoveries) ?>)</span>
            </div>
          </div>
        </div>
        <div class="fl w-50 tc stat-card">
          <div class="card-box tilebox-one">
            <span class="icon">
              <img src="assets/img/active_cases.svg">
            </span>
            <h6 class="black-40 ttu tl">Active Cases</h6>
            <h3 class="black tl" data-plugin="counterup"><?php echo number_format($obj-> active) ?></h3>
            <div class="sub-info pt3 pb4">
              <span class="badge <?php echo getBadgeClass(getPercentageChange($activeYesterday, $activeCases));?> mr-1"><?php echo getPercentageChange($activeYesterday, $activeCases) ?></span>
              <span class="text-muted black-40">from yesterday (<?php echo thousandsCurrencyFormat($activeYesterday) ?>)</span>
            </div>
          </div>
        </div>
      </article>
      <section class="country-table">

        <div class="table-responsive">
          <?php
            $json = file_get_contents("https://corona.lmao.ninja/v2/countries");
            $select2Data = json_encode($json);
            $data = json_decode($json);
            $array = json_decode(json_encode($data), true);
                  echo '<h1 class="freeze">🌎 Country Breakdown</h1>';
            echo '<table id="country-table" class="table table-striped table-curved">';
            echo '<thead>
                    <tr>
                      <th class="freeze">Rank</th>
                      <th class="freeze" style="    left: 58px;">Country</th>
                      <th>Cases</th>
                      <th>Deaths</th>
                      <th>Critical</th>
                      <th>Recovered</th>
                      <th>Today\'s Cases</th>
                      <th>Today\'s Deaths</th>
                      <th>Cases Per 1M</th>
                      <th>Deaths Per 1M</th>
                    </tr>
                  </thead>';

            echo'<tbody id="tbody">';


            $totalsCases = 0;
            $totalsDeaths = 0;
            $totalsCritical = 0;
            $totalsRecovered = 0;
            $totalsTodayCases = 0;
            $totalsTodayDeaths = 0;

            foreach($array as $result) {
              $totalsCases += $result['cases'];
              $totalsDeaths += $result['deaths'];
              $totalsCritical += $result['critical'];
              $totalsRecovered += $result['recovered'];
              $totalsTodayCases += $result['todayCases'];
              $totalsTodayDeaths += $result['todayDeaths'];
            };

            function styleZeroDeaths($num) {
              if ($num > 0) {
                return " class='badge-danger'>+";
              } else {
                return ">";
              }
            };

            function styleZeroCases($num) {
              if ($num > 0) {
                return " class='badge-warning'>+";
              } else {
                return ">";
              }
            };

            echo '<tr>';
            echo '<td class="freeze">0</td>';
            echo '<td class="freeze" style=" left: 58px;">🌍<div style="padding-left: 10px;" class="country">Global</div></td>';
            echo '<td>' .number_format($totalsCases).'</td>';
            echo '<td>'.number_format($totalsDeaths).'</td>';
            echo '<td>'.number_format($totalsCritical).'</td>';
            echo '<td>'.number_format($totalsRecovered).'</td>';
            echo '<td'.styleZeroCases($totalsTodayCases).number_format($totalsTodayCases).'</td>';
            echo '<td'.styleZeroDeaths($totalsTodayDeaths).number_format($totalsTodayDeaths).'</td>';
            echo '<td>'.number_format($totalsCases/7800).'</td>';
            echo '<td>'.number_format($totalsDeaths/7800).'</td>';
            echo '</tr>';

            foreach($array as $result) {
              echo '<tr>';
              echo '<td class="freeze"></td>';
              echo '<td class="freeze" style=" left: 58px;"> <img src='.$result['countryInfo']['flag'].'><div class="country">'.$result['country'].'</div></td>';
              echo '<td>' .number_format($result['cases']).'</td>';
              echo '<td>'.number_format($result['deaths']).'</td>';
              echo '<td>'.number_format($result['critical']).'</td>';
              echo '<td>'.number_format($result['recovered']).'</td>';
              echo '<td'.styleZeroCases($result['todayCases']).number_format($result['todayCases']).'</td>';
              echo '<td'.styleZeroDeaths($result['todayDeaths']).number_format($result['todayDeaths']).'</td>';
              echo '<td>'.number_format($result['casesPerOneMillion']).'</td>';
              echo '<td>'.number_format($result['deathsPerOneMillion']).'</td>';
              echo '</tr>';
            };
            echo'</tbody>';
            echo '</table>';
          ?>
        </div>
      </section>

      <section class="country-table">
        <div class="card-box chart-wrapper">
          <select class="js-data-example-ajax" style="width: 200px"> <option value="3620194" selected="selected">Filter</option></select>
          <div class="w-75">
            <h1 class="append-flag">Cases</h1>
                    <div class="mb4 mt2">
              <h2 class="lh-copy measure black-60 mb4">Total Cases </h2><p class="lh-copy measure black-60">
             (Linear scale)
          </p>
              </div>
          </div>


            <div id="casesContainer" class="chart-container">
            <canvas id="cases"></canvas>
          </div>
            <div class="mb4 mt4">
            <h2 class="lh-copy measure black-60 mb4 mt4">Daily New Cases </h2><p class="lh-copy measure black-60">per day
          </p>
                </div>
             <div id="newCasesContainer" class="chart-container">
            <canvas id="daily-cases"></canvas>
          </div>




        </div>
      </section>

      <section class="country-table">
        <div class="card-box chart-wrapper">
            <select class="deaths-select" style="width: 200px"> <option value="3620194" selected="selected">Filter</option></select>
            <div class="w-75">
            <h1 class="append-flag">Deaths</h1>
                    <div class="mb4 mt2">
              <h2 class="lh-copy measure black-60 mb4">Total Deaths </h2><p class="lh-copy measure black-60">
             (Linear scale)
          </p>
              </div>
          </div>

        <div id="deathsContainer" class="chart-container">
            <canvas id="deaths"></canvas>
          </div>

                <div class="mb4 mt4">
            <h2 class="lh-copy measure black-60 mb4 mt4">Daily New Deaths </h2><p class="lh-copy measure black-60">per day
          </p>
                </div>
             <div id="newDeathsContainer" class="chart-container">
            <canvas id="daily-deaths"></canvas>
          </div>




        </div>
      </section>

      <script>

      /* Select2 data filter */

      countryDataPHP = <?php echo $select2Data; ?>;
      objS2 = JSON.parse(countryDataPHP);

      var data = $.map(objS2, function (obj) {
  obj.id = obj.id || obj.countryInfo._id;
  obj.text = obj.text || obj.country;
  obj.flag = obj.flag || obj.countryInfo.flag

  return obj;

});

function formatState (state) {
  if (!state.id) {
    return state.flag;
  }
  var baseUrl = "https://raw.githubusercontent.com/NovelCOVID/API/master/assets/flags/";
  var $state = $(
    '<span><img src="' + state.flag + ' " class="img-flag" /> ' + state.text + '</span>'
  );
  return $state;
};




$(".js-data-example-ajax").select2({
    data: data,
    templateResult: formatState
        });

$(".deaths-select").select2({
    data: data,
    templateResult: formatState
        });



</script>
<script>

            var caseByDay = [<?php echo $casesByDayFormatted; ?>];



const newFromCumulative = starting => {
	var end = [];

	starting.forEach((val, index) => {
		if (index == 0) {
    	end.push(0);
    } else {
    	end.push(val - starting[index-1]);
    }
  });

  return end
};

var out = newFromCumulative(caseByDay);

console.log(out);



    /* Initialise chart for daily cases */
         var ctx = document.getElementById('daily-cases');
        var newCasesContainer = new Chart(ctx, {
          type: 'bar',
          responsive: true,

                              data: {
          labels:  [<?php echo $datesFormattedShort; ?>],
          datasets: [{
             data: out,
             backgroundColor: "rgba(54, 162, 235, 0.4)",
             pointBackgrondColor: "rgba(54, 162, 235, 1)",
             borderColor: "rgba(54, 162, 235, 1)",
             borderWidth: 1
          }]


          },
          options: {
              legend: {
        display: false
    },


            scales: {
               xAxes: [{
            gridLines: {
                color: "rgba(0, 0, 0, 0)",
            }
        }],
              yAxes: [{
                    ticks: {
                  beginAtZero: true,
                  callback: function(value, index, values) {
                      if (value >= 0 && value < 1000) return value;
                      if (value >= 1000 && value < 1000000) return (value / 1000) + "k";
                      if (value >= 1000000 && value < 1000000000) return (value / 1000000) + "m";
                      return value;
                  }
                }
              }
                       ]}

            }
          });


        var ctx = document.getElementById('cases');
        var casesChart = new Chart(ctx, {
          type: 'line',
          responsive: true,

                              data: {
          labels:  [<?php echo $datesFormattedShort; ?>],
          datasets: [{
             data: [<?php echo $casesByDayFormatted; ?>],
             backgroundColor: "rgba(54, 162, 235, 0.4)",
             pointBackgrondColor: "rgba(54, 162, 235, 1)",
             borderColor: "rgba(54, 162, 235, 1)",
             borderWidth: 1
          }]


          },
          options: {
              legend: {
        display: false
    },


            scales: {
               xAxes: [{
            gridLines: {
                color: "rgba(0, 0, 0, 0)",
            }
        }],
              yAxes: [{
                    ticks: {
                  beginAtZero: true,
                  callback: function(value, index, values) {
                      if (value >= 0 && value < 1000) return value;
                      if (value >= 1000 && value < 1000000) return (value / 1000) + "k";
                      if (value >= 1000000 && value < 1000000000) return (value / 1000000) + "m";
                      return value;
                  }
                }
              }
                       ]}

            }
          });

    $('.deaths-select').on('select2:select', function (e) {

        $('#flag').remove();

        $('#country-deaths-daily').remove();

            $('#country-deaths').remove();

          var imgurl = id_country_selected = e.params.data.flag;


            $(".select2-selection__rendered").eq(1).prepend("<img class='img-flag' src="+imgurl+">");

            $(".append-flag").eq(1).prepend("<img id='flag' class='img-flag' src="+imgurl+">");

            var id_country_selected = e.params.data.id;
          console.log(id_country_selected);
            var url = "https://corona.lmao.ninja/v2/historical/"+id_country_selected+"?lastdays=all";
            console.log(url);
              $.ajax({
        type: "POST",
        url: "getCountryData.php",
        data: {url: url},
        success: function(data){

            var split = data.split("|");
            var values = String(split[0]);
            var dates  = String(split[1]);
            var valuesDeath  = String(split[2]);
            console.log(values);
            console.log(dates);
            console.log(valuesDeath);

            var arrayValues = values.split(',');
            var arrayDates = dates.split(',');
            var valuesDeathCountry = valuesDeath.split(',');
            console.log(arrayValues);
            console.log(arrayDates);

            var out3 = newFromCumulative(valuesDeathCountry);

            console.log(out3);

            deathsChart.destroy();
            $('#deaths').remove();
            $('#deathsContainer').append('<canvas id="country-deaths"><canvas>');

             var ctx = document.getElementById('country-deaths');
        var deathsChartCountry = new Chart(ctx, {
          type: 'line',
          responsive: true,
                data: {
     labels: [<?php echo $datesDeathsFormattedShort ?>],
     datasets: [{
           data: valuesDeathCountry,
         label: 'Number of Deaths',
           backgroundColor: "rgba(255, 99, 132, 0.4)",
           pointBackgrondColor: "rgba(255, 99, 132, 1)",
           borderColor: "rgba(255, 99, 132, 1)",
           borderWidth: 1

       }]

          },
          options: {
                 legend: {
        display: false
    },
            scales: {
                               xAxes: [{
            gridLines: {
                color: "rgba(0, 0, 0, 0)",
            }
        }],
              yAxes: [{
                ticks: {
                  beginAtZero: true,
                  callback: function(value, index, values) {
                      if (value >= 0 && value < 1000) return value;
                      if (value >= 1000 && value < 1000000) return (value / 1000) + "k";
                      if (value >= 1000000 && value < 1000000000) return (value / 1000000) + "m";
                      return value;
                  }
                }
              }]
            }
          }
        });


            deathsChart2.destroy();
            $('#daily-deaths').remove(); $('#newDeathsContainer').append('<canvas id="country-deaths-daily"><canvas>');




            /* Initialise chart for daily cases */
         var ctx = document.getElementById('country-deaths-daily');
        var countryDailyDeaths = new Chart(ctx, {
          type: 'bar',
          responsive: true,

                              data: {
          labels:  [<?php echo $datesFormattedShort; ?>],
          datasets: [{
             data: out3,
             backgroundColor: "rgba(255, 99, 132, 0.4)",
             pointBackgrondColor: "rgba(255, 99, 132, 1)",
             borderColor: "rgba(255, 99, 132, 1)",
             borderWidth: 1
          }]


          },
          options: {
              legend: {
        display: false
    },


            scales: {
               xAxes: [{
            gridLines: {
                color: "rgba(0, 0, 0, 0)",
            }
        }],
              yAxes: [{
                    ticks: {
                  beginAtZero: true,
                  callback: function(value, index, values) {
                      if (value >= 0 && value < 1000) return value;
                      if (value >= 1000 && value < 1000000) return (value / 1000) + "k";
                      if (value >= 1000000 && value < 1000000000) return (value / 1000000) + "m";
                      return value;
                  }
                }
              }
                       ]}

            }
          });

        }
         })

    });;



        $('.js-data-example-ajax').on('select2:select', function (e) {






            $('#flag').remove();


            $('#country-cases-daily').remove();

            $('#country-cases').remove();

            var imgurl = id_country_selected = e.params.data.flag

            $(".select2-selection__rendered").first().prepend("<img class='img-flag' src="+imgurl+">");

            $(".append-flag").first().prepend("<img  id='flag' class='img-flag' src="+imgurl+">");

            console.log(imgurl);

            var id_country_selected = e.params.data.id;
            console.log(id_country_selected);
            var url = "https://corona.lmao.ninja/v2/historical/"+id_country_selected+"?lastdays=all";
            console.log(url);
              $.ajax({
        type: "POST",
        url: "getCountryData.php",
        data: {url: url},
        success: function(data){

            var split = data.split("|");
            var values = String(split[0]);
            var dates  = String(split[1]);
            console.log(values);
            console.log(dates);

            var arrayValues = values.split(',');
            var arrayDates = dates.split(',');
            console.log(arrayValues);
            console.log(arrayDates);


            var dailyCaseso = newFromCumulative(arrayValues);




            newCasesContainer.destroy();
            $('#daily-cases').remove();
            $('#newCasesContainer').append('<canvas id="country-cases-daily"><canvas>');




            /* Initialise chart for daily cases */
         var ctx = document.getElementById('country-cases-daily');
        var countryDaily = new Chart(ctx, {
          type: 'bar',
          responsive: true,

                              data: {
          labels:  [<?php echo $datesFormattedShort; ?>],
          datasets: [{
             data: dailyCaseso,
             backgroundColor: "rgba(54, 162, 235, 0.4)",
             pointBackgrondColor: "rgba(54, 162, 235, 1)",
             borderColor: "rgba(54, 162, 235, 1)",
             borderWidth: 1
          }]


          },
          options: {
              legend: {
        display: false
    },


            scales: {
               xAxes: [{
            gridLines: {
                color: "rgba(0, 0, 0, 0)",
            }
        }],
              yAxes: [{
                    ticks: {
                  beginAtZero: true,
                  callback: function(value, index, values) {
                      if (value >= 0 && value < 1000) return value;
                      if (value >= 1000 && value < 1000000) return (value / 1000) + "k";
                      if (value >= 1000000 && value < 1000000000) return (value / 1000000) + "m";
                      return value;
                  }
                }
              }
                       ]}

            }
          });



            casesChart.destroy();
            $('#cases').remove();
            $('#casesContainer').append('<canvas id="country-cases"><canvas>');


            var ctx = document.getElementById('country-cases');
        var countriesChart = new Chart(ctx, {
          type: 'line',
          responsive: true,

        data: {
          labels: arrayDates,
          datasets: [{
             data: arrayValues,
             label: 'Number of Cases',
             backgroundColor: "rgba(54, 162, 235, 0.4)",
             pointBackgrondColor: "rgba(54, 162, 235, 1)",
             borderColor: "rgba(54, 162, 235, 1)",
             borderWidth: 1
          }]


          },
          options: {
                 legend: {
        display: false
    },
            scales: {
                               xAxes: [{
            gridLines: {
                color: "rgba(0, 0, 0, 0)",
            }
        }],
              yAxes: [{
                ticks: {
                  beginAtZero: true,
                  callback: function(value, index, values) {
                      if (value >= 0 && value < 1000) return value;
                      if (value >= 1000 && value < 1000000) return (value / 1000) + "k";
                      if (value >= 1000000 && value < 1000000000) return (value / 1000000) + "m";
                      return value;
                  }
                }
              }]
            }
          }
        });
        }

    })
        });
      </script>

      <script>
                      var deathByDay = [<?php echo $deathsByDayFormatted; ?>];



var out2 = newFromCumulative(deathByDay);

          /* Initialise death charts */
               var ctx = document.getElementById('daily-deaths');
        var deathsChart2 = new Chart(ctx, {
          type: 'bar',
          responsive: true,
                data: {
     labels: [<?php echo $datesDeathsFormattedShort ?>],
     datasets: [{
           data: out2,
         label: 'Number of Deaths',
           backgroundColor: "rgba(255, 99, 132, 0.4)",
           pointBackgrondColor: "rgba(255, 99, 132, 1)",
           borderColor: "rgba(255, 99, 132, 1)",
           borderWidth: 1

       }]

          },
          options: {
                 legend: {
        display: false
    },
            scales: {
                               xAxes: [{
            gridLines: {
                color: "rgba(0, 0, 0, 0)",
            }
        }],
              yAxes: [{
                ticks: {
                  beginAtZero: true,
                  callback: function(value, index, values) {
                      if (value >= 0 && value < 1000) return value;
                      if (value >= 1000 && value < 1000000) return (value / 1000) + "k";
                      if (value >= 1000000 && value < 1000000000) return (value / 1000000) + "m";
                      return value;
                  }
                }
              }]
            }
          }
        });


        var ctx = document.getElementById('deaths');
        var deathsChart = new Chart(ctx, {
          type: 'line',
          responsive: true,
                data: {
     labels: [<?php echo $datesDeathsFormattedShort ?>],
     datasets: [{
           data: [<?php echo $deathsByDayFormatted; ?>],
         label: 'Number of Deaths',
           backgroundColor: "rgba(255, 99, 132, 0.4)",
           pointBackgrondColor: "rgba(255, 99, 132, 1)",
           borderColor: "rgba(255, 99, 132, 1)",
           borderWidth: 1

       }]

          },
          options: {
                 legend: {
        display: false
    },
            scales: {
                               xAxes: [{
            gridLines: {
                color: "rgba(0, 0, 0, 0)",
            }
        }],
              yAxes: [{
                ticks: {
                  beginAtZero: true,
                  callback: function(value, index, values) {
                      if (value >= 0 && value < 1000) return value;
                      if (value >= 1000 && value < 1000000) return (value / 1000) + "k";
                      if (value >= 1000000 && value < 1000000000) return (value / 1000000) + "m";
                      return value;
                  }
                }
              }]
            }
          }
        });
      </script>
      <footer class="">

        <div class="mt1">
          <a href="https://kyler.design" title="Kyler Phillips" class="f4 dib pr2 mid-gray dim">👨 Made by Kyler Phillips</a>
          <a href="https://github.com/NovelCOVID/API" title="Data Source" class="f4 dib pr2 mid-gray dim">📊 Data Source</a>
        </div>
      </footer>
    </div>
  </div>
  <script>
    $(() => {
      var t = $('#country-table').DataTable({

        "columnDefs": [ {
          "searchable": false,
          "orderable": false,
          "targets": 0
        } ],
        "order": [[ 2, 'desc' ]],
        "bLengthChange": false,
      });

      t.on('order.dt search.dt', () => {
        t.column(0, {search:'applied', order:'applied'}).nodes().each((cell, i) => {
          cell.innerHTML = i+1;
        });
      }).draw();
    });
  </script>
  <script>

      function isDay() {
  const hours = (new Date()).getHours();
  return (hours >= 6 && hours < 18);
}
/* Dynamically change theme */
      // if (isDay() == false) {
      //     $("body").toggleClass("light-theme");
      // } else {
      //     $("body").toggleClass("");
      // }

      $(".theme-switch").on("click", () => {
          $("body").toggleClass("light-theme");
      });
  </script>

  <script>// Add basic styles for active tabs
$('.tabs__menu-item').on('click', function() {
  $(this).addClass('bg-white').addClass('red');
  $(this).siblings().removeClass('red');
});</script>

</body>
</html>
