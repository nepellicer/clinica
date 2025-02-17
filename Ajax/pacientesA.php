<?php
require_once "../controladores/pacientesC.php";
require_once "../modelos/pacientesM.php";

class PacientesA
{

    public $Pid;

    public function EPacienteA()
    {
        $columna = "id";
        $valor = $this->Pid;
        $resultado = PacientesC::VerPacientesC($columna, $valor);

        echo json_encode($resultado);
    }

    public $Norepetir;

    public function NorepetirUsuarioA()
    {

        $columna = "usuario";
        $valor = $this->Norepetir;

        $resultado = PacientesC::VerPacientesC($columna, $valor);

        echo json_encode($resultado);
    }
}

if (isset($_POST["Pid"])) {
    $editarP = new PacientesA();
    $editarP->Pid = $_POST["Pid"];
    $editarP->EPacienteA();
}

if (isset($_POST["Norepetir"])) {
    $noRepetirU = new PacientesA();
    $noRepetirU->Norepetir = $_POST["Norepetir"];
    $noRepetirU->NorepetirUsuarioA();
}
