<?php 
if (!isset($_SESSION['user'])) {
    header('Location: ../index.php');
    exit;
}
$errors = [];
if (isset($_GET['action'])) {
    if ($_GET['action'] == 'remove') {
        $_user = Utilizator::GetOne($_GET['id']);
        if ($_user) {
            error_reporting(0);
            $result = $_user->Remove();
            error_reporting(1);
            
            if ($result) {
                echo "<script>alert('Utilizatorul a fost șters cu succes!'); window.location.href = '/Admin/?view=utilizatori.php';</script>";
            }
        }
    }
}

if (isset($_POST['action'])) {
    if ($_POST['action'] == 'creaza') {
        $email = $_POST['email'];
        $parola = $_POST['parola'];
        $rol = $_POST['rol'];

        if (strlen($email) == 0 || strlen($parola) == 0 || !in_array($rol, Utilizator::ROLURI)) {
            $errors['creaza'] = 'Date incorecte';
        }

        $user = new Utilizator($email, $parola, $rol);
        $result = $user->Create();
        
        if (!$result) {
            $errors['creaza'] = 'Nu s-a creat utilizatorul! Verificați datele sau contactați tehnicul!';
        }
    }
}

/**
 * @var Utilizator[] $useri
 */
?>
<div id="page-content"> 
    <h1>Lista Utilizatorilor</h1>
    <div class="list-body">
        <div style="display: <?php echo (sizeof($errors) > 0) ? 'none !important;' : 'block'; ?>; margin-bottom:20px;" class="addUser-container">
            <div class="locatie-buton adauga" id="addUser">Adaugă utilizator</div>
        </div>
        <form action="/Admin/?view=utilizatori.php" method="POST" class="list-form" id="adduser-form" style="<?php echo (sizeof($errors) > 0) ? 'display:block!important;' : ''; ?>">
            <input type="hidden" name="action" value="creaza">
            <input type="text" name="email" class="form-input" value="<?php echo (sizeof($errors) > 0) ? $_POST['email'] : ''; ?>" placeholder="Introduce Email-ul">
            <input type="password" name="parola" class="form-input" placeholder="Introduce Parola">
            <select name="rol" class="form-input">
                <?php 
                echo '<option value="' . Utilizator::ROL_ADMIN . '">Admin</option>';
                echo '<option value="' . Utilizator::ROL_USER . '">Utilizator</option>';
                ?>
            </select>
            <button type="submit" class="form-button">Adaugă</button>
            <?php 
            if (sizeof($errors) > 0) {
                foreach($errors as $error) {
                    
                echo '<br /><h5 class="list-error">' . $error. '</h5>';
                }
            }
            ?>
        </form>
        <?php 

        $useri = Utilizator::GetAll();

        foreach ($useri as $user) {
            echo '<div class="locatie">
                <div class="locatie-titlu">' .  $user->email .  '</div>
                <div class="locatie-creat"><span>' . $user->role . '</span></div>
                <div class="locatie-actions">' . 
                    '<a href="/Admin/?view=utilizatori.php&action=remove&id=' . $user->id .'" class="locatie-buton stergere">Stergere</a>' . 
                '</div>
            </div>';
        }
        ?>
    </div>
</div>