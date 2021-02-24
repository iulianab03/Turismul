<?php 
if (!isset($_SESSION['user'])) {
    header('Location: ../index.php');
    exit;
}

$categorie = isset($_GET['categorie']) ? $_GET['categorie'] : '';

if (isset($_POST['nume'])) {
    $locatie = new LocatieTurstica();
    $locatie->nume = $_POST['nume'];
    $locatie->categorie = $_POST['categorie'];
    $locatie->descriere = $_POST['descriere'];
    $locatie->program_destinatie = $_POST['program_destinatie'];
    $locatie->detalii_destinatie = $_POST['detalii_destinatie'];

    $locatie = $locatie->Create();

    if (is_object($locatie)) {
        echo '<script>alert("Locația turistică a fost creată cu succes!"); window.location.href = "/Admin/";</script>';

        mkdir('../images/' . $locatie->id);
    
        if (isset($_FILES['fundal'])) {
            if ($_FILES['fundal']['tmp_name']) {
                if (move_uploaded_file($_FILES['fundal']['tmp_name'], "../images/" . $locatie->id . "/0.jpg")) {
                    $_img = new LocatieTuristicaImagine($locatie->id, "/images/" . $locatie->id . "/0.jpg", 1);
                    $_img->Create();
                }
            }
        }
    
        if (isset($_FILES['imagine'])) {
            $_imaginiNoi = LocatieTuristicaImagine::reArrayFiles($_FILES['imagine']);
    
            foreach($_imaginiNoi as $key => $_imagine) {
                
                if ($_imagine['tmp_name']) {
                    if (move_uploaded_file($_imagine['tmp_name'], "../images/" . $locatie->id ."/" . ($key + 1) . ".jpg")) {
                        $_img = new LocatieTuristicaImagine($locatie->id, "/images/" . $locatie->id ."/" . ($key + 1) . ".jpg", 0);
                        $_img->Create();
                    }
                }
                $i++;
            }
        }
    }
    else {  
        echo '<script>alert("Eroare la creare!");</script>';
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
        <h1 class="page-title">Creare locatie</h1>
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
                    foreach (LocatieTurstica::CATEGORII as $_categorie) {
                        echo '<option value="' . $_categorie . '" ' . ($_categorie == $categorie ? 'selected' : '') . '>' . $_categorie .  '</option>';
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
                <textarea name="descriere" class="form-editare-input"></textarea>
            </div>
        </div>
        <div class="form-editare-row">
            <div class="form-editare-row-label">
                Program destinatie:
            </div>
            <div class="form-editare-row-value">
                <textarea name="program_destinatie" class="form-editare-input"></textarea>
            </div>
        </div>
        <div class="form-editare-row">
            <div class="form-editare-row-label">
               Detalii destinatie:
            </div>
            <div class="form-editare-row-value">
                <textarea name="detalii_destinatie" class="form-editare-input"></textarea>
            </div>
        </div>
        <div class="form-editare-row">
            <div class="form-editare-row-label">
               Data crearii:
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
                <div class="form-image" title="Apasa pentru a schimba imaginea">
                    <img src="/images/placeholder.png" class="form-image-preview"/>
                    <input type="file" name="fundal" class="form-image-input" onchange="setImage(this, $(this));">
                </div>
            </div>
        </div>
        <div class="form-editare-row">
            <div class="form-editare-row-label">
               Imagini: <div class="locatie-buton edit" id="addNewImage" style="cursor:pointer">Adauga</div>
            </div>
            <div class="form-editare-row-value" style="margin-top:10px" id="imagesContainer">
                <div class="form-image" title="Apasa pentru a schimba imaginea">
                    <img src="/images/placeholder.png" class="form-image-preview"/>
                    <input type="file" name="imagine[]" class="form-image-input" onchange="setImage(this, $(this));">
                    <span class="removeImage fa fa-remove" title="Sterge Imaginea"></span>
                </div>
            </div>
        </div>
        <div class="form-editare-row" style="margin-top:20px">
            <div class="form-editare-row-label">
            </div>
            <div class="form-editare-row-value">
                <button type="submit" class="form-button save">Creare</button>
            </div>
        </div>
    </form>
</div>