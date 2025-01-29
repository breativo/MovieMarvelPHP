<?php
// Incluir el archivo con la clase NextMovie
require_once 'NextMovie.php';

// Obtener los datos de la película desde la API
$data = MovieAPI::fetchMovieData();

// Si los datos están disponibles, crear el objeto de la película
$movie = null;
if (!empty($data)) {
    $movie = NextMovie::createFromAPIData($data);
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Próxima Película Marvel</title>

    <!-- Cargar los estilos genrales del fichero style.css -->
    <link rel="stylesheet" href="style.css">

    <!-- Cargar Font Awesome para los iconos del botón de cambio de tema -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>


    <!-- Botón de cambio de tema -->
    <button id="theme-toggle" aria-label="Cambiar tema" title="Cambiar tema">
        <i id="theme-icon" class="fa-solid fa-moon"></i>
    </button>

    <?php if ($movie): ?>
        <div class="card">
            <!-- Mostrar el póster de la película -->
            <?php if (!empty($movie->getPosterUrl())): ?>
                <img src="<?= htmlspecialchars($movie->getPosterUrl()) ?>" alt="Póster de la película">
            <?php endif; ?>

            <!-- Mostrar el título de la película -->
            <h1 class="title"><?= htmlspecialchars($movie->getTitle()) ?></h1>

            <!-- Mostrar la fecha de lanzamiento -->
            <p>
                <?php
                $releaseDate = new DateTime($movie->getReleaseDate());
                echo $releaseDate->format('d \d\e F \d\e Y');
                ?>
            </p>

            <!-- Mostrar los días restantes -->
            <span>
                <?= $movie->getDaysUntil() ?> remaining days

            </span>

            <!-- Mostrar la descripción de la película -->
            <p><?= htmlspecialchars($movie->getOverview()) ?></p>
        </div>
    <?php else: ?>
        <p>No se pudo obtener la información de la película.</p>
    <?php endif; ?>



    <script src="temaClaroOscuro.js"></script>

</body>

</html>