<?php
require_once 'cn.php'; // Conexión a la base de datos
session_start(); // Asegurarnos de que la sesión esté activa

$usuario_id = $_POST['usuario_id']; // Usuario que envió la solicitud
$destinatario_id = $_SESSION['id_usuario']; // Usuario que recibe la solicitud

// Verificar si la solicitud existe
$query_solicitud = "SELECT * FROM solicitudes WHERE remitente_id = ? AND destinatario_id = ? AND estado = 'pendiente'";
$stmt_solicitud = $conn->prepare($query_solicitud);
$stmt_solicitud->bind_param("ii", $usuario_id, $destinatario_id);
$stmt_solicitud->execute();
$result = $stmt_solicitud->get_result();

if ($result->num_rows > 0) {
    // Primero, aceptamos la solicitud de amistad
    $query = "UPDATE solicitudes SET estado = 'aceptada' WHERE remitente_id = ? AND destinatario_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $usuario_id, $destinatario_id);
    
    if ($stmt->execute()) {
        // Ahora agregamos a los dos usuarios a la tabla de contactos
        // Asegurándonos de que no haya duplicados, insertamos en la tabla contactos solo si no existe la relación
        $query_contactos = "INSERT INTO contactos (usuario1_id, usuario2_id) 
                            SELECT ?, ? 
                            WHERE NOT EXISTS (
                                SELECT 1 FROM contactos WHERE 
                                (usuario1_id = ? AND usuario2_id = ?) 
                                OR (usuario1_id = ? AND usuario2_id = ?)
                            )";
        $stmt_contactos = $conn->prepare($query_contactos);
        $stmt_contactos->bind_param("iiiiii", $destinatario_id, $usuario_id, $destinatario_id, $usuario_id, $usuario_id, $destinatario_id);
        
        if ($stmt_contactos->execute()) {
            echo "Solicitud aceptada y ahora son contactos.";
        } else {
            echo "Error al agregar el contacto.";
        }
    } else {
        echo "Error al aceptar la solicitud.";
    }
} else {
    echo "No se encontró una solicitud pendiente.";
}
?>
