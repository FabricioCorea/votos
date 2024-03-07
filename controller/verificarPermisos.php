<?php
include './config/conexion.php';

function verificarPermisoInsercion($conn, $usuario, $id_objeto)
{
    // Recuperar el ID del usuario
    $id_usuario = $usuario['id_usuario'];

    // Realizar la consulta SQL para obtener el permiso de inserción del usuario para el objeto específico
    $query = "SELECT tp.Permiso_insercion
              FROM tbl_usuarios tu
              INNER JOIN tbl_roles tr ON tu.id_rol = tr.id_rol
              INNER JOIN tbl_permisos tp ON tr.id_rol = tp.id_rol
              WHERE tu.id_usuario = $id_usuario AND tp.id_objeto = $id_objeto";

    $result = mysqli_query($conn, $query);

    if (!$result) {
        // Manejar el error si la consulta falla
        echo "Error en la consulta: " . mysqli_error($conn);
        return false;
    } else {
        // Verificar si se encontró el permiso de inserción
        if (mysqli_num_rows($result) > 0) {
            // Obtener el resultado de la consulta
            $row = mysqli_fetch_assoc($result);
            // Verificar el permiso de inserción
            if ($row['Permiso_insercion'] !== 'S') {
                // No tiene permiso de inserción
                return false;
            } else {
                return true;
            }
        } else {
            // No se encontró ningún permiso, permitir el registro
            return true;
        }
    }
}

function verificarPermisoActualizacion($conn, $usuario, $id_objeto)
{
    // Recuperar el ID del usuario
    $id_usuario = $usuario['id_usuario'];

    // Realizar la consulta SQL para obtener el permiso de actualización del usuario para el objeto específico
    $query = "SELECT tp.Permiso_actualizacion
              FROM tbl_usuarios tu
              INNER JOIN tbl_roles tr ON tu.id_rol = tr.id_rol
              INNER JOIN tbl_permisos tp ON tr.id_rol = tp.id_rol
              WHERE tu.id_usuario = $id_usuario AND tp.id_objeto = $id_objeto";

    $result = mysqli_query($conn, $query);

    if (!$result) {
        // Manejar el error si la consulta falla
        echo "Error en la consulta: " . mysqli_error($conn);
        return false;
    } else {
        // Verificar si se encontró el permiso de actualización
        if (mysqli_num_rows($result) > 0) {
            // Obtener el resultado de la consulta
            $row = mysqli_fetch_assoc($result);
            // Verificar el permiso de actualización
            if ($row['Permiso_actualizacion'] !== 'S') {
                // No tiene permiso de actualización
                return false;
            } else {
                return true;
            }
        } else {
            // No se encontró ningún permiso, permitir el registro
            return true;
        }
    }
}

function verificarPermisoEliminacion($conn, $usuario, $id_objeto)
{
    // Recuperar el ID del usuario
    $id_usuario = $usuario['id_usuario'];

    // Realizar la consulta SQL para obtener el permiso de eliminación del usuario para el objeto específico
    $query = "SELECT tp.Permiso_eliminacion
              FROM tbl_usuarios tu
              INNER JOIN tbl_roles tr ON tu.id_rol = tr.id_rol
              INNER JOIN tbl_permisos tp ON tr.id_rol = tp.id_rol
              WHERE tu.id_usuario = $id_usuario AND tp.id_objeto = $id_objeto";

    $result = mysqli_query($conn, $query);

    if (!$result) {
        // Manejar el error si la consulta falla
        echo "Error en la consulta: " . mysqli_error($conn);
        return false;
    } else {
        // Verificar si se encontró el permiso de eliminación 
        if (mysqli_num_rows($result) > 0) {
            // Obtener el resultado de la consulta
            $row = mysqli_fetch_assoc($result);
            // Verificar el permiso de eliminación 
            if ($row['Permiso_eliminacion'] !== 'S') {
                // No tiene permiso de eliminación 
                return false;
            } else {
                return true;
            }
        } else {
            // No se encontró ningún permiso, permitir el registro
            return true;
        }
    }
}

function verificarPermisoConsultar($conn, $usuario, $id_objeto)
{
    // Recuperar el ID del usuario
    $id_usuario = $usuario['id_usuario'];

    // Realizar la consulta SQL para obtener el permiso de consultar del usuario para el objeto específico
    $query = "SELECT tp.Permiso_consultar
              FROM tbl_usuarios tu
              INNER JOIN tbl_roles tr ON tu.id_rol = tr.id_rol
              INNER JOIN tbl_permisos tp ON tr.id_rol = tp.id_rol
              WHERE tu.id_usuario = $id_usuario AND tp.id_objeto = $id_objeto";

    $result = mysqli_query($conn, $query);

    if (!$result) {
        // Manejar el error si la consulta falla
        echo "Error en la consulta: " . mysqli_error($conn);
        return false;
    } else {
        // Verificar si se encontró el permiso de consultar
        if (mysqli_num_rows($result) > 0) {
            // Obtener el resultado de la consulta
            $row = mysqli_fetch_assoc($result);
            // Verificar el permiso de consultar
            if ($row['Permiso_consultar'] !== 'S') {
                // No tiene permiso de consultar
                return false;
            } else {
                return true;
            }
        } else {
            // No se encontró ningún permiso, permitir el registro
            return true;
        }
    }
}
?>
