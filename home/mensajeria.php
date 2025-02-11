<?php
require_once '../headfooter/head.php';
?>
<link rel="stylesheet" href="../css/style.css">
<div class="chat-container bg-dark text-white">
    <!-- 📜 Lista de usuarios -->
    <div class="user-list bg-dark text-white">
        <h1>Chats</h1>
        <ul id="usuariosLista">
            <!-- Se cargarán los usuarios aquí -->
        </ul>
    </div>

    <!-- 💬 Chat principal -->
    <div class="chat-box">
        <div class="bg-dark text-white" id="mensajesRecibidos"></div>
        
        <!-- 📩 Campo de mensaje -->
        <div id="mensajeria" style="display:none;">
            <div class="message-input  bg-dark text-white">
                <textarea id="mensaje" rows="2" placeholder="Escribe tu mensaje..."></textarea>
                <button id="enviarMensaje"><i class="fas fa-paper-plane"></i></button>
            </div>
        </div>
    </div>
</div>

<!-- Campo oculto para almacenar el ID del destinatario -->
<input type="hidden" id="destinatario" />  <!-- Este campo almacenará el ID del destinatario -->

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>

<?php 
require_once '../adicionales/script_mensajes.php'
?>

<?php
require_once '../headfooter/footer.php';
?>