<?php

// Función para crear un log a la tabla ordencompra
function crearlog_ordencompra($url_id, $accion, $redirect) {
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

// Función para enviar correos
function enviar_correo($asunto, $body, $correo_destino) {
    $mail = new PHPMailer\PHPMailer\PHPMailer();
    $mail->IsSMTP(); // enable SMTP
    $mail->CharSet = 'UTF-8';
    $mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
    $mail->SMTPAuth = true; // authentication enabled
    $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
    $mail->Host = "mail.gestionpedagogica.cl"; 
    $mail->Port = 465;
    $mail->IsHTML(true);
    $mail->Username = "contacto@gestionpedagogica.cl";
    $mail->Password = "2JPdh4U}A]}!";
    $mail->SetFrom("contacto@gestionpedagogica.cl");
    $mail->Subject = $asunto;
    $mail->Body = $body;
    $mail->AddAddress($correo_destino);

    if(!$mail->Send()) 
    {
        // Fallo
        return 0;
        // echo "Mailer Error: " . $mail->ErrorInfo;
    } else {
        // Exito
        return 1;
    }
}

// Función para ver si un usuario es dueño de un archivo o no
function comprobar_dueno_archivo($usuario_id, $archivo_id) {

    $sql_consulta = "SELECT * FROM ordencompra WHERE archivo_id = '".$archivo_id."' && usuario_id = '".$usuario_id."' && estado = 'Pagado'"; 
    $rs_result1 = mysqli_query($conn, $sql_consulta);
    $consulta_archivo = mysqli_fetch_assoc($rs_result1);

    if(mysqli_num_rows($rs_result1) < 1) {
        // Fallo, este usuario no tiene una compra finalizada de ese archivo
        return 0;
    } else {
        // Exito
        return 1;
    }
}
?>