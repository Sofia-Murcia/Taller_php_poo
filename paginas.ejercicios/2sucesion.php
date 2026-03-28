<?php
require_once '../classes/2Sucesion.php';

$serie     = null;
$numero    = '';
$operacion = '';
$error     = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numero    = trim($_POST['numero'] ?? '');
    $operacion = $_POST['operacion'] ?? '';

    if ($numero === '' || !is_numeric($numero)) {
        $error = 'Por favor ingresa un número válido.';
    } elseif ((int)$numero < 0) {
        $error = 'El número debe ser mayor o igual a 0.';
    } else {
        $obj = new Sucesion((int)$numero);
        if ($operacion === 'fibonacci') {
            $serie = $obj->fibonacci();
        } elseif ($operacion === 'factorial') {
            $serie = $obj->factorial();
        } else {
            $error = 'Selecciona una operación válida.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Fibonacci / Factorial — Taller PHP</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>

  <header class="topbar">
    <a href="../index.php" class="topbar-brand">// Taller PHP · POO</a>
    <a href="../index.php" class="topbar-back">← Menú</a>
  </header>

  <main class="page">

    <div class="page-header">
      <p class="page-num">// Ejercicio 02</p>
      <h1 class="page-title">Fibonacci / Factorial</h1>
    </div>

    <?php if ($error): ?>
      <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" class="form-block">
      <div class="field">
        <label for="numero">Número</label>
        <input
          type="number"
          id="numero"
          name="numero"
          min="0"
          value="<?= htmlspecialchars($numero) ?>"
          placeholder="Ej: 10"
          required
        >
      </div>
      <div class="field">
        <label for="operacion">Operación</label>
        <select id="operacion" name="operacion" required>
          <option value="" disabled <?= $operacion === '' ? 'selected' : '' ?>>Selecciona...</option>
          <option value="fibonacci" <?= $operacion === 'fibonacci' ? 'selected' : '' ?>>Sucesión de Fibonacci</option>
          <option value="factorial" <?= $operacion === 'factorial' ? 'selected' : '' ?>>Factorial</option>
        </select>
      </div>
      <button type="submit" class="btn btn-primary">Calcular</button>
    </form>

    <?php if ($serie !== null): ?>
      <div class="result">
        <p class="result-label">
          <?= $operacion === 'fibonacci' ? "Fibonacci de $numero términos" : "Pasos del factorial de $numero" ?>
        </p>
        <div class="result-series">
          <?php foreach ($serie as $val): ?>
            <span class="result-tag"><?= $val ?></span>
          <?php endforeach; ?>
        </div>
      </div>

      <?php if ($operacion === 'factorial' && !empty($serie)): ?>
        <div class="result">
          <p class="result-label"><?= $numero ?>! =</p>
          <p class="result-value"><?= end($serie) ?></p>
        </div>
      <?php endif; ?>
    <?php endif; ?>

  </main>

</body>
</html>
