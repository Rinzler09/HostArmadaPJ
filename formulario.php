<?php

$nombre = $_POST['txtNombreRegistro'];
$correo = $_POST['txtCorreoRegistro'];
$comentarios = $_POST['txtComentariosRegistro'];

if(empty($nombre) || empty($correo) || empty($comentarios))
{
    echo "INVALIDO, HAY CAMPOS VACIOS";
}
else
{
    $host = "sql109.infinityfree.com";
    $nombreDB = "if0_34528501_Registro_Website";
    $usuarioDB = "if0_34528501";
    $contraseniaDB = "Tta8xedwlQz65";

    $connection = new mysqli($host, $usuarioDB, $contraseniaDB, $nombreDB);
    
    if(mysqli_connect_error()){
        die('Error en la conexión: '.mysqli_connect_error());
    }

    $SELECT = "SELECT id from registro where Correo=?";
    $SELECT2 = "SELECT * from registro";
    $INSERT = "INSERT INTO registro (Nombre_Completo, Correo, Comentarios) VALUES (?, ?, ?)";

    $stmt = $connection->prepare($SELECT);
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $stmt->store_result();

    if($stmt->num_rows > 0){
        echo "El registro ya existe en la base de datos";
    }
    else{
        $stmt->close();
        $stmt = $connection->prepare($INSERT);
        $stmt2 = $connection->prepare($SELECT2);
        $stmt->bind_param("sss", $nombre, $correo, $comentarios);
        $stmt2->bind_param("sss", $nombre, $correo, $comentarios);
        if($stmt->execute()){
            echo "<b>REGISTRO ENVIADO A LA BASE DE DATOS EXITOSAMENTE</b><br>";
            $stmt2->execute();
            $result = $stmt2->get_result();
            while ($row = $result->fetch_assoc()){
                echo "<br>ID: ".$row['id']."<br>";
                echo "Nombre Completo: ".$row['Nombre_Completo']."<br>";
                echo "Correo: ".$row['Correo']."<br>";
                echo "Comentarios: ".$row['Comentarios']."<br>";
                echo "<br>***********************************<br>";
            }
        } else {
            echo "SE PRODUJO UN ERROR AL ENVIAR LOS DATOS";
        }
    }

    $stmt->close();
    $connection->close();
}

?>
