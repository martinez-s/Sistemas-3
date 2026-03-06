<?php

interface EstiloStrategy
{
    public function obtenerCSS(): array; 
    public function obtenerFuente(): string; 
}

class EstiloShortNSweet implements EstiloStrategy
{
    public function obtenerCSS(): array
    {
        return [
            "--color-primario"   => "#f8c8d8",  
            "--color-secundario" => "#d1495b",  
            "--color-fondo"      => "#fff5f7",
            "--color-texto"      => "#2d1b1e",
        ];
    }

    public function obtenerFuente(): string
    {
        return "Georgia, 'Times New Roman', serif";
    }
}

class EstiloEmailsICantSend implements EstiloStrategy
{
    public function obtenerCSS(): array
    {
        return [
            "--color-primario"   => "#c8d8f8",  
            "--color-secundario" => "#4966d1",  
            "--color-fondo"      => "#f5f7ff",
            "--color-texto"      => "#1b1d2d",
        ];
    }

    public function obtenerFuente(): string
    {
        return "'Helvetica Neue', Helvetica, sans-serif"; 
    }
}

class EraMusical
{
    public string $nombreEra;
    public string $paletaColores;
    public string $tipografiaPrincipal;

    private EstiloStrategy $estrategia;

    public function __construct(string $nombreEra, EstiloStrategy $estrategia)
    {
        $this->nombreEra           = $nombreEra;
        $this->estrategia          = $estrategia;
        $this->paletaColores       = json_encode($estrategia->obtenerCSS());
        $this->tipografiaPrincipal = $estrategia->obtenerFuente();
    }

    public function mostrarEstilo(): string
    {
        $vars = $this->estrategia->obtenerCSS();
        $css  = ":root {";

        foreach ($vars as $propiedad => $valor) {
            $css .= "{$propiedad}: {$valor};";
        }
        $css .= "font-family: {$this->tipografiaPrincipal};}";

        return "<style>{$css}</style>";
    }

    public function cambiarEstrategia(EstiloStrategy $nueva): void
    {
        $this->estrategia          = $nueva;
        $this->paletaColores       = json_encode($nueva->obtenerCSS());
        $this->tipografiaPrincipal = $nueva->obtenerFuente();
    }

    public static function crearDesdeNombre(string $nombre): EraMusical
    {
        $estrategia = match (true) {
            str_contains(strtolower($nombre), 'short') => new EstiloShortNSweet(),
            str_contains(strtolower($nombre), 'email') => new EstiloEmailsICantSend(),
            default                                     => new EstiloShortNSweet(),
        };
        return new EraMusical($nombre, $estrategia);
    }
}
