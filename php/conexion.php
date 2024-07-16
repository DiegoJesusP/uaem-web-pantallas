<?php
class CConexion {

    private $host = "localhost";
    private $dbname = "postgres";
    private $username = "postgres";
    private $password = "root";

    public function conexionBD(){
        $conn = null;
        try {
            $conn = new PDO("pgsql:host=$this->host;dbname=$this->dbname", $this->username, $this->password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //echo "Conexión exitosa c:";
        } 
        catch (PDOException $exp) {
            echo "No se conectó a la base de datos :c " . $exp->getMessage();
        }

        return $conn;
    }

    public function cerrarConexion(&$conn){
        $conn = null;
    }
}
?>
