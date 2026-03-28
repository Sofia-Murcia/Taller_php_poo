<?php

class Acronimo {
    private string $frase;

    public function __construct(string $frase) {
        $this->frase = $frase;
    }

    public function convertir(): string {
        $texto = str_replace('-', ' ', $this->frase);
        $texto = preg_replace('/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/u', '', $texto);
        $palabras = preg_split('/\s+/', trim($texto));
        $acronimo = '';
        foreach ($palabras as $palabra) {
            if (!empty($palabra)) {
                $acronimo .= mb_strtoupper(mb_substr($palabra, 0, 1));
            }
        }
        return $acronimo;
    }

    public function getFrase(): string {
        return $this->frase;
    }
}
?>
