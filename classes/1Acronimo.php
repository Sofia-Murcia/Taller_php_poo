<?php
class Acronimo {
    private string $frase;

    public function __construct(string $frase) {
        $this->frase = $frase;
    }

    public function convertir(): string {
        // Reemplaza guiones por espacios
        $texto = str_replace('-', ' ', $this->frase);
        // Elimina signos de puntuación excepto espacios y letras
        $texto = preg_replace('/[^a-zA-Z\s]/', '', $texto);
        // Obtiene la primera letra de cada palabra en mayúscula
        $palabras = explode(' ', trim($texto));
        $acronimo = '';
        foreach ($palabras as $palabra) {
            if (!empty($palabra)) {
                $acronimo .= strtoupper($palabra[0]);
            }
        }
        return $acronimo;
    }
}
?>
