<?php
    //obtener los datos POST (SIN URL)
    var_dump($_POST);

    //Obtener el num del socio
    $numSocio=isset($_POST['num_socio']) ? $_POST['num_socio'] : '';
    echo $numSocio;

    //Obtener la contraseña
    $password=isset($_POST['contrasenia']) ? $_POST['contrasenia'] : '';
    echo $password;
    
    if(filter_has_var(INPUT_POST, "num_socio")){
        echo "informacion enviada";
    } else echo "No se envio la informacion";

    // Validar el EMAIL
    if(filter_has_var(INPUT_POST, "info")){
        $email=$_POST["info"];

        //Eliminar caracteres invalidos
        $emailLimpio=filter_var($email,FILTER_SANITIZE_EMAIL);
        // echo $emailLimpio
    }
    else echo "No se envio la informacion";

?>