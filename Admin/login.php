<?php 
if (isset($_SESSION['user'])) {
    $view = __DIR__ . "locatii.php";
    header('Location: index.php');
    exit;
}

if (!isset($view)) {
    header('Location: ../index.php');
    exit;
}

$errors = [];

if (isset($_POST['email']) && isset($_POST['parola'])) {
    
    $user = Utilizator::Logare($_POST['email'], $_POST['parola']);
    
    if ($user && $user['rol'] == Utilizator::ROL_ADMIN){
        
        $_SESSION['user'] = $user;
        
        echo "<script>window.location.href = '/Admin/?view=locatii.php';</script>";
        exit;
    }
    else  {
        $errors[] = "Nu se poate de logat utilizatorul cu aceste date!";
    }
}
?>
<div id="page-content"> 
    <form action="" method="POST" id="login-form">
        <h3>Autorizare in panelul de Administrare </h3>
        <div class="form-row">
            <div class="form-label">Email:</div>
            <div class="form-value">
                <input type="text" name="email" class="form-input" placeholder="example@email.com" value="<?php echo $_POST['email'];?>">
            </div>
        </div>
        <div class="form-row">
            <div class="form-label">Parola:</div>
            <div class="form-value">
                <input type="password" name="parola" class="form-input">
            </div>
        </div>
        <div class="form-row">
            <?php 
            foreach ($errors as $error) {
                echo '<h6 class="form-error">' . $error . "</h6>";
            }
            ?>
        </div>
        <div class="form-row">
            <div class="form-label"></div>
            <div class="form-value">
                <button class="form-button" type="submit">Logare</button>
            </div>
        </div>
    </form>
</div>