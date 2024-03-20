<?php
    class Usuario extends Conectar{

        public function get_usuarios() {
            $conexion = parent::Conexion();
            parent::set_names();
            $sql = "SELECT u.*, r.rol 
                    FROM tbl_usuarios u
                    INNER JOIN tbl_roles r ON u.id_rol = r.id_rol";
            $sql = $conexion->prepare($sql);
            $sql->execute();
            return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
        } 
        public function insert_usuario($rol, $usuario, $nombre, $estado, $contrasena, $creadoPor) {
            $conectar = parent::conexion();
            parent::set_names();
            
            $sql = "INSERT INTO `tbl_usuarios` (`id_rol`, `usuario`, `nombre`, `estado`, `contraseña`, `fecha_ultima_conexion`, `creado_por`, `fecha_creacion`, `modificado_por`, `fecha_modificacion`) 
                    VALUES (?, ?, ?, ?, ?, NULL, ?, CURRENT_TIMESTAMP(), NULL, NULL);";
            
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $rol);
            $sql->bindValue(2, $usuario);
            $sql->bindValue(3, $nombre);
            $sql->bindValue(4, $estado);
            $sql->bindValue(5, $contrasena);
            $sql->bindValue(6, $creadoPor);
            $sql->execute();
            return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
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
        
        public function get_roles(){  
            $conectar = parent::Conexion();
            parent::set_names();
        
            $sql = "SELECT * FROM tbl_roles";       
            $sql = $conectar->prepare($sql);
            $sql->execute();
        
            return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
        }   
        public function verificar_usuario($usuario){               
            $conectar = parent::Conexion();
            parent::set_names();
            $sql = "SELECT usuario FROM `tbl_usuarios`  WHERE usuario=?";
            $sql = $conectar->prepare($sql);
            $sql->bindvalue(1, $usuario);
            $sql->execute();
            return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
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