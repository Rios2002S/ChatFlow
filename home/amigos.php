<?php require_once '../headfooter/head.php'; ?>

<!-- Contenedor con Tabs -->
<div class="container mt-4">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="usuarios-tab" data-bs-toggle="tab" href="#usuarios" role="tab" aria-controls="usuarios" aria-selected="true">Usuarios</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="solicitudes-tab" data-bs-toggle="tab" href="#solicitudes" role="tab" aria-controls="solicitudes" aria-selected="false">Solicitudes</a>
        </li>
    </ul>
    
    <div class="tab-content" id="myTabContent">
        <!-- Tab Usuarios -->
        <div class="tab-pane fade show active" id="usuarios" role="tabpanel" aria-labelledby="usuarios-tab">
            <div class="card mt-3 shadow-sm">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">Usuarios Disponibles</h5>
                </div>
                <div class="card-body">
                    <ul id="usuariosLista" class="list-group">
                        <!-- Los usuarios serán cargados aquí mediante AJAX -->
                    </ul>
                </div>
            </div>
        </div>

        <!-- Tab Solicitudes -->
        <div class="tab-pane fade" id="solicitudes" role="tabpanel" aria-labelledby="solicitudes-tab">
            <div class="card mt-3 shadow-sm">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">Solicitudes Pendientes</h5>
                </div>
                <div class="card-body">
                    <ul id="solicitudesLista" class="list-group">
                        <!-- Las solicitudes de amistad serán cargadas aquí -->
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once '../headfooter/footer.php'; ?>
<script>
$(document).ready(function() {
    $.ajax({
        url: '../bd/obtener_amigos.php',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            console.log(data); // Verifica la respuesta en la consola
            var userList = '';
            $.each(data, function(index, user) {
                // Si el usuario ya es contacto, muestra el check, si no, muestra el botón "Agregar"
                var boton = user.es_contacto 
                    ? `<button class="btn btn-success btn-sm" disabled>✔</button>`  
                    : `<button class="btn btn-primary btn-sm add-contact" data-id="${user.id_usuario}">Agregar</button>`; 

                userList += `
                    <li class="list-group-item d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <img src="${user.foto}" class="rounded-circle me-2" alt="Avatar" width="35px">
                            <span class="fw-bold">${user.nombre}</span>
                        </div>
                        ${boton}
                    </li>`;
            });
            $('#usuariosLista').html(userList);
        },
        error: function(err) {
            console.error('Error:', err);
        }
    });

    // Evento al hacer clic en "Agregar"
    $(document).on('click', '.add-contact', function() {
        var idUsuario = $(this).data('id');
        $.ajax({
            url: '../bd/enviar_solicitud.php',
            method: 'POST',
            data: { destinatario_id: idUsuario },
            success: function(response) {
                if (response === 'Solicitud enviada') {
                    alert('Solicitud enviada con éxito');
                } else {
                    alert('Error al enviar la solicitud');
                }
            }
        });
    });

    // Cargar las solicitudes de amistad
    function cargarSolicitudes() {
        $.ajax({
            url: '../bd/obtener_solicitudes.php',
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                var solicitudesList = '';
                $.each(data, function(index, solicitud) {
                    solicitudesList += `
                        <li class="list-group-item d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <img src="${solicitud.foto}" class="rounded-circle me-2" width="35px" alt="Avatar">
                                <span class="fw-bold">${solicitud.nombre}</span>
                            </div>
                            <div>
                                <button class="btn btn-success btn-sm accept-request" data-id="${solicitud.id_usuario}">Aceptar</button>
                                <button class="btn btn-danger btn-sm reject-request" data-id="${solicitud.id_usuario}">Rechazar</button>
                            </div>
                        </li>`;
                });
                $('#solicitudesLista').html(solicitudesList);
                
                // Agregar los eventos de aceptación y rechazo después de cargar las solicitudes
                $(document).on('click', '.accept-request', function() {
                    var usuario_id = $(this).data('id');
                    
                    $.ajax({
                        url: '../bd/aceptar_solicitud.php',
                        method: 'POST',
                        data: { usuario_id: usuario_id },
                        success: function(response) {
                            alert(response); // Mostrar mensaje de éxito
                            cargarSolicitudes(); // Recargar las solicitudes
                        }
                    });
                });

                $(document).on('click', '.reject-request', function() {
                    var usuario_id = $(this).data('id');
                    
                    $.ajax({
                        url: '../bd/rechazar_solicitud.php',
                        method: 'POST',
                        data: { usuario_id: usuario_id },
                        success: function(response) {
                            alert(response); // Mostrar mensaje de éxito
                            cargarSolicitudes(); // Recargar las solicitudes
                        }
                    });
                });
            }
        });
    }

    // Cargar solicitudes al inicio
    cargarSolicitudes();
});

</script>