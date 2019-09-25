<?php

	function vmostrarmensaje($titulo, $texto) {
		$mensaje = file_get_contents("mensaje.html");
		$mensaje = str_replace("##titulo##", $titulo, $mensaje);
		$mensaje = str_replace("##texto##", $texto, $mensaje);

		echo $mensaje;
	}

	function vmostrarportada($resultado){
		$portada = file_get_contents("portada.html");
		$trozos = explode("##cortar##",$portada);
		$aux="";
		$cuerpo = "";
		$i=0;
		while (($datos = $resultado->fetch_assoc()) && ($i<21)){
			$i++;
			$aux = $trozos[1];
			$aux = str_replace("##imagen##", $datos["name_image"], $aux);
			$aux = str_replace("##descripcion##", $datos["desc_image"], $aux);
			$aux = str_replace("##categoria##", $datos["tipo_cat"], $aux);
			$cuerpo = $cuerpo . $aux;
		}
		echo $trozos[0] . $cuerpo . $trozos[2];
	}

	function vmostrarportadalogeado2($username,$resultado){
		$portada = file_get_contents("portadalogeado.html");
		$portada = str_replace("##username##", $username, $portada);
		$trozos = explode("##cortar##",$portada);
		$aux="";
		$cuerpo = "";
		$i=0;
		while (($datos = $resultado->fetch_assoc()) && ($i<21)){
			$i++;
			$aux = $trozos[1];
			$aux = str_replace("##imagen##", $datos["name_image"], $aux);
			$aux = str_replace("##descripcion##", $datos["desc_image"], $aux);
			$aux = str_replace("##categoria##", $datos["tipo_cat"], $aux);
			$cuerpo = $cuerpo . $aux;
		}
		echo $trozos[0] . $cuerpo . $trozos[2];
	}

	function vmostrarportadalogeado(){
		$portada = file_get_contents("portadalogeado.html");
		echo $portada;
	}

	function vmostraraltapersona() {
		echo file_get_contents("alta_usuario.html");
	}

	function vmostrarloginpersona() {
		echo file_get_contents("login_usuario.html");
	}

	function vmostrarmodificarpersona($username){
		$mensaje = file_get_contents("modificar_usuario.html");
		$mensaje = str_replace("##username##",$username,$mensaje);
		echo $mensaje;
	}

	function vmostrareliminarpersona($username){
		$mensaje = file_get_contents("eliminar_usuario.html");
		$mensaje = str_replace("##username##",$username,$mensaje);
		echo $mensaje;
	}

	function vmostrarpaneladmin(){
		echo file_get_contents("panel_administracion.html");
	}

	function vmostrarresultadomodificarpersona($res){
		switch($res) {
			case 1:
				//vmostrarportadalogeado();
				$username = $_SESSION["user"];
				vmostrarportadalogeado2($username,mrecogerimagenes());
				break;
			case -1:
				vmostrarmensaje("Modificar Usuario", "Error en la conexión con la base de datos ");
				break;
			case -2:
				vmostrarmensaje("Modificar Usuario", "Solo puedes modificar tu usuario ");
				break;
			case -3:
				vmostrarmensaje("Modificar Usuario", "No se puede dejar campos vacíos");
				break;
		}
	}

	function vmostrarresultadologinpersona($res) {
		switch($res) {
			case 1:
				//vmostrarmensaje("Login de usuario", "Usuario logeado correctamente");
				$username = $_SESSION["user"];
				//echo "El password es : " . $_SESSION["password"] . "<br>";
				if($username=="admin"){
					vmostrarpaneladmin();
				}else{
					vmostrarportadalogeado2($username,mrecogerimagenes());
				}
				break;
			case -1:
				vmostrarmensaje("Login de usuario", "Error en la conexión con la base de datos ");
				break;
			case -2:
				vmostrarmensaje("Login de usuario", "Usuario o contraseña incorrectos");
				break;
		}
	}

	function vmostrarresultadoaltapersona($res) {
		switch($res) {
			case 1:
				vmostrarportada(mrecogerimagenes());
				break;
			case -1:
				vmostrarmensaje("Alta de usuario", "Error en la conexión con la base de datos ");
				break;
			case -2:
				vmostrarmensaje("Alta de usuario", "Ya existe un usuario con ese nombre");
				break;
			case -3:
				vmostrarmensaje("Alta de usuario", "No se puede dejar el campo \"nombre de usuario\" vacío");
				break;
			case -4:
				vmostrarmensaje("Alta de usuario", "No se puede dejar el campo \"email\" vacío");
				break;
			case -5:
				vmostrarmensaje("Alta de usuario", "No se puede dejar el campo \"password\" vacío");
				break;
			case -6:
				vmostrarmensaje("Alta de usuario", "Las contraseñas introducidas no coinciden");
				break;
		}
	}

	function vmostrarexit() {
		vmostrarportada(mrecogerimagenes());
	}

	function vmostrarresultadomiperfil($resultado){
		$mensaje = file_get_contents("miperfil.html");
		while ($datos = $resultado->fetch_assoc()) {
			$mensaje = str_replace("##username##",$datos["username"],$mensaje);
			$mensaje = str_replace("##name##", $datos["name"], $mensaje);
			$mensaje = str_replace("##surname##", $datos["surname"], $mensaje);
			$mensaje = str_replace("##surname2##", $datos["surname2"], $mensaje);
			$mensaje = str_replace("##email##", $datos["email"], $mensaje);
		}
		echo $mensaje;
	}

	function vmostrarresultadoeliminarpersona($res){
		switch($res){
			case 1:
				vmostrarportada(mrecogerimagenes());
				break;	
			case -1:
				vmostrarmensaje("Eliminar Usuario", "Error en la conexión con la base de datos ");
				break;
			case -2:
				vmostrarmensaje("Eliminar Usuario", "Contraseña Incorrecta ");
				break;
			case -3:
				vmostrarmensaje("Eliminar Usuario", "No ha indicado la contraseña ");
				break;

		}
	}

	function vmostrarsubirimagen($resultado,$categorias){
		$mensaje = file_get_contents("dropzone.html");
		while ($datos = $resultado->fetch_assoc()) {
			$mensaje = str_replace("##username##",$datos["username"],$mensaje);
		}
		$trozos=explode("##cortar##",$mensaje);
		$aux= "";
		$cuerpo="";
		while ($datos = $categorias->fetch_assoc()) {
			$aux = $trozos[1];
			$aux = str_replace("##categoria##",$datos["categoria"],$aux);
			$cuerpo .= $aux;
		}
		echo $trozos[0].$cuerpo.$trozos[2];
	}

	function vmostrarresultadosubirimagen($resultado){
		//switch($resultado) {
			//case -1:
				//vmostrarmensaje("Error Imagen", "Error en la conexión con la base de datos ");
			//	break;
			//default:
				$mensaje = file_get_contents("miperfil.html");
				while ($datos = $resultado->fetch_assoc()) {
					$mensaje = str_replace("##username##",$datos["username"],$mensaje);
					$mensaje = str_replace("##name##", $datos["name"], $mensaje);
					$mensaje = str_replace("##surname##", $datos["surname"], $mensaje);
					$mensaje = str_replace("##surname2##", $datos["surname2"], $mensaje);
					$mensaje = str_replace("##email##", $datos["email"], $mensaje);
				}
				echo $mensaje;
			//	break;
		//}
	}

	function vmostrarimagenes($resultado,$username){
		$cadena = file_get_contents("mostrar_imagenes.html");
		if(mysqli_num_rows($resultado)==0){
			$cadena = str_replace("##username##",$username,$cadena);
			$trozos = explode("##imagenes##",$cadena);
			echo $trozos[0].$trozos[2];
		}else{
			$trozos = explode("##imagenes##",$cadena);
			$aux="";
			$aux2="";
			$aux3="";
			$cuerpo = "";
			while ($datos = $resultado->fetch_assoc()) {
				$aux = $trozos[1];
				$aux2 = $trozos[0];
				$aux3 = $trozos[2];
				$imagen = explode(".",$datos["name_image"]);
				$imagen2 = explode("_",$imagen[0]);
				$aux2 = str_replace("##username##", $datos["id_user"], $aux2);
				$aux3 = str_replace("##username##", $datos["id_user"], $aux3);
				$aux = str_replace("##name_image##", $imagen2 [0], $aux);
				$aux = str_replace("##username##", $datos["id_user"], $aux);
				$aux = str_replace("##imagen##", $datos["name_image"], $aux);
				$aux = str_replace("##description_image##", $datos["desc_image"], $aux);
				$aux = str_replace("##categoria##", $datos["tipo_cat"], $aux);
				$aux = str_replace("##likes##", $datos["likes"], $aux);
				$aux = str_replace("##date##", $datos["date"], $aux);
				$cuerpo = $cuerpo . $aux;
			}
			echo $aux2 . $cuerpo . $aux3;
		}
	}

	function vmostrartodascategorias($resultado){
		$cadena = file_get_contents("todas_categorias.html");
		$trozos=explode("##cortar##",$cadena);
		$aux= "";
		$cuerpo="";
		while ($datos = $resultado->fetch_assoc()) {
			$aux = $trozos[1];
			$aux = str_replace("##categoria##",$datos["categoria"],$aux);
			$cuerpo .= $aux;
		}
		echo $trozos[0].$cuerpo.$trozos[2];
	}

	function vmostrarimagenesadmin($resultado,$username){
		$cadena = file_get_contents("mostrar_imagenes_admin.html");
		if(mysqli_num_rows($resultado)==0){
			$cadena = str_replace("##username##",$username,$cadena);
			$trozos = explode("##imagenes##",$cadena);
			echo $trozos[0]."No existen imagenes de este usuario<br><br><br><br>".$trozos[2];
		}else{
			$trozos = explode("##imagenes##",$cadena);
			$aux="";
			$aux2="";
			$aux3="";
			$cuerpo = "";
			while ($datos = $resultado->fetch_assoc()) {
				$aux = $trozos[1];
				$aux2 = $trozos[0];
				$aux3 = $trozos[2];
				$imagen = explode(".",$datos["name_image"]);
				$imagen2 = explode("_",$imagen[0]);
				$aux2 = str_replace("##username##", $datos["id_user"], $aux2);
				$aux3 = str_replace("##username##", $datos["id_user"], $aux3);
				$aux = str_replace("##name_image##", $imagen2 [0], $aux);
				$aux = str_replace("##username##", $datos["id_user"], $aux);
				$aux = str_replace("##imagen##", $datos["name_image"], $aux);
				$aux = str_replace("##description_image##", $datos["desc_image"], $aux);
				$aux = str_replace("##categoria##", $datos["tipo_cat"], $aux);
				$aux = str_replace("##likes##", $datos["likes"], $aux);
				$aux = str_replace("##date##", $datos["date"], $aux);
				$cuerpo = $cuerpo . $aux;
			}
			echo $aux2 . $cuerpo . $aux3;
		}
	}

	function vmostrarimagenesadmincategorias($resultado){
		$cadena = file_get_contents("mostrar_imagenes_admin.html");
		if(mysqli_num_rows($resultado)==0){
			$trozos = explode("##imagenes##",$cadena);
			echo $trozos[0]."No existen imagenes de este usuario<br><br><br><br>".$trozos[2];
		}else{
			$trozos = explode("##imagenes##",$cadena);
			$aux="";
			$aux2="";
			$aux3="";
			$cuerpo = "";
			while ($datos = $resultado->fetch_assoc()) {
				$aux = $trozos[1];
				$aux2 = $trozos[0];
				$aux3 = $trozos[2];
				$imagen = explode(".",$datos["name_image"]);
				$imagen2 = explode("_",$imagen[0]);
				$aux2 = str_replace("##username##", $datos["id_user"], $aux2);
				$aux3 = str_replace("##username##", $datos["id_user"], $aux3);
				$aux = str_replace("##name_image##", $imagen2 [0], $aux);
				$aux = str_replace("##username##", $datos["id_user"], $aux);
				$aux = str_replace("##imagen##", $datos["name_image"], $aux);
				$aux = str_replace("##description_image##", $datos["desc_image"], $aux);
				$aux = str_replace("##categoria##", $datos["tipo_cat"], $aux);
				$aux = str_replace("##likes##", $datos["likes"], $aux);
				$aux = str_replace("##date##", $datos["date"], $aux);
				$cuerpo = $cuerpo . $aux;
			}
			echo $aux2 . $cuerpo . $aux3;
		}
	}
	

	function vmostrarimagenesbusqueda($resultado,$username){
		if ($username != '##username##'){
			if(mysqli_num_rows($resultado)==0){
				vmostrarportadalogeado2($username,mrecogerimagenes());
			}else{
				$cadena = file_get_contents("mostrar_imagenes_busqueda.html");
				$trozos = explode("##imagenes##",$cadena);
				$aux="";
				$aux2="";
				$aux3="";
				$cuerpo = "";
				while ($datos = $resultado->fetch_assoc()) {
					$aux = $trozos[1];
					$aux2 = $trozos[0];
					$aux3 = $trozos[2];
					$imagen = explode(".",$datos["name_image"]);
					$imagen2 = explode("_",$imagen[0]);
					$aux2 = str_replace("##username##", $username, $aux2);
					$aux3 = str_replace("##username##", $username, $aux3);
					$aux = str_replace("##name_image##", $imagen2 [0], $aux);
					$aux = str_replace("##username##",$datos["id_user"], $aux);
					$aux = str_replace("##imagen##", $datos["name_image"], $aux);
					$aux = str_replace("##description_image##", $datos["desc_image"], $aux);
					$aux = str_replace("##categoria##", $datos["tipo_cat"], $aux);
					$aux = str_replace("##likes##", $datos["likes"], $aux);
					$aux = str_replace("##date##", $datos["date"], $aux);
					$cuerpo = $cuerpo . $aux;
				}
				echo $aux2 . $cuerpo . $aux3;
			}
		}else{
			if(mysqli_num_rows($resultado)==0){
				vmostrarportada(mrecogerimagenes());
			}else{
				$cadena = file_get_contents("mostrar_imagenes_busqueda_sinlogin.html");
				$trozos = explode("##imagenes##",$cadena);
				$aux="";
				$aux2="";
				$aux3="";
				$cuerpo = "";
				while ($datos = $resultado->fetch_assoc()) {
					$aux = $trozos[1];
					$aux2 = $trozos[0];
					$aux3 = $trozos[2];
					$imagen = explode(".",$datos["name_image"]);
					$imagen2 = explode("_",$imagen[0]);
					$aux2 = str_replace("##username##", $username, $aux2);
					$aux3 = str_replace("##username##", $username, $aux3);
					$aux = str_replace("##name_image##", $imagen2 [0], $aux);
					$aux = str_replace("##username##",$datos["id_user"], $aux);
					$aux = str_replace("##imagen##", $datos["name_image"], $aux);
					$aux = str_replace("##description_image##", $datos["desc_image"], $aux);
					$aux = str_replace("##categoria##", $datos["tipo_cat"], $aux);
					$aux = str_replace("##likes##", $datos["likes"], $aux);
					$aux = str_replace("##date##", $datos["date"], $aux);
					$cuerpo = $cuerpo . $aux;
				}
				echo $aux2 . $cuerpo . $aux3;
			}
		}
	}

	function vmostrartodosusuarios($resultado){
		$cadena = file_get_contents("todos_usuarios.html");
		$trozos = explode("##cortar##",$cadena);
		$aux="";
		$cuerpo = "";
		while ($datos = $resultado->fetch_assoc()) {
			$aux = $trozos[1];
			$aux = str_replace("##username##", $datos["username"], $aux);
			$aux = str_replace("##name##", $datos["name"], $aux);
			$aux = str_replace("##surname##", $datos["surname"], $aux);
			$aux = str_replace("##surname2##", $datos["surname2"], $aux);
			$aux = str_replace("##email##", $datos["email"], $aux);
			$cuerpo .= $aux;
		}

		echo $trozos[0] . $cuerpo . $trozos[2];
	}

	function vmostrartodasimagenes($resultado){
		$cadena = file_get_contents("todas_imagenes.html");
		if(mysqli_num_rows($resultado)==0){
			$trozos = explode("##cortar##",$cadena);
			echo "<div><br><br><br><br>No hay imagenes<br><br></div>" . $trozos[0] . $trozos[2];
		}else{
			$trozos = explode("##cortar##",$cadena);
			$aux="";
			$aux2="";
			$aux3="";
			$cuerpo = "";
			while ($datos = $resultado->fetch_assoc()) {
				$i=1;
				$aux = $trozos[1];
				$aux2 = $trozos[0];
				$aux3 = $trozos[2];
				$imagen = explode(".",$datos["name_image"]);
				$imagen2 = explode("_",$imagen[0]);
				$aux2 = str_replace("##username##", $datos["id_user"], $aux2);
				$aux3 = str_replace("##username##", $datos["id_user"], $aux3);
				$aux = str_replace("##name_image##", $imagen2[0], $aux);
				$aux = str_replace("##username##", $datos["id_user"], $aux);
				$aux = str_replace("##imagen##", $datos["name_image"], $aux);
				$aux = str_replace("##desc_image##", $datos["desc_image"], $aux);
				$aux = str_replace("##categoria##", $datos["tipo_cat"], $aux);
				$aux = str_replace("##likes##", $datos["likes"], $aux);
				$aux = str_replace("##date##", $datos["date"], $aux);
				$cuerpo = $cuerpo . $aux;
			}
			echo $aux2 . $cuerpo . $aux3;
		}
	}

	function vmostrarresultadoscargarcsv($res){
		switch($res){
			case 1:
				vmostrarpaneladmin();
				break;
			case -1:
				vmostrarmensaje("Error Csv", "Se ha producido un error al instertar ");
				break;
		}

	}
?>
