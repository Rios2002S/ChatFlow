<?php
require_once 'cn.php';
session_start();

if (!isset($_SESSION['id_usuario'])) {
    echo json_encode(["error" => "No estás logueado."]);
    exit();
}

$id_usuario = $_SESSION['id_usuario'];

// Consulta para obtener los contactos del usuario y contar los mensajes no leídos
$query = "SELECT u.id_usuario, u.nombreusu, u.nombre, u.foto, 
                 (SELECT COUNT(*) FROM mensajes 
                  WHERE mensajes.destinatario_id = ? 
                  AND mensajes.remitente_id = u.id_usuario 
                  AND mensajes.leido = 0) AS mensajes_no_leidos
          FROM usuarios u
          JOIN contactos c ON (c.usuario1_id = u.id_usuario OR c.usuario2_id = u.id_usuario)
          WHERE (c.usuario1_id = ? OR c.usuario2_id = ?) AND u.id_usuario != ?";
          
$stmt = $conn->prepare($query);
$stmt->bind_param("iiii", $id_usuario, $id_usuario, $id_usuario, $id_usuario);
$stmt->execute();
$result = $stmt->get_result();

$usuarios = [];
while ($row = $result->fetch_assoc()) {
    $usuarios[] = $row;
}

echo json_encode($usuarios);
?>