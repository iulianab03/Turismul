<?php 

// definirea prin constanta calea catre proiect pe disc
define('PROJECT_ROOT_PATH', __DIR__);

// pentru a pastra in memorie datele din logare sub forma de cheie
session_start();

include_once "mysql.php";

include_once PROJECT_ROOT_PATH .'/Models/utilizator.php';
include_once PROJECT_ROOT_PATH .'/Models/locatieTuristica.php';
include_once PROJECT_ROOT_PATH .'/Models/locatieTuristicaImagine.php';

if (isset($_POST['action'])) {
	if ($_POST['action'] == 'login'){
		$_email = $_POST['email'];
		$_parola = $_POST['parola'];

		if ($user = Utilizator::Logare($_email, $_parola)){
			$_SESSION['user'] = $user;
		}
		else  {
			echo "Nu se poate de logat utilizatorul cu aceste date!";
		}

		exit(1);
	}
	if ($_POST['action'] == 'logout')
	{
		unset($_SESSION['user']);

		exit(1);
	}
	exit(1);
}
if (isset($_GET['action'])) {
	if ($_GET['action'] == 'check') {
		if (isset($_SESSION['user']) && strlen($_SESSION['user']['email'])>0) {
			echo 1;
		}
		else {
			echo 0;
		}

		exit();
	}
}
?>
<!DOCTYPE html>
<html> 
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Julia Tur - Agenție de turism</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css"  href="index.css">
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
	<style>
		body{
			margin:0;
			padding: 0;
			background: url(resources/imagini/slider/n.jpg);
		}
		.slider{
			-webkit-filter: blur(0.30px);
			filter: blur(0.30px);
			width: 100%;
			height: 500px;
			background: url(resources/imagini/slider/1.jpg);
			animation: slide 20s infinite;
		}
		.app-content .app-button:hover {
			background-color: #19334d;
		}

		@keyframes slide{
			25%{
				background: url(resources/imagini/slider/2.jpg);
			}
			50%{
				background: url(resources/imagini/slider/3.jpg);
			}
			75%{
				background: url(resources/imagini/slider/5.jpg);
			}
			100%{
				background: url(resources/imagini/slider/1.jpg);
			}
		}
	</style>
</head>
<body>
	<div id="overlay-container">
		<div class="overlay-content">
			<form action="#" class="overlay-form animate" id="login-site">
				<div class="overlay-form-avatar-container">
					<img src="resources/img_avatar2.png" alt="Avatar" class="overlay-form-avatar">
				</div>

				<div class="overlay-container">
					<label class="overlay-form-label" for="email"><b>Email</b></label>
					<input type="text" class="overlay-form-input" placeholder="Introduceți emailul" name="email" required>

					<label class="overlay-form-label" for="parola"><b>Parola</b></label>
					<input type="password" class="overlay-form-input" placeholder="Introduceți parola" name="parola" required>
					<h5 class="overlay-error"></h5>
					<button type="submit" class="overlay-form-button" style="margin-bottom: 16px;">Login</button>
				</div>
			</form>
		</div>
	</div>
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
						<ul class="sublist bg-i "> 
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
		</div>
	</div>

	<div class="app-content">
		<div class="app-content-title">Descoperă lumea cu noi!</div>
		<div class="app-content-description">O dată pe an, du-te undeva unde nu ai mai fost înainte. Umple-ți ochii de minuni, fiindcă călătoriile au tendința de a intensifica toate emoțiile umane.</div>
		<div class="app-content-action">
			<button class="app-button"><a href="categorie.php?categorie=excursii" style="color: white;">Detalii</a></button>
		</div>
	</div>
	<div class="app-features">
		<div class="app-features-header">Agenția de turism "Julia Tur" oferă:</div>
		<div class="app-features-list">
			<div class="app-feature">
				<img src="resources/imagini/icon/icon1.png" class="app-feature-icon">
				<div class="app-feature-description">O vacanță de calitate, dar, de asemenea, o valoare pentru bani, facilități excelente și o experiență de neuitat.</div>
			</div>
			<div class="app-feature">
				<img src="resources/imagini/icon/icon2.png" class="app-feature-icon">
				<div class="app-feature-description">Personalul este pregătit în conformitate cu standardele corporative și cerințele agenției de turism "Julia Tur".</div>
			</div>
			<div class="app-feature">
				<img src="resources/imagini/icon/icon3.png" class="app-feature-icon">
				<div class="app-feature-description">Dorința de a furniza toate informațiile cele mai actualizate și exacte cu privire la zona în care doriți să mergeți.</div>
			</div>
			<div class="app-feature">
				<img src="resources/imagini/icon/icon4.png" class="app-feature-icon">
				<div class="app-feature-description">Echipamente tehnice moderne și utilizarea de tehnologii inovatoare în domeniul turismului și servicii pentru clienți.</div>
			</div>
		</div>
	</div>
	<div class="app-gallery" >
		<div class="app-gallery-title">Principalele destinații!</div>
		<div class="app-gallery-description">Nu ai nevoie de magie să dispari: ai nevoie doar de o destinație. Oriunde te duci, ceva devine o parte din tine.</div>
		<div class="app-gallery-content" style="max-width: 1200px;display: inline-block;">
			<?php 
			$locatii = LocatieTurstica::GetMany(LocatieTurstica::CATEGORIE_DEFAULT);
			foreach ($locatii as $loc) {
				$img = $loc->FirstImage();
				echo 
					'<div class="app-gallery-item" style="background-image: url(' . $img->path .');">
						<a href="/locatie.php?id=' . $loc->id . '">
						<div class="app-gallery-item-description">
							<span style="font-family:Monotype Corsiva;">' . $loc->nume . '</span>
						</div>
						</a>
					</div>';
			}
			?>
		</div>
	</div>
	<div class="citat">
		<div class="citat-descriere"><p>„Există trei lucruri pe care nu le poți întoarce: timpul, cuvântul și posibilitatea.</p><p>Prin urmare: nu pierde timpul, alege cuvintele, nu pierde ocazia! Călătorește! Și oriunde te-ai duce, du-te cu toată inima.”</p> <p>- Confucius</p></div>
	</div>
	<div class="video"> 
		<div class="video-title">Nu știi unde să mergi ? </div>
		<div class="video-description">Te sfătuim să vizionezi următoarele videoclipuri pentru a te ghida și pentru a alege destinația potrivită.</div>
		<div class="video-container">
			<div class="video-item-container">
				<iframe class="video-item" src="https://www.youtube.com/embed/S1ZVI7KctXg" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
			</div>
			<div class="video-item-container">
				<iframe class="video-item" src="https://www.youtube.com/embed/uk25g3YgyRM" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
			</div>
			<div class="video-item-container">
				<iframe class="video-item" src="https://www.youtube.com/embed/T05al3wiiPk" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
			</div>
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
				<p class="contacte-info"> <a href="tel:37369005583" style="color: black; text-decoration: none;">+37369005583</a></p>
			</div>
			<div class="contacte-container">
				<p class="contacte-titlu"> E-mail</p>
				<p class="contacte-info"> <a href = "mailto:iulianab03@gmail.com" style="color: black; text-decoration: none;">iulianab03@gmail.com </a></p>
			</div>
		</div>
	</div>
    <script type="text/javascript" src="index.js"></script>
</body>
</html>