<?php 
if (!isset($_SESSION['user'])) {
    header('Location: ../index.php');
    exit;
}

if (!isset($_GET['id'])) {
    header('Location: ./index.php');
    exit;
}
/**
 * @var LocatieTuristica $locatie
 */
$locatie = LocatieTurstica::GetOne($_GET['id']);

$errors = [];
if (isset($_POST['id'])) {
    $locatie->nume = $_POST['nume'];
    $locatie->categorie = $_POST['categorie'];
    $locatie->descriere = $_POST['descriere'];
    $locatie->program_destinatie = $_POST['program_destinatie'];
    $locatie->detalii_destinatie = $_POST['detalii_destinatie'];

    $locatie->Update();
    echo '<script>alert("Locatie turistica a fost modificata cu succes!");</script>';
    
    if (isset($_FILES['fundal'])) {
        if ($_FILES['fundal']['tmp_name']) {
            if (!move_uploaded_file($_FILES['fundal']['tmp_name'], "../images/" . $locatie->id . "/0.jpg")) {
                echo "<H1>ERROR</h1>";
            }
        }
    }

    if (isset($_FILES['imagine'])) {
        $_imaginiNoi = LocatieTuristicaImagine::reArrayFiles($_FILES['imagine']);

        foreach($_imaginiNoi as $key => $_imagine) {
            if ($_imagine['tmp_name']) {

                if ($_POST['imagineId'][$key] == 0) {
                    $path = "/images/" . $locatie->id . "/" . rand(100, 999999999) . ".jpg";
                    LocatieTuristicaImagine::NewImage($locatie->id, $path);
                }
                else {
                    $imagineSalvata = $locatie->GetImageById($_POST['imagineId'][$key]);
                    $path = $imagineSalvata->path;
                }

                if (!move_uploaded_file($_imagine['tmp_name'], ".." . $path)) {
                    echo "<H1>ERROR</h1>";
                }
            }

            
            $i++;
        }
    }

    if (isset($_POST['removeImage'])) {
        foreach ($_POST['removeImage'] as $rmi) {
            $result = LocatieTuristicaImagine::StergeImagine($rmi);

            if (!$result) $errors['imagine'] = "Eroare la ștergerea imaginii!";
        }
    }

    unset($_POST['id']);
    unset($_POST['nume']);
    unset($_POST['categorie']);
    unset($_POST['program_destinatie']);
    unset($_POST['detalii_destinatie']);
    unset($_FILES['fundal']);
    unset($_FILES['imagine']);
}
?>
<div id="page-content"> 
    <form enctype="multipart/form-data" action="" method="POST" class="form-editare">
        <h1 class="page-title">Editare locație</h1>
        <input type="hidden" name="id" value="<?php echo $locatie->id; ?>">
        <div class="form-editare-row">
            <div class="form-editare-row-label">
                Denumire:
            </div>
            <div class="form-editare-row-value">
                <input type="text" name="nume" class="form-editare-input" value="<?php echo $locatie->nume;?>">
            </div>
        </div>
        <div class="form-editare-row">
            <div class="form-editare-row-label">
                Categorie:
            </div>
            <div class="form-editare-row-value">
                <select name="categorie" class="form-editare-input">
                    <?php
                    foreach (LocatieTurstica::CATEGORII as $categorie) {
                        echo '<option value="' . $categorie . '" ' . ($locatie->categorie == $categorie ? 'selected' : '') . '>' . $categorie .  '</option>';
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="form-editare-row">
            <div class="form-editare-row-label">
                Descriere:
            </div>
            <div class="form-editare-row-value">
                <textarea name="descriere" class="form-editare-input"><?php echo $locatie->descriere;?></textarea>
            </div>
        </div>
        <div class="form-editare-row">
            <div class="form-editare-row-label">
                Program destinație:
            </div>
            <div class="form-editare-row-value">
                <textarea name="program_destinatie" class="form-editare-input"><?php echo $locatie->program_destinatie;?></textarea>
            </div>
        </div>
        <div class="form-editare-row">
            <div class="form-editare-row-label">
               Detalii destinație:
            </div>
            <div class="form-editare-row-value">
                <textarea name="detalii_destinatie" class="form-editare-input"><?php echo $locatie->detalii_destinatie;?></textarea>
            </div>
        </div>
        <div class="form-editare-row">
            <div class="form-editare-row-label">
               Data creării:
            </div>
            <div class="form-editare-row-value">
                <span><?php echo $locatie->created;?></span>
            </div>
        </div>
        <div class="form-editare-row">
            <div class="form-editare-row-label">
               Fundal:
            </div>
            <div class="form-editare-row-value">
                <?php 
                $fundal = $locatie->Fundal();
                echo 
                    '<div class="form-image" title="Apasă pentru a schimba imaginea">'.
                        '<img src="' . $fundal->path . '" class="form-image-preview"/>' . 
                        '<input type="file" name="fundal" class="form-image-input" onchange="setImage(this, $(this));">' . 
                    '</div>';
                ?>
            </div>
        </div>
        <div class="form-editare-row">
            <div class="form-editare-row-label">
               Imagini: <div class="locatie-buton edit" id="addNewImage" style="cursor:pointer">Adaugă</div>
            </div>
            <div class="form-editare-row-value" style="margin-top:10px" id="imagesContainer">
                <?php 
                $imagini = $locatie->Images();
                
                foreach ($imagini as $imagine) {
                    echo 
                        '<div class="form-image" title="Apasă pentru a schimba imaginea">'.
                            '<img src="' . $imagine->path . '" class="form-image-preview"/>' . 
                            '<input type="hidden" name="imagineId[]" value="' . $imagine->id . '">' . 
                            '<input type="file" name="imagine[]" class="form-image-input" onchange="setImage(this, $(this));">' . 
                            '<span class="removeImage fa fa-remove" id="' . $imagine->id . '" title="Șterge imagine"></span>' .
                        '</div>';
                }
                if (isset($errors['imagine'])) {
                    echo '<h5 class="form-error">' . $errors['imagine'] . '</h5>';
                }
                ?>
            </div>
        </div>
        <div class="form-editare-row" style="margin-top:20px">
            <div class="form-editare-row-label">
            </div>
            <div class="form-editare-row-value">
                <button type="submit" class="form-button save">Salvare</button>
            </div>
        </div>
    </form>
</div>