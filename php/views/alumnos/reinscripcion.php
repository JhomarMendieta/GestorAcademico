<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./reinscripcion.css">
</head>
<body>
    <!-- navbar -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a id="logo" class="navbar-brand" href="menu.php">
                <img src="../../../img/LogoEESTN1.png" alt="">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="reinscripcion.php">Solicitud de reinscripción</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="#">Ver RITE</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="#">Ver materias</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- form -->
    <div class="container">
        <form action="reinscripcion_post.php" method="post" enctype="multipart/form-data">
            <div id="col1">
                <div>
                    <label for="nombre">Nombre/s:</label>
                    <input type="text" id="nombre" name="nombre" required>
                </div>
                <div>
                    <label for="apellido">Apellido/s:</label>
                    <input type="text" id="apellido" name="apellido" required>
                </div>
                <div>
                    <label for="nacimiento">Fecha de nacimiento:</label>
                    <input type="date" id="nacimiento" name="nacimiento" required>
                </div>
                <div>
                    <label for="cpi">¿Posee Certificado de Pre-Identificación? (CPI)</label>
                    <select id="cpi" name="cpi">
                        <option value="si">Sí</option>
                        <option value="no">No</option>
                    </select>
                </div>
                <div>
                    <label for="archivos">PDF reinscripción:</label>
                    <input type="file" id="archivos" name="archivos" required>
                </div>
            </div>
            <div id="col2">
                <div>
                    <p><b>¿Posee DNI Argentino?</b></p>
                    <div class="radio">
                        <input type="radio" id="dni_si_fisico" name="dni_argentino" value="si_fisico">
                        <label for="dni_si_fisico">Sí, y tiene el DNI físico</label><br>
                    </div>
                    <div class="radio">
                        <input type="radio" id="dni_si_tramite" name="dni_argentino" value="si_tramite">
                        <label for="dni_si_tramite">Sí, pero no tiene el DNI físico y se encuentra en trámite</label><br>
                    </div>
                    <div class="radio">
                        <input type="radio" id="dni_si_no_tramite" name="dni_argentino" value="si_no_tramite">
                        <label for="dni_si_no_tramite">Sí, pero no tiene el DNI físico y NO se encuentra en trámite</label><br>
                    </div>
                    <div class="radio">
                        <input type="radio" id="dni_no" name="dni_argentino" value="no">
                        <label for="dni_no">No posee DNI Argentino</label>
                    </div>
                </div>
                <div class="dnicuil">
                    <div>
                        <label for="dni">DNI:</label>
                        <input type="text" id="dni" name="dni">
                    </div>
                    <div>
                        <label for="cuil">CUIL:</label>
                        <input type="text" id="cuil" name="cuil">
                    </div>
                </div>
                <div class="extranjero">
                    <div>
                        <label for="documento_extranjero"><b>¿Posee documento extranjero</b>?</label>
                        <select id="documento_extranjero" name="documento_extranjero">
                            <option value="si">Sí</option>
                            <option value="no">No</option>
                        </select>
                    </div>
                    <div class="dnicuil">
                        <div>
                            <label for="tipo_documento">Tipo de Documento:</label>
                            <select id="tipo_documento" name="tipo_documento">
                                <option value="pasaporte">Pasaporte</option>
                                <option value="cedula">Cédula</option>
                                <option value="otro">Otro</option>
                            </select>
                        </div>
                        <div>
                            <label for="numero_documento">Número de Documento:</label>
                            <input type="text" id="numero_documento" name="numero_documento">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Enviar</button>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLES
</body>
</html>