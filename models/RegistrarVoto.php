<?php
    class RegistrarVoto extends Conectar{

        public function get_empresas() {
            $conexion = parent::Conexion();
            parent::set_names();
            $sql = "SELECT * FROM votos";
            $sql = $conexion->prepare($sql);
            $sql->execute();
            return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
        }
        public function get_empresa($id) {
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