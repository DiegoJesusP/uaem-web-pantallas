<?php
class CConexion {

    public function conexionBD(){
        $host = "localhost";
        $dbname = "postgres";
        $username = "postgres";
        $pasword = "root";

        try {
            $conn = new PDO("pgsql:host=$host;dbname=$dbname", $username, $pasword);
            //echo "Segun si conecto c:";
        } 
        catch (PDOException $exp) {
            echo "No se conecto a la base de datos :c" . $exp->getMessage();
        }

        return $conn;
    }
}
?>
