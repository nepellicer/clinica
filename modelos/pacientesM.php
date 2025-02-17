<?php

require_once "conexionBD.php";

class PacientesM extends conexionBD
{

    //crear paciente

    static public function CrearPacienteM($tablaBD, $datosC)
    {
        $pdo = conexionBD::cBD()->prepare("INSERT INTO $tablaBD(apellido, nombre, documento, usuario, clave, rol) 
        VALUES (:apellido, :nombre, :documento, :usuario, :clave, :rol) ");

        $pdo->bindParam(":apellido", $datosC["apellido"], PDO::PARAM_STR);
        $pdo->bindParam(":nombre", $datosC["nombre"], PDO::PARAM_STR);
        $pdo->bindParam(":documento", $datosC["documento"], PDO::PARAM_STR);
        $pdo->bindParam(":usuario", $datosC["usuario"], PDO::PARAM_STR);
        $pdo->bindParam(":clave", $datosC["clave"], PDO::PARAM_STR);
        $pdo->bindParam(":rol", $datosC["rol"], PDO::PARAM_STR);

        if ($pdo->execute()) {

            return true;
        }
        $pdo = null;
    }

    //Ver Pacientes

    static public function VerPacientesM($tablaBD, $columna, $valor)
    {
        if ($columna == null) {
            $pdo = conexionBD::cBD()->prepare("SELECT * FROM $tablaBD ORDER BY apellido ASC");
            $pdo->execute();
            return $pdo->fetchAll();
        } else {
            // Se usa un marcador de posición fijo en la consulta
            $pdo = conexionBD::cBD()->prepare("SELECT * FROM $tablaBD WHERE $columna = :valor ORDER BY apellido ASC");

            // Se enlaza correctamente el parámetro
            $pdo->bindParam(":valor", $valor, PDO::PARAM_STR);

            $pdo->execute();
            return $pdo->fetch();
        }
    }

    //Borrar Paciente
    static public function BorrarPacienteM($tablaBD, $id)
    {

        $pdo = conexionBD::cBD()->prepare("DELETE FROM $tablaBD WHERE id= :id");
        $pdo->bindParam(":id", $id, PDO::PARAM_INT);
        if ($pdo->execute()) {

            return true;
        }

        $pdo = null;
    }

    //Actualizar paciente Editado

    static public function ActualizarPacienteM($tablaBD, $datosC)
    {

        $pdo = conexionBD::cBD()->prepare("UPDATE $tablaBD SET apellido= :apellido, nombre= :nombre, documento= :documento, usuario= :usuario, clave= :clave WHERE id= :id ");

        $pdo->bindParam(":id", $datosC["id"], PDO::PARAM_INT);
        $pdo->bindParam("apellido", $datosC["apellido"], PDO::PARAM_STR);
        $pdo->bindParam("nombre", $datosC["nombre"], PDO::PARAM_STR);
        $pdo->bindParam("documento", $datosC["documento"], PDO::PARAM_STR);
        $pdo->bindParam("usuario", $datosC["usuario"], PDO::PARAM_STR);
        $pdo->bindParam("clave", $datosC["clave"], PDO::PARAM_STR);
        if ($pdo->execute()) {

            return true;
        }

        $pdo = null;
    }

    //INGRESO DE LOS PACIENTES A SU MODULO

    static public function IngresarPacienteM($tablaBD, $datosC)
    {

        $pdo = conexionBD::cBD()->prepare("SELECT usuario, clave, apellido, nombre, documento, foto, rol, id FROM $tablaBD 
        WHERE usuario= :usuario");

        $pdo->bindParam(":usuario", $datosC["usuario"], PDO::PARAM_STR);

        $pdo->execute();

        return $pdo->fetch();

        $pdo->close();

        $pdo = null;
    }

    //VER PERFIL DE PACIENTE

    static public function VerPerfilPacientesM($tablaBD, $id)
    {

        $pdo = conexionBD::cBD()->prepare("SELECT usuario, clave, apellido, nombre, documento, foto, rol, id FROM $tablaBD 
        WHERE id= :id");

        $pdo->bindParam(":id", $id, PDO::PARAM_INT);

        $pdo->execute();

        return $pdo->fetch();

        $pdo->close();

        $pdo = null;
    }
}
