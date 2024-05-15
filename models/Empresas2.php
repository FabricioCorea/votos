<?php

class Empresas2 extends Conectar {

    // Método para obtener las empresas
    public function obtenerEmpresas() {
        try {
            $conexion = $this->conexion();
            $query = "SELECT * FROM votos";
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
    public function agregarEmpresa($id, $empresa, $representante) {
        try {
            $conexion = $this->conexion();
            $query = "INSERT INTO votos (id, empresa, representante) VALUES (:idEmpresa, :nombreEmpresa, :representante)";
            $stmt = $conexion->prepare($query);
            $stmt->bindParam(':idEmpresa', $id);
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

    // Método para actualizar una empresa
    public function actualizarEmpresa($idEmpresa, $empresa, $representante) {
        try {
            $conexion = $this->conexion();
            $query = "UPDATE votos SET empresa = :nombreEmpresa, representante = :representante WHERE id = :idEmpresa";
            $stmt = $conexion->prepare($query);
            $stmt->bindParam(':idEmpresa', $idEmpresa);
            $stmt->bindParam(':nombreEmpresa', $empresa);
            $stmt->bindParam(':representante', $representante);
            $exito = $stmt->execute();
            return $exito;
        } catch (PDOException $e) {
            // Manejar errores de la base de datos
            error_log("Error al actualizar empresa: " . $e->getMessage());
            return false;
        }
    }

    // Método para eliminar una empresa
    public function eliminarEmpresa($idEmpresa) {
        try {
            $conexion = $this->conexion();
            $query = "DELETE FROM votos WHERE id = :idEmpresa";
            $stmt = $conexion->prepare($query);
            $stmt->bindParam(':idEmpresa', $idEmpresa);
            $exito = $stmt->execute();
            return $exito;
        } catch (PDOException $e) {
            // Manejar errores de la base de datos
            error_log("Error al eliminar empresa: " . $e->getMessage());
            return false;
        }
    }

}

?>
