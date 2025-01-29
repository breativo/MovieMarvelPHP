#### Proyecto: Movie Marvel API
#### Lenguaje: PHP
#### Autor: breativo

# Movie Marvel API
![PHP](https://img.shields.io/badge/PHP-8.4-blue)


## **Descripción**

Este proyecto es una aplicación web en PHP que consume una API externa para mostrar información sobre la próxima película del Universo Cinematográfico de Marvel.

Se muestra:

- **Título de la película.**
- **Fecha de estreno** (formato español).
- **Póster promocional.**
- **Descripción breve de la película.**
- **Días restantes hasta el estreno.**
- **Modo oscuro y modo claro**, que se puede alternar con un botón.  

La interfaz es sencilla y amigable, con un diseño centrado en la accesibilidad.


## **Requisitos previos**

- Tener instalado `PHP 8.1 o superior.`
- Asegurarse de que las `extensiones curl e intl` están habilitadas.
- Tener `acceso a internet` para conectar con la API externa.

## **Conexión a la API**

Este código inicializa una **conexión cURL para obtener datos de la API externa**:

````PHP
const API_URL = "https://whenisthenextmcufilm.com/api";
$ch = curl_init(API_URL);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
$result = curl_exec($ch);
if ($result === false) {
    echo "<p>Error al obtener los datos. Por favor, intenta más tarde.</p>";
    $data = [];
} else {
    $data = json_decode($result, true);
}
curl_close($ch);
````

## **Formateo de la fecha**

El **formateo de la fecha** se realiza utilizando **IntlDateFormatter** para mostrarla en formato español:

````PHP
<?php
if (isset($data["release_date"])) {
    $date = new DateTime($data["release_date"]);
    echo $date->format('d F Y');  // Ejemplo: "29 enero 2025"
} else {
    echo "Fecha no disponible";
}
?>

````

## **Iniciar el servidor**

Para probar la aplicación localmente, utiliza el comando:


````PHP
php -S localhost:8000
````

## **Capturas de pantalla**

<div style="text-align: center;">
  <img src="TemaClaro.png" alt="Api Movie Marvel" style="margin: auto; width: 100%; height: auto;">
</div>
</br>
<div style="text-align: center;">
  <img src="TemaOscuro.png" alt="Api Movie Marvel" style="margin: auto; width: 100%; height: auto;">
</div>

## **URL del proyecto**

[URL del proyecto](https://moviemarvelphp.zeabur.app/)

## ¡Apóyame! 
#### Puedes apoyar mi trabajo haciendo "☆ Star" en el repositorio. ¡Gracias!



### En mi perfil de GitHub tienes más información

[![Web](https://img.shields.io/badge/GitHub-breativo-14a1f0?style=for-the-badge&logo=github&logoColor=white&labelColor=101010)](https://github.com/breativo)