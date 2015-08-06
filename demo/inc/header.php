<!DOCTYPE html>
<html>
	<head>
		<title><?= $title ?></title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script>
    	$(document).ready(function(){

    		$(".flash").hide()
    			.slideDown()
    			.delay(2000)
    			.slideUp('slow');
    	});
    </script>
	</head>
	<body>

	<?php include('inc/nav.php'); ?>


