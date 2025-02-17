<?php
require_once "conexionBD.php";

class DoctoresM extends conexionBD
{

    //Crear Doctores

    static public function CrearDoctorM($tablaBD, $datosC)
    {
        $pdo = conexionBD::cBD()->prepare("INSERT INTO $tablaBD(apellido, nombre, sexo, id_consultorio, usuario, clave, rol) 
        VALUES(:apellido, :nombre, :sexo, :id_consultorio, :usuario, :clave, :rol)");

        $pdo->bindParam(":apellido", $datosC["apellido"], PDO::PARAM_STR);
        $pdo->bindParam(":nombre", $datosC["nombre"], PDO::PARAM_STR);
        $pdo->bindParam(":sexo", $datosC["sexo"], PDO::PARAM_STR);
        $pdo->bindParam(":id_consultorio", $datosC["id_consultorio"], PDO::PARAM_INT);
        $pdo->bindParam(":usuario", $datosC["usuario"], PDO::PARAM_STR);
        $pdo->bindParam(":clave", $datosC["clave"], PDO::PARAM_STR);
        $pdo->bindParam(":rol", $datosC["rol"], PDO::PARAM_STR);

        if ($pdo->execute()) {
            return true;
        }


        $pdo = null;
    }

    //Mostrar Doctores
    static public function VerDoctoresM($tablaBD, $columna, $valor)
    {

        if ($columna != null) {
            $pdo = conexionBD::cBD()->prepare("SELECT * FROM $tablaBD WHERE $columna = :$columna");
            $pdo->bindParam(":" . $columna, $valor, PDO::PARAM_STR);
            $pdo->execute();
            return $pdo->fetchALL();
        } else {
            $pdo = conexionBD::cBD()->prepare("SELECT * FROM $tablaBD");

            $pdo->execute();
            return $pdo->fetchAll();
        }
        $pdo->close();
        $pdo = null;
    }

    //Editar Doctor
    static public function DoctorM($tablaBD, $columna, $valor)
    {

        if ($columna != null) {
            $pdo = conexionBD::cBD()->prepare("SELECT * FROM $tablaBD WHERE $columna = :$columna");
            $pdo->bindParam(":" . $columna, $valor, PDO::PARAM_STR);
            $pdo->execute();
            return $pdo->fetch();
        }

        $pdo = null;
    }

    //Actualizar Doctores

    static public function ActualizarDoctorM($tablaBD, $datosC)
    {
        $pdo = conexionBD::cBD()->prepare("UPDATE $tablaBD SET apellido= :apellido, nombre= :nombre, sexo= :sexo, usuario=:usuario,
        clave= :clave WHERE id= :id ");

        $pdo->bindParam(":id", $datosC["id"], PDO::PARAM_INT);
        $pdo->bindParam(":apellido", $datosC["apellido"], PDO::PARAM_STR);
        $pdo->bindParam(":nombre", $datosC["nombre"], PDO::PARAM_STR);
        $pdo->bindParam(":sexo", $datosC["sexo"], PDO::PARAM_STR);
        $pdo->bindParam(":usuario", $datosC["usuario"], PDO::PARAM_STR);
        $pdo->bindParam(":clave", $datosC["clave"], PDO::PARAM_STR);

        if ($pdo->execute()) {
            return true;
        }


        $pdo = null;
    }

    //Borrar Doctor

    static public function BorrarDoctorM($tablaBD, $id)
    {
        $pdo = conexionBD::cBD()->prepare("DELETE FROM $tablaBD WHERE id=:id");
        $pdo->bindParam(":id", $id, PDO::PARAM_INT);

        if ($pdo->execute()) {

            return true;
        }

        $pdo = null;
    }
}
