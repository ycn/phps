<?php include 'config.php'; ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $config['APP_NAME']; ?> Home</title>
	<link rel="stylesheet" href="static/css/jquery.mobile.structure-1.2.0.min.css">
	<link rel="stylesheet" href="static/css/main.css?<?php echo $config['version']; ?>">
	<script type="text/javascript" src="static/js/jquery-1.8.2.min.js"></script>
	<script type="text/javascript" src="static/js/jquery.mobile-1.2.0.min.js"></script>
	<script type="text/javascript" src="static/js/main.js?<?php echo $config['version']; ?>"></script>
</head>
<body>
<h3>APP CONFIGURE:</h3>
<pre>
<?php print_r($config); ?>
</pre>
<h3>Please use <a href="http://jquerymobile.com/themeroller/">ThemeRoller</a> generate your theme.</h3>
</body>
</html>