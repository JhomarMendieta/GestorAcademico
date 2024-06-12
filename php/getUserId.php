<?php
        session_start();
        include 'conn.php';
        if (isset($_SESSION["id"])) {
            $userId = $_SESSION["id"];

        } else {
            header("Location: ../index.html");
            exit();
        }
