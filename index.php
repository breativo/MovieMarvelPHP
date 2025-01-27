<!-- Codigo PHP -->
<?php
// Definir la constante con la URL de la API
const API_URL = "https://whenisthenextmcufilm.com/api";

// Inicializar cURL para hacer la solicitud HTTP a la API
$ch = curl_init(API_URL);

// Configurar opciones de cURL
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Recibir respuesta como string
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Deshabilitar la verificación del certificado SSL
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // No verificar el host SSL
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Seguir redirecciones si las hay

// Ejecutar la solicitud y almacenar el resultado
$result = curl_exec($ch);

// Verificar si hubo un error durante la solicitud
if ($result === false) {
    // Mostrar mensaje de error si cURL falla
    echo "<p>Error al obtener los datos. Por favor, intenta más tarde.</p>";
    $data = []; // Definir $data como un array vacío para evitar errores posteriores
} else {
    // Convertir el resultado JSON en un array asociativo
    $data = json_decode($result, true);
}

// Cerrar el recurso cURL
curl_close($ch);

// Configurar la localización para mostrar meses en español
setlocale(LC_TIME, "es_ES.UTF-8");
?>

<!-- Codigo HTML -->
<main>
    <h1 class="title_page">La próxima película Marvel</h1>
    <!-- Tarjeta para mostrar los datos de la película -->
    <div class="card">
        <section>
            <?php
            // Comprobar si la URL del póster existe antes de mostrarla
            if (isset($data["poster_url"])): ?>
                <img src="<?= htmlspecialchars($data["poster_url"]) ?>" alt="poster pelicula">
            <?php endif; ?>
        </section>
        <hgroup>
            <h1 class="title">
                <!-- Mostrar el título de la película, asegurando que el dato está disponible -->
                <?= htmlspecialchars($data["title"] ?? "Título no disponible", ENT_QUOTES, 'UTF-8'); ?>
            </h1>
            <p>
                <!-- Mostrar la fecha de estreno en formato español -->
                <?= isset($data["release_date"]) ? strftime("%d de %B de %Y", strtotime($data["release_date"])) : "Fecha no disponible"; ?>
                <span>
                    <!-- Mostrar los días restantes para el estreno, si están disponibles -->
                    <?= isset($data["days_until"]) ? htmlspecialchars($data["days_until"] . " días pendientes") : ""; ?>
                </span>
            </p>
            <br>
            <p>
                <!-- Mostrar la descripción de la película -->
                <?= htmlspecialchars($data["overview"] ?? "Sin descripción", ENT_QUOTES, 'UTF-8'); ?>
            </p>
        </hgroup>
    </div>
</main>

<!-- Codigo estilos -->
<style>
    /* Estilo general de la página */
    :root {
        color-scheme: light dark;
        /* Soporte para temas claro/oscuro */
    }

    body {
        margin: 0;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100vh;
        background-color: rgb(15, 14, 14);
    }

    /* Estilo de la tarjeta */
    .card {
        text-align: center;
        padding: 20px;
        background: white;
        border-radius: 15px;
        background-color: #f4f4f4;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        max-width: 400px;
    }

    /* Estilo para la imagen */
    img {
        border-radius: 15px;
        max-width: 100%;
        height: auto;
        margin-bottom: 20px;
    }

    /* Estilo del título */
    .title {
        font-size: 1.5rem;
        margin: 0 0 10px;
        color: rgb(15, 14, 14);
    }

    .title_page {
        font-size: 1.5rem;
        margin: 0 0 10px;
        color: rgb(255, 255, 255);
    }

    /* Estilo para el párrafo */
    p {
        font-size: 1rem;
        margin: 0;
        color: #555;
        text-align: start;

    }

    /* Estilo para el texto destacado */
    span {
        color: red;
        font-weight: bold;
        margin-left: 5px;
    }
</style>