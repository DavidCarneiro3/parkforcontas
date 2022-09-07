
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Parkfor - Contas</title>
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/font-awesome.min.css" rel="stylesheet">
        <link href="css/prettyPhoto.css" rel="stylesheet">
        <link href="css/price-range.css" rel="stylesheet">
        <link href="css/animate.css" rel="stylesheet">
        <link href="css/main.css" rel="stylesheet">
        <link href="css/responsive.css" rel="stylesheet">
        <!--[if lt IE 9]>
        <script src="js/html5shiv.js"></script>
        <script src="js/respond.min.js"></script>
        <![endif]-->       
        <link rel="shortcut icon" href="./imgages/favicon.ico" />
        <!-- <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png"> -->
        <!-- choose a theme file -->
<link rel="stylesheet" href="js/dist/css/theme.blue.css">
<script src="js/jquery.js"></script>
<!-- load jQuery and tablesorter scripts -->
<!-- <script type="text/javascript" src="js/dist/js/jquery-latest.js"></script> -->
<script type="text/javascript" src="js/dist/js/jquery.tablesorter.js"></script>

<!-- tablesorter widgets (optional) -->
<script type="text/javascript" src="js/dist/js/jquery.tablesorter.widgets.js"></script>

    </head><!--/head-->
<body>
<table class="tablesorter" id="mytable">
  <thead>
    <tr>
      <th>AlphaNumeric</th>
      <th>Numeric</th>
      <th>Animals</th>
      <th>Sites</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>abc 123</td>
      <td>10</td>
      <td>Koala</td>
      <td>http://www.google.com</td>
    </tr>
    <tr>
      <td>abc 1</td>
      <td>234</td>
      <td>Ox</td>
      <td>http://www.yahoo.com</td>
    </tr>
    <tr>
      <td>abc 9</td>
      <td>10</td>
      <td>Girafee</td>
      <td>http://www.facebook.com</td>
    </tr>
    <tr>
      <td>zyx 24</td>
      <td>767</td>
      <td>Bison</td>
      <td>http://www.whitehouse.gov/</td>
    </tr>
    <tr>
      <td>abc 11</td>
      <td>3</td>
      <td>Chimp</td>
      <td>http://www.ucla.edu/</td>
    </tr>
    <tr>
      <td>abc 2</td>
      <td>56</td>
      <td>Elephant</td>
      <td>http://www.wikipedia.org/</td>
    </tr>
    <tr>
      <td>abc 9</td>
      <td>155</td>
      <td>Lion</td>
      <td>http://www.nytimes.com/</td>
    </tr>
    <tr>
      <td>ABC 10</td>
      <td>87</td>
      <td>Zebra</td>
      <td>http://www.google.com</td>
    </tr>
    <tr>
      <td>zyx 1</td>
      <td>999</td>
      <td>Koala</td>
      <td>http://www.mit.edu/</td>
    </tr>
    <tr>
      <td>zyx 12</td>
      <td>0</td>
      <td>Llama</td>
      <td>http://www.nasa.gov/</td>
    </tr>
  </tbody>
  <script>
    $(function() {
        $("#mytable").tablesorter();
     });
  </script>
</table>
</body>
</html>
