<?php
require_once '../classes/1Acronimo.php';

$resultado = null;
$frase     = '';
$error     = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $frase = trim($_POST['frase'] ?? '');
    if ($frase === '') {
        $error = 'Por favor ingresa una frase.';
    } else {
        $obj       = new Acronimo($frase);
        $resultado = $obj->convertir();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Acrónimo — Taller PHP</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>

  <header class="topbar">
    <a href="../index.php" class="topbar-brand">// Taller PHP · POO</a>
    <a href="../index.php" class="topbar-back">← Menú</a>
  </header>

  <main class="page">

    <div class="page-header">
      <p class="page-num">// Ejercicio 01</p>
      <h1 class="page-title">Convertir a Acrónimo</h1>
    </div>

    <?php if ($error): ?>
      <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" class="form-block">
      <div class="field">
        <label for="frase">Frase completa</label>
        <input type="text" id="frase" name="frase"
          value="<?= htmlspecialchars($frase) ?>"
          placeholder="Ej: As Soon As Possible" required>
      </div>
      <button type="submit" class="btn btn-primary">Convertir</button>
    </form>

    <?php if ($resultado !== null): ?>
      <div class="result">
        <p class="result-label">Resultado</p>
        <p class="result-value"><?= htmlspecialchars($resultado) ?></p>
      </div>
      <div class="result">
        <p class="result-label">Frase original</p>
        <p class="result-value" style="font-size:1.1rem"><?= htmlspecialchars($frase) ?></p>
      </div>
    <?php endif; ?>

  </main>
</body>
</html>
