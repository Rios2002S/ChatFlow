<?php
header('Content-Type: application/json');
session_start();
include 'cn.php';

$id_usuario = $_SESSION['id_usuario']; 

$query = "SELECT COUNT(*) AS nuevos FROM mensajes WHERE destinatario_id = ? AND leido = 0";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();

echo json_encode($result);
?>