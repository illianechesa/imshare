<?php
	


		// Atributos generales
		$navItems;
		$funcResult;

		function __construct(){
				$navItems = array(array("login", "log"), array("Sign Up", "alta"));
		}

		// Atributos para BBDD
		 $dbConn;
		 $dbHost = "dbserver";
		 $dbUser = "grupo39";
		 $dbPass = "ona";
		 $db = "db_grupo39";

	     function conexion() {
			$dbConn = mysqli_connect("dbserver", "grupo39", "ona","db_grupo39");
		    return $dbConn;
		}

		function mregistrarusuario($user, $pass) {
			$_SESSION["user"] = $user;
			$_SESSION["password"] = $pass;
		}

		/**************************************
		Registramos un usuario en la base de datos
		1 - Alta correcta -----------> Devuelvo  1
		2 - Error BBDD --------------> Devuelvo -1
		3 - Usuario registrado ------> Devuelvo -2
		4 - Campo usuario vacio -----> Devuelvo -3
		5 - Campo wmail vacio -------> Devuelvo -4
		6 - Campo password vacio ----> Devuelvo -5
		7 - Contraseñas diferentes --> Devuelvo -6
		(Nota: guardamos la contraseña encriptada md5)
		******************************************/
		function mvalidaraltapersona() {

		    $dbConn = conexion();

		    $username = $_POST["username"];
		    $email = $_POST["email"];
		    $password = $_POST["password"];
		    $password2 = $_POST["password2"];
		    
		    $name = $_POST["nombre"];
		    $surname = $_POST["apellido1"];
		    $surname2 = $_POST["apellido2"];


		    $consulta = "select * from final_usuario where username = '$username'";
		    if ($resultado = $dbConn->query($consulta))  {
		        if ($datos = $resultado->fetch_assoc()) {
		            return -2;
		        }
		    } else {
		        if (strlen($resultado) != 0){
		            //Error en la consulta
		            return -1;
		        }			
		    }

		    if (strlen($username) == 0) {
		        return -3;
		    }

		    if (strlen($email) == 0) {
		        return -4;
		    }

		    if ((strlen($password) ==0) || (strlen($password2) == 0)) {
		        return -5;
		    }
		    
		    if ($password != $password2) {
		        return -6;
		    }

		    //Añadimos el usuario
		    $consulta = "INSERT INTO final_usuario (username, password, name , surname, surname2, email) VALUES ('$username','" . md5($password) ."', '$name', '$surname', '$surname2', '$email')";

		    if ($dbConn->query($consulta) === TRUE) {
				mregistrarusuario($username, $password);
		        return 1;
		    } else {
		        return -1;
		    }
		}

		/**************************************
		Registramos un usuario en la base de datos
		1 - Login correcto --------------------> Devuelvo  1
		2 - Error BBDD ------------------------> Devuelvo -1
		3 - Usuario o contrasena incorrectos --> Devuelvo -2
		******************************************/
		function mvalidarloginpersona() {

		    $dbConn = conexion();

			if (isset($_GET["username"])) {
				$username = $_GET["username"];
			} else {
				if (isset($_POST["username"])) {
					$username = $_POST["username"];
				}
			}

			if($username == "admin"){
				$password = "admin";
			}else{
				$password = $_POST["password"];
			}

		    $consulta = "select * from final_usuario where username = '$username'";
		    if ($resultado = $dbConn->query($consulta))  {
		        if ($datos = $resultado->fetch_assoc()) {
		            if ($datos["password"] == md5($password)) {
						mregistrarusuario($username, $password);
						return 1;
					} else {
						return -2;
					}
		        } else {
					return -2;
				}
		    } else {
		        if (strlen($resultado) != 0){
		            //Error en la consulta
		            return -1;
		        }
		    }
		}

		function mcogerusuario() {
			$dbConn = conexion();
			$username = $_GET["username"];
			$consulta = "select * from final_usuario where username = '$username'";
			return $dbConn->query($consulta);
		  }
  

		function mcerrarsesion(){
			session_destroy();
		}

		function mvalidarmodificarpersona($username){
			$dbConn = conexion();

		    //$username = $_POST["username"];
		    $email = $_POST["email"];
		    $password = $_POST["password"];
		    $password2 = $_POST["password2"];
		    
		    $name = $_POST["nombre"];
		    $surname = $_POST["apellido1"];
		    $surname2 = $_POST["apellido2"];


		    $consulta = "select * from final_usuario where username = '$username'";
		    if ($resultado = $dbConn->query($consulta))  {
		        if ($datos = $resultado->fetch_assoc()) {
		            if (strlen($username) == 0) {
						return -3;
					}
					if (strlen($email) == 0) {
						return -3;
					}
					if ((strlen($password) ==0) || (strlen($password2) == 0)) {
						return -3;
					}
					if ($username != $datos["username"]) {
						return -2;
					}
		
					//if ($email != $datos["email"]) {
					//	return -2;
				    //}
		
					//if (md5($password) != $datos["password"]) {
					//	return -2;
					//}
		
					if ($password != $password2) {
						return -2;
					}
		        }
		    } else {
		        if (strlen($resultado) != 0){
		            //Error en la consulta
		            return -1;
		        }			
		    }


		    //Añadimos el usuario
		    $consulta = "Update final_usuario SET username='$username',password='" . md5($password) ."',name='$name',surname='$surname',surname2='$surname2',email='$email' WHERE username='$username'";

		    if ($dbConn->query($consulta) === TRUE) {
				mregistrarusuario($username, $password);
		        return 1;
		    } else {
		        return -1;
		    }
		}

		function meliminarpersona(){
			$dbConn = conexion();


			$username = $_POST["username"];
			$password = $_POST["password"];
			$password2 = $_POST["password2"];
  
			$consulta = "select * from final_usuario where username = '$username'";
			if ($resultado = $dbConn->query($consulta)) {
			  if ($datos = $resultado->fetch_assoc()) {
				if ((strlen($password) ==0) || (strlen($password2) == 0)) {
				  return -3;
				}
  
				if ((md5($password) != $datos["password"]) || ($password != $password2)) {
				  return -2;
				}
  
			  }
			} else {
			  if (strlen($resultado) != 0){
					  //Error en la consulta			
				return -1;
			  }			
			}
  
			  //Modificamos el usuario
			$consulta = "DELETE FROM final_usuario WHERE username = '$username'";
  
			if ($dbConn->query($consulta) === TRUE) {
			  return 1;
			} else {
			  return -1;
			}
		}
  
		function msubiracarpeta(){
			$filename = $_POST["name_image"];
			$target_dir = "temp_folder/";
			$target_file = $target_dir . $filename;//basename($_FILES["file"]["name"]);
			//$filename = basename($_FILES["file"]["name"];
            $formato = explode(".",basename($_FILES["file"]["name"]));
            
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file."_".uniqid().".".$formato[1])) {
			$status = 1;
            }
		}

		function msubirimagen($username){
			$dbConn = conexion();
			$desc_image= $_POST["desc_image"];
			$categoria = $_POST["categoria"];
			$files = glob('temp_folder/{*.jpg,*.jpeg,*.png}',GLOB_BRACE);
   			foreach($files as $file) {
				$name_image = basename($file);
				$sql = "INSERT INTO final_imagen (name_image,id_user,desc_image,likes,tipo_cat) VALUES ('$name_image','$username','$desc_image','0','$categoria')";
				if(mysqli_query($dbConn,$sql)){
					rename ("temp_folder/".$name_image."","archivos_subidos/".$name_image."");
				}
			}
			$consulta = "select * from final_usuario where username = '$username'";
			return $dbConn->query($consulta);
		}

		function mmostrarimagenes($username){
			$dbConn = conexion();
			$consulta = "select * from final_imagen where id_user = '$username' order by date desc";
			return $dbConn->query($consulta);
		}

		function mrecogerusuarios(){
			$dbConn = conexion();
			$consulta = "select * from final_usuario where username not in ('admin')";
			return $dbConn->query($consulta);
		}

		function mrecogerimagenes(){
			$dbConn = conexion();
			$consulta = "select * from final_imagen where id_user not in ('admin') order by date desc";
			return $dbConn->query($consulta);
		}

		function mrecogerimagenescategoria(){
			$categoria = $_GET["categoria"];
			$dbConn = conexion();
			$consulta = "select * from final_imagen where tipo_cat = '$categoria' order by tipo_cat";
			return $dbConn->query($consulta);
		}

		function mrecogercategorias(){
			$con = conexion();
			$sql= "select * from final_categoria order by categoria";
			return $con->query($sql);
		}


		function mbuscadorimagenes(){
			$link = conexion();
 
			// Check connection
			if($link === false){
				die("ERROR: Could not connect. " . mysqli_connect_error());
			}
			
			if(isset($_REQUEST["term"])){
				// Prepare a select statement
				$sql = "SELECT * FROM final_imagen WHERE name LIKE ?";
				
				if($stmt = mysqli_prepare($link, $sql)){
					// Bind variables to the prepared statement as parameters
					mysqli_stmt_bind_param($stmt, "s", $param_term);
					
					// Set parameters
					$param_term = $_REQUEST["term"] . '%';
					
					// Attempt to execute the prepared statement
					if(mysqli_stmt_execute($stmt)){
						$result = mysqli_stmt_get_result($stmt);
						
						// Check number of rows in the result set
						if(mysqli_num_rows($result) > 0){
							// Fetch result rows as an associative array
							while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
								echo "<p>" . $row["name"] . "</p>";
							}
						} else{
							echo "<p>No matches found</p>";
						}
					} else{
						echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
					}
									
				// Close statement
				mysqli_stmt_close($stmt);
				}
			}
			// close connection
			mysqli_close($link);
		}

		function mvisualizarimagen($desc_image){
			$dbConn = conexion();
			$consulta = "select * from final_imagen where desc_image = '$desc_image'";
			return $dbConn->query($consulta);
		}

		function mlistadocategorias(){
			$dbConn = conexion();
			$consulta = "select * from final_categoria";
			return $dbConn->query($consulta);
		}

		function meliminarimagen($name_image,$username){
			$dbConn = conexion();
			$consulta = "delete from final_imagen where name_image = '$name_image' ";
			if ($dbConn->query($consulta) === TRUE) {
				$file = "archivos_subidos/".$name_image ."";
				unlink($file);
				$consulta = "select * from final_imagen where id_user = '$username' order by date";
				return $dbConn->query($consulta);
			}else{
				$consulta = "select * from final_imagen where id_user = '$username' order by date";
				return $dbConn->query($consulta);
			}
	  
		}

		function meliminarusuario($username){
			$dbConn = conexion();
			$consulta = "delete from final_usuario where username = '$username' ";
			$dbConn->query($consulta);
			$consulta = "select * from final_usuario where username not in ('admin')";
			return $dbConn->query($consulta);
		}

		function meliminarcategoria(){
			$dbConn = conexion();
			$categoria = $_POST["categoria"];
			$consulta = "UPDATE final_imagen SET tipo_cat='Otros' WHERE tipo_cat='$categoria'";
			$dbConn->query($consulta);
			$consulta = "delete from final_categoria where categoria = '$categoria' ";
			$dbConn->query($consulta);
			$sql= "select * from final_categoria order by categoria";
			return $dbConn->query($sql);
		}

		function manadircategoria(){
			$dbConn = conexion();
			$categoria = $_POST["categoria"];
			$consulta = "insert into final_categoria (categoria) values ('$categoria')";
			$dbConn->query($consulta);
			$sql= "select * from final_categoria order by categoria";
			return $dbConn->query($sql);
		}
	
		function mcargarcsv(){
			// conexión
			$mysqli = conexion();

			if (isset($_POST['enviar'])){
				
				$filename=$_FILES["file"]["name"];
				$info = new SplFileInfo($filename);
				$extension = pathinfo($info->getFilename(), PATHINFO_EXTENSION);

				if($extension == 'csv'){
					$filename = $_FILES['file']['tmp_name'];
					$handle = fopen($filename, "r");

					while( ($data = fgetcsv($handle, 1000, ";") ) !== FALSE ){
						if(strlen($data[0]) != 0 && strlen($data[1]) != 0 && strlen($data[2]) != 0 && strlen($data[3]) != 0 && strlen($data[4]) != 0 && strlen($data[5]) != 0){
							$q = "INSERT INTO final_usuario (username, password, name, surname, surname2, email ) VALUES (
								'$data[0]', 
								' " . md5($data[1]) ." ',
								'$data[2]',
								'$data[3]',
								'$data[4]',
								'$data[5]'
							)";

							$mysqli->query($q);
						}
					}
					fclose($handle);	
					return 1;
				}
				return -1;
			}
			return -1;

		}

		function mgenerarjson(){
			//Creamos la conexión
			$conexion = conexion()
			or die("Ha sucedido un error inexperado en la conexion de la base de datos");

			//generamos la consulta
			$sql = "SELECT * FROM final_usuario";
			mysqli_set_charset($conexion, "utf8"); //formato de datos utf8

			if(!$result = mysqli_query($conexion, $sql)) die();

			$usuarios = array(); //creamos un array

			while($row = mysqli_fetch_array($result)) 
			{ 
				$username=$row['username'];
				$name=$row['name'];
				$surname=$row['surname'];
				$surname2=$row['surname2'];
				$email=$row['email'];
				

				$clientes[] = array('username'=> $username, 'name'=> $name, 'surname'=> $surname, 'surname2'=> $surname2,
									'email'=> $email);

			}
				
			//desconectamos la base de datos
			$close = mysqli_close($conexion) 
			or die("Ha sucedido un error inexperado en la desconexion de la base de datos");
			

			//Creamos el JSON
			$json_string = json_encode($clientes);

			//Si queremos crear un archivo json, sería de esta forma:
			
			$file = 'usuarios.json';
			file_put_contents("./json/".$file, $json_string);
			//echo "<body style='color:white;background:black'>";
			echo $json_string;
			echo "<br><br><br><a href='index.php?accion=generarjson&id=2&file=json/usuarios.json'>Download JSON file</a>";
			echo "<br><br><a href='index.php?accion=log&id=2&username=admin&file=json/usuarios.json'>Volver al Panel</a>";
			//echo "</body>";
		}

		function mdescargarjson(){
			// Name of the directory where all the sub directories and files exists
			$file = "./json/usuarios.json";
			// Quick check to verify that the file exists
			if( !file_exists($file) ) die("File not found");
				// Force the download
				header("Content-Disposition: attachment; filename=" . basename($file) . "");
				header("Content-Length: " . filesize($file));
				header("Content-Type: application/octet-stream;");
				readfile($file);
		}
		
		

	
    
?>
