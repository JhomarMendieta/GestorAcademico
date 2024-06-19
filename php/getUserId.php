<?php
        session_start();
        include 'conn.php';
        if (isset($_SESSION["id"])) {
            $userId = $_SESSION["id"];
            $userName = $_SESSION["nombre_usuario"];

        } else {
            header("Location: ../index.html");
            exit();
        }
