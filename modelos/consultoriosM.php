<?php

require_once "conexionBD.php";

class ConsultoriosM extends conexionBD{

    //Crear consultorio

    static public function CrearConsultorioM($tablaBD, $consultorio){

        $pdo = conexionBD::cBD()->prepare("INSERT INTO $tablaBD(nombre) VALUES(:nombre)");
        $pdo -> bindParam(":nombre", $consultorio["nombre"], PDO::PARAM_STR);

        if ($pdo -> execute()) {
            return true;

        }else {
            return false;
        }

        $pdo -> close();
        $pdo = null;


    }

    //Ver Consultorios

    static public function VerConsultoriosM($tablaBD, $columna, $valor){

        if($columna == null){

            $pdo = conexionBD::cBD()-> prepare ("SELECT * FROM $tablaBD");
            $pdo -> execute();

            return $pdo -> fetchAll();
        } else {
            $pdo = conexionBD::cBD()->prepare("SELECT * FROM $tablaBD WHERE $columna = :$columna");

            $pdo -> bindParam(":".$columna, $valor, PDO::PARAM_STR);

            $pdo -> execute();

            return $pdo -> fetch();
        }
    }

    //Borrar Consultorios
    static public function BorrarConsultorioM($tablaBD, $id){

        $pdo = conexionBD::cBD()->prepare("DELETE FROM $tablaBD WHERE id= :id");

        $pdo -> bindParam(":id", $id, PDO::PARAM_INT);

        if ($pdo -> execute()) {
            return true;

        }else {
            return false;
        }

        $pdo -> close();
        $pdo = null;

    }

    //editar consultorio

    static public function EditarConsultoriosM($tablaBD, $id){
        $pdo = conexionBD::cBD()->prepare("SELECT id, nombre FROM $tablaBD WHERE id=:id");
        $pdo -> bindParam (":id", $id, PDO::PARAM_INT);
        $pdo -> execute();
        return $pdo -> fetch();
        $pdo -> close();
        $pdo = null;

    }

    //actualizar consultorios

    static public function ActualizarConsultoriosM($tablaBD, $datosC){

        $pdo = conexionBD::cBD()->prepare("UPDATE $tablaBD SET nombre=:nombre WHERE id=:id");

        $pdo -> bindParam(":id", $datosC["id"], PDO::PARAM_INT);
        $pdo -> bindParam (":nombre", $datosC["nombre"], PDO::PARAM_STR);

        if ($pdo -> execute()) {
            return true;

        }else {
            return false;
        }

        $pdo -> close();
        $pdo = null;
    }

}

?>