<?php
    class Conectar{
        protected $dbh;

        protected function Conexion(){
            try {
                $conexion = $this->dbh = new PDO("mysql:host=localhost;dbname=voto","root","");
                return $conexion;
            } catch (Exception $e) {
                print "¡Error BD!: " . $e->getMessage() . "<br/>";
                die();
            }
        }
        public function set_names(){
              return $this->dbh->query("SET NAMES 'utf8'");  
        }
    }
?>   