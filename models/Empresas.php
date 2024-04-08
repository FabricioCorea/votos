<?php
class Voto extends Conectar{

    public function get_votos() {
        $conexion = parent::Conexion();
        parent::set_names();
        $sql = "SELECT * FROM votos LIMIT 50";
        $sql = $conexion->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    } 

    public function insert_voto($empresa, $representante) {
        $conectar = parent::conexion();
        parent::set_names();
        
        $sql = "INSERT INTO `votos` (`empresa`, `representante`) VALUES (?, ?)";
        
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $empresa);
        $sql->bindValue(2, $representante);
        $sql->execute();
        
        // Retornar el número de filas afectadas por la inserción
        return $sql->rowCount();
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
