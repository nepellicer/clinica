<?php
require_once "conexionBD.php";

class SecretariasM extends conexionBD
{

    static public function IngresarSecretariaM($tablaBD, $datosC)
    {

        // Preparamos la consulta
        $pdo = conexionBD::cBD()->prepare(
            "SELECT usuario, clave, nombre, apellido, foto, rol, id 
        FROM $tablaBD 
        WHERE usuario = :usuario"
        );

        // Vinculamos el parámetro
        $pdo->bindParam(":usuario", $datosC["usuario"], PDO::PARAM_STR);

        // Ejecutamos la consulta
        $pdo->execute();

        return $pdo->fetch();

        $pdo->close();
        $pdo = null;
    }

    // ver perfil secretaria
    static public function VerPerfilSecretariaM($tablaBD, $id)
    {
        $pdo = conexionBD::cBD()->prepare(
            "SELECT usuario, clave, nombre, apellido, foto, rol, id 
            FROM $tablaBD 
            WHERE id = :id"
        );

        // Vinculamos el parámetro
        $pdo->bindParam(":id", $id, PDO::PARAM_INT);

        // Ejecutamos la consulta
        $pdo->execute();

        return $pdo->fetch();

        $pdo->close();
        $pdo = null;
    }

    // Actualizar perfil secretaria

    static public function ActualizarPerfilSecretariaM($tablaBD, $datosC)
    {
        $pdo = conexionBD::cBD()->prepare(
            "UPDATE $tablaBD 
                SET usuario=:usuario, clave=:clave, nombre=:nombre, 
                apellido=:apellido, foto=:foto 
                WHERE id=:id"
        );

        $pdo->bindParam(":id", $datosC["id"], PDO::PARAM_INT);
        $pdo->bindParam(":usuario", $datosC["usuario"], PDO::PARAM_STR);
        $pdo->bindParam(":nombre", $datosC["nombre"], PDO::PARAM_STR);
        $pdo->bindParam(":apellido", $datosC["apellido"], PDO::PARAM_STR);
        $pdo->bindParam(":clave", $datosC["clave"], PDO::PARAM_STR);
        $pdo->bindParam(":foto", $datosC["foto"], PDO::PARAM_STR);

        if ($pdo->execute()) {
            return true;
        } else {
            return false;
        }

        $pdo = null;
    }
}
