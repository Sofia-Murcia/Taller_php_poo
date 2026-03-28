<?php
require_once '../classes/5Binario.php';

$binario = null;
$pasos   = null;
$numero  = '';
$error   = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numero = trim($_POST['numero'] ?? '');
    if ($numero === '' || !is_numeric($numero)) {
        $error = 'Por favor ingresa un número entero válido.';
    } else {
        $obj    = new Binario((int)$numero);
        $binario = $obj->convertir();
        $pasos  = $obj->pasos();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Decimal a Binario — Taller PHP</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>

  <header class="topbar">
    <a href="../index.php" class="topbar-brand">// Taller PHP · POO</a>
    <a href="../index.php" class="topbar-back">← Menú</a>
  </header>

  <main class="page">

    <div class="page-header">
      <p class="page-num">// Ejercicio 05</p>
      <h1 class="page-title">Decimal a Binario</h1>
    </div>

    <?php if ($error): ?>
      <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" class="form-block">
      <div class="field">
        <label for="numero">Número entero</label>
        <input
          type="number"
          id="numero"
          name="numero"
          value="<?= htmlspecialchars($numero) ?>"
          placeholder="Ej: 42"
          required
        >
      </div>
      <button type="submit" class="btn btn-primary">Convertir</button>
    </form>

    <?php if ($binario !== null): ?>
      <div class="result">
        <p class="result-label"><?= htmlspecialchars($numero) ?> en binario</p>
        <p class="result-value"><?= htmlspecialchars($binario) ?></p>
      </div>

      <?php if ($pasos && $numero != 0): ?>
        <div class="result">
          <p class="result-label">Proceso de conversión</p>
          <ul class="result-list">
            <?php foreach ($pasos as $p): ?>
              <li>
                <?= $p['dividendo'] ?> ÷ 2 = <?= $p['cociente'] ?> &nbsp; resto: <strong><?= $p['resto'] ?></strong>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>
    <?php endif; ?>

  </main>

</body>
</html>
