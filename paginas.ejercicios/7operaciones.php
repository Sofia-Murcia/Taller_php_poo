<?php
require_once '../classes/7Operaciones.php';
session_start();

if (!isset($_SESSION['historial'])) {
    $_SESSION['historial'] = [];
}

$resultado = null;
$error     = '';

if (isset($_POST['borrar_historial'])) {
    $_SESSION['historial'] = [];
    header('Location: 7operaciones.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['calcular'])) {
    $a  = trim($_POST['a']  ?? '');
    $b  = trim($_POST['b']  ?? '');
    $op = $_POST['operacion'] ?? '';

    if (!is_numeric($a) || !is_numeric($b)) {
        $error = 'Ingresa dos números válidos.';
    } elseif (!in_array($op, ['+', '-', '*', '/', '%'])) {
        $error = 'Selecciona una operación válida.';
    } else {
        $calc      = new Calculadora((float)$a, (float)$b, $op);
        $resultado = $calc->calcular();
        if (!is_string($resultado)) {
            array_unshift($_SESSION['historial'], [
                'expresion' => $calc->getExpresion(),
                'resultado' => $resultado,
            ]);
            if (count($_SESSION['historial']) > 30) array_pop($_SESSION['historial']);
        } else {
            $error     = $resultado;
            $resultado = null;
        }
    }
}

$historial = $_SESSION['historial'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Calculadora — Taller PHP</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>

  <header class="topbar">
    <a href="../index.php" class="topbar-brand">// Taller PHP · POO</a>
    <a href="../index.php" class="topbar-back">← Menú</a>
  </header>

  <main class="page">

    <div class="page-header">
      <p class="page-num">// Ejercicio 07</p>
      <h1 class="page-title">Calculadora</h1>
    </div>

    <?php if ($error): ?>
      <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <div class="calc-wrap">

      <div>
        <div class="calc-display">
          <?= $resultado !== null ? htmlspecialchars($resultado) : '0' ?>
        </div>

        <form method="POST" class="form-block">
          <div class="field">
            <label for="a">Número A</label>
            <input type="number" step="any" id="a" name="a" placeholder="0" required>
          </div>
          <div class="field">
            <label for="operacion">Operación</label>
            <select id="operacion" name="operacion" required>
              <option value="" disabled selected>Selecciona...</option>
              <option value="+">+ Suma</option>
              <option value="-">− Resta</option>
              <option value="*">× Multiplicación</option>
              <option value="/">÷ División</option>
              <option value="%">% Módulo</option>
            </select>
          </div>
          <div class="field">
            <label for="b">Número B</label>
            <input type="number" step="any" id="b" name="b" placeholder="0" required>
          </div>
          <button type="submit" name="calcular" class="btn btn-primary">= Calcular</button>
        </form>
      </div>

      <div class="history-panel">
        <p class="history-title">Historial (<?= count($historial) ?>)</p>
        <div class="history-list">
          <?php if (empty($historial)): ?>
            <p style="font-family:var(--font-mono);font-size:.78rem;color:var(--muted)">Sin operaciones aún.</p>
          <?php else: ?>
            <?php foreach ($historial as $item): ?>
              <div class="history-item">
                <?= htmlspecialchars($item['expresion']) ?> = <span><?= htmlspecialchars($item['resultado']) ?></span>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
        <?php if (!empty($historial)): ?>
          <form method="POST">
            <button type="submit" name="borrar_historial" class="btn btn-danger">Borrar historial</button>
          </form>
        <?php endif; ?>
      </div>

    </div>

  </main>
</body>
</html>