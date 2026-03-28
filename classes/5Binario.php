<?php

class Binario {
    private int $numero;

    public function __construct(int $numero) {
        $this->numero = $numero;
    }

    public function convertir(): string {
        if ($this->numero === 0) return '0';
        $n = abs($this->numero);
        $binario = '';
        while ($n > 0) {
            $binario = ($n % 2) . $binario;
            $n = intdiv($n, 2);
        }
        return ($this->numero < 0 ? '-' : '') . $binario;
    }

    public function pasos(): array {
        if ($this->numero === 0) return [['dividendo' => 0, 'cociente' => 0, 'resto' => 0]];
        $n = abs($this->numero);
        $pasos = [];
        while ($n > 0) {
            $pasos[] = [
                'dividendo' => $n,
                'cociente'  => intdiv($n, 2),
                'resto'     => $n % 2,
            ];
            $n = intdiv($n, 2);
        }
        return $pasos;
    }

    public function getNumero(): int {
        return $this->numero;
    }
}
?>