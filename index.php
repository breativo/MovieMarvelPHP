<?php
// Definir la constante con la URL de la API que proporciona la información de la próxima película del MCU
const API_URL = "https://whenisthenextmcufilm.com/api";

// Inicializar cURL para hacer la solicitud HTTP a la API
$ch = curl_init(API_URL);

// Configurar opciones de cURL
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Indica que queremos recibir el resultado como una cadena
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Deshabilita la verificación SSL (no recomendado en producción)
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // Evita errores en algunos servidores
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Permite redireccionamientos si la URL cambia

// Ejecutar la solicitud y almacenar el resultado en $result
$result = curl_exec($ch);

// Verificar si hubo un error en la solicitud
if ($result === false) {
    echo "<p>Error al obtener los datos. Por favor, intenta más tarde.</p>";
    $data = []; // En caso de error, se define un array vacío para evitar problemas
} else {
    $data = json_decode($result, true); // Decodificar la respuesta JSON en un array asociativo
}

// Cerrar la sesión cURL
curl_close($ch);

// Configurar la localización para mostrar los nombres de los meses en español
setlocale(LC_TIME, 'es_ES', 'es_ES.utf8', 'spanish');
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Próxima Película Marvel</title>

    <!-- Cargar Font Awesome para los iconos del botón de cambio de tema -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        /* Estilos generales */
        :root {
            color-scheme: light dark;
        }

        body {
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-color: rgb(15, 14, 14);
            color: #fff;
            font-family: Arial, sans-serif;
        }

        /* Botón de cambio de tema */
        #theme-toggle {
            position: fixed;
            top: 20px;
            right: 20px;
            background: none;
            border: none;
            font-size: 1.2rem;
            cursor: pointer;
            color: white;
        }

        body.light-mode #theme-toggle {
            color: black;
        }

        /* Modo claro */
        body.light-mode {
            background-color: #f4f4f4;
            color: #333;
        }

        /* Tarjeta de la película */
        .card {
            padding: 20px;
            border-radius: 15px;
            background-color: #f4f4f4;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 400px;
        }

        /* Estilos de la imagen */
        img {
            border-radius: 15px;
            max-width: 100%;
            height: auto;
            margin-bottom: 20px;
        }

        /* Estilo del título */
        .title {
            font-size: 1.2rem;
            color: rgb(15, 14, 14);
        }

        /* Estilos del texto */
        p {
            font-size: 1rem;
            color: #555;
            text-align: start;
        }

        span {
            color: red;
            font-weight: bold;
            margin-left: 5px;
        }
    </style>
</head>

<body>

    <!-- Botón de cambio de tema -->
    <button id="theme-toggle" aria-label="Cambiar tema" title="Cambiar tema">
        <i id="theme-icon" class="fa-solid fa-moon"></i>
    </button>

    <!-- Tarjeta con la información de la película -->
    <div class="card">
        <section>
            <?php if (!empty($data["poster_url"])): ?>
                <img src="<?= htmlspecialchars($data["poster_url"]) ?>" alt="Póster de la película">
            <?php endif; ?>
        </section>
        <hgroup>
            <h1 class="title">
                <?= htmlspecialchars($data["title"] ?? "Título no disponible", ENT_QUOTES, 'UTF-8'); ?>
            </h1>
            <p>
                <?php
                if (!empty($data["release_date"])) {
                    $date = new DateTime($data["release_date"]);
                    echo date_format($date, 'd \d\e F \d\e Y'); // Mostrar la fecha en formato día de mes de año
                } else {
                    echo "Fecha no disponible";
                }
                ?>
                <br>
                <span>
                    <?= isset($data["days_until"]) ? htmlspecialchars($data["days_until"] . " días restantes", ENT_QUOTES, 'UTF-8') : ""; ?>
                </span>
            </p>
            <br>
            <p>
                <?= htmlspecialchars($data["overview"] ?? "Sin descripción", ENT_QUOTES, 'UTF-8'); ?>
            </p>
        </hgroup>
    </div>

    <script>
        // Obtener referencias a los elementos del botón de cambio de tema
        const themeToggle = document.getElementById('theme-toggle');
        const themeIcon = document.getElementById('theme-icon');

        // Verificar si el usuario ya tenía guardado un tema preferido
        if (localStorage.getItem('theme') === 'light') {
            document.body.classList.add('light-mode');
            themeIcon.classList.replace('fa-moon', 'fa-sun');
        }

        // Evento de clic para cambiar entre modo claro y oscuro
        themeToggle.addEventListener('click', () => {
            document.body.classList.toggle('light-mode');

            if (document.body.classList.contains('light-mode')) {
                themeIcon.classList.replace('fa-moon', 'fa-sun');
                localStorage.setItem('theme', 'light'); // Guardar la preferencia en localStorage
            } else {
                themeIcon.classList.replace('fa-sun', 'fa-moon');
                localStorage.setItem('theme', 'dark'); // Guardar la preferencia en localStorage
            }
        });
    </script>

</body>

</html>