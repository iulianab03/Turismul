<?php 
define('PROJECT_ROOT_PATH', __DIR__);
session_start();
if (!isset($_SESSION['user'])) {
	header('Location: ./index.php');
    exit;
}

$categorie = '';
if (isset($_GET['categorie'])) {
	$categorie = $_GET['categorie'];
} 
else {
	header('Location: ./index.php');
    exit;
}

include_once "mysql.php";

include_once PROJECT_ROOT_PATH .'/Models/utilizator.php';
include_once PROJECT_ROOT_PATH .'/Models/locatieTuristica.php';
include_once PROJECT_ROOT_PATH .'/Models/locatieTuristicaImagine.php';

if (!in_array($categorie, LocatieTurstica::CATEGORII) || $categorie == LocatieTurstica::CATEGORIE_DEFAULT) {
	echo '<script>window.location.href = "index.php";</script>';
}
?>
<!DOCTYPE html>
<html> 
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo LocatieTurstica::CATEGORII_DENUMIRE[$categorie];?> | Julia Tur</title>
	<link rel="stylesheet" type="text/css"  href="index.css">
	<style>
		body {
			margin:0;
			padding: 0;
		}
		.nav1{
			background: url(resources/categorii/<?php echo $categorie . '.jpg'; ?>);
		}
		.n-gallery-item-description {
			background-color: #444422;
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

	<div class="nav1">
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
			<div class="n-title"><span style="background-color:hsla(60, 33%, 20%, 0.7);" ><?php echo LocatieTurstica::CATEGORII_DENUMIRE[$categorie];?></span></div>
			<div class="n-description">
				<span style="background-color:#444422">
					<?php 
					$textes = array (
						LocatieTurstica::CATEGORIE_EXCURSII => 'Cu cât călătoreşti mai mult, cu atât universul se strânge, distanţele îşi înghit măsura, pământul devine tot mai mic.',
						LocatieTurstica::CATEGORIE_EXOTICA => 'Alintă-te cu cele mai frumoase vacnțe la mare !',
						LocatieTurstica::CATEGORIE_MARE => 'Alege destinația visurilor tale !'
					);
					echo $textes[$categorie];
					?>
				</span>
			</div>
		</div>
	</div>

	<div class="n-gallery">
	<div class="n-gallery-title">Descoperă!</div>
	<div class="n-gallery-content">
		<?php 
		$locatii = LocatieTurstica::GetMany($categorie);
		foreach ($locatii as $loc) {
			$img = $loc->FirstImage();

			echo 
				'<div class="n-gallery-item">
					<a href="/locatie.php?id=' . $loc->id . '">
						<img class="n-gallery-item-image" src="' . $img->path . '">
						<div class="n-gallery-item-description">
							<span style="font-family:Monotype Corsiva;">' . $loc->nume . '</span>
						</div>
					</a>
				</div>';
		}
		?>
	</div>
	<div class="app-contacts">
		<div class="app-contacts-list">
			<div class="app-contact">
				<img src="resources/o1.png" class="app-contact-icon">
				<div class="app-contact-description"><a href="tel:37369005583" style="text-decoration: none;">+37369005583</a></div>
			</div>
			<div class="app-contact">
				<img src="resources/o2.png" class="app-contact-icon">
				<div class="app-contact-description"><a href="mailto:iulianab03@gmail.com" style="text-decoration: none;">iulianab03@gmail.com</a></div>
			</div>
		</div>
	</div>
</body>
</body>
</html>
<script type="text/javascript" src="index.js"></script>
