<?php

class Beitrag
{
    private int $id;
    private Account $creator;
    private string $title;
    private string $picture;
    private string $description;
    private string $location;
    private string $lat;
    private string $lng;

    public function __construct(int $id, Account $creator, string $title, string $picture, string $description, string $location, string $lat, string $lng)
    {
        $this->id = $id;
        $this->creator = $creator;
        $this->title = $title;
        $this->picture = $picture;
        $this->description = $description;
        $this->location = $location;
        $this->lat = $lat;
        $this->lng = $lng;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCreator(): Account
    {
        return $this->creator;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getPicture(): string
    {
        return $this->picture;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getLocation(): string
    {
        return $this->location;
    }

    public function getLat(): string
    {
        return $this->lat;
    }
    public function getLng(): string
    {
        return $this->lng;
    }

    public function toArray(): Array
    {
        return [
            'id' => $this->id,
            'title'=> $this->title,
            'location' => $this->location,
            'lat' => $this->lat,
            'lng' => $this->lng,
        ];
    }

    static function getCoordinatesFromAddress(string $address) : ?array {
        $address = urlencode($address);
        $url = "https://nominatim.openstreetmap.org/search?q={$address}&format=json";

        // cURL initialisieren
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Optional, falls HTTPS-Probleme auftreten
        curl_setopt($ch, CURLOPT_USERAGENT, "UniProjekt/1.0 (julian.haase@uol.de)"); // Benutzerdefinierter User-Agent

        // Anfrage ausführen und Antwort speichern
        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        // Prüfe auf cURL-Fehler
        if ($response === false) {
            echo "cURL-Fehler: " . $error;
            return [
                'lat' => 53.14414935510071,
                'lng' => 8.223154596861308
            ];
        }

        // JSON-Antwort dekodieren
        $data = json_decode($response, true);

        // Prüfen, ob die Antwort gültige Daten enthält
        if (!empty($data) && isset($data[0]['lat']) && isset($data[0]['lon'])) {
            return [
                'lat' => $data[0]['lat'],
                'lng' => $data[0]['lon']
            ];
        } else {
            echo "Keine gültigen Geodaten für die Adresse gefunden.";
            return [
                'lat' => 53.14414935510071,
                'lng' => 8.223154596861308
            ];
        }
    }
}