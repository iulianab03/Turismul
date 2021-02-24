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
	<title>Despre companie | Julia Tur</title>
	<link rel="stylesheet" type="text/css"  href="index.css">
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
	background: url(resources/imagini/despre/n.jpg);
	}
	.app-content .app-content-description {
	font-family: "Times New Roman";
	color: #555555;
	font-size: 18px;
	font-weight: 400;
	margin: 10px 10px;
	text-align: left;
}
.app-content {
	padding: 10px;
	text-align: left;
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
			<div class="n-title"><span style="background-color:hsla(60, 33%, 20%, 0.7);" >Despre</span></div>
			<div class="n-description"><span style="background-color:#444422">Cu cât călătoreşti mai mult, cu atât universul se strânge, distanţele îşi înghit măsura, pământul devine tot mai mic.</span></div>
		</div>
	</div>


	<div class="app-content">
	<div class="app-content-description"> 
	<br>  Agenția de turism <span style="font-style: italic;">Julia Tur</span>  garantează:
	<br>- Echipamente tehnice moderne și utilizarea de tehnologii inovatoare în domeniul turismului și servicii pentru clienți.
	<br>- Dorința de a furniza toate informațiile cele mai actualizate si exacte cu privire la zona în care doriți să mergeți.
	<br>- Lucrul cu  cei mai de incredere tou-operatorii de turism internațional.
	<br>- Imediat, actualizarea bazei informaționale a ofertelor și ofertelor speciale.
	<br>- Personalul este pregătit în conformitate cu standardele corporative și cerințele de<span style="font-style: italic;"> Julia Tur.</span> 
	<p>Acum, nu aveți nevoie să pierdeți timpul în căutarea pentru cele mai favorabile condiții pentru un sejur minunat. Știi cine te ajuta cu ușurință în acest sens.</p>
	<span style="font-style: italic;">Julia Tur</span> - este nu numai o vacanță de calitate, dar, de asemenea, o valoare pentru bani, 
	facilități excelente și o experiență de neuitat. 
	<p> <span style="color: #555555;">Uită tot ce știi despre restul, echipa <span style="font-style: italic;">Julia Tur</span> 
	vă va învăța să vă relaxați într-un nou mod. Impresiile proaspete, evenimentele luminoase, plajele însorite și vârfurile acoperite de zăpadă, 
	tot ce e mai bun pentru Dumnevoastră. Am pornit ca o companie mică, cu 2 angajați, și am ajuns una din cele mai  mari agenții 
	de turism online din Republica Moldova. De-a lungul anilor, singura constantă care a rămas cu noi a fost pasiunea de a calatori. 
	Am schimbat birouri, am schimbat platforme tehnologice, am trecut de la bilete de avion pe hârtie la bilete electronice, de la plăți 
	prin transfer bancar la plăți in Bitcoin, dar pasiunea pentru călătorii a ramas în ADN-ul nostru. </span> </p>
	
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
</body>
</body>
</html>
<script type="text/javascript" src="index.js"></script>