<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/principal.css">
    <link rel="icon" type="image/png" href="css/Imagenes/4931660.jpg">
    <title>Control de Gastos</title>
</head>

<body class="StartWeb">
    <div class="logo">
        <h1>Control de Gastos</h1>
    </div>

    <div class="menu-container">
        <form action="Ingreso.php" method="get">
            <button class="opciones" type="submit">Ingresos</button>
        </form>
        
        <form action="Categoria.php" method="get">
            <button class="opciones" type="submit">Categorías</button>
        </form>
        
        <form action="ControlGastos.php" method="get">
            <button class="opciones" type="submit">Gastos Mensuales</button>
        </form>
        
        <form action="FormReporte.php" method="get">
            <button class="opciones" type="submit">Generar Reporte</button>
        </form>
    </div>

</body>

</html>
