<?php

class ORDEN {
    public string $valor;
    public ?NodoArbol $izquierdo;
    public ?NodoArbol $derecho;

    public function __construct(string $valor) {
        $this->valor     = $valor;
        $this->izquierdo = null;
        $this->derecho   = null;
    }
}

class ArbolBinario {
    private ?NodoArbol $raiz = null;

    /**
     * Construye el árbol a partir de preorden e inorden.
     */
    public function construirDesdePreorderInorder(array $preorden, array $inorden): void {
        $this->raiz = $this->buildPI($preorden, $inorden);
    }

    private function buildPI(array $pre, array $ino): ?NodoArbol {
        if (empty($pre) || empty($ino)) return null;
        $raizValor = $pre[0];
        $nodo = new NodoArbol($raizValor);
        $idx = array_search($raizValor, $ino);
        if ($idx === false) return $nodo;

        $inoIzq = array_slice($ino, 0, $idx);
        $inoDer  = array_slice($ino, $idx + 1);
        $preIzq  = array_slice($pre, 1, count($inoIzq));
        $preDer  = array_slice($pre, 1 + count($inoIzq));

        $nodo->izquierdo = $this->buildPI($preIzq, $inoIzq);
        $nodo->derecho   = $this->buildPI($preDer, $inoDer);
        return $nodo;
    }

    public function preorden(): array {
        $result = [];
        $this->preordenRec($this->raiz, $result);
        return $result;
    }

    private function preordenRec(?NodoArbol $nodo, array &$result): void {
        if (!$nodo) return;
        $result[] = $nodo->valor;
        $this->preordenRec($nodo->izquierdo, $result);
        $this->preordenRec($nodo->derecho, $result);
    }

    public function inorden(): array {
        $result = [];
        $this->inordenRec($this->raiz, $result);
        return $result;
    }

    private function inordenRec(?NodoArbol $nodo, array &$result): void {
        if (!$nodo) return;
        $this->inordenRec($nodo->izquierdo, $result);
        $result[] = $nodo->valor;
        $this->inordenRec($nodo->derecho, $result);
    }

    public function postorden(): array {
        $result = [];
        $this->postordenRec($this->raiz, $result);
        return $result;
    }

    private function postordenRec(?NodoArbol $nodo, array &$result): void {
        if (!$nodo) return;
        $this->postordenRec($nodo->izquierdo, $result);
        $this->postordenRec($nodo->derecho, $result);
        $result[] = $nodo->valor;
    }

    /**
     * Genera representación visual del árbol como texto.
     */
    public function visualizar(): string {
        if (!$this->raiz) return '';
        $lineas = [];
        $this->visualizarRec($this->raiz, '', true, $lineas);
        return implode("\n", $lineas);
    }

    private function visualizarRec(?NodoArbol $nodo, string $prefijo, bool $esUltimo, array &$lineas): void {
        if (!$nodo) return;
        $conector = $esUltimo ? '└── ' : '├── ';
        $lineas[] = $prefijo . $conector . $nodo->valor;
        $nuevoPrefijo = $prefijo . ($esUltimo ? '    ' : '│   ');
        $hijos = array_filter([$nodo->izquierdo, $nodo->derecho]);
        $hijos = array_values($hijos);
        foreach ($hijos as $i => $hijo) {
            $this->visualizarRec($hijo, $nuevoPrefijo, $i === count($hijos) - 1, $lineas);
        }
    }

    public function getRaiz(): ?NodoArbol {
        return $this->raiz;
    }
}
?>