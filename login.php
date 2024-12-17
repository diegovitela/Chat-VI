<?php
// Incluir el archivo de conexión
include 'db.php';

// Verificar si el formulario de inicio de sesión ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir datos del formulario
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Preparar la consulta para buscar el usuario en la tabla cat
    $sql = "SELECT id, username, password FROM cat WHERE email = ?";
    if ($stmt = $conn->prepare($sql)) {
        // Enlazar los parámetros
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        // Si el correo existe, verificar la contraseña
        if ($stmt->num_rows > 0) {
            // Vincular los resultados
            $stmt->bind_result($id, $username, $hashed_password);

            // Recuperar los resultados
            $stmt->fetch();

            // Verificar la contraseña
            if (password_verify($password, $hashed_password)) {
                // Inicio de sesión exitoso
                echo "¡Bienvenido, " . $username . "!";
                // Redirigir a la página principal o dashboard
                // header("Location: dashboard.php");
                // exit();
            } else {
                // Contraseña incorrecta
                echo "Contraseña incorrecta.";
            }
        } else {
            // El correo no está registrado
            echo "Este correo no está registrado.";
        }

        // Cerrar la sentencia
        $stmt->close();
    } else {
        echo "Error en la consulta: " . $conn->error;
    }

    // Cerrar la conexión
    $conn->close();
}
?>
