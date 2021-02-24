<?php 
define('PROJECT_ROOT_PATH', __DIR__);
session_start();
if (!isset($_SESSION['user'])) {
	header('Location: ./index.php');
    exit;
}

include_once "mysql.php";

include_once PROJECT_ROOT_PATH .'/Models/utilizator.php';
include_once PROJECT_ROOT_PATH .'/Models/locatieTuristica.php';
include_once PROJECT_ROOT_PATH .'/Models/locatieTuristicaImagine.php';
?>
<!DOCTYPE html>
<html> 
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Contacte | Julia Tur</title>
	<link rel="stylesheet" type="text/css"  href="index.css">
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
	<style>
		body{
			margin:0;
			padding: 0;
		}
		.slider{
			-webkit-filter: blur(0.30px);
			filter: blur(0.30px);
			width: 100%;
			height: 400px;
			background: url(resources/imagini/contacte/w.jpg);
		}
		.app-c {
			background-color: #f1f1f1;
			padding:40px 10px;
			text-align: center;
			width: calc(100% - 20px);
		}

		.app-c-title {
			font-family: "Times New Roman";
			color:#262626;
			margin: 20px 0 10px;
			font-size: 36px;
			font-weight: 600px;
			letter-spacing: 1px;
			margin: 0;
			text-transform: uppercase;
		}

		.app-c-subtitle {
			font-size: 20px;
			font-weight: 500px;
			letter-spacing: 0.6px;
			text-transform: none;
		}

		#app-form-container {
			display: inline-block;;
			margin: 20px 10px;
			max-width: 800px;
			width: calc(100% - 20px);
		}

		.app-form-field {
			display: block;
			margin: 10px 0;
			width: 100%;
		}

		.app-form-input-container {
			box-sizing: border-box;
			display: inline-block;
			margin: 0;
			width: calc(100%);
		}

		.app-form-input-container.half {
			display: inline-block;
			width: calc(50% - 5px);
		}

		.app-form-input-container.half:first-child {
			display: inline-block;
			margin-right: 5px;
		}

		.app-form-input-container.half:last-child {
			display: inline-block;
			margin-left: 5px;
		}
		.app-form-input {
			font-family: 'Times New Roman', Times, serif;
			border: none;
			background-color: #FFFFFF;
			display: inline-block;
			font-size: 16px;
			padding: 10px 12px;
			width: calc(100% - 24px);
		}

		.app-form-input:placeholder {
			color: #666666;
		}


		textarea.app-form-input {
			height: 200px;
			resize: none;
		}

		.app-form-button {
			font-family: 'Times New Roman', Times, serif;
			background-color: #51adc2;
			border: none;
			color: #FFFFFF;
			cursor: pointer;
			font-size: 14px;
			font-weight: 600;
			padding: 10px 12px;
			width: 100%;
		}

		.app-form-button:hover {
			background-color: #308ba0;
		}

		#app-form-error {
			color: #F01300;
			display: none;
			font-size: 16px;;
			font-family: 'Times New Roman', Times, serif;
			font-weight: 500;
		}

		#app-form-result {
			display: none;
		}
		.app-form-submit-title{
			font-family: 'Times New Roman', Times, serif;
			font-size: 26px;
			color: #262626;
		}
		.app-features-contacts {
			background-repeat: no-repeat;
			background-position: center;
			background-size: cover;
			color: black;
			padding: 40px 50px 30px;
			text-align: center;
			width: calc(100% - 100px);
		}

		.app-features-contacts .app-features-contacts-header{
			display: block;
			font-size: 16px;
			font-weight: 600;
			margin: 0 0 20px;
			text-transform: uppercase;
		}

		.app-features-contacts .app-features-contacts-list{
			display: inline-block;
			padding: 10px 0;
			text-align: center;
		}

		.app-features-contacts .app-feature-contacts {
			display: inline-block;
			width: calc(25% - 4px);
		}

		.app-features-contacts .app-feature-contacts-icon {
			display: inline-block;
			height: 50px;
			width: 50px;
		}
		.app-feature-contacts-description a{
			color: black;
		}
		.app-features-contacts .app-feature-contacts-description {
			display: inline-block;
			font-size: 14px;
			margin-left: 10px;
			text-align: left;
			width: calc(100% - 65px);
			vertical-align: top;
			padding-top: 10px;
		}
	</style>
</head>
<body>
	<!--    slider bar-->
	<div id="sidebar-container">
		<div id="sidebar">
			<ul class="sidebar-item-list">
				<li><img id="close-sidebar" src="resources/imagini/slider/close.png"></li>
				<li><a href="index.php">Acasă</a></li>
				<?php 
				foreach (LocatieTurstica::CATEGORII as $cat) {
					if ($cat == LocatieTurstica::CATEGORIE_DEFAULT) continue;
					
					echo 
						'<li>' .
						'<div class="navbar-main-link-container"><a class="navbar-main-link" href="categorie.php?categorie=' . $cat .'">' . LocatieTurstica::CATEGORII_DENUMIRE[$cat] .'</a><img class="sidebar-arrow" src="resources/imagini/slider/arrow1.png"></div>' .
						'<ul class="sublist">';

						$_locatii = LocatieTurstica::GetMany($cat, 6, 15);

						foreach($_locatii as $_locatie) 
						{
							echo '<li><a href="/locatie.php?id=' . $_locatie->id . '">' . $_locatie->NumeSpecial() . '</a></li>';
						}

					echo '</ul>' .
					'</li>';
				}
				?>
				<li><a href="despre.php">Despre companie</a></li>
				<li><a href="contacte.php">Contacte</a></li>
			</ul>
		</div>
	</div>

	<div class="slider">
		<div class="nav" style="text-align: center;">
			<nav style="display: inline-block;">
				<ul>
					<li class="no-bg"><a href="index.php" class="navbar-link-special"><img src="resources/logou/n.png" class="nav-bar-logo"></a></li>
					<li class="bg user-widget" title="<?php echo isset($_SESSION['user']) ? '' : 'Click pentru a te autoriza';?>" id="<?php echo !isset($_SESSION['user']) ? 'loginButton' : '';?>"> 
						<img src="resources/a.png" style="width: 26px;padding: 20px 20px;">
						<ul class="sublist bg-i"> 
							<?php 
							if (isset($_SESSION['user']) || strlen($_SESSION['user'])) {
								if ($_SESSION['user']['rol'] == Utilizator::ROL_ADMIN){
									echo '<li><a href="/Admin/">Admin</a></li>';
								}

								echo "<li>" . $_SESSION['user']['email'] . "</li>";
								echo '<li id="logoutLink">Logout</li>';
							}
							?>
						</ul>
					</li>
					<div style="float: right;" class="main-menu">
						<li><a href="index.php">Acasă</a></li>
						<?php 
						foreach (LocatieTurstica::CATEGORII as $cat) {
							if ($cat == LocatieTurstica::CATEGORIE_DEFAULT) continue;
							
							echo 
								'<li>' .
								'<a href="categorie.php?categorie=' . $cat .'">' . LocatieTurstica::CATEGORII_DENUMIRE[$cat] .'</a>' .
								'<ul class="sublist">';

								$_locatii = LocatieTurstica::GetMany($cat, 6, 15);

								foreach($_locatii as $_locatie) 
								{
									echo '<li><a href="/locatie.php?id=' . $_locatie->id . '">' . $_locatie->NumeSpecial() . '</a></li>';
								}

							echo '</ul>' .
							'</li>';
						}
						?>
						<li><a href="despre.php">Despre companie</a></li>
						<li><a href="contacte.php">Contacte</a></li>
					</div>
					<div id="menu-slider-open">
						<img src="resources/imagini/slider/burger.png">
					</div>
				</ul>
			</nav>
			<div class="zigzag"></div>
			<div class="n-title"><span style="background-color:hsla(60, 33%, 20%, 0.7);" >Contacte</span></div>
			<div class="n-description"><span style="background-color:#444422">Cu cât călătoreşti mai mult, cu atât universul se strânge, distanţele îşi înghit măsura, pământul devine tot mai mic.</span></div>
		</div>
	</div>

	<div class="app-features-contacts">
		<div class="app-features-contacts-list">
			<div class="app-feature-contacts">
				<img src="resources/imagini/contacte/1con1.png" class="app-feature-contacts-icon">
				<div class="app-feature-contacts-description"><b>Regim de lucru </b>
					<br>LUNI-VINERI: 09:00 - 19:00
					<br>SÂMBĂTĂ: 10:00 - 15:00
				</div>
			</div>
			<div class="app-feature-contacts">
				<img src="resources/imagini/contacte/2icon2.png" class="app-feature-contacts-icon">
				<div class="app-feature-contacts-description"><b>Adresa </b>
					<br>Chișinău, str.Miron Costin 15/5
				</div>
			</div>
			<div class="app-feature-contacts">
				<img src="resources/imagini/contacte/3icon3.png" class="app-feature-contacts-icon">
				<div class="app-feature-contacts-description"><b>Telefon</b>
				<br>FIX: <a href="tel:+37324873164" style="color: black;text-decoration: none;">+37324873164</a>
				<br>MOBIL: <a href="tel:+37369005583" style="color: black;text-decoration: none;">+37369005583</a>
				</div>
			</div>
			<div class="app-feature-contacts">
				<img src="resources/imagini/contacte/4icon4.png" class="app-feature-contacts-icon">
				<div class="app-feature-contacts-description"><b>E-mail</b>
					<br><a href="mailto:iulianab03@gmail.com" style="color: black;text-decoration: none;">iulianab03@gmail.com</a></div>
			</div>
		</div>
	</div>
	
	<div class="app-c">
		<div id="app-form-result">
			<h3 class="app-form-submit-title">Vă mulțumim pentru mesaj!</h4>
		</div>
		<div id="app-form-body">
			<h1 class="app-c-title">Contactează-ne!</h1>
			<h3 class="app-c-subtitle">Și noi o să revenim cu un răspuns</h3>
			<form id="app-form-container" action="mailer/mailer.php" method="POST">
				<div class="app-form-field">
					<div class="app-form-input-container half">
						<input type="text" name="name" class="app-form-input" placeholder="Nume, Prenume*">
					</div><div class="app-form-input-container half">
						<input type="email" name="email" class="app-form-input" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" placeholder="Email* "> 
					</div>
				</div>
				<div class="app-form-field">
					<div class="app-form-input-container">
						<input type="text" name="subject" class="app-form-input" placeholder="Subiect">
					</div>
				</div>
				<div class="app-form-field">
					<div class="app-form-input-container">
						<textarea name="message" class="app-form-input" placeholder="Mesaj*"></textarea>
					</div>
				</div>
				<h5 id="app-form-error">Formularul nu este completat deplin!</h5>
				<br />
				<div class="app-form-field">
					<div class="app-form-input-container">
						<button type="submit" class="app-form-button">TRIMITE ACUM</button>
					</div>
				</div>
			</form>
		</div>
	</div>

	<div id="map"> 
		<iframe  class="map-container" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2718.3092000042393!2d28.86429805962645!3d47.05378464779704!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40c97ce33d2a579d%3A0x403b3a41d3868845!2sBulevardul%20Moscova%2015%2C%20Chi%C8%99in%C4%83u%2C%20Moldova!5e0!3m2!1sen!2s!4v1574887086335!5m2!1sen!2s" width="100%" height="450" frameborder="0" style="border:0;" allowfullscreen=""></iframe> 
		<div id="contacte">
			<div class="contacte-container">
				<p class="contacte-titlu"> Adresa </p>
				<p class="contacte-info"> Chișinău, str.Miron Costin 15/5 </p>
			</div>
			<div class="contacte-container">
				<p class="contacte-titlu"> Telefon </p>
				<p class="contacte-info"> <a href="tel:37369005583" style="color: black;text-decoration: none;">+37369005583</a></p>
			</div>
			<div class="contacte-container">
				<p class="contacte-titlu"> E-mail</p>
				<p class="contacte-info"> <a href = "mailto:iulianab03@gmail.com" style="color: black;text-decoration: none;">iulianab03@gmail.com </a></p>
			</div>
		</div>
	</div>
</body>
<script>
	// executarea formularului și afișarea răspunsului conform datelor introduse
	// (function() {
	// 	document.getElementById("app-form-container").addEventListener('submit', function(e) {
	// 		var name = document.querySelectorAll('.app-form-input[name=name]')[0].value;
	// 		var email = document.querySelectorAll('.app-form-input[name=email]')[0].value;
	// 		var subject = document.querySelectorAll('.app-form-input[name=subject]')[0].value;
	// 		var message = document.querySelectorAll('.app-form-input[name=message]')[0].value;
			
	// 		if (name.length == 0 || email.length == 0 || message.length == 0) {
	// 			document.getElementById('app-form-error').style.display = 'inline-block';
	// 			e.preventDefault();
	// 		}
	// 		else {
	// 			var url = $(this).attr('action');
	// 			$.ajax({
	// 				"url": url, 
	// 				"type":"POST", 
	// 				data:{"action":"sendMail", "name": name, "email": email, "subject": subject, "message": message}
	// 			}).then(function(data){
	// 				console.log(data);
	// 			});
	// 			document.getElementById("app-form-body").style.display = 'none';
	// 			document.getElementById("app-form-result").style.display = 'inline-block';
	// 		}
	// 	});
	// })();
</script>
</html>
<script type="text/javascript" src="index.js"></script>