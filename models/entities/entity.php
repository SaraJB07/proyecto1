<?php
namespace app\models\entities;


abstract class Entity
{
    abstract public function all();
    abstract  public function save();
    abstract  public function update();
    abstract  public function delete();

    public function set($prop, $value)
    {
        $this->{$prop} = $value;
    }

    public function get($prop)
    {
        return $this->{$prop};
    }
}
