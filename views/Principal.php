<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/Principal.css">
    <link rel="icon" type="image/png" href="css/Imagenes/logo.jpg">
    <title>Control de Gastos</title>
    
</head>

<body class="StartWeb">
    <div class="logo">
    <h1>Control de gastos</h1>
    </div>
    

    <div class ="menu-container">
        <form action="Ingreso.php" method="get">
            <button class="opciones" type="submit">Ingresos</button>
        </form>
        <br>
       
        
        <form action="Categoria.php" method="get">
            <button class="opciones1" type="submit">Categorias</button>
        </form>
        <br>
        <form action="ControlGastos.php" method="get">
            <button class="opciones2" type="submit">Gastos Mensuales</button>
        </form>
        <br>        
        <form action="FormReporte.php" method="get">
            <button class="opciones3" type="submit">Generar reporte</button>
        </form>
        <br>

    </div>

</body>


</html>
