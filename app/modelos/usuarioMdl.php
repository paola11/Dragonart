<?php
	class usuarioMdl{

		private $acceso;
		private $db;

		function __construct(){
			require_once('app/modelos/conector.php');
			$this->acceso = conector::getInstancia();
			$this->db = $this->acceso->getDriver();
		}

		function alta($nombre, $alias, $correo, $contrasena, $tipo){
			$bandera = false;
			$avatar = 'uploads/avatar/avatar.jpg';
			//TIPO 0 ES ADMINISTRADOR
			//TIPO 1 ES USUARIO
			$status = 1; //Usuario activo

			if($stmt = $this->db->prepare('INSERT INTO usuario (nombreUsuario, aliasUsuario, correoUsuario, contrasenaUsuario, avatarUsuario, tipoUsuario, statusUsuario) VALUES (?, ?, ?, PASSWORD(?), ?, ?, ?)')){

				$stmt->bind_param("sssssii", $nombre, $alias, $correo, $contrasena, $avatar, $tipo, $status);

				$bandera = $stmt->execute();

				$stmt->fetch();

				$stmt->close();
			}

			return $bandera;
		}

		function baja($id){
			$bandera = false;

			if($stmt = $this->db->prepare('UPDATE usuario SET statusUsuario=0 WHERE idUsuario=?')){

				$stmt->bind_param("i", $id);

				$bandera = $stmt->execute();

				$stmt->fetch();
				
				$stmt->close();

			}

			return $bandera;
		}

		function reactivar($id){
			$bandera = false;

			if($stmt = $this->db->prepare('UPDATE usuario SET statusUsuario=1 WHERE idUsuario=?')){

				$stmt->bind_param("i", $id);

				$bandera = $stmt->execute();

				$stmt->fetch();
				
				$stmt->close();

			}

			return $bandera;
		}

		function modificar($id, $alias, $contrasena, $biografia, $avatar){
			$bandera = false;

			if($stmt = $this->db->prepare('UPDATE usuario SET aliasUsuario=?, contrasenaUsuario=PASSWORD(?), biografiaUsuario=?, avatarUsuario=? WHERE idUsuario=?')){

				$stmt->bind_param("ssssi", $alias, $contrasena, $biografia, $avatar, $id);

				$bandera = $stmt->execute();

				$stmt->fetch();
				
				$stmt->close();

			}

			return $bandera;
		}

		function modificarAdmon($id, $nombre, $alias, $correo, $biografia){
			$bandera = false;

			if($stmt = $this->db->prepare('UPDATE usuario SET nombreUsuario=?, aliasUsuario=?, correoUsuario=?, biografiaUsuario=? WHERE idUsuario=?')){

				$stmt->bind_param("ssssi", $nombre, $alias, $correo, $biografia, $id);

				$bandera = $stmt->execute();

				$stmt->fetch();
				
				$stmt->close();

			}

			return $bandera;
		}

		function modificarSinContrasena($id, $alias, $biografia, $avatar){
			$bandera = false;

			if($stmt = $this->db->prepare('UPDATE usuario SET aliasUsuario=?, biografiaUsuario=?, avatarUsuario=? WHERE idUsuario=?')){

				$stmt->bind_param("sssi", $alias, $biografia, $avatar, $id);

				$bandera = $stmt->execute();

				$stmt->fetch();
				
				$stmt->close();

			}

			return $bandera;
		}

		function iniciarSesion($correo, $contrasena){
			if($stmt = $this->db->prepare('SELECT * FROM usuario WHERE correoUsuario=? AND contrasenaUsuario=PASSWORD(?)')){

				$stmt->bind_param("ss", $correo, $contrasena);

				$stmt->execute();

				$stmt->store_result();

				$stmt->fetch();
				$numFilas = $stmt->num_rows;

				$stmt->close();

				if($numFilas === 0){
					return false;
				}
				else{
					return true;
				}
			}
			return false;
		}

		function cambiarContrasenas($viejoPass, $nuevoPass){
			$bandera = false;

			if($stmt = $this->db->prepare('UPDATE usuario SET contrasenaUsuario=? WHERE idUsuario=?')){

				$stmt->bind_param("sssi", $alias, $biografia, $avatar, $id);

				$bandera = $stmt->execute();

				$stmt->fetch();
				
				$stmt->close();

			}

			return $bandera;
		}

		function cambiarContrasenaCorreo($id, $nuevoPass){
			$bandera = false;

			if($stmt = $this->db->prepare('UPDATE usuario SET contrasenaUsuario=PASSWORD(?) WHERE idUsuario=?')){

				$stmt->bind_param("si", $nuevoPass, $id);

				$bandera = $stmt->execute();

				$stmt->fetch();
				
				$stmt->close();

			}

			return $bandera;
		}

		function existeNombre($nombre){
			if($stmt = $this->db->prepare('SELECT * FROM usuario WHERE nombreUsuario=?')){

				$stmt->bind_param("s", $nombre);

				$stmt->execute();

				$stmt->store_result();

				$stmt->fetch();
				$numFilas = $stmt->num_rows;

				$stmt->close();

				if($numFilas === 0){
					return false;
				}
				else{
					return true;
				}
			}
			return true;
		}

		function existeCorreo($correo){
			if($stmt = $this->db->prepare('SELECT * FROM usuario WHERE correoUsuario=?')){

				$stmt->bind_param("s", $correo);

				$stmt->execute();

				$stmt->store_result();

				$stmt->fetch();
				$numFilas = $stmt->num_rows;

				$stmt->close();

				if($numFilas === 0){
					return false;
				}
				else{
					return true;
				}
			}
			return true;
		}

		function existeNombreExcepto($nombre, $id){
			if($stmt = $this->db->prepare('SELECT * FROM usuario WHERE nombreUsuario=? AND NOT idUsuario=?')){

				$stmt->bind_param("si", $nombre, $id);

				$stmt->execute();

				$stmt->store_result();

				$stmt->fetch();
				$numFilas = $stmt->num_rows;

				$stmt->close();

				if($numFilas === 0){
					return false;
				}
				else{
					return true;
				}
			}
			return true;
		}

		function existeCorreoExcepto($correo, $id){
			if($stmt = $this->db->prepare('SELECT * FROM usuario WHERE correoUsuario=? AND NOT idUsuario=?')){

				$stmt->bind_param("si", $correo, $id);

				$stmt->execute();

				$stmt->store_result();

				$stmt->fetch();
				$numFilas = $stmt->num_rows;

				$stmt->close();

				if($numFilas === 0){
					return false;
				}
				else{
					return true;
				}
			}
			return true;
		}
        
        function existeCorreoNombre($correo){
			if($stmt = $this->db->prepare('SELECT idUsuario, nombreUsuario, correoUsuario, contrasenaUsuario FROM usuario WHERE correoUsuario=?')){

				$stmt->bind_param("s", $correo);

				$stmt->execute();
                
                $stmt->bind_result($idUsuario, $nombreUsuario, $correoUsuario, $contrasenaUsuario);
                
				$stmt->fetch();
                
                $array = array(
                	'id' => $idUsuario,
                    'nombre' => $nombreUsuario,
                    'correo' => $correoUsuario,
                    'pass' => $contrasenaUsuario
                );
                
				$stmt->close();
                
                return $array;
			}
			return false;
		}
        
        function obtenerInfoFB($correo){
			if($stmt = $this->db->prepare('SELECT * FROM usuario WHERE correoUsuario=?')){

				$stmt->bind_param("s", $correo);

				$stmt->execute();
                
                $stmt->bind_result($idUsuario, $nombreUsuario, $aliasUsuario, $correoUsuario, $contrasenaUsuario, $biografiaUsuario, $avatarUsuario, $tipoUsuario, $statusUsuario);

				$stmt->fetch();
				
				$array = array(
					'id' => $idUsuario,
					'nombre' => $nombreUsuario,
					'alias' => $aliasUsuario,
					'correo' => $correoUsuario,
					'contrasena' => $contrasenaUsuario,
					'biografia' => $biografiaUsuario,
					'avatar' => $avatarUsuario,
					'tipo' => $tipoUsuario,
					'status' => $statusUsuario
				);
                
				$stmt->close();
                
                return $array;
			}
			return false;
		}

		function obtenerInfo($correo, $contrasena){
			if($stmt = $this->db->prepare('SELECT * FROM usuario WHERE correoUsuario=? AND contrasenaUsuario=PASSWORD(?)')){

				$stmt->bind_param("ss", $correo, $contrasena);

				$stmt->execute();

				$stmt->bind_result($idUsuario, $nombreUsuario, $aliasUsuario, $correoUsuario, $contrasenaUsuario, $biografiaUsuario, $avatarUsuario, $tipoUsuario, $statusUsuario);

				$stmt->fetch();
				
				$array = array(
					'id' => $idUsuario,
					'nombre' => $nombreUsuario,
					'alias' => $aliasUsuario,
					'correo' => $correoUsuario,
					'contrasena' => $contrasenaUsuario,
					'biografia' => $biografiaUsuario,
					'avatar' => $avatarUsuario,
					'tipo' => $tipoUsuario,
					'status' => $statusUsuario
				);
				
				$stmt->close();

				return $array;
			}

			return false;
		}

		function obtenerInfoPorID($id){
			if($stmt = $this->db->prepare('SELECT * FROM usuario WHERE idUsuario=?')){

				$stmt->bind_param("i", $id);

				$stmt->execute();

				$stmt->bind_result($idUsuario, $nombreUsuario, $aliasUsuario, $correoUsuario, $contrasenaUsuario, $biografiaUsuario, $avatarUsuario, $tipoUsuario, $statusUsuario);

				$stmt->fetch();
				
				$array = array(
					'id' => $idUsuario,
					'nombre' => $nombreUsuario,
					'alias' => $aliasUsuario,
					'correo' => $correoUsuario,
					'contrasena' => $contrasenaUsuario,
					'biografia' => $biografiaUsuario,
					'avatar' => $avatarUsuario,
					'tipo' => $tipoUsuario,
					'status' => $statusUsuario
				);
				
				$stmt->close();

				return $array;
			}

			return false;
		}

		function paginaUsuario($usuario){
			if($stmt = $this->db->prepare('SELECT * FROM usuario WHERE nombreUsuario=?')){

				$stmt->bind_param("s", $usuario);

				$stmt->execute();

				$stmt->bind_result($idUsuario, $nombreUsuario, $aliasUsuario, $correoUsuario, $contrasenaUsuario, $biografiaUsuario, $avatarUsuario, $tipoUsuario, $statusUsuario);

				$stmt->fetch();
				
				$stmt->close();
				
				$array = array(
					'id' => $idUsuario,
					'nombre' => $nombreUsuario,
					'alias' => $aliasUsuario,
					'correo' => $correoUsuario,
					'contrasena' => $contrasenaUsuario,
					'biografia' => $biografiaUsuario,
					'avatar' => $avatarUsuario,
					'tipo' => $tipoUsuario,
					'status' => $statusUsuario
				);

				return $array;
			}

			return false;
		}

		function cambiarEstadoUsuario($nombre, $estado){
			$bandera = false;

			if($stmt = $this->db->prepare('UPDATE usuario SET statusUsuario=? WHERE nombreUsuario=?')){

				$stmt->bind_param("is", $estado, $nombre);

				$bandera = $stmt->execute();

				$stmt->fetch();
				
				$stmt->close();

			}

			return $bandera;
		}

		function getError(){
			return $this->db->error;
		}

		function real_escape_string($cadena){
			return $this->db->real_escape_string($cadena);
		}
        
        function busquedaUsuarioNombre($palabra, $offset, $limit){
        	$palabra = '%'.$palabra.'%';
            if($stmt = $this->db->prepare('SELECT idUsuario, nombreUsuario, aliasUsuario, avatarUsuario, statusUsuario FROM usuario WHERE nombreUsuario LIKE ? AND statusUsuario=1 LIMIT ?,?')){

				$stmt->bind_param("sii", $palabra, $offset, $limit);

				$stmt->execute();

				$stmt->bind_result($idUsuario, $nombreUsuario, $aliasUsuario, $avatarUsuario, $statusUsuario);

				$array = array();

				while($stmt->fetch()){
					$array[] = array(
						'id' => $idUsuario,
						'nombre' => $nombreUsuario,
						'alias' => $aliasUsuario,
						'avatar' => $avatarUsuario,
						'status' => $statusUsuario
					);
				}

				return $array;
			}

			return false;
        }

        function busquedaUsuarioAlias($palabra, $offset, $limit){
        	$palabra = '%'.$palabra.'%';
            if($stmt = $this->db->prepare('SELECT idUsuario, nombreUsuario, aliasUsuario, avatarUsuario, statusUsuario FROM usuario WHERE aliasUsuario LIKE ? AND statusUsuario=1 LIMIT ?,?')){

				$stmt->bind_param("sii", $palabra, $offset, $limit);

				$stmt->execute();

				$stmt->bind_result($idUsuario, $nombreUsuario, $aliasUsuario, $avatarUsuario, $statusUsuario);

				$array = array();

				while($stmt->fetch()){
					$array[] = array(
						'id' => $idUsuario,
						'nombre' => $nombreUsuario,
						'alias' => $aliasUsuario,
						'avatar' => $avatarUsuario,
						'status' => $statusUsuario
					);
				}

				return $array;
			}

			return false;
        }

        function backend($offset, $limit){
        	if($stmt = $this->db->prepare('SELECT * FROM usuario ORDER BY idUsuario DESC LIMIT ?,?')){

				$stmt->bind_param("ii", $offset, $limit);

				$stmt->execute();

				$stmt->bind_result($idUsuario, $nombreUsuario, $aliasUsuario, $correoUsuario, $contrasenaUsuario, $biografiaUsuario, $avatarUsuario, $tipoUsuario, $statusUsuario);

				$array = array();

				while($stmt->fetch()){
					$array[] = array(
						'id' => $idUsuario,
						'nombre' => $nombreUsuario,
						'alias' => $aliasUsuario,
						'correo' => $correoUsuario,
						'contrasena' => $contrasenaUsuario,
						'biografia' => $biografiaUsuario,
						'avatar' => $avatarUsuario,
						'tipo' => $tipoUsuario,
						'status' => $statusUsuario
					);
				}

				$stmt->close();

				return $array;
			}

			return false;
        }
		
	}
?>