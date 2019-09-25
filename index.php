<?php
	
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	include "model.php";
	include "view.php";

	if (isset($_GET["accion"])) {
		$accion = $_GET["accion"];
		$id = $_GET["id"];
	} else {
		if (isset($_POST["accion"])) {
			$accion = $_POST["accion"];
			$id = $_POST["id"];
		} else {
			$accion = "portada";
			$id = 1;
		}
	}

	if ($accion == "portada") {
		switch ($id) {
			case 1 : 
				vmostrarportada(mrecogerimagenes());
				break;
			case 2:
				if (isset($_GET["username"])) {
					$username = $_GET["username"];
				} else {
					if (isset($_POST["username"])) {
						$username = $_POST["username"];
					}
				}
				vmostrarportadalogeado2($username,mrecogerimagenes());
		}
	}

	if($accion == "log"){
		switch($id){
			case 1:
				vmostrarloginpersona();
				break;
			case 2:
				vmostrarresultadologinpersona(mvalidarloginpersona());
				break;
		}
	}

	if($accion == "alta"){
		switch($id){
			case 1:
				vmostraraltapersona();
				break;
			case 2:
				vmostrarresultadoaltapersona(mvalidaraltapersona());
		}
	}

	if($accion == "perfil"){
		switch($id){
			case 1:
				vmostrarresultadomiperfil(mcogerusuario());
				break;
		}
	}

	if($accion == "salir"){
		switch($id){
			case 1:
				session_start();
				vmostrarexit(mcerrarsesion());
				break;
		}
	}

	if($accion == "modificarperfil"){
		switch($id){
				case 1:
				if (isset($_GET["username"])) {
					$username = $_GET["username"];
				} else {
					if (isset($_POST["username"])) {
						$username = $_POST["username"];
					}
				}
				vmostrarmodificarpersona($username);
				break;
			case 2:
				if (isset($_GET["username"])) {
					$username = $_GET["username"];
				} else {
					if (isset($_POST["username"])) {
						$username = $_POST["username"];
					}
				}
				vmostrarresultadomodificarpersona(mvalidarmodificarpersona($username));
				break;
		}
	}

	if($accion == "eliminarperfil"){
		switch($id){
			case 1:
				if (isset($_GET["username"])) {
					$username = $_GET["username"];
				} else {
					if (isset($_POST["username"])) {
						$username = $_POST["username"];
					}
				}
				vmostrareliminarpersona($username);
				break;
			case 2:
				vmostrarresultadoeliminarpersona(meliminarpersona());
				break;
		}
	}

	if($accion == "subirimagen"){
		switch($id){
			case 1:
				vmostrarsubirimagen(mcogerusuario(),mlistadocategorias());
				break;
			case 2:
				msubiracarpeta();
				break;
			case 3:
				if (isset($_GET["username"])) {
					$username = $_GET["username"];
				} else {
					if (isset($_POST["username"])) {
						$username = $_POST["username"];
					}
				}
				vmostrarresultadosubirimagen(msubirimagen($username));
				break;
		}
	}

	if($accion == "mostrarimagenes"){
		switch($id){
			case 1:
				if (isset($_GET["username"])) {
					$username = $_GET["username"];
				} else {
					if (isset($_POST["username"])) {
						$username = $_POST["username"];
					}
				}
				vmostrarimagenes(mmostrarimagenes($username),$username);
				break;
			case 2:
				if (isset($_GET["username"])) {
					$username = $_GET["username"];
				} else {
					if (isset($_POST["username"])) {
						$username = $_POST["username"];
					}
				}
				vmostrarimagenesadmin(mmostrarimagenes($username),$username);
				break;
			case 3:
				vmostrarimagenesadmincategorias(mrecogerimagenescategoria());
				break;
		}

	}

	if($accion == "buscarimagenes"){
		switch($id){
			case 1:
				mbuscadorimagenes();
		}
	}

	if($accion == "visualizarimagen"){
		switch ($id){
			case 1:
				if (isset($_GET["username"])) {
					$username = $_GET["username"];
				} else {
					if (isset($_POST["username"])) {
						$username = $_POST["username"];
					}
				}
				if (isset($_GET["desc_image"])) {
					$desc_image = $_GET["desc_image"];
				} else {
					if (isset($_POST["desc_image"])) {
						$desc_image = $_POST["desc_image"];
					}
				}
				vmostrarimagenesbusqueda(mvisualizarimagen($desc_image,$username),$username);
				break;
			case 2:
				if (isset($_GET["username"])) {
					$username = $_GET["username"];
				} else {
					if (isset($_POST["username"])) {
						$username = $_POST["username"];
					}
				}
				if (isset($_GET["desc_image"])) {
					$desc_image = $_GET["desc_image"];
				} else {
					if (isset($_POST["desc_image"])) {
						$desc_image = $_POST["desc_image"];
					}
				}
				vmostrarimagenesbusqueda(mvisualizarimagen($desc_image,$username),$username);
				break;
		}
	}

	if($accion == "mostrartodosdatos"){
		switch($id){
			case 1:
				vmostrartodosusuarios(mrecogerusuarios());
				break;
			case 2;
				vmostrartodasimagenes(mrecogerimagenes());
				break;
		}
	}

	if($accion == "cargarcsv"){
		switch($id){
			case 1:
				vmostrarresultadoscargarcsv(mcargarcsv());
				break;
		}
	}

	if($accion == "generarjson"){
		switch($id){
			case 1:
				mgenerarjson();
				break;
			case 2:
				mdescargarjson();
		}
	}

	if($accion == "eliminarimagen"){
		switch($id){
			case 1:
				if (isset($_GET["username"])) {
					$username = $_GET["username"];
				} else {
					if (isset($_POST["username"])) {
						$username = $_POST["username"];
					}
				}
				if (isset($_GET["name_image"])) {
					$name_image = $_GET["name_image"];
				} else {
					if (isset($_POST["name_image"])) {
						$name_image = $_POST["name_image"];
					}
				}
				if (isset($_GET["user"])) {
					$user = $_GET["user"];
				} else {
					if (isset($_POST["user"])) {
						$user = $_POST["user"];
					}else{
						$user = "normal";
					}
				}
				if($user == "admin")
					vmostrarimagenesadmin(meliminarimagen($name_image,$username),$username);
				elseif ($user == "normal")
					vmostrarimagenes(meliminarimagen($name_image,$username),$username);
		}
	}

	if($accion == "eliminarusuario"){
		switch($id){
			case 1:
				if (isset($_GET["username"])) {
					$username = $_GET["username"];
				} else {
					if (isset($_POST["username"])) {
						$username = $_POST["username"];
					}
				}
				vmostrartodosusuarios(meliminarusuario($username));
				break;
		}
	}

	if($accion == "mostrartodascategorias"){
		switch($id){
			case 1:
				vmostrartodascategorias(mrecogercategorias());
		}
	}

	if($accion == "eliminarcategoria"){
		switch($id){
			case 1:
				vmostrartodascategorias(meliminarcategoria());
		}
	}

	if($accion == "anadircategoria"){
		switch($id){
			case 1:
				vmostrartodascategorias(manadircategoria());
		}
	}
?>
