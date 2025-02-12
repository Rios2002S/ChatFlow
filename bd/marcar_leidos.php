<?php
require_once 'cn.php';
session_start();

if (!isset($_SESSION['id_usuario'])) {
    echo "No estás logueado.";
    exit();
}

$id_usuario = $_SESSION['id_usuario']; 
$remitente_id = $_POST['remitente_id']; 

$query = "UPDATE mensajes SET leido = 1 
          WHERE destinatario_id = ? AND remitente_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $id_usuario, $remitente_id);
$stmt->execute();

echo "Mensajes marcados como leídos.";
?>
