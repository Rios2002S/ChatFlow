<?php
require_once 'cn.php'; // Conexión a la base de datos

session_start();
if (!isset($_SESSION['id_usuario'])) {
    echo json_encode([]); // Si no está logueado, devolver un array vacío
    exit();
}

$usuario_id = $_SESSION['id_usuario']; // Obtener el ID del usuario logueado

// Obtener todos los usuarios, excepto el usuario logueado
$query = "SELECT id_usuario, nombre FROM usuarios WHERE id_usuario != ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();

$usuarios = [];
while ($row = $result->fetch_assoc()) {
    $usuarios[] = $row;
}

// Devolver los usuarios en formato JSON
echo json_encode($usuarios);
?>