<?php
require_once '../classes/3Serie.php';

$promedio = null;
$mediana  = null;
$moda     = null;
$numeros  = [];
$input    = '';
$error    = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = trim($_POST['numeros'] ?? '');
    if ($input === '') {
        $error = 'Por favor ingresa al menos un número.';
    } else {
        // Separa por comas, espacios o punto y coma
        $partes = preg_split('/[\s,;]+/', $input);
        $numeros = array_filter($partes, fn($v) => is_numeric($v));
        $numeros = array_values($numeros);

        if (empty($numeros)) {
            $error = 'No se encontraron números válidos en la entrada.';
        } else {
            $obj      = new Estadistica($numeros);
            $promedio = round($obj->promedio(), 4);
            $mediana  = round($obj->mediana(), 4);
            $moda     = $obj->moda();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Estadística — Taller PHP</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>

  <header class="topbar">
    <a href="../index.php" class="topbar-brand">// Taller PHP · POO</a>
    <a href="../index.php" class="topbar-back">← Menú</a>
  </header>

  <main class="page">

    <div class="page-header">
      <p class="page-num">// Ejercicio 03</p>
      <h1 class="page-title">Estadística</h1>
    </div>

    <?php if ($error): ?>
      <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" class="form-block">
      <div class="field">
        <label for="numeros">Serie de números (separados por coma, espacio o punto y coma)</label>
        <textarea
          id="numeros"
          name="numeros"
          rows="3"
          placeholder="Ej: 4, 7, 2, 9, 4, 1, 7, 4"
          required
        ><?= htmlspecialchars($input) ?></textarea>
      </div>
      <button type="submit" class="btn btn-primary">Calcular</button>
    </form>

    <?php if ($promedio !== null): ?>

      <?php if (!empty($numeros)): ?>
        <div class="result">
          <p class="result-label">Números ingresados (<?= count($numeros) ?>)</p>
          <div class="result-series">
            <?php foreach ($numeros as $n): ?>
              <span class="result-tag"><?= htmlspecialchars($n) ?></span>
            <?php endforeach; ?>
          </div>
        </div>
      <?php endif; ?>

      <div class="stats-row">
        <div class="stat-cell">
          <span class="stat-label">Promedio</span>
          <span class="stat-val"><?= $promedio ?></span>
        </div>
        <div class="stat-cell">
          <span class="stat-label">Mediana</span>
          <span class="stat-val"><?= $mediana ?></span>
        </div>
        <div class="stat-cell">
          <span class="stat-label">Moda</span>
          <span class="stat-val"><?= implode(', ', $moda) ?></span>
        </div>
      </div>

    <?php endif; ?>

  </main>

</body>
</html>
