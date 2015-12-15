<?php

class ErrorHandler
{
    protected  $errors = [];

    public function addError($error, $field = null)
    {
        if ($field) {
            $this->errors[$field][] = $error;
        } else {
            $this->errors[] = $error;
        }
    }

    public function hasError()
    {
        return count($this->all()) ? true : false;
    }

    public function all($field = null)
    {
        return (isset($field)) ? $this->errors[$field] : $this->errors;
    }

    public function first($field)
    {
        return isset($this->all()[$field][0]) ? $this->all()[$field][0] : null;
    }
}