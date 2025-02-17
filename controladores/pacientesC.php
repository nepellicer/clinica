<?php

class PacientesC
{
    // Crear Paciente
    public function CrearPacienteC()
    {
        if (isset($_POST["rolP"])) {
            $tablaBD = "pacientes";
            $datosC = array(
                "apellido" => $_POST["apellido"],
                "nombre" => $_POST["nombre"],
                "documento" => $_POST["documento"],
                "usuario" => $_POST["usuario"],
                "clave" => $_POST["clave"],
                "rol" => $_POST["rolP"]
            );

            $resultado = PacientesM::CrearPacienteM($tablaBD, $datosC);

            if ($resultado == true) {
                echo '<script>
                    
                    window.location = "pacientes";
                    
                    </script>  ';
            }
        }
    }


    //Ver Pacientes

    static public function VerPacientesC($columna, $valor)
    {

        $tablaBD = "pacientes";
        $resultado = PacientesM::VerPacientesM($tablaBD, $columna, $valor);

        return $resultado;
    }


    //Borrar Paciente

    public function BorrarPacienteC()
    {
        if (isset($_GET["Pid"])) {

            $tablaBD = "pacientes";
            $id = $_GET["Pid"];

            if ($_GET["imgP"] != "") {

                unlink($_GET["imgP"]);
            }

            $resultado = PacientesM::BorrarPacienteM($tablaBD, $id);

            if ($resultado == true) {
                echo '<script>
                    
                    window.location = "pacientes";
                    
                    </script>  ';
            }
        }
    }

    //Actualizar Paciente Editado

    public function ActualizarPacienteC()
    {
        if (isset($_POST["Pid"])) {
            $tablaBD = "pacientes";

            $datosC = array(
                "id" => $_POST["Pid"],
                "apellido" => $_POST["apellidoE"],
                "nombre" => $_POST["nombreE"],
                "documento" => $_POST["documentoE"],
                "usuario" => $_POST["usuarioE"],
                "clave" => $_POST["claveE"],
            );
            $resultado = PacientesM::ActualizarPacienteM($tablaBD, $datosC);
            if ($resultado == true) {
                echo '<script>
                    
                    window.location = "pacientes";
                    
                    </script>  ';
            }
        }
    }

    //INGRESO DE LOS PACIENTES 
    public function IngresarPacienteC()
    {

        if (isset($_POST["usuario-Ing"])) {

            if (preg_match('/^[a-zA-Z0-9]+$/', $_POST["usuario-Ing"]) && preg_match('/^[a-zA-Z0-9]+$/', $_POST["clave-Ing"]));

            $tablaBD = "pacientes";
            $datosC = array("usuario" => $_POST["usuario-Ing"], "clave" => $_POST["clave-Ing"]);

            $resultado = PacientesM::IngresarPacienteM($tablaBD, $datosC);

            if ($resultado["usuario"] == $_POST["usuario-Ing"] && $resultado["clave"] == $_POST["clave-Ing"]) {

                $_SESSION["ingresar"] = true;

                $_SESSION["id"] = $resultado["id"];
                $_SESSION["usuario"] = $resultado["usuario"];
                $_SESSION["clave"] = $resultado["clave"];
                $_SESSION["apellido"] = $resultado["apellido"];
                $_SESSION["nombre"] = $resultado["nombre"];
                $_SESSION["docuemnto"] = $resultado["documento"];
                $_SESSION["foto"] = $resultado["foto"];
                $_SESSION["rol"] = $resultado["rol"];

                echo '<script>
                
                window.location="inicio";
                </script>';
            }
        }
    }

    //Ver perfil del paciente

    public function VerPerfilPacienteC()
    {

        $tablaBD = "pacientes";
        $id = $_SESSION["id"];

        $resultado = PacientesM::VerPerfilPacientesM($tablaBD, $id);

        echo '<tr>
                    <td>' . $resultado["usuario"] . '</td>
                    <td>' . $resultado["clave"] . '</td>
                    <td>' . $resultado["nombre"] . '</td>
                    <td>' . $resultado["apellido"] . '</td>';

        if ($resultado["foto"] == "") {

            echo '<td> <img src="vistas/img/defecto.png" width="40px"></img></td>';
        } else {
            echo '<td> <img src="vistas/img/' . $resultado["foto"] . '" width="40px"></img></td>';
        }

        echo '<td>' . $resultado["documento"] . ' </td>
                    <td>
                        <a href="#">
                            <button class="btn btn-success"><i class="fa fa-pencil"></i></button>
                        </a>
                    </td>
                </tr>';
    }
}
