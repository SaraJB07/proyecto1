<?php

namespace app\models\entities;

abstract class Entity
{
    abstract function obtenerIngreso();
    abstract function guardarIngreso();
    abstract function actualizarIngreso();
    abstract function delete();

    public function set($prop, $value)
    {
        $this->{$prop} = $value;
    }

    public function get($prop)
    {
        return $this->{$prop};
    }
}