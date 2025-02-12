<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $nombreusu = $_POST['nombreusu'];
    $pas = $_POST['contrasena'];
    $telefono = $_POST['telefono'];

    require_once 'cn.php'; // Archivo de conexión a la base de datos

    // Generar el hash de la contraseña
    $hashedPassword = password_hash($pas, PASSWORD_DEFAULT);

    // Crear conexión
    $conn = new mysqli($servername, $username, $password, $database);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    // Verificar si el nombre de usuario ya existe
    $checkStmt = $conn->prepare("SELECT id_usuario FROM usuarios WHERE nombreusu = ?");
    $checkStmt->bind_param("s", $nombreusu);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        // Si el usuario ya existe, redirigir con un mensaje de error
        header("Location: ../registro.php?error=usuario_existente");
        exit();
    }
    $checkStmt->close();

    // Preparar y ejecutar la consulta de inserción
    $sql = "INSERT INTO usuarios (nombreusu, nombre, contrasena, numero_telefono) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }

    $stmt->bind_param("ssss", $nombreusu, $nombre, $hashedPassword, $telefono);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        header("Location: ../index.php?registro=exitoso");
        exit();
    } else {
        echo "Error al registrar el usuario: " . $conn->error;
    }

    // Cerrar la conexión
    $stmt->close();
    $conn->close();
}
?>