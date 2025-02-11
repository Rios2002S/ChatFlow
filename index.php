<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión | ChatFlow</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
	<link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&display=swap" rel="stylesheet">
    <style>
		body {
			background-image: url(https://r4.wallpaperflare.com/wallpaper/175/524/956/digital-digital-art-artwork-fantasy-art-drawing-hd-wallpaper-d8562dc820d0acd8506c415eb8e2a49a.jpg);
			background-size: cover; /* Ajusta la imagen al tamaño del div */
			background-position: center; /* Centra la imagen */
			background-repeat: no-repeat; /* No repetir la imagen */
			color: white;
			font-family: Arial, sans-serif;
			height: 100vh; /* Ocupa toda la altura de la pantalla */
			display: flex;
			justify-content: center; /* Centra horizontalmente */
			align-items: center; /* Centra verticalmente */
			margin: 0;
		}
		.login-container {
			width: 450px;
			padding: 30px;
			background-color:rgba(30, 30, 30, 0.45);
			border-radius: 8px;
			box-shadow: 0px 0px 10px rgba(255, 0, 0, 0.5);
		}

        .btn-red {
			background: linear-gradient(45deg, #ff0000, #cc0000, #990000, #660000);
			border: none;
			color: white;
			padding: 12px 20px;
			font-size: 16px;
			font-weight: bold;
			text-transform: uppercase;
			border-radius: 8px;
			cursor: pointer;
			transition: all 0.3s ease;
			box-shadow: 0px 4px 10px rgba(255, 0, 0, 0.5);
        }
        .btn-red:hover {
			background: linear-gradient(45deg, #ff3333, #dd0000, #aa0000, #770000);
			box-shadow: 0px 6px 15px rgba(255, 0, 0, 0.7);
			transform: scale(1.05);
        }
        .error {
            color: #ff0000;
        }
		.chat-title {
			font-family: 'Orbitron', sans-serif;
			font-size: 36px; /* Tamaño grande */
			font-weight: 700; /* Negrita */
			text-align: center;
			color:rgb(250, 247, 247); /* Rojo vibrante */
			text-shadow: 3px 3px 10px rgba(255, 0, 0, 0.7); /* Brillo rojo */
			letter-spacing: 2px; /* Espaciado entre letras */
			text-transform: uppercase; /* Todo en mayúsculas */
		}
    </style>
</head>
<body>

<div class="login-container">
	<h2 class="chat-title">ChatFlow</h2>
    <h5 class="text-center">Iniciar Sesión</h5>
    <form action="bd/verifyuser.php" method="POST">
        <div class="mb-3">
            <label>Usuarios</label>
            <input type="text" name="nombreusu" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Contraseña</label>
            <input type="password" name="contrasena" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-red w-100">Ingresar</button>
    </form>

    <p class="text-center mt-3">
        ¿No tienes cuenta? <a href="registro.php" class="text-danger">Regístrate</a>
    </p>
</div>

</body>
</html>