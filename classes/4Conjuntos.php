<?php

class Conjuntos {
    private array $A;
    private array $B;

    public function __construct(array $A, array $B) {
        $this->A = array_values(array_unique(array_map('intval', $A)));
        $this->B = array_values(array_unique(array_map('intval', $B)));
    }

    public function union(): array {
        $union = array_unique(array_merge($this->A, $this->B));
        sort($union);
        return array_values($union);
    }

    public function interseccion(): array {
        $inter = array_intersect($this->A, $this->B);
        sort($inter);
        return array_values($inter);
    }

    public function diferenciaAB(): array {
        $diff = array_diff($this->A, $this->B);
        sort($diff);
        return array_values($diff);
    }

    public function diferenciaBA(): array {
        $diff = array_diff($this->B, $this->A);
        sort($diff);
        return array_values($diff);
    }

    public function getA(): array { return $this->A; }
    public function getB(): array { return $this->B; }
}
?>