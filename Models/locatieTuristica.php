<?php 
if (!PROJECT_ROOT_PATH) {
    include_once "../mysql.php";
}

/** 
 * Class LocatieTurstica
 * 
 * @property int    $id
 * @property string $nume
 * @property string $categorie
 * @property string $descriere
 * @property string $program_destinatie
 * @property string $detalii_destinatie
 * @property string $created
 * @property string $updated
 */
class LocatieTurstica {
    const CATEGORIE_EXCURSII = "excursii";
    const CATEGORIE_MARE = "mare";
    const CATEGORIE_EXOTICA = "exotica";
    const CATEGORIE_DEFAULT = "default";

    const CATEGORII = array (
        self::CATEGORIE_EXCURSII,
        self::CATEGORIE_MARE,
        self::CATEGORIE_EXOTICA,
        self::CATEGORIE_DEFAULT
    );

    const CATEGORII_DENUMIRE = array (
        self::CATEGORIE_EXCURSII => "Excursii",
        self::CATEGORIE_MARE => "Mare",
        self::CATEGORIE_EXOTICA => "Exotica",
        self::CATEGORIE_DEFAULT => "Acasa"
    );
    

    public $id;
    public $nume;
    public $categorie;
    public $descriere;
    public $program_destinatie;
    public $detalii_destinatie;
    public $created;
    public $updated;

    public function __construct ($_nume = '', $_categorie = '', $_descriere = '', $_program_destinatie = '', $_detalii_destinatie = '', $_id = 0, $_created = '', $_updated = '') {
        if (strlen($_nume) > 0)                 $this->nume                 = $_nume;
        if (strlen($_categorie) > 0)            $this->categorie            = $_categorie;
        if (strlen($_descriere) > 0)            $this->descriere            = $_descriere;
        if (strlen($_program_destinatie) > 0)   $this->program_destinatie   = $_program_destinatie;
        if (strlen($_detalii_destinatie) > 0)   $this->detalii_destinatie   = $_detalii_destinatie;
        if (strlen($_created) > 0)              $this->created              = $_created;
        if (strlen($_updated) > 0)              $this->updated              = $_updated;
        if ($_id > 0)                           $this->id                   = $_id;
    }

    public static function GetMany ($_categorie = '', $limit = -1, $maxLengthName = -1) {
        $mysql = new MySql();

                                        $query = "SELECT * FROM `locatie_turistica`";
        if (strlen($_categorie) > 0)    $query .= " WHERE `categorie` = '" . $_categorie . "'";
        if ($maxLengthName > 0)         $query .= " AND Length(`nume`) < $maxLengthName";
                                        $query .= " ORDER BY `created` DESC";
        if ($limit > 0)                 $query .= " LIMIT " . $limit;
                                        $query .= ";";

        $result = $mysql->query($query);

        return array_map(function ($item) {
            return new LocatieTurstica($item[1], $item[2], $item[3], $item[4], $item[5], $item[0], $item[6]);
        }, $result);
    }


    public static function GetOne ($id) {
        if (strlen($id) == 0) return null;

        $mysql = new MySql();

        $query = "SELECT * FROM `locatie_turistica` WHERE `id` = " . $id;
        $result = $mysql->query($query);

        return array_map(function ($item) {
            return new LocatieTurstica($item[1], $item[2], $item[3], $item[4], $item[5], $item[0], $item[6]);
        }, $result)[0];
    }

    public function Images () {
        $mysql = new MySql();

        $query = "SELECT * FROM `imagine` WHERE `locatie_turistica` = " . $this->id . " AND `fundal` = 0;";

        $result = $mysql->query($query);
        
        return array_map(function ($item) {
            return new LocatieTuristicaImagine((int)$item[1], $item[2], $item[3], $item[0], $item[4]);
        }, $result);
    }

    public function FirstImage () {
        $mysql = new MySql();

        $query = "SELECT * FROM `imagine` WHERE `locatie_turistica` = " . $this->id . " AND `fundal` = 0 LIMIT 1;";

        $result = $mysql->query($query);
        
        return array_map(function ($item) {
            return new LocatieTuristicaImagine((int)$item[1], $item[2], $item[3], $item[0], $item[4]);
        }, $result)[0];
    }

    public function AllImages () {
        $mysql = new MySql();

        $query = "SELECT * FROM `imagine` WHERE `locatie_turistica` = " . $this->id . ";";

        $result = $mysql->query($query);
        
        return array_map(function ($item) {
            return new LocatieTuristicaImagine((int)$item[1], $item[2], $item[3], $item[0], $item[4]);
        }, $result);
    }

    public function GetImageById ($id) {
        $mysql = new MySql();

        $query = "SELECT * FROM `imagine` WHERE `locatie_turistica` = " . $this->id . " AND `id` = " . $id . ";";

        $result = $mysql->query($query);
        
        return array_map(function ($item) {
            return new LocatieTuristicaImagine((int)$item[1], $item[2], $item[3], $item[0], $item[4]);
        }, $result)[0];
    }

    public function Fundal () {
        $mysql = new MySql();

        $query = "SELECT * FROM `imagine` WHERE `locatie_turistica` = " . $this->id . " AND `fundal` = 1;";

        $result = $mysql->query($query);

        return array_map(function ($item) {
            return new LocatieTuristicaImagine($item[1], $item[2], $item[3], $item[0], $item[4]);
        }, $result)[0];
    }

    /**
     * @return mixed
     */
    public function Create () {
        $mysql = new MySql ();

        $query = "  INSERT INTO `locatie_turistica` (`nume`, `categorie`, `descriere`, `program_destinatie`, `detalii_destinatie`, `created`)
                    VALUES ('" . $this->nume ."', '" . $this->categorie . "', '" . $this->descriere . "', '" . $this->program_destinatie . "', '" . $this->detalii_destinatie . "', Now());";

        $result = $mysql->query($query);

        if ($result) {
            $query = "SELECT * FROM `locatie_turistica` WHERE `nume` = '" . $this->nume ."' AND `categorie` =  '" . $this->categorie . "'";
            $result = $mysql->query($query);

            return array_map(function ($item) {
                return new LocatieTurstica($item[1], $item[2], $item[3], $item[4], $item[5], $item[0], $item[6]);
            }, $result)[0];
        }

        return $result;
    }

    public function Remove () {
        $mysql = new MySql ();

        $query = "DELETE FROM `locatie_turistica` WHERE `id` = " . $this->id . ";";
        $result = $mysql->query($query);
        
        $images = $this->AllImages();

        foreach ($images as $image) {
            array_map('unlink', glob("../images/" . $this->id . "/*.*"));
            
            try {
                rmdir("../images/" . $this->id);
            } 
            catch (Exception $ex) {}
        }

        $query = "DELETE FROM `imagine` WHERE `locatie_turistica` = " . $this->id . ";";
        $result = $mysql->query($query);

        return $result;
    }

    public function Update () {
        $mysql = new MySql ();

        $query = "  UPDATE `locatie_turistica` 
                    SET  `nume` = '" . $this->nume . "', `categorie` = '" . $this->categorie . "', `descriere` = '" . $this->descriere . "', `program_destinatie` = '" . $this->program_destinatie . "', `detalii_destinatie` = '" . $this->detalii_destinatie . "', `updated` = Now()
                    WHERE `id` = " . $this->id . ";";

        $result = $mysql->query($query);

        return $result;
    }

    public function NumeSpecial () {
        $_temp = explode(",", $this->nume);
        $_temp2 = sizeof($_temp) == 1 ? $_temp[0] : $_temp[1];

        return trim(str_replace("!", "", $_temp2));
    }
}
?>