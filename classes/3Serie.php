<?php

class Serie {
    private array $numeros;

    public function __construct(array $numeros) {
        $this->numeros = array_map('floatval', $numeros);
    }

    public function promedio(): float {
        if (empty($this->numeros)) return 0;
        return array_sum($this->numeros) / count($this->numeros);
    }

    public function mediana(): float {
        if (empty($this->numeros)) return 0;
        $sorted = $this->numeros;
        sort($sorted);
        $n = count($sorted);
        $medio = intdiv($n, 2);
        if ($n % 2 === 0) {
            return ($sorted[$medio - 1] + $sorted[$medio]) / 2;
        }
        return $sorted[$medio];
    }

    public function moda(): array {
        if (empty($this->numeros)) return [];
        $frecuencias = array_count_values(array_map('strval', $this->numeros));
        $maxFreq = max($frecuencias);
        $modas = [];
        foreach ($frecuencias as $valor => $freq) {
            if ($freq === $maxFreq) {
                $modas[] = (float)$valor;
            }
        }
        sort($modas);
        return $modas;
    }

    public function getNumeros(): array {
        return $this->numeros;
    }
}
?>