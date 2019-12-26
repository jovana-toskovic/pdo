<?php

namespace App\Classes\Validation;

// ova klasa bi trebalo da se naznaci da je na menjena za validaciju Query Buildera
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

//    private function isColumnValid($key, $model)
//    {
//        if (!in_array($key, $model->getColumnNames())) {
//            $this->errors[] = "Invalid sql, $key does not exists in table.";
//        }
//    }

    private function isOperatorValid($value)
    {
        if(!in_array($value, $this->operators) ) {
            $this->errors[] = "Invalid sql, operator $value is invalid.";
        }
    }

    public function validate($data, $model)
    {
        if(!$this->isAssoc($data)) {
            $this->errors[] = "Invalid sql, wrong type of parameter sent, data must be of the type associative array.";
        }
//        foreach ($data as $key=>$value) {
//            $this->isValueValid($value, $key);
//            $key !== "operator" ? $this->isColumnValid($key, $model) : $this->isOperatorValid($value);
//        }
    }

    public function getErrors()
    {
        return $this->errors;
    }

    private function isAssoc($array)
    {
        foreach($array as $key=>$value)
        {
            if (!is_string($key)){
                return false;
            }
        }
        return true;
    }
}
