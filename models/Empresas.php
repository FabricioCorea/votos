<?php
class Voto extends Conectar {
    // Método para obtener los votos (empresas)
    public function obtenerVotos() {
        try {
            $conexion = $this->conexion();
            parent::set_names(); // No es necesario en este contexto
            $sql = "SELECT id, empresa, representante FROM votos";
            $stmt = $conexion->prepare($sql);
            $stmt->execute();
            $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (PDOException $e) {
            // Manejar errores de la base de datos
            error_log("Error en la consulta: " . $e->getMessage());
            return false;
        }
    }

    // Inicializar conexión a la base de datos
    private function conectar() {
        return $this->conexion();
    }

    // Método para agregar una nueva empresa
    public function agregarEmpresa($id, $empresa, $representante) {
        try {
            $conexion = $this->conectar();
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
            $conexion = $this->conectar();
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
            $conexion = $this->conectar();
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