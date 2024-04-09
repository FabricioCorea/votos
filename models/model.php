<?php
class Model {
    private $conexion;

    public function __construct() {
        $this->conexion = new mysqli("localhost", "root", "", "voto");
        if ($this->conexion->connect_error) {
            die("Error en la conexión a la base de datos: " . $this->conexion->connect_error);
        }
    }

    public function obtenerRegistros($busqueda = "", $pagina = 1, $porPagina = 10) {
        $offset = ($pagina - 1) * $porPagina;
        $busqueda = $this->conexion->real_escape_string($busqueda);
        $query = "SELECT * FROM votos";
        if (!empty($busqueda)) {
            $query .= " WHERE empresa LIKE '%$busqueda%' OR representante LIKE '%$busqueda%'";
        }
        $query .= " LIMIT $offset, $porPagina";
        $result = $this->conexion->query($query);
        $registros = [];
        while ($row = $result->fetch_assoc()) {
            $registros[] = $row;
        }
        return $registros;
    }

    public function contarRegistros($busqueda = "") {
        $busqueda = $this->conexion->real_escape_string($busqueda);
        $query = "SELECT COUNT(*) AS total FROM votos";
        if (!empty($busqueda)) {
            $query .= " WHERE empresa LIKE '%$busqueda%' OR representante LIKE '%$busqueda%'";
        }
        $result = $this->conexion->query($query);
        $row = $result->fetch_assoc();
        return $row['total'];
    }
}
?>
