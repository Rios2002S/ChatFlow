<?php
require_once 'cn.php'; // Archivo de conexión
session_start();

// Verificar que el usuario esté logueado
if (!isset($_SESSION['id_usuario'])) {
    echo json_encode(['error' => 'No estás logueado.']);
    exit();
}

$remitente_id = $_SESSION['id_usuario']; // ID del usuario actual
$destinatario_id = isset($_GET['destinatario']) ? (int)$_GET['destinatario'] : 0;

if ($destinatario_id === 0) {
    echo json_encode(['error' => 'Destinatario inválido.']);
    exit();
}

// 🔹 1. Marcar como leídos los mensajes recibidos del destinatario
$update_query = "UPDATE mensajes SET leido = 1 WHERE remitente_id = ? AND destinatario_id = ? AND leido = 0";
$stmt_update = $conn->prepare($update_query);
$stmt_update->bind_param("ii", $destinatario_id, $remitente_id);
$stmt_update->execute();

// 🔹 2. Obtener los mensajes entre ambos usuarios
$query = "SELECT m.mensaje, m.fecha_envio, m.leido, u.nombreusu AS remitente, m.remitente_id
          FROM mensajes m
          JOIN usuarios u ON m.remitente_id = u.id_usuario
          WHERE (m.remitente_id = ? AND m.destinatario_id = ?)
             OR (m.remitente_id = ? AND m.destinatario_id = ?)
          ORDER BY m.fecha_envio ASC";

$stmt = $conn->prepare($query);
$stmt->bind_param("iiii", $remitente_id, $destinatario_id, $destinatario_id, $remitente_id);
$stmt->execute();
$result = $stmt->get_result();

$mensajes = [];
while ($row = $result->fetch_assoc()) {
    $mensajes[] = [
        'mensaje' => htmlspecialchars($row['mensaje']),
        'fecha_envio' => $row['fecha_envio'],
        'remitente' => htmlspecialchars($row['remitente']),
        'es_mio' => ($row['remitente_id'] == $remitente_id), // Indica si el mensaje es del usuario actual
        'leido' => $row['leido'] // ✅ Agregamos el estado de lectura
    ];    
}

// 🔹 3. Devolver los mensajes como JSON
echo json_encode(['mensajes' => $mensajes]);

?>