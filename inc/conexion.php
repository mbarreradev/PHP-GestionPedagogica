<?php

// configuraciónes
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "repositorio";

// conexión
$conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());

mysqli_set_charset( $conn, 'utf8');

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
} 

// Funciones

// Función para crear un log a la tabla ordencompra
function crearlog_ordencompra($url_id, $accion, $redirect) 
{
    $fecha_actualizacion = date("Y-m-d H:i:s");
    global $conn;

    $sql_create_ordencompra_historial= "INSERT INTO ordencompra_historial (historial_id, ordencompra_id, fecha_creacion, accion) VALUES (DEFAULT, '$url_id', '$fecha_actualizacion', '$accion')"; 
                    
    if ($conn->query($sql_create_ordencompra_historial) === TRUE) 
    {
        if (is_null($redirect))
        {
            // Refrescamos la página
            header("Refresh:0");
        }
        else
        {
            // Caso contrario, hacemos la redirección
            header("Location: https://repositorio.gestionpedagogica.cl/".$redirect);
        }
        
    }
    else
    {
        //echo "Error sql log." . $sql_create_ordencompra_historial . "<br>" . $conn->error;
        echo "Error sql update.";
    }
}

?>