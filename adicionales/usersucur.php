
                    <h1 class="text-center mb-4">Gestión de Usuarios</h1>
                    
                    <!-- Formulario de registro de usuario -->
                    <form action="../bd/adduser.php" method="POST" id="register">
                        <h2 class="text-center">Agregar Usuario</h2>
                        <div class="mb-3">
                            <label for="nombreusu" class="form-label">Nombre de usuario</label>
                            <input type="text" name="nombreusu" id="nombreusu" class="form-control" placeholder="Nombre de usuario" required>
                        </div>

                        <div class="mb-3">
                            <label for="contrasena" class="form-label">Contraseña</label>
                            <input type="password" name="contrasena" id="contrasena" class="form-control" placeholder="Contraseña" required>
                        </div>

                        <div class="mb-3">
                            <label for="clave_admin" class="form-label">Clave de administrador</label>
                            <input type="password" name="clave_admin" id="clave_admin" class="form-control" placeholder="Clave de administrador" required>
                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">Registrar</button>
                            <button type="reset" class="btn btn-secondary">Limpiar</button>
                        </div>
                    </form>

                    <!-- Usuarios registrados -->
                    <h2 class=" text-center my-5">Usuarios Registrados</h2>
                    <div class="row">
                        <?php
                        $sql4 = "SELECT id_usuario, nombreusu, es_admin FROM usuarios";
                        $result4 = $conn->query($sql4);

                        if ($result4->num_rows > 0) {
                            while ($row = $result4->fetch_assoc()) {
                                $rol = ($row['es_admin'] == 1) ? "Administrador" : "Usuario";
                                echo "
                                    <div class='col-md-4 mb-4'>
                                        <div class='card bg-dark text-white'>
                                            <div class='card-body'>
                                                <h5 class='card-title'>" . htmlspecialchars($row['nombreusu']) . "</h5>
                                                <p class='card-text'><strong>Rol:</strong> $rol</p>
                                                <div class='d-flex justify-content-between'>
                                                    <!-- Botón para eliminar -->
                                                    <button class='btn btn-danger' data-bs-toggle='modal' data-bs-target='#deleteModal' data-id='" . $row['id_usuario'] . "'>Eliminar</button>
                                                    <!-- Botón para actualizar -->
                                                    <button class='btn btn-warning' data-bs-toggle='modal' data-bs-target='#updateModal' data-id='" . $row['id_usuario'] . "' data-nombre='" . htmlspecialchars($row['nombreusu']) . "' data-rol='" . $row['es_admin'] . "'>Actualizar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                ";
                            }
                        } else {
                            echo "<p class='text-center'>No hay usuarios registrados</p>";
                        }
                        ?>
                    </div>

                    <!-- Modal para eliminar usuario -->
                    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content bg-dark text-white">
                                <form action="../bd/deleteuser.php" method="POST">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel">Eliminar Usuario</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>¿Estás seguro de que deseas eliminar este usuario?</p>
                                        <input type="hidden" name="id_usuario" id="delete-id">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-danger">Eliminar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Modal para actualizar usuario -->
                    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content bg-dark text-white">
                                <form action="../bd/updateuser.php" method="POST">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="updateModalLabel">Actualizar Usuario</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="id_usuario" id="update-id">
                                        <div class="mb-3">
                                            <label for="update-nombre" class="form-label">Nombre de usuario</label>
                                            <input type="text" name="nombreusu" id="update-nombre" class="form-control" required>
                                        </div> 
                                        <div class="mb-3">
                                            <label for="update-rol" class="form-label">Rol</label>
                                            <select name="es_admin" id="update-rol" class="form-select">
                                                <option value="1">Administrador</option>
                                                <option value="0">Usuario</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-warning">Actualizar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
        



                <script>
                    //Eliminar
                        const deleteModal = document.getElementById('deleteModal');
                        deleteModal.addEventListener('show.bs.modal', event => {
                        const button = event.relatedTarget;
                        const id = button.getAttribute('data-id');
                        document.getElementById('delete-id').value = id;
                        });
                            
                        //Actualizar
                        const updateModal = document.getElementById('updateModal');
                        updateModal.addEventListener('show.bs.modal', function (event) {
                        const button = event.relatedTarget;
                        const id = button.getAttribute('data-id');
                        const nombre = button.getAttribute('data-nombre');
                        const rol = button.getAttribute('data-rol');
                        const sucursal = button.getAttribute('data-sucursalAsig');

                        document.getElementById('update-id').value = id;
                        document.getElementById('update-nombre').value = nombre;
                        document.getElementById('update-rol').value = rol;
                        document.getElementById('update-sucursal_asignada').value = sucursal;  // Asegúrate de que este ID coincida
                        });
                </script>
                <script>
                    function openDeleteModal(id) {
                        document.getElementById('delete-id').value = id; // Asigna el ID al campo oculto
                        var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
                        deleteModal.show();
                    }
                </script>