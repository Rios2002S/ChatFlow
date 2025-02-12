<?php
require_once 'cn.php'; // Conexión a la base de datos
session_start();

// Verificar que el usuario esté logueado
if (!isset($_SESSION['id_usuario'])) {
    echo json_encode([]); // Si no está logueado, devolver un arreglo vacío
    exit();
}

$usuario_id = $_SESSION['id_usuario']; // Obtener el ID del usuario logueado

// Obtener solicitudes pendientes
$query = "SELECT u.id_usuario, u.nombre, u.foto 
          FROM usuarios u
          JOIN solicitudes s ON u.id_usuario = s.remitente_id
          WHERE s.destinatario_id = ? AND s.estado = 'pendiente'"; // Solicitudes pendientes del usuario

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $usuario_id); // Vinculamos el ID del destinatario (usuario logueado)
$stmt->execute();
$result = $stmt->get_result();

$solicitudes = []; // Arreglo para almacenar las solicitudes

// Recoger los resultados y almacenarlos en el arreglo
while ($row = $result->fetch_assoc()) {
    $solicitudes[] = $row;
}

// Devolver las solicitudes como JSON
echo json_encode($solicitudes);
?>
