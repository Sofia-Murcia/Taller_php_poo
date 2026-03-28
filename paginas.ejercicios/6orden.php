<?php
require_once '../classes/6Orden.php';

$arbol      = null;
$preorden   = '';
$inorden    = '';
$error      = '';
$preResult  = [];
$inoResult  = [];
$postResult = [];
$visual     = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $preorden = trim($_POST['preorden'] ?? '');
    $inorden  = trim($_POST['inorden']  ?? '');

    if ($preorden === '' || $inorden === '') {
        $error = 'Ingresa tanto el recorrido preorden como el inorden.';
    } else {
        $pre = array_values(array_filter(preg_split('/[\s,\-→>]+/u', $preorden), fn($v) => $v !== ''));
        $ino = array_values(array_filter(preg_split('/[\s,\-→>]+/u', $inorden),  fn($v) => $v !== ''));

        if (count($pre) !== count($ino)) {
            $error = 'Los recorridos deben tener la misma cantidad de nodos.';
        } elseif (empty($pre)) {
            $error = 'No se encontraron nodos válidos.';
        } else {
            $arbol = new ORDEN();
            $arbol->construirDesdePreorderInorder($pre, $ino);
            $preResult  = $arbol->preorden();
            $inoResult  = $arbol->inorden();
            $postResult = $arbol->postorden();
            $visual     = $arbol->visualizar();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Árbol Binario — Taller PHP</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>

  <header class="topbar">
    <a href="../index.php" class="topbar-brand">// Taller PHP · POO</a>
    <a href="../index.php" class="topbar-back">← Menú</a>
  </header>

  <main class="page">

    <div class="page-header">
      <p class="page-num">// Ejercicio 06</p>
      <h1 class="page-title">Árbol Binario</h1>
    </div>

    <div class="alert alert-info">
      Ingresa los nodos separados por espacios, comas o el símbolo →<br>
      Ejemplo — Preorden: A B D E C &nbsp;|&nbsp; Inorden: D B E A C
    </div>

    <?php if ($error): ?>
      <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" class="form-block">
      <div class="field">
        <label for="preorden">Recorrido Preorden</label>
        <input type="text" id="preorden" name="preorden"
          value="<?= htmlspecialchars($preorden) ?>" placeholder="Ej: A B D E C" required>
      </div>
      <div class="field">
        <label for="inorden">Recorrido Inorden</label>
        <input type="text" id="inorden" name="inorden"
          value="<?= htmlspecialchars($inorden) ?>" placeholder="Ej: D B E A C" required>
      </div>
      <button type="submit" class="btn btn-primary">Construir Árbol</button>
    </form>

    <?php if ($arbol !== null): ?>
      <div class="tree-canvas">
        <p class="result-label" style="margin-bottom:1rem">Estructura del árbol</p>
        <pre class="tree-visual"><?= htmlspecialchars($visual) ?></pre>
      </div>
      <div class="traversal-list">
        <div class="traversal-row">
          <span class="traversal-label">Preorden</span>
          <span class="traversal-val"><?= implode(' → ', array_map('htmlspecialchars', $preResult)) ?></span>
        </div>
        <div class="traversal-row">
          <span class="traversal-label">Inorden</span>
          <span class="traversal-val"><?= implode(' → ', array_map('htmlspecialchars', $inoResult)) ?></span>
        </div>
        <div class="traversal-row">
          <span class="traversal-label">Postorden</span>
          <span class="traversal-val"><?= implode(' → ', array_map('htmlspecialchars', $postResult)) ?></span>
        </div>
      </div>
    <?php endif; ?>

  </main>
</body>
</html>
