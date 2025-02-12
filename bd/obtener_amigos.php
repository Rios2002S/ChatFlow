<?php
require_once 'cn.php'; // Conexión a la base de datos

session_start();
if (!isset($_SESSION['id_usuario'])) {
    echo json_encode([]);
    exit();
}

$usuario_id = $_SESSION['id_usuario'];

// Obtener todos los usuarios y marcar si son contactos o no
$query = "SELECT u.id_usuario, u.nombre, u.foto,
                 CASE 
                     WHEN EXISTS (
                         SELECT 1 FROM contactos c 
                         WHERE (c.usuario1_id = u.id_usuario AND c.usuario2_id = ?) 
                            OR (c.usuario1_id = ? AND c.usuario2_id = u.id_usuario)
                     ) THEN 1
                     ELSE 0
                 END AS es_contacto
          FROM usuarios u
          WHERE u.id_usuario != ?";

$stmt = $conn->prepare($query);
$stmt->bind_param("iii", $usuario_id, $usuario_id, $usuario_id);
$stmt->execute();
$result = $stmt->get_result();

$usuarios = [];
while ($row = $result->fetch_assoc()) {
    $usuarios[] = $row;
}

echo json_encode($usuarios);
?>
