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
}
?>
