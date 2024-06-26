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
    <?php
include 'navbar_alumnos.php';
include 'autenticacion_alumno.php';
?>

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
                    <label>Provincia:</label>
                    <div class="radio">
                        <input  type="radio" id="buenosaires" name="provincia" value="buenosaires">
                        <label for="buenosaires">Buenos Aires</label>
                    </div>
                    <div class="radio">
                        <input type="radio" id="otra" name="provincia" value="otra">
                        <label for="otra">Otra Provincia</label>
                    </div>
                </div>
                <div>
                    <label for="distrito">Distrito:</label>
                    <input type="text" id="distrito" name="distrito">
                </div>
                <div>
                    <label for="localidad">Localidad:</label>
                    <input type="text" id="localidad" name="localidad">
                </div>
                <div class="espacio">
                    <label for="domicilio">Domicilio</label>
                </div>
                <div class="domicilio">
                    <label for="direccion">Direccion</label>
                    <input type="text" id="direccion" name="direccion">
                </div>
                <div class="numero">
                    <label for="numero">Numero</label>
                    <input type="text" id="numero" name="numero">
                </div>
                <div class="departamento">
                    <label for="departamento">Departamento</label>
                    <input type="text" id="departamento" name="departamento">
                </div>
                <div>
                    <label for="otros_datos">Otros Datos</label>
                </div>
                <div class="hermanos">
                    <label for="hermanos">Hermanos/as:</label>
                    <input type="text" id="hermanos" name="hermanos">
                </div>
                <div>
                    <label for="archivos">PDF reinscripción:</label>
                    <input type="file" id="archivos" name="archivos" required>
                </div>
                <br>
                <br>
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
                <div>
                    <label for="lugar_nacimiento">Lugar de nacimiento:</label>
                    <select id="lugar_nacimiento" name="lugar_nacimiento">
                        <option value="argentina">Argentina</option>
                        <option value="extranjero">Extranjero</option>
                    </select>
                </div>
                <div>
                    <label for="nacionalidad">Nacionalidad:</label>
                    <input type="text" id="nacionalidad" name="nacionalidad">
                </div>
                <br>
                <br>
                <br>
                <div class="espacio"></div>
                <div class="localidad">
                    <label for="localidad">Localidad</label>
                    <input type="text" id="localidad" name="localidad">
                </div>
                <div class="cod_postal">
                    <label for="cod_postal">Codigo postal</label>
                    <input type="text" id="cod_postal" name="cod_postal">
                </div>
                <div class="tel_fijo">
                    <label for="tel_fijo">Telefono Fijo</label>
                    <input type="text" id="tel_fijo" name="tel_fijo">
                </div>
                <br>
                <br>
                <div class="cantidad_hermanos">
                    <label for="cantidad_hermanos">Cantidad que asisten a esta escuela:</label>
                    <input type="text" id="cantidad_hermanos" name="cantidad_hermanos">
                </div>
                <div class="espacio"></div>
                <button type="submit" class="btn btn-primary">Enviar</button>
                <br>
                <br>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

<?php
// Cerrar la conexión
$conn->close();
?>