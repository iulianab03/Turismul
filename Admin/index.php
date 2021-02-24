<?php 
define('PROJECT_ROOT_PATH', __DIR__);
session_start();

include_once "../mysql.php";

include_once '../Models/utilizator.php';
include_once '../Models/locatieTuristica.php';
include_once '../Models/locatieTuristicaImagine.php';


$view = '';

if (isset($_SESSION['user'])) {
    if (isset($_GET['view'])) {
        $view = __DIR__ . "../" . $_GET['view'];
    }
    else {
        $view = __DIR__ . "/locatii.php";
    }
}
else {
    $view = __DIR__ . "/login.php";
}

if (isset($_GET['action'])) {
    if ($_GET['action'] == 'logout')
	{
		unset($_SESSION['user']);

        echo "<script>window.location.href= '/Admin/?view=login.php';</script>";
		exit(1);
	}
}
?>
<html>
<head>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,600;1,700;1,800&display=swap" rel="stylesheet">
    <link href="/resources/fontawesome/css/font-awesome.css" rel="stylesheet">
    <link href="index.css" rel="stylesheet">
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script type="text/javascript" src="index.js"></script>
</head>
<body>
    <div class="top-bar">
        <a href="/Admin" style="text-decoration:none; color:#FFFFFF;"  class="top-bar-logo-container"><div class="top-bar-logo">JuliaTur Admin Panel</div></a>
        <div class="admin-menu-header">
            <a href="/" class="admin-menu-option">Acasă</a>
            <a href="/Admin/?view=locatii.php" class="admin-menu-option">Locații</a>
            <a href="/Admin/?view=utilizatori.php" class="admin-menu-option">Utilizatori</a>
            <a href="/Admin/?action=logout" class="admin-menu-option" style="float: right;<?php echo !isset($_SESSION['user']) ? 'display:none' : ''; ?>">Logout</a>
        </div>
    </div>
    <?php 
    include_once $view;
    ?>
</body>
</html>