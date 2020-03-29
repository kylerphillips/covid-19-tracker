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


?>

<!doctype html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <title>COVID-19 Tracker</title>
    <meta name="description" content="Track the spread of the Coronavirus Covid-19 outbreak">

    <link rel="stylesheet" href="assets/css/tachyons.min.css">
    <link rel="stylesheet" href="assets/css/site.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js">
      
    </script>
    <script src="assets/js/jput.min.js">
    </script>
    
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

    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.js"></script>

       <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.css" />
    
</head>

<body>
    <div class="h-100 midnight-blue pa3 ph0-l pv6-l">
        <div class="center mw7">
            <article class="cf">
 <a href="https://www.producthunt.com/posts/covid-19-tracker-4?utm_source=badge-featured&utm_medium=badge&utm_souce=badge-covid-19-tracker-4" target="_blank"><img class="product-hunt"src="https://api.producthunt.com/widgets/embed-image/v1/featured.svg?post_id=190043&theme=light" alt="COVID-19 Tracker - Simple, no bullshit COVID-19 tracker. | Product Hunt Embed" style="width: 250px; height: 54px;" width="250px" height="54px" /></a>
            
                <header class="header mw5 mw7-ns tl pa3">
                    <h1 class="mt0">🦠 COVID-19 Tracker</h1>
                    <p class="lh-copy measure black-60">
                        Track the spread of the Coronavirus Covid-19 outbreak
                    </p>
                </header>


                <div class="fl w-50 tc stat-card">
                    <div class="card-box tilebox-one">
                        <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="48" height="48" viewBox="0 0 48 48" style=" fill:#000000;">
                                <path fill="#F44336" d="M38,44H12V4h26c2.2,0,4,1.8,4,4v32C42,42.2,40.2,44,38,44"></path>
                                <path fill="#BF360C" d="M10,4h2v40h-2c-2.2,0-4-1.8-4-4V8C6,5.8,7.8,4,10,4"></path>
                                <path fill="#FFF" d="M26,14c-5.5,0-10,4.5-10,10c0,5.5,4.5,10,10,10c5.5,0,10-4.5,10-10C36,18.5,31.5,14,26,14z M32,26h-4v4h-4v-4h-4v-4h4v-4h4v4h4V26z"></path>
                            </svg></span>
                        <h6 class="black-40 ttu tl">Total Cases</h6>
                        <h3 class="black tl" data-plugin="counterup"><?php echo number_format($obj-> cases) ?></h3>
                         <div class="sub-info pt3 pb4">
                    <span class="badge <?php echo getBadgeClass(getPercentageChange($yesterdayCases, $totalCases));?> mr-1"><?php echo getPercentageChange($yesterdayCases, $totalCases) ?></span>
                        <span class="text-muted black-40">from yesterday</span>
                        </div>
                    </div>
                </div>
                <div class="fl w-50 tc stat-card">
                    <div class="card-box tilebox-one">
                        <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="48" height="48" viewBox="0 0 48 48" style=" fill:#000000;">
                                <path fill="#B39DDB" d="M36,35H12V11.1c0,0,3.7-5.1,12-5.1s12,5.1,12,5.1V35z"></path>
                                <path fill="#9575CD" d="M17 14H31V16H17zM17 18H31V20H17zM17 22H31V24H17zM17 26H31V28H17z"></path>
                                <path fill="#B39DDB" d="M6 38H42V42H6z"></path>
                                <path fill="#9575CD" d="M8 34H40V38H8z"></path>
                            </svg></span>
                        <h6 class="black-40 ttu tl">Total Deaths</h6>
                        <h3 class="black tl" data-plugin="counterup"><?php echo number_format($obj-> deaths) ?></h3>
                        <div class="sub-info pt3 pb4">
                        <span class="badge <?php echo getBadgeClass(getPercentageChange($yesterdayDeaths, $totalDeaths));?> mr-1"><?php echo getPercentageChange($yesterdayDeaths, $totalDeaths) ?></span>
                        <span class="text-muted black-40">from yesterday</span>
                        </div>
                    </div>
                </div>
            </article>
            <article class="cf">
                <div class="fl w-50 tc stat-card">
                    <div class="card-box tilebox-one">
                        <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="48" height="48" viewBox="0 0 48 48" style=" fill:#000000;">
                                <path fill="#d7ccc8" d="M15 44L27 41 6 41z"></path>
                                <path fill="#fff176" d="M6 7H27V41H6z"></path>
                                <path fill="#fff59d" d="M6 41L27 41 27 17 6 7z"></path>
                                <path fill="#fff9c4" d="M6 41L27 41 27 31 6 7z"></path>
                                <path fill="#f44336" d="M6 41L13 44 13 4 6 7z"></path>
                                <path fill="#e0e0e0" d="M11.5 25A0.5 1 0 1 0 11.5 27A0.5 1 0 1 0 11.5 25Z"></path>
                                <path fill="#d50000" d="M13 4H15V44H13z"></path>
                                <path fill="#ffa726" d="M24,19.008c0,0,0.5,0.96,2,0.96c1.667,0,2-0.96,2-0.96v-2.331h-4V19.008z"></path>
                                <path fill="#455a64" d="M22 32L23 43 26.002 43 29 43 30 32 30 30 22 30z"></path>
                                <path fill="#ffb74d" d="M20 31L22 32 22 25 20 24zM30 32L32 31 32 24 30 25zM26 10A4 4 0 1 0 26 18 4 4 0 1 0 26 10z"></path>
                                <path fill="#424242" d="M27.571,9.812L27.19,9h-1.362C23.881,9,22,10.223,22,13.667V14l1,1v-2.5l4.75-1.5L29,12.5V15l1-1 v-0.333C30,11.707,29.823,10.292,27.571,9.812z"></path>
                                <path fill="#263238" d="M25.457 43L26.547 43 26.002 32.032z"></path>
                                <path fill="#039be5" d="M28.939,19.349c-0.072,0.2-0.66,1.618-2.939,1.618c-1.663,0-2.597-0.941-2.887-1.498l-0.061-0.117 C20.003,20.796,20,24,20.004,24.355L22,25v6h8v-6l2-1C32,24,31.99,20.791,28.939,19.349z"></path>
                                <path fill="#90caf9" d="M28,19.008c0,0-0.333,0.96-2,0.96c-1.5,0-2-0.96-2-0.96v-0.011c-0.348,0.094-0.658,0.218-0.948,0.356 l0.061,0.117c0.29,0.556,1.224,1.498,2.887,1.498c2.279,0,2.868-1.418,2.939-1.618c-0.288-0.136-0.595-0.259-0.939-0.352V19.008z"></path>
                                <path fill="#f44336" d="M42.333,9h-6.667C34.747,9,34,9.747,34,10.667v6.667C34,18.253,34.747,19,35.667,19h6.667 C43.253,19,44,18.253,44,17.333v-6.667C44,9.747,43.253,9,42.333,9z"></path>
                                <path fill="#fff" d="M38 11H40V17H38z"></path>
                                <path fill="#fff" d="M36 13H42V15H36z"></path>
                            </svg></span>
                        <h6 class="black-40 ttu tl">Total Recoveries</h6>
                        <h3 class="black tl" data-plugin="counterup"><?php echo number_format($obj-> recovered) ?></h3>
                        
                    
                    </div>
                </div>
                <div class="fl w-50 tc stat-card">
                    <div class="card-box tilebox-one">
                        <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="48" height="48" viewBox="0 0 48 48" style=" fill:#000000;">
                                <path fill="#6A1B9A" d="M32.322,9.042c-0.21,0.511-0.795,0.755-1.306,0.544l-1.85-0.762c-0.511-0.211-0.754-0.795-0.544-1.305l0,0c0.211-0.511,0.795-0.755,1.306-0.545l1.85,0.762C32.289,7.947,32.532,8.531,32.322,9.042L32.322,9.042z"></path>
                                <path fill="#6A1B9A" d="M28.521 8.093H30.521V13.093H28.521z" transform="rotate(22.382 29.52 10.593)"></path>
                                <path fill="#6A1B9A" d="M19.377,40.48c0.21-0.51-0.033-1.095-0.545-1.305l-1.849-0.762c-0.512-0.211-1.096,0.033-1.306,0.544l0,0c-0.21,0.511,0.033,1.095,0.544,1.306l1.85,0.762C18.582,41.235,19.166,40.991,19.377,40.48L19.377,40.48z"></path>
                                <path fill="#6A1B9A" d="M17.479 34.907H19.479V39.907H17.479z" transform="rotate(22.362 18.48 37.404)"></path>
                                <path fill="#6A1B9A" d="M9.042,15.678c0.511,0.21,0.755,0.795,0.544,1.306l-0.762,1.849c-0.21,0.512-0.795,0.754-1.306,0.545l0,0c-0.51-0.211-0.754-0.795-0.544-1.307l0.762-1.849C7.947,15.711,8.532,15.468,9.042,15.678L9.042,15.678z"></path>
                                <path fill="#6A1B9A" d="M9.592 15.978H11.592V20.979H9.592z" transform="rotate(-67.618 10.592 18.478)"></path>
                                <path fill="#6A1B9A" d="M40.48,28.623c-0.51-0.209-1.095,0.033-1.305,0.545l-0.762,1.849c-0.211,0.511,0.033,1.096,0.544,1.306l0,0c0.51,0.21,1.095-0.033,1.306-0.544l0.762-1.85C41.235,29.418,40.991,28.834,40.48,28.623L40.48,28.623z"></path>
                                <path fill="#6A1B9A" d="M36.408 27.021H38.407000000000004V32.021H36.408z" transform="rotate(-67.604 37.409 29.52)"></path>
                                <path fill="#6A1B9A" d="M7.539,28.691c0.509-0.212,1.095,0.027,1.308,0.538l0.769,1.847c0.213,0.51-0.029,1.096-0.538,1.309l0,0c-0.51,0.211-1.095-0.029-1.308-0.539L7,30C6.787,29.488,7.029,28.904,7.539,28.691L7.539,28.691z"></path>
                                <path fill="#6A1B9A" d="M9.616 27.076H11.615V32.076H9.616z" transform="scale(-1) rotate(67.394 44.351 -15.92)"></path>
                                <path fill="#6A1B9A" d="M38.923,15.615c-0.509,0.213-0.751,0.797-0.538,1.307l0.77,1.847c0.213,0.511,0.798,0.751,1.308,0.538l0,0c0.509-0.211,0.751-0.797,0.539-1.307l-0.771-1.847C40.019,15.644,39.434,15.402,38.923,15.615L38.923,15.615z"></path>
                                <path fill="#6A1B9A" d="M36.384 15.922H38.385V20.922H36.384z" transform="rotate(-112.65 37.384 18.422)"></path>
                                <path fill="#6A1B9A" d="M19.309,7.538c0.212,0.51-0.028,1.095-0.538,1.308l-1.847,0.77c-0.51,0.212-1.096-0.029-1.308-0.539l0,0c-0.212-0.51,0.028-1.096,0.538-1.308L18.001,7C18.512,6.787,19.097,7.028,19.309,7.538L19.309,7.538z"></path>
                                <path fill="#6A1B9A" d="M17.424 8.114H19.424V13.114H17.424z" transform="rotate(-22.631 18.425 10.615)"></path>
                                <path fill="#6A1B9A" d="M32.386,38.922c-0.214-0.508-0.798-0.75-1.308-0.538l-1.846,0.769c-0.512,0.215-0.752,0.8-0.54,1.311l0,0C28.905,40.971,29.49,41.213,30,41l1.847-0.77C32.357,40.018,32.598,39.432,32.386,38.922L32.386,38.922z"></path>
                                <path fill="#6A1B9A" d="M28.577 34.883H30.579V39.884H28.577z" transform="rotate(-22.661 29.58 37.384)"></path>
                                <g>
                                    <path fill="#9C27B0" d="M26,5c0,0.552-0.447,1-1,1h-2c-0.553,0-1-0.448-1-1l0,0c0-0.552,0.447-1,1-1h2C25.553,4,26,4.448,26,5L26,5z"></path>
                                    <path fill="#9C27B0" d="M23 5H25V10H23zM26 43c0-.552-.447-1-1-1h-2c-.553 0-1 .448-1 1l0 0c0 .552.447 1 1 1h2C25.553 44 26 43.552 26 43L26 43z"></path>
                                    <path fill="#9C27B0" d="M23 38H25V43H23zM5 22c.552 0 1 .447 1 1v2c0 .553-.448 1-1 1l0 0c-.552 0-1-.447-1-1v-2C4 22.447 4.448 22 5 22L5 22z"></path>
                                    <path fill="#9C27B0" d="M5 23H10V25H5zM43 22c-.552 0-1 .447-1 1v2c0 .553.448 1 1 1l0 0c.552 0 1-.447 1-1v-2C44 22.447 43.552 22 43 22L43 22z"></path>
                                    <path fill="#9C27B0" d="M38 23H43V25H38zM9.15 36.021c.391-.39 1.023-.391 1.415 0l1.414 1.414c.391.391.39 1.024 0 1.414l0 0c-.391.391-1.023.392-1.414 0L9.15 37.435C8.76 37.044 8.761 36.411 9.15 36.021L9.15 36.021z"></path>
                                    <path fill="#9C27B0" d="M11.333 33.167H13.333V38.166000000000004H11.333z" transform="rotate(-134.999 12.333 35.667)"></path>
                                    <path fill="#9C27B0" d="M36.021,9.15c-0.39,0.391-0.391,1.023,0,1.414l1.415,1.414c0.391,0.392,1.023,0.391,1.414,0l0,0c0.39-0.39,0.391-1.023,0-1.414L37.436,9.15C37.044,8.76,36.411,8.761,36.021,9.15L36.021,9.15z"></path>
                                    <path fill="#9C27B0" d="M34.667 9.832H36.667V14.833000000000002H34.667z" transform="scale(-1) rotate(44.98 29.787 -86.145)"></path>
                                    <path fill="#9C27B0" d="M36.021,38.85c-0.39-0.391-0.391-1.023,0-1.415l1.414-1.414c0.391-0.391,1.024-0.39,1.414,0l0,0c0.391,0.391,0.392,1.023,0,1.414l-1.414,1.415C37.044,39.24,36.411,39.239,36.021,38.85L36.021,38.85z"></path>
                                    <path fill="#9C27B0" d="M34.667 33.167H36.667V38.166000000000004H34.667z" transform="rotate(134.999 35.667 35.667)"></path>
                                    <path fill="#9C27B0" d="M9.15,11.979c0.391,0.39,1.023,0.391,1.414,0l1.414-1.415c0.392-0.391,0.391-1.023,0-1.414l0,0c-0.39-0.39-1.023-0.391-1.414,0L9.15,10.564C8.76,10.956,8.761,11.589,9.15,11.979L9.15,11.979z"></path>
                                    <path fill="#9C27B0" d="M11.332 9.833H13.332V14.834H11.332z" transform="scale(-1) rotate(-45.02 -29.758 29.757)"></path>
                                </g>
                                <path fill="#8BC34A" d="M24 9A15 15 0 1 0 24 39A15 15 0 1 0 24 9Z"></path>
                                <path fill="#689F38" d="M24,11c7.168,0,13,5.832,13,13c0,7.168-5.832,13-13,13c-7.168,0-13-5.832-13-13C11,16.832,16.832,11,24,11 M24,9C15.716,9,9,15.716,9,24s6.716,15,15,15s15-6.716,15-15S32.284,9,24,9L24,9z"></path>
                                <g>
                                    <path fill="#558B2F" d="M20.94 34.523c-.102 0-.205-.016-.308-.049l-.205-.068c-.523-.178-.802-.746-.624-1.27.178-.522.747-.804 1.269-.623l.175.059c.525.169.814.733.644 1.259C21.755 34.254 21.363 34.523 20.94 34.523zM28.852 33.747c-.351 0-.69-.185-.874-.512-.27-.482-.097-1.092.385-1.361l.162-.092c.479-.276 1.091-.111 1.365.367.276.479.111 1.09-.367 1.365l-.184.105C29.185 33.706 29.017 33.747 28.852 33.747zM24.541 34.909c-.327-.127-.577-.422-.629-.793-.077-.548.305-1.053.852-1.13l.184-.026c.547-.085 1.058.291 1.14.837.084.546-.291 1.056-.837 1.139l-.209.032C24.866 34.992 24.694 34.97 24.541 34.909zM17.334 32.454c-.237 0-.474-.084-.665-.253l-.167-.153c-.402-.378-.422-1.011-.043-1.413.377-.404 1.011-.423 1.414-.044L18 30.707c.412.368.449 1 .081 1.412C17.883 32.341 17.609 32.454 17.334 32.454zM31.986 31.019c-.211 0-.423-.066-.604-.203-.44-.334-.526-.962-.192-1.401l.106-.144c.324-.447.948-.545 1.396-.221.447.324.546.95.221 1.396l-.13.177C32.587 30.883 32.288 31.019 31.986 31.019zM14.878 29.103c-.381 0-.745-.219-.912-.589l-.088-.2c-.217-.508.019-1.095.526-1.313.51-.216 1.096.02 1.313.527l.071.163c.228.503.004 1.095-.5 1.322C15.155 29.074 15.016 29.103 14.878 29.103zM33.746 27.253c-.073 0-.148-.008-.223-.024-.538-.123-.876-.658-.754-1.197l.04-.177c.112-.54.643-.891 1.183-.774.541.112.888.643.774 1.183l-.046.212C34.615 26.938 34.202 27.253 33.746 27.253zM14 25.021c-.552 0-1-.427-1-.979l.002-.262c.012-.552.454-.984 1.021-.978.552.012.99.47.978 1.022L15 24C15 24.552 14.552 25.021 14 25.021zM33.818 23.098c-.47 0-.888-.332-.98-.81l-.037-.18c-.114-.541.232-1.071.772-1.185.538-.113 1.07.232 1.185.772l.043.211c.105.542-.249 1.067-.791 1.172C33.945 23.092 33.882 23.098 33.818 23.098zM14.86 20.935c-.137 0-.275-.028-.408-.088-.504-.226-.729-.817-.504-1.321l.088-.193c.232-.502.827-.718 1.328-.487.501.232.719.827.487 1.328l-.078.17C15.607 20.715 15.242 20.935 14.86 20.935zM32.198 19.271c-.314 0-.624-.148-.819-.425l-.106-.148c-.325-.447-.227-1.072.221-1.397.447-.325 1.072-.226 1.396.22l.126.176c.317.452.208 1.075-.243 1.393C32.598 19.212 32.396 19.271 32.198 19.271zM17.306 17.572c-.273 0-.546-.111-.744-.331-.37-.41-.336-1.042.074-1.413l.165-.146c.418-.36 1.051-.314 1.411.103.361.418.315 1.049-.103 1.411l-.134.118C17.783 17.487 17.544 17.572 17.306 17.572zM29.16 16.433c-.178 0-.358-.047-.521-.147l-.148-.088c-.479-.275-.644-.887-.367-1.366.275-.478.886-.643 1.365-.367l.195.115c.471.289.619.904.33 1.375C29.825 16.263 29.497 16.433 29.16 16.433zM20.902 15.49c-.421 0-.813-.269-.951-.691-.171-.525.116-1.089.641-1.26l.208-.066c.528-.161 1.087.136 1.249.665.161.528-.136 1.087-.665 1.249l-.173.054C21.108 15.474 21.004 15.49 20.902 15.49zM25.234 15.075c-.042 0-.084-.002-.127-.008l-.175-.02c-.549-.057-.949-.548-.892-1.097.056-.549.543-.957 1.097-.892l.222.025c.548.07.936.57.866 1.118C26.161 14.706 25.73 15.075 25.234 15.075zM23.012 30.919c-.054 0-.108-.004-.163-.014-.08-.013-.16-.027-.24-.044-.541-.113-.886-.645-.772-1.185s.644-.886 1.185-.772l.152.028c.545.089.914.604.825 1.148C23.917 30.571 23.493 30.919 23.012 30.919zM26.867 30.272c-.353 0-.695-.187-.877-.519-.267-.483-.09-1.092.395-1.357l.148-.084c.478-.282 1.09-.12 1.368.356.279.477.12 1.089-.356 1.368l-.197.111C27.195 30.232 27.03 30.272 26.867 30.272zM19.444 28.903c-.284 0-.566-.12-.764-.354l-.144-.173c-.345-.432-.276-1.061.155-1.406.43-.345 1.059-.277 1.406.154l.11.134c.357.421.304 1.052-.117 1.409C19.901 28.825 19.672 28.903 19.444 28.903zM29.582 27.203c-.123 0-.248-.022-.369-.07-.513-.204-.764-.785-.561-1.299l.059-.155c.187-.521.761-.791 1.279-.604.521.188.79.76.604 1.279l-.082.218C30.355 26.964 29.979 27.203 29.582 27.203zM17.999 25.035c-.542 0-.987-.4-.999-.944 0-.007 0-.083 0-.091l.004-.236c.021-.552.482-.975 1.036-.963.552.021.983.484.963 1.036L19 24c0 .548-.441 1.028-.989 1.034C18.007 25.034 18.003 25.035 17.999 25.035zM29.695 23.107c-.423 0-.814-.27-.951-.693l-.051-.142c-.195-.517.065-1.094.582-1.289.515-.195 1.094.065 1.289.582.029.077.057.155.082.234.17.526-.118 1.089-.644 1.259C29.9 23.091 29.797 23.107 29.695 23.107zM19.398 21.149c-.227 0-.454-.076-.641-.233-.424-.354-.48-.985-.125-1.409l.154-.178c.37-.411 1.001-.443 1.413-.074.41.37.443 1.002.074 1.413l-.106.123C19.968 21.027 19.684 21.149 19.398 21.149zM27.15 19.894c-.178 0-.358-.047-.521-.147l-.147-.089c-.479-.275-.644-.887-.367-1.366.274-.478.887-.643 1.365-.367l.194.115c.471.289.619.904.33 1.375C27.815 19.724 27.487 19.894 27.15 19.894zM22.942 19.093c-.475 0-.896-.339-.983-.822-.098-.543.263-1.064.806-1.162l.236-.038c.543-.079 1.052.304 1.128.852.077.547-.305 1.052-.852 1.128l-.157.025C23.061 19.088 23 19.093 22.942 19.093z"></path>
                                </g>
                            </svg></span>
                        <h6 class="black-40 ttu tl">Active Cases</h6>
                        <h3 class="black tl" data-plugin="counterup"><?php echo number_format($obj-> active)  ?></h3>
                       
                    </div>
                </div>
            </article>
            <section class="country-table">
                <h1>🌎 Country Breakdown</h1>

  <?php 
        $json=file_get_contents("https://corona.lmao.ninja/countries");
    $data =  json_decode($json);
 
$array = json_decode(json_encode($data), true);
    
 echo '<table id="country-table" class="table table-striped table-curved">';
echo '  <thead>
                        <tr>
                            <th>Country</th>
                            <th>Cases</th>
                            <th>Deaths</th>
                            <th>Recovered</th>
                            <th>Today\'s Cases</th>
                            <th>Today\'s Deaths</th>
                        </tr>
                    </thead>';   
    
    echo'<tbody id="tbody">';
        foreach($array as $result){
           
          echo '<tr>';
            echo '<td> <img src='.$result['countryInfo']['flag'].'>'.$result['country'].'</td>';
            echo '<td>' .number_format($result['cases']).'</td>';
            echo '<td>'.number_format($result['deaths']).'</td>';
            echo '<td>'.number_format($result['recovered']).'</td>';
            echo '<td>'.number_format($result['todayCases']).'</td>';
            echo '<td>'.number_format($result['todayDeaths']).'</td>';
          echo '</tr>';
        }          
        echo'</tbody>';
        echo '</table>';                 


?>
            </section>
            
           
            <footer class="">
  <div class="mt1">
    <a href="https://kyler.design" title="Kyler Phillips" class="f4 dib pr2 mid-gray dim">👨 Made by Kyler Phillips</a>
      <a href="https://github.com/NovelCOVID/API" title="Data Source" class="f4 dib pr2 mid-gray dim">📊 Data Source</a>
  </div>
</footer>
        </div>
    </div>

  
<script>
     $(document).ready(function() {
    $('#country-table').DataTable({
     "order": [
      [1, "desc"]
     ],
        "bLengthChange": false,
    });
   });
    </script>

</body>

</html>