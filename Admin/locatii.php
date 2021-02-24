<?php 
if (!isset($_SESSION['user'])) {
    header('Location: ../index.php');
    exit;
}

if (isset($_GET['action'])) {
    if ($_GET['action'] == 'remove') {
        $_locatie = LocatieTurstica::GetOne($_GET['id']);

        if ($_locatie) {
            error_reporting(0);
            $result = $_locatie->Remove();
            error_reporting(1);
            
            if ($result) {
                echo "<script>alert('Locație ștearsă!'); window.location.href = '/Admin/';</script>";
            }
        }
    }
}

/**
 * @var LocatieTuristica[] $locatii
 */

$categorii = array(
    'default' => 'Acasă',
    'excursii' => 'Excursii',
    'mare' => 'Mare',
    'exotica' => 'Exotică'
);
?>
<div id="page-content"> 
    <h1>Lista Locațiilor</h1>
    <div class="list-body">
        <?php 
        foreach ($categorii as $key => $value) {
            echo '<h2>' . $value . '  <a href="/Admin/?view=creaza_locatie.php&categorie=' . $key . '" class="locatie-buton adauga" style="margin-left: 20px">Adaugă locație nouă în categoria dată</a></h2>';

            $locatii = LocatieTurstica::GetMany($key);

            foreach ($locatii as $locatie) {
                echo '<div class="locatie">
                    <div class="locatie-titlu">' .  $locatie->nume .  '</div>
                    <div class="locatie-creat">Creat: <span>' . $locatie->created . '</span></div>
                    <div class="locatie-actions">' . 
                        '<a href="/Admin/?view=editare_locatie.php&id=' . $locatie->id .'" class="locatie-buton edit">Modifică</a>' . 
                        '<a href="/Admin/?view=locatii.php&action=remove&id=' . $locatie->id .'" class="locatie-buton stergere">Șterge</a>' . 
                    '</div>
                </div>';
            }
        }
        ?>
    </div>
</div>