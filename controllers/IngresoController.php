<?php

namespace app\controllers;
use app\models\entities\Ingreso;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $mes = $_POST['mes'];
    $anio = intval($_POST['anio']);
    $valor = floatval($_POST['valor']);

    if ($valor < 0) {
        $mensaje = " El ingreso no puede ser menor a cero.";
        require 'views/mensaje.php';
        exit;
    }

    $ingreso = new Ingreso();
    $ingresoExistente = $ingreso->obtenerIngreso($mes, $anio);

    if ($ingresoExistente) {
        $ingreso->actualizarIngreso($mes, $anio, $valor);
        $mensaje = "Ingreso actualizado correctamente.";
    } else {
        $ingreso->guardarIngreso($mes, $anio, $valor);
        $mensaje = "Ingreso registrado correctamente.";
    }

    require 'views/mensaje.php';
}
?>
