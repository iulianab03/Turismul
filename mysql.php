<?php 

class MySql { 
    public $connection;

    public function __construct() {
        $this->connection =  new mysqli('localhost', 'root','', 'turism');
    }

    public function __destruct()
    {
        $this->connection->close();
    }

    public function query($query, $multiQuery = false){
        if (strlen($query) == 0) return null;

        if ($multiQuery) {
            if ($this->connection->multi_query($query)) {
                $out = [];
                do {
                    if ($result = $this->connection -> store_result()) {
                        while ($row = $result -> fetch_row()) {
                            $out[] = $row;
                        }
                        $result -> free_result();
                    }

                    if (!$this->connection->more_results()) break;
                } 
                while ($this->connection->next_result());

                return sizeof($out) > 0 ? $out : true;
            }

            return true;
        }

        if ($result = $this->connection->query($query)) {
            if (is_bool($result)) {
                return $result;
            }
            return $result->fetch_all();
        }

        return false;
    }
}

?>