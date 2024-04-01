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

    public function insert_voto($empresa, $representante, $presente, $representado, $voto) {
        $conectar = parent::conexion();
        parent::set_names();
        
        $sql = "INSERT INTO `votos` (`empresa`, `representante`, `presente`, `representado`, `voto`) 
                VALUES (?, ?, ?, ?, ?)";
        
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $empresa);
        $sql->bindValue(2, $representante);
        $sql->bindValue(3, $presente);
        $sql->bindValue(4, $representado);
        $sql->bindValue(5, $voto);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }  

    public function delete_voto($id_voto) {
        $conectar = parent::conexion();
        parent::set_names();
        
        $sql = "DELETE FROM `votos` WHERE `id` = ?";
        
        $stmt = $conectar->prepare($sql);
        $stmt->execute([$id_voto]);
        
        // Verificar si se eliminó correctamente el voto
        if ($stmt->rowCount() > 0) {
            return true; // Voto eliminado con éxito
        } else {
            return false; // No se pudo eliminar el voto
        }
    }
}
?>
