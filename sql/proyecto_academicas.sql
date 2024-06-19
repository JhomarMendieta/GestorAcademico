CREATE DATABASE `proyecto_academicas`;

USE `proyecto_academicas`;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 13, 2024 at 05:50 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

START TRANSACTION;

SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */
;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */
;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */
;
/*!40101 SET NAMES utf8mb4 */
;

--
-- Database: `proyecto_academicas`
--

-- --------------------------------------------------------

--
-- Table structure for table `alumno`
--

CREATE TABLE `alumno` (
    `id` int(11) NOT NULL,
    `dni` int(8) NOT NULL,
    `legajo` int(11) NOT NULL,
    `nombres` varchar(120) NOT NULL,
    `apellidos` varchar(120) NOT NULL,
    `nacimiento` date NOT NULL,
    `direccion` varchar(120) NOT NULL,
    `telefono` varchar(30) NOT NULL,
    `tel_alternativo` int(15) NOT NULL,
    `nacionalidad` varchar(20) NOT NULL,
    `sexo` enum('Masculino', 'Femenino') NOT NULL,
    `localidad` varchar(50) NOT NULL,
    `lugar_nacimiento` varchar(100) NOT NULL,
    `foto_alumno` varchar(120) NOT NULL,
    `identidad_genero` varchar(50) NOT NULL,
    `anio_entrada` year(4) NOT NULL,
    `ficha_medica` varchar(120) NOT NULL,
    `partida_nacimiento` varchar(120) NOT NULL,
    `certificado_pase_primaria` varchar(120) NOT NULL,
    `certificado_alumno_regular` varchar(120) NOT NULL,
    `fotocopia_dni` varchar(120) NOT NULL,
    `id_responsable` int(11) DEFAULT NULL,
    `id_usuario` int(11) DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

--
-- Dumping data for table `alumno`
--

INSERT INTO
    `alumno` (
        `id`,
        `dni`,
        `legajo`,
        `nombres`,
        `apellidos`,
        `nacimiento`,
        `direccion`,
        `telefono`,
        `tel_alternativo`,
        `nacionalidad`,
        `sexo`,
        `localidad`,
        `lugar_nacimiento`,
        `foto_alumno`,
        `identidad_genero`,
        `anio_entrada`,
        `ficha_medica`,
        `partida_nacimiento`,
        `certificado_pase_primaria`,
        `certificado_alumno_regular`,
        `fotocopia_dni`,
        `id_responsable`,
        `id_usuario`
    )
VALUES (
        1,
        31231288,
        3123123,
        'Juan',
        'Doe',
        '2007-05-03',
        'Batalla la florida 1256',
        '123123',
        123123,
        'Japones',
        'Femenino',
        'Boulogne',
        'recoleta',
        'PATH',
        'varon',
        '2022',
        'PATH',
        'PATH',
        'PATH',
        'PATH',
        'PATH',
        1,
        12
    ),
    (
        6,
        46501859,
        546501859,
        'Luciano',
        'Castro',
        '2005-05-12',
        'Lukaku 2904',
        '1125438960',
        1145896321,
        'Inglés',
        'Masculino',
        'Boulogne',
        'Lujan',
        'PATH',
        'varon',
        '2022',
        'PATH',
        'PATH',
        'PATH',
        'PATH',
        'PATH',
        NULL,
        NULL
    );

-- --------------------------------------------------------

--
-- Table structure for table `alumno_curso`
--

CREATE TABLE `alumno_curso` (
    `id_curso` int(11) NOT NULL,
    `id_alumno` int(11) NOT NULL,
    `grupo` enum('a', 'b', 'NA') NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

--
-- Dumping data for table `alumno_curso`
--

INSERT INTO
    `alumno_curso` (
        `id_curso`,
        `id_alumno`,
        `grupo`
    )
VALUES (1, 1, 'a'),
    (1, 6, 'a');

-- --------------------------------------------------------

--
-- Table structure for table `alumno_mesa`
--

CREATE TABLE `alumno_mesa` (
    `id_alumno` int(11) NOT NULL,
    `id_mesa` int(11) NOT NULL,
    `calificacion` int(11) DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `asistencia`
--

CREATE TABLE `asistencia` (
    `id` int(11) NOT NULL,
    `asistencia` enum(
        'Presente',
        'Ausente',
        'Ausente con presencia',
        'Retiro anticipado'
    ) NOT NULL,
    `fecha` date NOT NULL,
    `id_materias` int(11) NOT NULL,
    `id_preceptores` int(11) NOT NULL,
    `id_alumno` int(11) DEFAULT NULL,
    `cargo` enum('Profesor', 'Alumno') NOT NULL,
    `id_profesor` int(11) DEFAULT NULL,
    `observaciones` varchar(50) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `condicion`
--

CREATE TABLE `condicion` (
    `id_alumno` int(11) NOT NULL,
    `id_materia` int(11) NOT NULL,
    `condicion` enum('TED', 'TEP', 'TEA') NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

--
-- Dumping data for table `condicion`
--

INSERT INTO
    `condicion` (
        `id_alumno`,
        `id_materia`,
        `condicion`
    )
VALUES (1, 5, 'TEP');

-- --------------------------------------------------------

--
-- Table structure for table `curso`
--

CREATE TABLE `curso` (
    `id` int(11) NOT NULL,
    `division` int(11) NOT NULL,
    `anio` int(11) NOT NULL,
    `especialidad` enum('Programación', 'Electrónica') NOT NULL,
    `anio_lectivo` year(4) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

--
-- Dumping data for table `curso`
--

INSERT INTO
    `curso` (
        `id`,
        `division`,
        `anio`,
        `especialidad`,
        `anio_lectivo`
    )
VALUES (1, 1, 1, '', '2024'),
    (2, 2, 1, '', '2024'),
    (3, 3, 1, '', '2024'),
    (4, 4, 1, '', '2024'),
    (5, 5, 1, '', '2024'),
    (6, 1, 2, '', '2024'),
    (7, 2, 2, '', '2024'),
    (8, 3, 2, '', '2024'),
    (9, 4, 2, '', '2024'),
    (10, 5, 2, '', '2024'),
    (11, 1, 3, '', '2024'),
    (12, 2, 3, '', '2024'),
    (13, 3, 3, '', '2024'),
    (14, 4, 3, '', '2024'),
    (
        15,
        1,
        4,
        'Electrónica',
        '2024'
    ),
    (
        16,
        2,
        4,
        'Electrónica',
        '2024'
    ),
    (
        17,
        3,
        4,
        'Electrónica',
        '2024'
    ),
    (
        18,
        4,
        4,
        'Programación',
        '2024'
    ),
    (
        19,
        1,
        5,
        'Electrónica',
        '2024'
    ),
    (
        20,
        2,
        5,
        'Electrónica',
        '2024'
    ),
    (
        21,
        3,
        5,
        'Programación',
        '2024'
    ),
    (
        22,
        1,
        6,
        'Electrónica',
        '2024'
    ),
    (
        23,
        2,
        6,
        'Electrónica',
        '2024'
    ),
    (
        24,
        3,
        6,
        'Programación',
        '2024'
    ),
    (
        25,
        1,
        7,
        'Electrónica',
        '2024'
    ),
    (
        26,
        2,
        7,
        'Programación',
        '2024'
    );

-- --------------------------------------------------------

--
-- Table structure for table `materia`
--

CREATE TABLE `materia` (
    `id` int(11) NOT NULL,
    `nombre` varchar(120) NOT NULL,
    `horario` varchar(120) NOT NULL,
    `id_curso` int(11) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

--
-- Dumping data for table `materia`
--

INSERT INTO
    `materia` (
        `id`,
        `nombre`,
        `horario`,
        `id_curso`
    )
VALUES (
        3,
        'Lenguajes tecnológicos I',
        '-',
        1
    ),
    (
        4,
        'Procedimientos técnicos I',
        '-',
        1
    ),
    (
        5,
        'Sistemas tecnológicos I',
        '-',
        1
    ),
    (
        6,
        'Ciencias naturales',
        '-',
        1
    ),
    (
        7,
        'Ciencias sociales',
        '-',
        1
    ),
    (
        8,
        'Construcción ciudadana',
        '-',
        1
    ),
    (
        9,
        'Educación artística',
        '-',
        1
    ),
    (
        10,
        'Educación física',
        '-',
        1
    ),
    (11, 'Inglés', '-', 1),
    (12, 'Matemática', '-', 1),
    (
        13,
        'Prácticas del lenguaje',
        '-',
        1
    ),
    (
        14,
        'Lenguajes tecnológicos I',
        '-',
        2
    ),
    (
        15,
        'Procedimientos técnicos I',
        '-',
        2
    ),
    (
        16,
        'Sistemas tecnológicos I',
        '-',
        2
    ),
    (
        17,
        'Ciencias naturales',
        '-',
        2
    ),
    (
        18,
        'Ciencias sociales',
        '-',
        2
    ),
    (
        19,
        'Construcción ciudadana',
        '-',
        2
    ),
    (
        20,
        'Educación artística',
        '-',
        2
    ),
    (
        21,
        'Educación física',
        '-',
        2
    ),
    (22, 'Inglés', '-', 2),
    (23, 'Matemática', '-', 2),
    (
        24,
        'Prácticas del lenguaje',
        '-',
        2
    ),
    (
        25,
        'Lenguajes tecnológicos I',
        '-',
        3
    ),
    (
        26,
        'Procedimientos técnicos I',
        '-',
        3
    ),
    (
        27,
        'Sistemas tecnológicos I',
        '-',
        3
    ),
    (
        28,
        'Ciencias naturales',
        '-',
        3
    ),
    (
        29,
        'Ciencias sociales',
        '-',
        3
    ),
    (
        30,
        'Construcción ciudadana',
        '-',
        3
    ),
    (
        31,
        'Educación artística',
        '-',
        3
    ),
    (
        32,
        'Educación física',
        '-',
        3
    ),
    (33, 'Inglés', '-', 3),
    (34, 'Matemática', '-', 3),
    (
        35,
        'Prácticas del lenguaje',
        '-',
        3
    ),
    (
        36,
        'Lenguajes tecnológicos I',
        '-',
        4
    ),
    (
        37,
        'Procedimientos técnicos I',
        '-',
        4
    ),
    (
        38,
        'Sistemas tecnológicos I',
        '-',
        4
    ),
    (
        39,
        'Ciencias naturales',
        '-',
        4
    ),
    (
        40,
        'Ciencias sociales',
        '-',
        4
    ),
    (
        41,
        'Construcción ciudadana',
        '-',
        4
    ),
    (
        42,
        'Educación artística',
        '-',
        4
    ),
    (
        43,
        'Educación física',
        '-',
        4
    ),
    (44, 'Inglés', '-', 4),
    (45, 'Matemática', '-', 4),
    (
        46,
        'Prácticas del lenguaje',
        '-',
        4
    ),
    (
        47,
        'Lenguajes tecnológicos I',
        '-',
        5
    ),
    (
        48,
        'Procedimientos técnicos I',
        '-',
        5
    ),
    (
        49,
        'Sistemas tecnológicos I',
        '-',
        5
    ),
    (
        50,
        'Ciencias naturales',
        '-',
        5
    ),
    (
        51,
        'Ciencias sociales',
        '-',
        5
    ),
    (
        52,
        'Construcción ciudadana',
        '-',
        5
    ),
    (
        53,
        'Educación artística',
        '-',
        5
    ),
    (
        54,
        'Educación física',
        '-',
        5
    ),
    (55, 'Inglés', '-', 5),
    (56, 'Matemática', '-', 5),
    (
        57,
        'Prácticas del lenguaje',
        '-',
        5
    ),
    (
        58,
        'Lenguajes tecnológicos II',
        '-',
        6
    ),
    (
        59,
        'Procedimientos técnicos II',
        '-',
        6
    ),
    (
        60,
        'Sistemas tecnológicos II',
        '-',
        6
    ),
    (61, 'Biología', '-', 6),
    (
        62,
        'Construcción de la ciudadanía',
        '-',
        6
    ),
    (
        63,
        'Educación artística',
        '-',
        6
    ),
    (
        64,
        'Educación física',
        '-',
        6
    ),
    (65, 'Físico-Química', '-', 6),
    (66, 'Geografía', '-', 6),
    (67, 'Historia', '-', 6),
    (68, 'Inglés', '-', 6),
    (69, 'Matemática', '-', 6),
    (
        70,
        'Prácticas del lenguaje',
        '-',
        6
    ),
    (
        71,
        'Lenguajes tecnológicos II',
        '-',
        7
    ),
    (
        72,
        'Procedimientos técnicos II',
        '-',
        7
    ),
    (
        73,
        'Sistemas tecnológicos II',
        '-',
        7
    ),
    (74, 'Biología', '-', 7),
    (
        75,
        'Construcción de la ciudadanía',
        '-',
        7
    ),
    (
        76,
        'Educación artística',
        '-',
        7
    ),
    (
        77,
        'Educación física',
        '-',
        7
    ),
    (78, 'Físico-Química', '-', 7),
    (79, 'Geografía', '-', 7),
    (80, 'Historia', '-', 7),
    (81, 'Inglés', '-', 7),
    (82, 'Matemática', '-', 7),
    (
        83,
        'Prácticas del lenguaje',
        '-',
        7
    ),
    (
        84,
        'Lenguajes tecnológicos II',
        '-',
        8
    ),
    (
        85,
        'Procedimientos técnicos II',
        '-',
        8
    ),
    (
        86,
        'Sistemas tecnológicos II',
        '-',
        8
    ),
    (87, 'Biología', '-', 8),
    (
        88,
        'Construcción de la ciudadanía',
        '-',
        8
    ),
    (
        89,
        'Educación artística',
        '-',
        8
    ),
    (
        90,
        'Educación física',
        '-',
        8
    ),
    (91, 'Físico-Química', '-', 8),
    (92, 'Geografía', '-', 8),
    (93, 'Historia', '-', 8),
    (94, 'Inglés', '-', 8),
    (95, 'Matemática', '-', 8),
    (
        96,
        'Prácticas del lenguaje',
        '-',
        8
    ),
    (
        97,
        'Lenguajes tecnológicos II',
        '-',
        9
    ),
    (
        98,
        'Procedimientos técnicos II',
        '-',
        9
    ),
    (
        99,
        'Sistemas tecnológicos II',
        '-',
        9
    ),
    (100, 'Biología', '-', 9),
    (
        101,
        'Construcción de la ciudadanía',
        '-',
        9
    ),
    (
        102,
        'Educación artística',
        '-',
        9
    ),
    (
        103,
        'Educación física',
        '-',
        9
    ),
    (104, 'Físico-Química', '-', 9),
    (105, 'Geografía', '-', 9),
    (106, 'Historia', '-', 9),
    (107, 'Inglés', '-', 9),
    (108, 'Matemática', '-', 9),
    (
        109,
        'Prácticas del lenguaje',
        '-',
        9
    ),
    (
        110,
        'Lenguajes tecnológicos II',
        '-',
        10
    ),
    (
        111,
        'Procedimientos técnicos II',
        '-',
        10
    ),
    (
        112,
        'Sistemas tecnológicos II',
        '-',
        10
    ),
    (113, 'Biología', '-', 10),
    (
        114,
        'Construcción de la ciudadanía',
        '-',
        10
    ),
    (
        115,
        'Educación artística',
        '-',
        10
    ),
    (
        116,
        'Educación física',
        '-',
        10
    ),
    (
        117,
        'Físico-Química',
        '-',
        10
    ),
    (118, 'Geografía', '-', 10),
    (119, 'Historia', '-', 10),
    (120, 'Inglés', '-', 10),
    (121, 'Matemática', '-', 10),
    (
        122,
        'Prácticas del lenguaje',
        '-',
        10
    ),
    (
        123,
        'Lenguajes tecnológicos III',
        '-',
        11
    ),
    (
        124,
        'Procedimientos técnicos III',
        '-',
        11
    ),
    (
        125,
        'Sistemas tecnológicos III',
        '-',
        11
    ),
    (126, 'Biología', '-', 11),
    (
        127,
        'Construcción ciudadana',
        '-',
        11
    ),
    (
        128,
        'Educación artística',
        '-',
        11
    ),
    (
        129,
        'Educación física',
        '-',
        11
    ),
    (
        130,
        'Físico-Química',
        '-',
        11
    ),
    (131, 'Geografía', '-', 11),
    (132, 'Historia', '-', 11),
    (133, 'Inglés', '-', 11),
    (134, 'Matemática', '-', 11),
    (
        135,
        'Prácticas del lenguaje',
        '-',
        11
    ),
    (
        136,
        'Lenguajes tecnológicos III',
        '-',
        12
    ),
    (
        137,
        'Procedimientos técnicos III',
        '-',
        12
    ),
    (
        138,
        'Sistemas tecnológicos III',
        '-',
        12
    ),
    (139, 'Biología', '-', 12),
    (
        140,
        'Construcción ciudadana',
        '-',
        12
    ),
    (
        141,
        'Educación artística',
        '-',
        12
    ),
    (
        142,
        'Educación física',
        '-',
        12
    ),
    (
        143,
        'Físico-Química',
        '-',
        12
    ),
    (144, 'Geografía', '-', 12),
    (145, 'Historia', '-', 12),
    (146, 'Inglés', '-', 12),
    (147, 'Matemática', '-', 12),
    (
        148,
        'Prácticas del lenguaje',
        '-',
        12
    ),
    (
        149,
        'Lenguajes tecnológicos III',
        '-',
        13
    ),
    (
        150,
        'Procedimientos técnicos III',
        '-',
        13
    ),
    (
        151,
        'Sistemas tecnológicos III',
        '-',
        13
    ),
    (152, 'Biología', '-', 13),
    (
        153,
        'Construcción ciudadana',
        '-',
        13
    ),
    (
        154,
        'Educación artística',
        '-',
        13
    ),
    (
        155,
        'Educación física',
        '-',
        13
    ),
    (
        156,
        'Físico-Química',
        '-',
        13
    ),
    (157, 'Geografía', '-', 13),
    (158, 'Historia', '-', 13),
    (159, 'Inglés', '-', 13),
    (160, 'Matemática', '-', 13),
    (
        161,
        'Prácticas del lenguaje',
        '-',
        13
    ),
    (
        162,
        'Lenguajes tecnológicos III',
        '-',
        14
    ),
    (
        163,
        'Procedimientos técnicos III',
        '-',
        14
    ),
    (
        164,
        'Sistemas tecnológicos III',
        '-',
        14
    ),
    (165, 'Biología', '-', 14),
    (
        166,
        'Construcción ciudadana',
        '-',
        14
    ),
    (
        167,
        'Educación artística',
        '-',
        14
    ),
    (
        168,
        'Educación física',
        '-',
        14
    ),
    (
        169,
        'Físico-Química',
        '-',
        14
    ),
    (170, 'Geografía', '-', 14),
    (171, 'Historia', '-', 14),
    (172, 'Inglés', '-', 14),
    (173, 'Matemática', '-', 14),
    (
        174,
        'Prácticas del lenguaje',
        '-',
        14
    );

-- --------------------------------------------------------

--
-- Table structure for table `materia_mesa`
--

CREATE TABLE `materia_mesa` (
    `id` int(11) NOT NULL,
    `id_materia` int(11) NOT NULL,
    `id_mesa` int(11) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

--
-- Dumping data for table `materia_mesa`
--

INSERT INTO
    `materia_mesa` (`id`, `id_materia`, `id_mesa`)
VALUES (1, 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `mesa`
--

CREATE TABLE `mesa` (
    `id` int(11) NOT NULL,
    `Instancia` enum(
        'Diciembre',
        'Febrero',
        'Previa'
    ) NOT NULL,
    `fecha` date NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

--
-- Dumping data for table `mesa`
--

INSERT INTO
    `mesa` (`id`, `Instancia`, `fecha`)
VALUES (1, 'Diciembre', '2024-12-20');

-- --------------------------------------------------------

--
-- Table structure for table `nota`
--

CREATE TABLE `nota` (
    `id` int(11) NOT NULL,
    `calificacion` int(11) DEFAULT NULL,
    `id_alumno` int(11) DEFAULT NULL,
    `id_materia` int(11) NOT NULL,
    `instancia` enum(
        'MAYO',
        'JULIO',
        'SEPTIEMBRE',
        'NOVIEMBRE'
    ) DEFAULT NULL,
    `nombre` varchar(120) DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

--
-- Dumping data for table `nota`
--

INSERT INTO
    `nota` (
        `id`,
        `calificacion`,
        `id_alumno`,
        `id_materia`,
        `instancia`,
        `nombre`
    )
VALUES (
        52,
        NULL,
        NULL,
        5,
        'JULIO',
        'INDICADOR 1: PUEDE LOGRAR etc'
    ),
    (
        55,
        3,
        1,
        5,
        'JULIO',
        'INDICADOR 1: PUEDE LOGRAR etc'
    ),
    (
        58,
        NULL,
        NULL,
        6,
        'MAYO',
        'INDICADOR 1'
    ),
    (
        59,
        NULL,
        NULL,
        6,
        'MAYO',
        'INDICADOR 1'
    ),
    (
        60,
        NULL,
        NULL,
        6,
        'MAYO',
        'INDICADOR 8'
    ),
    (
        61,
        NULL,
        NULL,
        6,
        'MAYO',
        'INDICADOR 8'
    ),
    (
        62,
        NULL,
        NULL,
        8,
        'MAYO',
        'INDICADOR 1'
    );

-- --------------------------------------------------------

--
-- Table structure for table `preceptores`
--

CREATE TABLE `preceptores` (
    `id` int(11) NOT NULL,
    `nombre` text NOT NULL,
    `apellido` text NOT NULL,
    `nacionalidad` varchar(20) NOT NULL,
    `num_tel` int(15) NOT NULL,
    `num_cel` int(15) NOT NULL,
    `domicilio` varchar(30) NOT NULL,
    `fecha_nacimiento` date NOT NULL,
    `fecha_ingreso` date NOT NULL,
    `mail_institucional` varchar(100) NOT NULL,
    `mail_personal` int(11) NOT NULL,
    `titulo_que_posee` varchar(1000) NOT NULL,
    `antiguedad` varchar(10) NOT NULL,
    `id_usuario` int(11) DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `preceptor_curso`
--

CREATE TABLE `preceptor_curso` (
    `id_curso` int(11) NOT NULL,
    `id_preceptor` int(11) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `profesores`
--

CREATE TABLE `profesores` (
    `numLegajo` int(11) NOT NULL,
    `prof_nombre` text NOT NULL,
    `prof_apellido` text NOT NULL,
    `dni` int(8) NOT NULL,
    `num_tel` int(15) NOT NULL,
    `num_cel` int(15) NOT NULL,
    `tel_alternativo` int(15) NOT NULL,
    `edad` int(2) NOT NULL,
    `fecha_nacimiento` date NOT NULL,
    `domicilio` varchar(25) NOT NULL,
    `mail` varchar(50) NOT NULL,
    `titulo` varchar(50) NOT NULL,
    `fecha_ingreso` date NOT NULL,
    `id_usuario` int(11) DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

--
-- Dumping data for table `profesores`
--

INSERT INTO
    `profesores` (
        `numLegajo`,
        `prof_nombre`,
        `prof_apellido`,
        `dni`,
        `num_tel`,
        `num_cel`,
        `tel_alternativo`,
        `edad`,
        `fecha_nacimiento`,
        `domicilio`,
        `mail`,
        `titulo`,
        `fecha_ingreso`,
        `id_usuario`
    )
VALUES (
        78979879,
        'Hernan',
        'Hernan',
        31231245,
        1122225555,
        1166668888,
        1111231233,
        25,
        '1994-05-03',
        'Batalla 1235',
        'figueroa@gmail.com',
        'Tecnico',
        '2024-05-01',
        1
    ),
    (
        234791231,
        'York',
        'Mansilla',
        45689201,
        1577778888,
        1199996666,
        1155554444,
        23,
        '2001-04-21',
        'Batalla 1235',
        'york@gmail.com',
        'Tecnico',
        '2024-05-01',
        11
    );

-- --------------------------------------------------------

--
-- Table structure for table `profesor_materia`
--

CREATE TABLE `profesor_materia` (
    `id_profesor_materia` int(11) NOT NULL,
    `id_profesor` int(11) NOT NULL,
    `id_materia` int(11) NOT NULL,
    `grupo` enum('a', 'b', 'NA') NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

--
-- Dumping data for table `profesor_materia`
--

INSERT INTO
    `profesor_materia` (
        `id_profesor_materia`,
        `id_profesor`,
        `id_materia`,
        `grupo`
    )
VALUES (4, 78979879, 6, 'NA'),
    (5, 78979879, 5, 'NA'),
    (6, 78979879, 152, 'a'),
    (7, 234791231, 8, 'a');

-- --------------------------------------------------------

--
-- Table structure for table `reinscripcion`
--

CREATE TABLE `reinscripcion` (
    `id` int(11) NOT NULL,
    `id_alumno` int(11) NOT NULL,
    `nombre` varchar(100) NOT NULL,
    `apellido` varchar(100) NOT NULL,
    `nacimiento` date NOT NULL,
    `posee_pre_identificacion` tinyint(1) NOT NULL,
    `posee_dni_arg` varchar(100) NOT NULL,
    `dni` int(11) NOT NULL,
    `cuil` varchar(20) NOT NULL,
    `posee_doc_ext` tinyint(1) NOT NULL,
    `tipo_doc_ext` varchar(20) NOT NULL,
    `nro_doc_ext` int(11) NOT NULL,
    `archivo` varchar(255) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `responsable`
--

CREATE TABLE `responsable` (
    `id` int(11) NOT NULL,
    `nombre` varchar(30) NOT NULL,
    `apellido` varchar(30) NOT NULL,
    `dni` int(10) NOT NULL,
    `telefono` int(15) NOT NULL,
    `otros_datos` varchar(255) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

--
-- Dumping data for table `responsable`
--

INSERT INTO
    `responsable` (
        `id`,
        `nombre`,
        `apellido`,
        `dni`,
        `telefono`,
        `otros_datos`
    )
VALUES (
        1,
        'francisco',
        'rocchi',
        12312332,
        1121637315,
        'asdasdasd'
    );

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE `usuario` (
    `id` int(11) NOT NULL,
    `nombre_usuario` varchar(50) NOT NULL,
    `mail` varchar(100) NOT NULL,
    `contrasenia` varchar(50) NOT NULL,
    `rol` enum(
        'master',
        'profesor',
        'alumno',
        'preceptor'
    ) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

--
-- Dumping data for table `usuario`
--

INSERT INTO
    `usuario` (
        `id`,
        `nombre_usuario`,
        `mail`,
        `contrasenia`,
        `rol`
    )
VALUES (
        1,
        'figueroa_hernan',
        'figueroa@gmail.com',
        '123456',
        'profesor'
    ),
    (
        11,
        'york_munoz',
        'york@gmail.com',
        '123456',
        'profesor'
    ),
    (
        12,
        'juan_doe',
        'juandoe@gmail.com',
        '123456',
        'alumno'
    );

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alumno`
--
ALTER TABLE `alumno`
ADD PRIMARY KEY (`id`),
ADD KEY `dni` (`dni`),
ADD KEY `id_responsable` (`id_responsable`),
ADD KEY `id_usuario` (`id_usuario`);

--
-- Indexes for table `alumno_curso`
--
ALTER TABLE `alumno_curso`
ADD KEY `id_curso` (`id_curso`),
ADD KEY `id_alumno` (`id_alumno`);

--
-- Indexes for table `alumno_mesa`
--
ALTER TABLE `alumno_mesa`
ADD KEY `id_alumno` (`id_alumno`),
ADD KEY `id_mesa` (`id_mesa`);

--
-- Indexes for table `asistencia`
--
ALTER TABLE `asistencia`
ADD PRIMARY KEY (`id`),
ADD KEY `id_materias` (
    `id_materias`,
    `id_preceptores`,
    `id_alumno`
),
ADD KEY `id_preceptores` (`id_preceptores`),
ADD KEY `id_dni` (`id_alumno`),
ADD KEY `dni_profesor` (`id_profesor`);

--
-- Indexes for table `condicion`
--
ALTER TABLE `condicion`
ADD KEY `id_alumno` (`id_alumno`),
ADD KEY `id_materia` (`id_materia`);

--
-- Indexes for table `curso`
--
ALTER TABLE `curso` ADD PRIMARY KEY (`id`);

--
-- Indexes for table `materia`
--
ALTER TABLE `materia`
ADD PRIMARY KEY (`id`),
ADD KEY `id_curso` (`id_curso`);

--
-- Indexes for table `materia_mesa`
--
ALTER TABLE `materia_mesa`
ADD PRIMARY KEY (`id`),
ADD KEY `id_materia` (`id_materia`),
ADD KEY `id_mesa` (`id_mesa`);

--
-- Indexes for table `mesa`
--
ALTER TABLE `mesa` ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nota`
--
ALTER TABLE `nota`
ADD PRIMARY KEY (`id`),
ADD KEY `id_alumno` (`id_alumno`),
ADD KEY `id_materia` (`id_materia`);

--
-- Indexes for table `preceptores`
--
ALTER TABLE `preceptores`
ADD PRIMARY KEY (`id`),
ADD KEY `id_usuario` (`id_usuario`);

--
-- Indexes for table `preceptor_curso`
--
ALTER TABLE `preceptor_curso`
ADD KEY `id_curso` (`id_curso`),
ADD KEY `id_preceptor` (`id_preceptor`);

--
-- Indexes for table `profesores`
--
ALTER TABLE `profesores`
ADD PRIMARY KEY (`numLegajo`),
ADD KEY `dni` (`dni`),
ADD KEY `id_usuario` (`id_usuario`);

--
-- Indexes for table `profesor_materia`
--
ALTER TABLE `profesor_materia`
ADD PRIMARY KEY (`id_profesor_materia`),
ADD KEY `id_profesor` (`id_profesor`),
ADD KEY `id_materia` (`id_materia`);

--
-- Indexes for table `reinscripcion`
--
ALTER TABLE `reinscripcion`
ADD PRIMARY KEY (`id`),
ADD KEY `id_alumno` (`id_alumno`);

--
-- Indexes for table `responsable`
--
ALTER TABLE `responsable` ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario` ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alumno`
--
ALTER TABLE `alumno`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 10;

--
-- AUTO_INCREMENT for table `asistencia`
--
ALTER TABLE `asistencia`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 7;

--
-- AUTO_INCREMENT for table `curso`
--
ALTER TABLE `curso`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 27;

--
-- AUTO_INCREMENT for table `materia`
--
ALTER TABLE `materia`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 175;

--
-- AUTO_INCREMENT for table `materia_mesa`
--
ALTER TABLE `materia_mesa`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 2;

--
-- AUTO_INCREMENT for table `mesa`
--
ALTER TABLE `mesa`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 2;

--
-- AUTO_INCREMENT for table `nota`
--
ALTER TABLE `nota`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 63;

--
-- AUTO_INCREMENT for table `profesor_materia`
--
ALTER TABLE `profesor_materia`
MODIFY `id_profesor_materia` int(11) NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 8;

--
-- AUTO_INCREMENT for table `reinscripcion`
--
ALTER TABLE `reinscripcion`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `responsable`
--
ALTER TABLE `responsable`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 2;

--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `alumno`
--
ALTER TABLE `alumno`
ADD CONSTRAINT `alumno_ibfk_1` FOREIGN KEY (`id_responsable`) REFERENCES `responsable` (`id`),
ADD CONSTRAINT `alumno_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`);

--
-- Constraints for table `alumno_curso`
--
ALTER TABLE `alumno_curso`
ADD CONSTRAINT `alumno_curso_ibfk_1` FOREIGN KEY (`id_alumno`) REFERENCES `alumno` (`id`),
ADD CONSTRAINT `alumno_curso_ibfk_2` FOREIGN KEY (`id_curso`) REFERENCES `curso` (`id`);

--
-- Constraints for table `alumno_mesa`
--
ALTER TABLE `alumno_mesa`
ADD CONSTRAINT `alumno_mesa_ibfk_1` FOREIGN KEY (`id_alumno`) REFERENCES `alumno` (`id`),
ADD CONSTRAINT `alumno_mesa_ibfk_2` FOREIGN KEY (`id_mesa`) REFERENCES `mesa` (`id`);

--
-- Constraints for table `asistencia`
--
ALTER TABLE `asistencia`
ADD CONSTRAINT `asistencia_ibfk_1` FOREIGN KEY (`id_profesor`) REFERENCES `profesores` (`numLegajo`),
ADD CONSTRAINT `asistencia_ibfk_2` FOREIGN KEY (`id_preceptores`) REFERENCES `preceptores` (`id`),
ADD CONSTRAINT `asistencia_ibfk_3` FOREIGN KEY (`id_alumno`) REFERENCES `alumno` (`id`),
ADD CONSTRAINT `asistencia_ibfk_4` FOREIGN KEY (`id_materias`) REFERENCES `materia` (`id`);

--
-- Constraints for table `condicion`
--
ALTER TABLE `condicion`
ADD CONSTRAINT `condicion_ibfk_1` FOREIGN KEY (`id_alumno`) REFERENCES `alumno` (`id`),
ADD CONSTRAINT `condicion_ibfk_2` FOREIGN KEY (`id_materia`) REFERENCES `materia` (`id`);

--
-- Constraints for table `materia`
--
ALTER TABLE `materia`
ADD CONSTRAINT `materia_ibfk_1` FOREIGN KEY (`id_curso`) REFERENCES `curso` (`id`);

--
-- Constraints for table `materia_mesa`
--
ALTER TABLE `materia_mesa`
ADD CONSTRAINT `materia_mesa_ibfk_1` FOREIGN KEY (`id_mesa`) REFERENCES `mesa` (`id`),
ADD CONSTRAINT `materia_mesa_ibfk_2` FOREIGN KEY (`id_materia`) REFERENCES `materia` (`id`);

--
-- Constraints for table `nota`
--
ALTER TABLE `nota`
ADD CONSTRAINT `nota_ibfk_1` FOREIGN KEY (`id_alumno`) REFERENCES `alumno` (`id`),
ADD CONSTRAINT `nota_ibfk_2` FOREIGN KEY (`id_materia`) REFERENCES `materia` (`id`);

--
-- Constraints for table `preceptores`
--
ALTER TABLE `preceptores`
ADD CONSTRAINT `preceptores_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`);

--
-- Constraints for table `preceptor_curso`
--
ALTER TABLE `preceptor_curso`
ADD CONSTRAINT `preceptor_curso_ibfk_1` FOREIGN KEY (`id_preceptor`) REFERENCES `preceptores` (`id`),
ADD CONSTRAINT `preceptor_curso_ibfk_2` FOREIGN KEY (`id_curso`) REFERENCES `curso` (`id`);

--
-- Constraints for table `profesores`
--
ALTER TABLE `profesores`
ADD CONSTRAINT `profesores_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`);

--
-- Constraints for table `profesor_materia`
--
ALTER TABLE `profesor_materia`
ADD CONSTRAINT `profesor_materia_ibfk_3` FOREIGN KEY (`id_profesor`) REFERENCES `profesores` (`numLegajo`),
ADD CONSTRAINT `profesor_materia_ibfk_4` FOREIGN KEY (`id_materia`) REFERENCES `materia` (`id`);

--
-- Constraints for table `reinscripcion`
--
ALTER TABLE `reinscripcion`
ADD CONSTRAINT `reinscripcion_ibfk_1` FOREIGN KEY (`id_alumno`) REFERENCES `alumno` (`id`);

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */
;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */
;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */
;