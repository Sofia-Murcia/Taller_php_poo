<?php

class Calculadora {
    private float $a;
    private float $b;
    private string $operacion;

    public function __construct(float $a, float $b, string $operacion) {
        $this->a = $a;
        $this->b = $b;
        $this->operacion = $operacion;
    }

    public function calcular(): float|string {
        return match($this->operacion) {
            '+'  => $this->a + $this->b,
            '-'  => $this->a - $this->b,
            '*'  => $this->a * $this->b,
            '/'  => $this->b != 0 ? $this->a / $this->b : 'Error: División por cero',
            '%'  => $this->b != 0 ? fmod($this->a, $this->b) : 'Error: División por cero',
            default => 'Operación no válida',
        };
    }

    public function getExpresion(): string {
        return "{$this->a} {$this->operacion} {$this->b}";
    }

    public function getA(): float { return $this->a; }
    public function getB(): float { return $this->b; }
    public function getOperacion(): string { return $this->operacion; }
}
?>