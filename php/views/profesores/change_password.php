<?php
include "./components/navbar_profesores.php";
include 'autenticacion_profesor.php';
include '../../conn.php';
if (!isset($_SESSION["id"])) {
    header("Location: ../index.html");
    exit();
}

$userId = $_SESSION["id"];
$message = "";
$messageType = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $current_password = $_POST["current_password"];
    $new_password = $_POST["new_password"];
    $confirm_password = $_POST["confirm_password"];
    $new_email = $_POST["new_email"];

    $sql = "SELECT contrasenia, mail FROM usuario WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $storedHash = $row["contrasenia"];
    $current_email = $row["mail"];

    if (password_verify($current_password, $storedHash)) {
        if ($new_password == $confirm_password) {
            $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);

            // Actualizar solo si se ha ingresado un nuevo correo electrónico
            if (!empty($new_email)) {
                $update_sql = "UPDATE usuario SET contrasenia = ?, mail = ? WHERE id = ?";
                $stmt = $conn->prepare($update_sql);
                $stmt->bind_param("ssi", $hashed_new_password, $new_email, $userId);
            } else {
                $update_sql = "UPDATE usuario SET contrasenia = ? WHERE id = ?";
                $stmt = $conn->prepare($update_sql);
                $stmt->bind_param("si", $hashed_new_password, $userId);
            }

            if ($stmt->execute() === TRUE) {
                $message = "Contraseña actualizada exitosamente.";
                if (!empty($new_email)) {
                    $message .= " Correo electrónico también actualizado.";
                }
                $messageType = "success";
            } else {
                $message = "Error al actualizar la información: " . $conn->error;
                $messageType = "danger";
            }
        } else {
            $message = "Las nuevas contraseñas no coinciden.";
            $messageType = "warning";
        }
    } else {
        $message = "La contraseña actual es incorrecta.";
        $messageType = "danger";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar Contraseña y Correo Electrónico</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    </head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Cambiar Contraseña y Correo Electrónico</h2>
    <?php if (!empty($message)) { ?>
    <div class="alert alert-<?php echo $messageType; ?>" role="alert">
        <?php echo $message; ?>
    </div>
    <?php } ?>
    <form method="POST" action="change_password.php">
        <div class="form-group">
            <label for="current_password">Contraseña Actual:</label>
            <input type="password" id="current_password" name="current_password" required class="form-control">
        </div>
        <div class="form-group">
            <label for="new_password">Nueva Contraseña:</label>
            <input type="password" id="new_password" name="new_password" required class="form-control">
        </div>
        <div class="form-group">
            <label for="confirm_password">Confirmar Nueva Contraseña:</label>
            <input type="password" id="confirm_password" name="confirm_password" required class="form-control">
        </div>
        <div class="form-group">
            <label for="new_email">Nuevo Correo Electrónico(opcional):</label>
            <input type="email" id="new_email" name="new_email" class="form-control" value="<?php echo isset($current_email) ? $current_email : ''; ?>">
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="menu.php" class="btn btn-secondary">Volver</a>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>