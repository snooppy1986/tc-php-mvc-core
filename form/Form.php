<?php


namespace Core\form;


use Core\Model;

class Form
{
    public static function begin($action, $method)
    {
        echo "<form action=\"$action\" method=\"$method\">";
        return new Form();
    }

    public static function end()
    {
        echo '</form>';
    }

    public function field(Model $model, $attribute)
    {
        return new InputField($model, $attribute);
    }
}