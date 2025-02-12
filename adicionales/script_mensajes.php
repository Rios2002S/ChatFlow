<script>
    $(document).ready(function() {
        var intervalId = null; // Variable para almacenar el ID del intervalo

        // Obtener los usuarios y cargar la lista

        // Función para obtener los usuarios y cargar la lista
        function obtenerUsuarios() {
            $.ajax({
                url: '../bd/obtener_usuarios.php',
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    if (data.error) {
                        alert(data.error);
                    } else {
                        var userList = '';
                        $.each(data, function(index, user) {
                            userList += `<li class="user-item" data-id="${user.id_usuario}">
                                            ${user.foto ? `<img src="${user.foto}" alt="${user.nombreusu}" class="user-photo">` : `<i class="fas fa-user-circle"></i>`}
                                            &nbsp;&nbsp;${user.nombre}
                                            ${user.mensajes_no_leidos > 0 ? `<span class="badge">${user.mensajes_no_leidos}</span>` : ''}
                                        </li>`;
                        });
                        $('#usuariosLista').html(userList);
                    }
                }
            });
        }

        // Llamar la función para obtener usuarios al cargar la página
        obtenerUsuarios();

        // Actualizar la lista de usuarios cada 30 segundos
        setInterval(obtenerUsuarios, 3000); // 30000ms = 30 segundos

        // Cuando seleccionan un destinatario, cargar los mensajes
        $(document).on('click', '.user-item', function() {
            var destinatario = $(this).data('id');
            console.log("Destinatario ID:", destinatario);  // Verificar ID seleccionado
            $('#destinatario').val(destinatario);  // Actualiza el campo del destinatario

            if (destinatario) {
                $('#mensajeria').show();
                $('#mensajesRecibidos').html('');  // Limpiar los mensajes antes de cargar los nuevos
                if (intervalId !== null) {
                    clearInterval(intervalId);
                }
                cargarMensajes(destinatario);

                // Actualizar los mensajes cada 20 segundos
                intervalId = setInterval(function() {
                    cargarMensajes(destinatario);
                }, 5000);  // 20000ms = 20 segundos
            }
        });

        // Función para cargar los mensajes y asegurar que el contenedor se desplace hacia abajo
        function cargarMensajes(destinatario) {
            $.ajax({
                url: '../bd/cargar_mensajes.php',
                method: 'GET',
                data: { destinatario: destinatario },
                dataType: 'json',
                success: function(response) {
                    if (response.error) {
                        alert(response.error);
                        return;
                    }

                    let mensajesHtml = '';
                    response.mensajes.forEach(m => {
                        mensajesHtml += `<div class="message ${m.es_mio ? 'message-right' : 'message-left'}">
                                            <p>${m.mensaje}</p>
                                            <div class="d-flex align-items-center">
                                                <span class="message-time">${m.fecha_envio}</span>
                                                ${m.es_mio ? `
                                                    <span class="message-status">
                                                        ${m.leido == 0 ? '<i class="fas fa-check text-white"></i>' : '<i class="fas fa-check-double text-primary"></i>'}
                                                    </span>
                                                ` : ''}
                                            </div>
                                        </div>`;
                    });

                    $('#mensajesRecibidos').html(mensajesHtml);
                    $('#mensajesRecibidos').scrollTop($('#mensajesRecibidos')[0].scrollHeight);
                }
            });
        }

        // Marcar los mensajes como leídos cuando el usuario abra un chat
        function marcarComoLeidos(destinatario) {
            $.ajax({
                url: '../bd/marcar_leidos.php',
                method: 'POST',
                data: { destinatario: destinatario },
                success: function(response) {
                    console.log("Mensajes marcados como leídos");
                    obtenerUsuarios(); // Actualiza la lista de usuarios después de marcar los mensajes como leídos
                }
            });
        }

        // Enviar un mensaje
        $('#enviarMensaje').on('click', function() {
            var destinatario = $('#destinatario').val();
            var mensaje = $('#mensaje').val();
            console.log("Destinatario:", destinatario, "Mensaje:", mensaje);  // Verificar los valores antes de enviar

            if (destinatario && mensaje) {
                $.ajax({
                    url: '../bd/enviar_mensaje.php',
                    method: 'POST',
                    data: {
                        destinatario: destinatario,
                        mensaje: mensaje
                    },
                    success: function(response) {
                        $('#mensaje').val('');  // Limpiar el campo de mensaje
                        cargarMensajes(destinatario);  // Recargar los mensajes
                    }
                });
            } else {
                alert('Por favor, completa todos los campos.');
            }
        });

        // Función para verificar si hay mensajes nuevos
        function verificarMensajesNuevos() {
            $.ajax({
                url: '../bd/verificar_mensajes.php',
                method: 'GET',
                success: function(response) {
                    if (response.nuevos > 0) {
                        // Verificar si las notificaciones están permitidas
                        if (Notification.permission === "granted") {
                            // Crear la notificación
                            new Notification(`Tienes ${response.nuevos} mensaje(s) nuevo(s)`);
                        } else if (Notification.permission !== "denied") {
                            // Solicitar permiso para notificaciones si no está denegado
                            Notification.requestPermission().then(function(permission) {
                                if (permission === "granted") {
                                    new Notification(`Tienes ${response.nuevos} mensaje(s) nuevo(s)`);
                                }
                            });
                        }
                    }
                }
            });
        }

        // Revisar si hay mensajes nuevos cada 5 segundos
        setInterval(verificarMensajesNuevos, 5000);

    });
</script>