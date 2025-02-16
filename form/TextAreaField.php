<?php


namespace Core\form;


class TextAreaField extends BaseField
{
    public function renderInput(): string
    {
        return sprintf('<textarea name="%s" class="form-control%s">%s</textarea>',
            $this->attribute,
            $this->model->hasErrors($this->attribute) ? ' is-invalid' : '',
            $this->model->{$this->attribute}
        );
    }
}