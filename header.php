<?php
// Start the session
session_start();

if (!isset($_SESSION["login"])) {die('not login');}


$customer_page='';
$insurance_page='';
$document_page='';
if (isset($page)) {
 switch ($page)
{
case 'customer':
$customer_page='active';
break;
case 'insurance':
$insurance_page='active';
break;
case 'renewal_register':
$renewal_register_page='active';
break;
case 'document':
$document_page='active';
break;
case 'calculator':
$calculator_page='active';
break;

}
}

include('fun.php');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Volkswagen Bareilly</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	
	
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
<link href="bootstrap-editable/css/bootstrap-editable.css" rel="stylesheet">
<script src="bootstrap-editable/js/bootstrap-editable.min.js"></script>
  </head>
  <body>

  <nav class="navbar navbar-default">
  <div class="container-fluid">
  <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php">Volkswagen Bareilly</a>
    </div>
  
  
    <!-- Brand and toggle get grouped for better mobile display -->

	  <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	  <ul class="nav navbar-nav">
	  <li class="<?=$customer_page?>"><a href="customers.php">CUSTOMERS</a></li>
	  <li class="<?=$insurance_page?>"><a href="insurance.php">INSURANCE</a></li>
	  <li class="<?=$renewal_register_page?>"><a href="renewal_register.php">RENEWAL REGISTER</a></li>
	  <li class="<?=$document_page?>"><a href="document.php">DOCUMENTS</a></li>
	  </ul>
	  </div>
	  

	
	  
</div></nav>	