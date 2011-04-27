<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>CP Local Library</title>
	<meta name="generator" content="TextMate http://macromates.com/">
	<meta name="author" content="Dave Lawson">
	
	<!-- this working html library uses the wordpress colors-fresh stylesheet as a base -->
	<link rel="stylesheet" href="css-remote/colors-fresh.css" type="text/css" media="screen" title="no title" />
	<link rel="stylesheet" href="css/admin.css" type="text/css" media="screen" title="no title" />
	<style type="text/css" media="screen">
		body {
			margin: 25px;
		}
		h2 {
			border-bottom: 1px #999 solid;
			color: #999;
			margin-top: 40px;
			padding: bottom: 20px;
		}
	</style>
</head>
<body>
	
	<div style="width: 717px">
		<h2>Navigation Elements</h2>
		<?php include('element-navigation.php'); ?>
		
		<h2>Status Elements</h2>
		<?php include('element-status-in-reply.php'); ?>
		<?php include('element-status-content.php'); ?>
	
		<h2>Quote Elements</h2>
		<?php include('element-quote-content.php'); ?>
		<?php include('element-quote-source.php'); ?>
	
		<h2>Image Elements</h2>
		
		<?php include('element-title.php'); ?>
		<?php include('element-image-start.php'); ?>
		<?php include('element-image-uploaded.php'); ?>
		<?php include('element-description.php'); ?>
	
		<h2>Image Gallery Elements</h2>
		<?php include('element-title.php'); ?>
		<?php include('element-image-gallery.php'); ?>
		<?php include('element-description.php'); ?>
	</div>
	

</body>
</html>
