<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Ingreso</title>
</head>
<body>
    <h1>Registrar o Modificar Ingreso Mensual</h1>
    <?php
    if(!empty($_POST['mes'])){
        echo $_POST['mes'];
    }
    ?>
    <form action="" method="post">
        <label for="mes">Mes:</label>
        <input type="text" name="mes" id="mes" required><br><br>

        <label for="anio">Año:</label>
        <input type="number" name="anio" id="anio" required><br><br>

        <label for="valor">Valor del ingreso ($):</label>
        <input type="number" name="valor" id="valor" step="0.01" required><br><br>

        <button type="submit">Guardar</button>
    </form>
</body>
</html>
