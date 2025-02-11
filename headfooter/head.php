<?php
        session_start();
        require_once("../bd/cn.php");
        // Verificar si el usuario está autenticado
        if (!isset($_SESSION['id_usuario'])) {
            header("Location: ../index.php"); // Si no está autenticado, redirigir al login
            exit();
        }

        // Verificar si el usuario está autenticado y obtener los valores de la sesión
        $es_admin = $_SESSION['es_admin'] ?? 0;
        $nombreu = $_SESSION['nombreusu'];
        $idusuario = $_SESSION['id_usuario']; 
        $nombre = $_SESSION['nombre']; 
?>
<!doctype html>
<html lang="en">
    <head>
        <title>ChatFlow</title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />
        <!-- Bootstrap CSS v5.2.1 -->
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous"
        />
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Protest+Guerrilla&display=swap" rel="stylesheet">

        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">

        <!-- DataTables CSS -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">

        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <!-- DataTables JS -->
        <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
        <script src="https://accounts.google.com/gsi/client" async defer></script>
        <script src="https://apis.google.com/js/api.js"></script>
        <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&display=swap" rel="stylesheet">
     <link rel="stylesheet" href="../css/estilosbase.css"> 
     <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-1684429777478310"
     crossorigin="anonymous"></script>  
    </head>

    <body>
        <header>
            <div class="infor mb-0 fijo">
                <h3 class="m-0 fs-3">Programador Ríos&nbsp;</h3>
            </div><br><br>


            <!-- Menú deslizante -->
            <?php
            require_once  '../adicionales/navbar.php';
            ?>

        </header>
        <main>

        <!-- Contenedor principal con margen a la derecha para no quedar oculto -->
        <div id="mainContent">
        <?php
        require_once '../adicionales/saludo.php';
        ?>



