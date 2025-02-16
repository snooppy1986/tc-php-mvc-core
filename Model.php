<?php


namespace Core;


abstract class Model
{
    public const RULE_REQUIRED = 'required';
    public const RULE_STRING = 'string';
    public const RULE_EMAIL = 'email';

    public array $errors = [];

    public function loadData($data)
    {
        foreach ($data as $key => $value){
            if(property_exists($this, $key)){
                $this->{$key} = $value;
            }
        }
    }

    abstract public function rules(): array;

    public function labels(): array
    {
        return [];
    }

    public function validate()
    {
        foreach ($this->rules() as $attribute => $rules){
            $value = $this->{$attribute};
            foreach ($rules as $rule){
                $ruleName = $rule;
                if(!is_string($ruleName)){
                    $ruleName = $rule[0];
                }
                if($ruleName === self::RULE_REQUIRED && !$value){
                    $this->addErrorForRule($attribute, self::RULE_REQUIRED);
                }
                if($ruleName === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)){
                    $this->addErrorForRule($attribute, self::RULE_EMAIL);
                }
                if($ruleName === self::RULE_STRING && !is_string($value)){
                    $this->addErrorForRule($attribute, self::RULE_STRING);
                }
            }
        }
        return empty($this->errors);
    }

    private function addErrorForRule(string $attribute, string $rule)
    {
        $messages = $this->errorMessages()[$rule] ?? '';
        $this->errors[$attribute][] = $messages;
    }

    public function addError(string $attribute, string $message)
    {
        $this->errors[$attribute][] = $message;
    }

    public function errorMessages()
    {
        return [
            self::RULE_REQUIRED => 'This field required',
            self::RULE_EMAIL => 'This field must be email',
            self::RULE_STRING => 'This field must be string'

        ];
    }

    public function hasErrors($attribute)
    {
        return $this->errors[$attribute] ?? false;
    }

    public function getFirstError($attribute)
    {
        return $this->errors[$attribute][0] ?? false;
    }
}