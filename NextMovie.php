<?php

declare(strict_types=1);

// Definir la clase MovieAPI para manejar la conexión a la API
class MovieAPI
{
    private const API_URL = "https://whenisthenextmcufilm.com/api";

    public static function fetchMovieData(): array
    {
        $ch = curl_init(self::API_URL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        $result = curl_exec($ch);
        curl_close($ch);

        return $result ? json_decode($result, true) : [];
    }
}

// Clase para formatear la fecha
class DateFormatter
{
    public static function formatDate($date): string
    {
        $dateTime = new DateTime($date);
        $formatter = new IntlDateFormatter(
            'es_ES',
            IntlDateFormatter::LONG,
            IntlDateFormatter::NONE
        );

        return $formatter->format($dateTime);
    }
}


// Definir la clase NextMovie
class NextMovie
{
    public function __construct(
        private int $days_until,
        private string $title,
        private string $following_producting,
        private string $release_date,
        private string $poster_url,
        private string $overview,
    ) {}

    public function getDaysUntil(): int
    {
        return $this->days_until;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getFollowingProducting(): string
    {
        return $this->following_producting;
    }

    public function getReleaseDate(): string
    {
        return $this->release_date;
    }

    public function getPosterUrl(): string
    {
        return $this->poster_url;
    }

    public function getOverview(): string
    {
        return $this->overview;
    }

    public static function createFromAPIData(array $data): self
    {
        return new self(
            (int)($data['days_until'] ?? 0),
            $data['title'] ?? 'Título no disponible',
            $data['following_producting'] ?? 'Producción no disponible',
            $data['release_date'] ?? 'Fecha no disponible',
            $data['poster_url'] ?? '',
            $data['overview'] ?? 'Sin descripción'
        );
    }
}
