<?php
    class Voto extends Conectar{

        public function get_votos() {
            $conexion = parent::Conexion();
            parent::set_names();
            $sql = "SELECT * FROM votos";
            $sql = $conexion->prepare($sql);
            $sql->execute();
            return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
        }
        public function get_voto($id) {
            $conexion = parent::Conexion();
            parent::set_names();
            
            $sql = "SELECT * FROM votos WHERE id = :id";
            $sql = $conexion->prepare($sql);
            $sql->bindParam(':id', $id, PDO::PARAM_INT);
            $sql->execute();
            
            return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
        }
        
    }
?>