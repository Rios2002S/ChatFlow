<?php
require_once 'cn.php'; // Conexión a la base de datos
session_start();

// Verificar que el usuario esté logueado
if (!isset($_SESSION['id_usuario'])) {
    echo "No estás logueado.";
    exit();
}

$remitente_id = $_SESSION['id_usuario']; // ID del usuario actual
$destinatario_id = $_POST['destinatario_id']; // ID del usuario destinatario

// Verificar que los campos no estén vacíos
if (empty($destinatario_id)) {
    echo "No se ha seleccionado un usuario.";
    exit();
}

// Insertar la solicitud en la base de datos
$query = "INSERT INTO solicitudes (remitente_id, destinatario_id, estado) VALUES (?, ?, 'pendiente')";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $remitente_id, $destinatario_id);

if ($stmt->execute()) {
    echo "Solicitud enviada";
} else {
    echo "Error al enviar la solicitud";
}
?>
