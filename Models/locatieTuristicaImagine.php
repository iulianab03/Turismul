<?php 
if (!PROJECT_ROOT_PATH) {
    include_once "../mysql.php";
}

/**
 * Class LocatieTuristicaImagine
 * 
 * @property int $id
 * @property string $locatieTuristica
 * @property string $path
 * @property bool $fundal
 * @property string $created
 */
class LocatieTuristicaImagine {
    public $id;
    public $locatieTuristica;
    public $path;
    public $fundal;
    public $created;

    public function __construct($_locatieTuristica = '', $_path = '', $_fundal = '', $_id = 0, $_created = '') {
        if (strlen($_locatieTuristica) > 0) $this->locatieTuristica  = $_locatieTuristica;
        if (strlen($_path) > 0)             $this->path              = $_path;
        if (strlen($_fundal) > 0)           $this->fundal            = $_fundal;
        if (strlen($_created) > 0)          $this->created           = $_created;
        if ($_id > 0)                       $this->id                = (int)$_id;
    }

    public static function reArrayFiles(&$file_post) {
        $file_ary = array();
        $file_count = count($file_post['name']);
        $file_keys = array_keys($file_post);
    
        for ($i=0; $i<$file_count; $i++) {
            foreach ($file_keys as $key) {
                $file_ary[$i][$key] = $file_post[$key][$i];
            }
        }
    
        return $file_ary;
    }

    /**
     * @return mixed
     */
    public function Create () {
        $mysql = new MySql ();

        $query = "INSERT INTO `imagine` (`locatie_turistica`, `path`, `fundal`) VALUES (" . $this->locatieTuristica .", '" . $this->path . "', '" . $this->fundal . "');";

        $result = $mysql->query($query);

        return $result;
    }

    public static function NewImage ($locatie, $path) {
        $image = new LocatieTuristicaImagine($locatie, $path, 0);
        $image->Create();
    }
    
    public static function StergeImagine ($imagineId) {
        $mysql = new MySql ();
        $query = "SELECT `path` FROM `imagine` WHERE `id` = " . $imagineId . ";";
        $result = $mysql->query($query);

        $path = $result[0][0];
        if (!$path || strlen($path) == 0) return false;
        
        $query = "DELETE FROM `imagine` WHERE `id` = " . $imagineId . ";";
        $result = $mysql->query($query);
        
        error_reporting(0);
        unlink("../" . $path);
        error_reporting(1);

        return true;
    }
}
?>