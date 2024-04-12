<?php
class Empresas2 extends Conectar {
    // Método para obtener las empresas
    public function obtenerEmpresas() {
        try {
            $conexion = $this->conexion();
            $query = "SELECT * FROM votos"; // Ajusta esta consulta según tu esquema de base de datos
            $stmt = $conexion->prepare($query);
            $stmt->execute();
            $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (PDOException $e) {
            // Manejar errores de la base de datos
            error_log("Error en la consulta: " . $e->getMessage());
            return false;
        }
    }


    // Método para agregar una nueva empresa
    public function agregarEmpresa($empresa, $representante) {
        try {
            $conexion = $this->conexion();
            $query = "INSERT INTO votos (empresa, representante) VALUES (:nombreEmpresa, :representante)";
            $stmt = $conexion->prepare($query);
            $stmt->bindParam(':nombreEmpresa', $empresa);
            $stmt->bindParam(':representante', $representante);
            $exito = $stmt->execute();
            return $exito;
        } catch (PDOException $e) {
            // Manejar errores de la base de datos
            error_log("Error al agregar empresa: " . $e->getMessage());
            return false;
        }
    }



    public function delete_usuario($id_usuario) {
        $conectar = parent::conexion();
        parent::set_names();
        
        $sql = "DELETE FROM `tbl_usuarios` WHERE `id_usuario` = ?";
        
        $stmt = $conectar->prepare($sql);
        $stmt->execute([$id_usuario]);
        
        // Verificar si se eliminó correctamente el usuario
        if ($stmt->rowCount() > 0) {
            return true; // Usuario eliminado con éxito
        } else {
            return false; // No se pudo eliminar el usuario
        }
    }

    // Verificar que el usuario a eliminar existe
    public function verificar_usuario_por_id($id_usuario) {
        $conectar = parent::conexion();
        parent::set_names();
        
        $sql = "SELECT * FROM `tbl_usuarios` WHERE `id_usuario` = ?";
        
        $stmt = $conectar->prepare($sql);
        $stmt->execute([$id_usuario]);
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}
?>
