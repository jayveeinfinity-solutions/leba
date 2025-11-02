<?php
	require_once 'app/ib_init.php';
?>
<!DOCTYPE html>
<html>
	<head>
		<title>
			Ooopsss! Your out of G-Shock Warriors! &sdot; G-Shock Warriors
		</title>
    	<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="x icon" type="img/png" href="http://www.gshockwarriors.com/storage/Infinity-favicon.png">
		<link rel="stylesheet" type="text/css" href="http://www.gshockwarriors.com/css/ib_style.min.css">
		<link rel="stylesheet" type="text/css" href="http://www.gshockwarriors.com/css/ib_grid_style.min.css">
		<link rel="stylesheet" type="text/css" href="http://www.gshockwarriors.com/css/ib_responsive_nav.min.css">
		<script type="text/javascript" scr="scripts/js/jquery-3.1.0.min.js"></script>
	</head>
	<body>
		<?php
			IB_View::getView('navigation.header');
		?>
		<div class="ib_wrapper bg3">
			<div class="ib_welcome" style="padding: 60px 10px 100px">
				<p class="ib_welcome_tag" id="welcome_text"></p>
				<script type="text/javascript">
					var myString = ' Ooopsss! Your out of G-Shock Warriors!';
					var myArray = myString.split("");
					var loopTimer;
					function frameLooper() {
						if(myArray.length > 0) {
						     document.getElementById("welcome_text").innerHTML += myArray.shift();
						} else {
						     clearTimeout(loopTimer);
						     return false;
						}
						loopTimer = setTimeout('frameLooper()',100);
					}
					frameLooper();
				</script>
				<p class="ib_welcome_des">
					Trying to access anything here?
					<br>
					It's either this page is private or not exist on G-Shock Warriors
				</p>
				<a href="http://www.gshockwarriors.com/">
					<span class="ib_welcome_btn bg_green">
						Return to home
					</span>
				</a>
			</div>
		</div>
		<?php
			include_once 'templates/ib_footer.temp.php';
		?>
	</body>
</html>