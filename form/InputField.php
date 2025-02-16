<?php


namespace Core\form;


use Core\Model;

class InputField extends BaseField
{
    public const TYPE_TEXT = 'text';
    public const TYPE_PASSWORD = 'password';
    public string $type;
    public Model $model;
    public string $attribute;

    public function __construct(Model $model, string $attribute)
    {
        $this->type =self::TYPE_TEXT;
        parent::__construct($model, $attribute);
    }



    public function passwordField()
    {
        $this->type = self::TYPE_PASSWORD;
        return $this;
    }

    public function renderInput(): string
    {
        return sprintf('<input name="%s" value="%s" type="%s" class="form-control%s">',
            $this->attribute,
            $this->model->{$this->attribute},
            $this->type,
            $this->model->hasErrors($this->attribute) ? ' is-invalid' : '',
        );
    }
}