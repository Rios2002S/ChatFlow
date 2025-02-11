<?php
require_once 'cn.php'; // Conexión a la base de datos
session_start();

if (!isset($_SESSION['id_usuario'])) {
    echo json_encode(["error" => "No estás logueado."]);
    exit();
}

$usuario_id = $_POST['usuario_id']; // Usuario que envió la solicitud
$destinatario_id = $_SESSION['id_usuario']; // Usuario logueado que recibirá la solicitud

// Verificar si la solicitud existe y está pendiente
$query = "SELECT * FROM solicitudes WHERE remitente_id = ? AND destinatario_id = ? AND estado = 'pendiente'";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $usuario_id, $destinatario_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Si existe una solicitud pendiente, la eliminamos
    $query_delete = "DELETE FROM solicitudes WHERE remitente_id = ? AND destinatario_id = ?";
    $stmt_delete = $conn->prepare($query_delete);
    $stmt_delete->bind_param("ii", $usuario_id, $destinatario_id);

    if ($stmt_delete->execute()) {
        echo "Solicitud rechazada.";
    } else {
        echo "Error al rechazar la solicitud.";
    }
} else {
    echo "No existe una solicitud pendiente de este usuario.";
}
?>