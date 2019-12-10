<?php
namespace App\Classes\Validation;
class Validator
{

    private $errors = [];
    private $operators = ['LIKE', "=", "!=", ">", "<", ">=", "<="];

    private function isValueValid($value, $key)
    {
        If($value === null) {
            $this->errors[] = "Invalid sql, $key must not be of the type null.";
        }
    }

    private function isColumnValid($key, $model)
    {
        if (!in_array( $key, $model->getModelProperties(),true )) {
            $this->errors[] = "Invalid sql, $key does not exists in table.";
        }
    }

    private function isOperatorValid($value)
    {
        if(!in_array($value, $this->operators, true) ) {
            $this->errors[] = "Invalid sql, operator $value is invalid.";
        }
    }

    public function validate($data, $model)
    {
        foreach ($data as $key=>$value) {
            $this->isValueValid($value, $key);
            $key !== "operator" ? $this->isColumnValid($key, $model) : $this->isOperatorValid($value);
        }
//        $this->errors = [];
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
