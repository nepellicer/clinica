<?php
// Ingreso secretaria
class SecretariasC {
    public function IngresarSecretariaC() {
        if (isset($_POST["usuario-Ing"])) {
            // Validamos las entradas
            if (preg_match('/^[a-zA-Z0-9]+$/', $_POST["usuario-Ing"]) && preg_match('/^[a-zA-Z0-9]+$/', $_POST["clave-Ing"])) {
                $tablaBD = "secretarias";
                $datosC = array("usuario" => $_POST["usuario-Ing"], "clave" => $_POST["clave-Ing"]);
                
                // Llamada al modelo
                $resultado = SecretariasM::IngresarSecretariaM($tablaBD, $datosC);
                
                // Verificamos si el usuario y clave coinciden
                if ($resultado["usuario"] == $_POST["usuario-Ing"] && $resultado["clave"] == $_POST["clave-Ing"]) {
                    // Iniciar sesión
                    $_SESSION["ingresar"] = true;
                    $_SESSION["id"] = $resultado["id"];
                    $_SESSION["usuario"] = $resultado["usuario"];
                    $_SESSION["clave"] = $resultado["clave"];
                    $_SESSION["nombre"] = $resultado["nombre"];
                    $_SESSION["apellido"] = $resultado["apellido"];
                    $_SESSION["foto"] = $resultado["foto"];
                    $_SESSION["rol"] = $resultado["rol"];

                    echo '<script> 
                        window.location = "inicio";
                    </script>';
                } else {
                    // Mensaje de error si las credenciales no coinciden
                    echo '<div class="alert alert-danger">Usuario o contraseña incorrectos.</div>';
                }
            } else {
                // Mensaje si la validación no se cumple
                echo '<div class="alert alert-warning">Solo se permiten letras y números en los campos.</div>';
            }
        }
    }

    // Ver perfil secretaria
    public function VerPerfilSecretariaC() {
        $tablaBD = "secretarias";
        $id = $_SESSION["id"];
        $resultado = SecretariasM::VerPerfilSecretariaM($tablaBD, $id);

        echo '<tr>
            <td>' . $resultado["usuario"] . '</td>
            <td>' . $resultado["clave"] . '</td>
            <td>' . $resultado["nombre"] . '</td>
            <td>' . $resultado["apellido"] . '</td>';

        if ($resultado["foto"] != "") {
            echo '<td><img src="http://localhost/clinica/' . $resultado["foto"] . '" class="img-responsive" width="40px"></td>';
        } else {
            echo '<td><img src="http://localhost/clinica/vistas/img/defecto.png" class="img-responsive" width="40px"></td>';
        }

        echo '<td>
            <a href="http://localhost/clinica/perfil-S/' . $resultado["id"] . '">
                <button class="btn btn-success"><i class="fa fa-pencil"></i></button>
            </a>
        </td>
        </tr>';
    }

    // Editar perfil
    public function EditarPerfilSecretariaC() {
        $tablaBD = "secretarias";
        $id = $_SESSION["id"];
        $resultado = SecretariasM::VerPerfilSecretariaM($tablaBD, $id);

        echo '<form method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6 col-xs-12">
                    <h2>Nombre:</h2>
                    <input type="text" class="input-lg" name="nombreP" value="' . $resultado["nombre"] . '">
                    <input type="hidden" class="input-lg" name="idP" value="' . $resultado["id"] . '">

                    <h2>Apellido:</h2>
                    <input type="text" class="input-lg" name="apellidoP" value="' . $resultado["apellido"] . '">

                    <h2>Usuario:</h2>
                    <input type="text" class="input-lg" name="usuarioP" value="' . $resultado["usuario"] . '">

                    <h2>Contraseña:</h2>
                    <input type="text" class="input-lg" name="claveP" value="' . $resultado["clave"] . '">
                </div>

                <div class="col-md-6 col-xs-12"> 
                    <br><br>
                   <input type="file" name="imgP">
                    <br>';
                    
        if ($resultado["foto"] == "") {
            echo '<img src="http://localhost/clinica/vistas/img/defecto.png" width="200px">';
        } else {
            echo '<img src="http://localhost/clinica/' . $resultado["foto"] . '" width="200px">';
        }

        echo '<input type="hidden" name="imgActual" value="'.$resultado["foto"].'">
                    <br><br>
                    <button type="submit" class="btn btn-success">Guardar Cambios</button>
                </div>
            </div>
        </form>';
    }

    // Actualiazar perfil Secretaria
    public function ActualizarPerfilSecretariaC(){

		if(isset($_POST["idP"])){

			$rutaImg = $_POST["imgActual"];

            
		    if(isset($_FILES["imgP"]["tmp_name"]) && !empty($_FILES["imgP"]["tmp_name"])){

                echo "<p>Archivo detectado para la actualización: " . $_FILES["imgP"]["name"] . "</p>";

			   if(!empty($_POST["imgActual"])){ 

					unlink($_POST["imgActual"]);
				
			}
			 // Generamos un nuevo nombre para la imagen
			$nombre = mt_rand(10, 99);
			
			// Verificamos el tipo de archivo
				if($_FILES["imgP"]["type"] == "image/jpeg"){
					
					$rutaImg = "vistas/img/Secretarias/S-" . $nombre . ".jpg";

            } elseif ($_FILES["imgP"]["type"] == "image/png") {

                $rutaImg = "vistas/img/Secretarias/S-" . $nombre . ".png";

            } else {

                echo '<div class="alert alert-warning">Solo se permiten imágenes JPG o PNG.</div>';
				
                return;
            }

			// Movemos el archivo subido a la carpeta correspondiente
			if (!move_uploaded_file($_FILES["imgP"]["tmp_name"], $rutaImg)) {

                echo '<div class="alert alert-danger">Error al mover la imagen al servidor.</div>';

                return;

				}

			}

           // Datos a actualizar en la base de datos

			$tablaBD = "secretarias";

			$datosC = array(
				"id"=>$_POST["idP"], 
				"usuario"=>$_POST["usuarioP"], 
				"apellido"=>$_POST["apellidoP"], 
            	"nombre"=>$_POST["nombreP"], 
				"clave"=>$_POST["claveP"], 
				"foto"=>$rutaImg);

 			// Llamamos al modelo para actualizar los datos
			$resultado = SecretariasM::ActualizarPerfilSecretariaM($tablaBD, $datosC);

			
			// Si la actualización es exitosa
			if($resultado == true){

				echo '<script>

				window.location = "http://localhost/clinica/perfil-S/'.$_SESSION["id"].'";
				</script>';

			}

		}

	} 


	

}
?>

        

