<!DOCTYPE html>
<html lang="pt">
	<head>
		<title>Site Checker</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href='http://fonts.googleapis.com/css?family=Ubuntu|Inconsolata' rel='stylesheet' type='text/css'>
		<link href="style.css" media="screen" rel="stylesheet" type="text/css" />
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	</head>
	<body>
	<div class="wrap">
		<div class="page">
			<div class="toolbar">
				<h1>Site Checker</h1>
				<span class="last-check f-r"></span>
			</div>
			
			<div class="check-wrap">
				<button class="btn btn-check-now f-r" onclick="checkNow();">Check Now</button>
			</div>
			
		<div class="sites-wrap-offline">
			<h2>Sites Offline</h2>
			<ul class="sites sites-offline"></ul>
		</div>
		
		<div class="sites-wrap-timeout">
			<h2>Sites Timed Out</h2>
			<ul class="sites sites-timeout"></ul>
		</div>
		
		<div class="sites-wrap">
			<h2>Sites Online</h2>
			
			<ul class="sites sites-online">
		<?php foreach( $sites AS $i => $site ) : ?>
	
			<li class="site site-<?php echo $i+1; ?>" data-el="site-<?php echo $i+1; ?>" data-url="<?php echo $site; ?>">
				<span class="col url"><?php echo str_replace('http://', '', $site); ?></span>
				<span class="col time sort"></span>
				<a class="col link" href="<?php echo $site; ?>" target="_blank">&rsaquo;</a>
			</li>

		<?php endforeach; ?>
			</ul>
		</div>
		
			<div class="footer">
				<a href="http://softag.pt" target="_blank">with passion by softag</a>
			</div>
		</div>
	</div>

		<script src="script.js"></script>
	</body>
</html>