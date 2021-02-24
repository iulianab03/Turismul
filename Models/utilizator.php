<?php 
if (!PROJECT_ROOT_PATH) {
    include_once "../mysql.php";
}
/**
 * Class Utilizator
 * 
 * @property int $id
 * @property string $email
 * @property string $parola
 * @property string $rol
 * @property string $created
 */
class Utilizator {
    const ROL_USER = "user";
    const ROL_ADMIN = "admin";
    const ROLURI = array(
        self::ROL_USER, 
        self::ROL_ADMIN
    );

    public $id;
    public $email;
    public $parola;
    public $rol;
    public $created;

    public function __construct($_email, $_parola, $_rol, $_id = 0,  $_created = '') {
        $this->email = $_email;
        $this->parola = $_parola;
        $this->rol = $_rol;

        if ($_id > 0) $this->id = $_id;
        if (strlen($_created) > 0) $this->created = $_created;
    }

    /**
     * @return string
     */
    public static function Password ($_email, $_password) {
        return sha1($_email . $_password);
    }

    public function Create () {
        $mysql = new MySql ();

        if (strlen($this->email) == 0 || strlen($this->parola) == 0 || strlen($this->rol) == 0) {
            return 400;
        }

        $userPassword = self::Password($this->email, $this->parola);
        $query = "  INSERT INTO `utilizator` (`email`, `parola`, `rol`, `created`)
                    VALUES ('" . $this->email ."', '" . $userPassword . "', '" . $this->rol . "', Now());";

        $result = $mysql->query($query);

        return $result;
    }

    public static function Logare ($_email, $_parola) {
        $mysql = new MySql ();

        if (strlen($_email) == 0 || strlen($_parola) == 0) {
            return 400;
        }

        $userPassword = self::Password($_email, $_parola);
        $query = "SELECT * FROM `utilizator` WHERE `email` = '" . $_email ."' AND `parola` = '" . $userPassword . "';";
        
        $result = $mysql->query($query);
        if (sizeof($result) == 0) return null;

        return array_map(function ($item) {
            return array(
                "id" => $item[0],
                "email" => $item[1],
                "parola" => "",
                "rol" => $item[3],
                "created" => $item[4]
            );
        }, $result)[0];;
    }

    public function UpdatePassword () {
        $mysql = new MySql ();

        if (strlen($this->email) == 0 || strlen($this->parola) == 0) {
            return 400;
        }

        $userPassword = self::Password($this->email, $this->parola);
        $query = "  UPDATE `utilizator` SET `parola` = '" . $userPassword . "' WHERE `id` = " . $this->id . ";";

        $result = $mysql->query($query);

        return $result;
    }

    public function ChangeRole () {
        $mysql = new MySql ();

        if (strlen($this->email) == 0 || strlen($this->rol) == 0) {
            return 400;
        }

        $query = "  UPDATE `utilizator` SET `role` = '" . $this->rol . "' WHERE `id` = " . $this->id . ";";

        $result = $mysql->query($query);

        return $result;
    }

    public static function GetAll () {
        $mysql = new MySql();

        $query = "SELECT  * FROM `utilizator`;";

        $result = $mysql->query($query);

        return array_map(function ($item) {
            return new Utilizator($item[1], $item[2], $item[3], $item[0], $item[4]);
        }, $result);
    }

    public static function GetOne ($_id) {
        $mysql = new MySql();

        $query = "SELECT  * FROM `utilizator` WHERE `id` = " . $_id . ";";

        $result = $mysql->query($query);

        return array_map(function ($item) {
            return new Utilizator($item[1], $item[2], $item[3], $item[0], $item[4]);
        }, $result)[0];
    }

    public function Remove () {
        $mysql = new MySql ();
        $query = "DELETE FROM `utilizator` WHERE `id` = " . $this->id . ";";
        $result = $mysql->query($query);

        return $result;
    }
}
?>