<?php
require_once '../classes/4Conjuntos.php';

$resultado = null;
$inputA    = '';
$inputB    = '';
$error     = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $inputA = trim($_POST['setA'] ?? '');
    $inputB = trim($_POST['setB'] ?? '');

    if ($inputA === '' || $inputB === '') {
        $error = 'Por favor ingresa ambos conjuntos.';
    } else {
        $A = array_values(array_filter(preg_split('/[\s,;]+/', $inputA), fn($v) => is_numeric($v)));
        $B = array_values(array_filter(preg_split('/[\s,;]+/', $inputB), fn($v) => is_numeric($v)));

        if (empty($A) || empty($B)) {
            $error = 'Los conjuntos deben contener números enteros válidos.';
        } else {
            $obj = new Conjuntos($A, $B);
            $resultado = [
                'A'            => $obj->getA(),
                'B'            => $obj->getB(),
                'union'        => $obj->union(),
                'interseccion' => $obj->interseccion(),
                'difAB'        => $obj->diferenciaAB(),
                'difBA'        => $obj->diferenciaBA(),
            ];
        }
    }
}

function setToStr(array $arr): string {
    if (empty($arr)) return '∅ (vacío)';
    return '{ ' . implode(', ', $arr) . ' }';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Conjuntos — Taller PHP</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>

  <header class="topbar">
    <a href="../index.php" class="topbar-brand">// Taller PHP · POO</a>
    <a href="../index.php" class="topbar-back">← Menú</a>
  </header>

  <main class="page">

    <div class="page-header">
      <p class="page-num">// Ejercicio 04</p>
      <h1 class="page-title">Operaciones de Conjuntos</h1>
    </div>

    <?php if ($error): ?>
      <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" class="form-block">
      <div class="field">
        <label for="setA">Conjunto A (números separados por coma)</label>
        <input type="text" id="setA" name="setA"
          value="<?= htmlspecialchars($inputA) ?>" placeholder="Ej: 1, 2, 3, 4, 5" required>
      </div>
      <div class="field">
        <label for="setB">Conjunto B (números separados por coma)</label>
        <input type="text" id="setB" name="setB"
          value="<?= htmlspecialchars($inputB) ?>" placeholder="Ej: 3, 4, 5, 6, 7" required>
      </div>
      <button type="submit" class="btn btn-primary">Calcular</button>
    </form>

    <?php if ($resultado): ?>
      <div class="set-results">
        <div class="set-row">
          <span class="set-row-label">A</span>
          <span class="set-row-val"><?= setToStr($resultado['A']) ?></span>
        </div>
        <div class="set-row">
          <span class="set-row-label">B</span>
          <span class="set-row-val"><?= setToStr($resultado['B']) ?></span>
        </div>
        <div class="set-row">
          <span class="set-row-label">A ∪ B (Unión)</span>
          <span class="set-row-val"><?= setToStr($resultado['union']) ?></span>
        </div>
        <div class="set-row">
          <span class="set-row-label">A ∩ B (Intersección)</span>
          <span class="set-row-val"><?= setToStr($resultado['interseccion']) ?></span>
        </div>
        <div class="set-row">
          <span class="set-row-label">A − B</span>
          <span class="set-row-val"><?= setToStr($resultado['difAB']) ?></span>
        </div>
        <div class="set-row">
          <span class="set-row-label">B − A</span>
          <span class="set-row-val"><?= setToStr($resultado['difBA']) ?></span>
        </div>
      </div>
    <?php endif; ?>

  </main>
</body>
</html>
