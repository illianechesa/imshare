<?php 
	require_once("dompdf/dompdf_config.inc.php");
	$conexion = mysqli_connect("dbserver", "grupo39", "ona","db_grupo39");

$codigoHTML='
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Lista</title>
</head>

<body>
<div>
	<img src="img/imshare_black.png" width="150px" height="100px">
    <table width="95%" border="1">
      <tr>
        <td bgcolor="#0099FF"><strong>Username</strong></td>
        <td bgcolor="#0099FF"><strong>Name</strong></td>
        <td bgcolor="#0099FF"><strong>Surname</strong></td>
        <td bgcolor="#0099FF"><strong>Second Surname</strong></td>
        <td bgcolor="#0099FF"><strong>Email</strong></td>
      </tr>';

        $consulta="SELECT * FROM final_usuario";
        if ($resultado = $conexion->query($consulta))  {
            while($dato=$resultado->fetch_assoc()){
                $codigoHTML.='
                      <tr>
                        <td>'.$dato['username'].'</td>
                        <td>'.$dato['name'].'</td>
                        <td>'.$dato['surname'].'</td>
                        <td>'.$dato['surname2'].'</td>
                        <td>'.$dato['email'].'</td>
                      </tr>';
              } 
           
          }

        $codigoHTML.='
            </table>
          <img src="img/imshare_black.png" width="150px" height="100px">
        </div>
        </body>
        </html>';

$codigoHTML=utf8_decode($codigoHTML);
$dompdf=new DOMPDF();
$dompdf->load_html($codigoHTML);
ini_set("memory_limit","128M");
$dompdf->render();
$dompdf->stream("ListadoUsuarios.pdf");
?>
