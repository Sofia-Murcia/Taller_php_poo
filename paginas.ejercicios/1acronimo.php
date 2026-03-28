<?php require_once '../classes/1Acronimo.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Acrónimo</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h2>Convertir frase a Acrónimo</h2>
    <a href="../index.php">← Volver al menú</a>

    <form method="POST">
        <label>Ingresa la frase:</label>
        <input type="text" name="frase" placeholder="Ej: As Soon As Possible" required>
        <button type="submit">Convertir</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $frase = $_POST['frase'];
        $obj = new Acronimo($frase);
        $resultado = $obj->convertir();
        echo "<p><strong>Resultado:</strong> $resultado</p>";
    }
    ?>
</body>
</html>