<?php
// Archivo: models/SitioWeb.php

class SitioWeb
{
    public $tituloSitio = "Sabrina Carpenter Official";
    public $urlOficial = "https://sabrinacarpenter.com";
    public array $redesSociales;
    
    private static ?SitioWeb $instancia = null;

    private function __construct()
    {
        $this->tituloSitio   = "Sabrina Carpenter - Sitio Oficial";
        $this->urlOficial    = "https://sabrinacarpenter.com";
        $this->redesSociales = [
            "instagram" => "https://www.instagram.com/sabrinacarpenter",
            "tiktok"    => "https://www.tiktok.com/@sabrinacarpenter",
            "spotify"   => "https://open.spotify.com/artist/74KM79TiuVkeSDWKoJOu08",
            "youtube"   => "https://www.youtube.com/@SabrinaCarpenter",
        ];
    }

    public static function obtenerInstancia(): SitioWeb
    {
        if (self::$instancia === null) {
            self::$instancia = new SitioWeb();
        }
        return self::$instancia;
    }

    public function configurarSEO(string $descripcion = ""): array
    {
        return [
            "title"       => $this->tituloSitio,
            "description" => $descripcion ?: "Sitio oficial de Sabrina Carpenter.",
            "og_url"      => $this->urlOficial,
        ];
    }

    private function __clone() {}
    public function __wakeup()
    {
        throw new \Exception("No se puede deserializar un Singleton.");
    }
}
