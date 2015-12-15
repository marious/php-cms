<?php

class Validation
{
    protected $errorHandler;
    protected $items;
    protected $rules = ['required', 'minlength', 'maxlength', 'email', 'match', 'alnum', 'unique'];
    protected $messages = [
        'required' => 'The :field field is required',
        'minlength' => 'The :field field must be a minimum :satisfier Character length',
        'maxlength' => 'The :field field must be a maximum :satisfier Character length',
        'email' => 'The :field field must be valid email address',
        'match' => 'The Confirmation :satisfier field must be match :satisfier field',
        'alnum' => 'The :field field must be alphanumeric only.',
        'unique' => 'The :field field already exist please enter another one'
    ];


    public function __construct($items = null, $rules = null)
    {
        $this->errorHandler = new ErrorHandler();
        if ($items && $rules) {
            $this->check($items, $rules);
        }
    }

    public function check($items, $rules)
    {
        $this->items = $items;

        foreach ($items as $item => $value)
        {
            if (in_array($item, array_keys($rules))) {

                $this->validate([
                    'value' => $value,
                    'field' => $item,
                    'rules' => $rules[$item]
                ]);
            }
        }

        return $this;
    }

    public function fails()
    {
        return $this->errorHandler->hasError();
    }

    public function errors()
    {
        return $this->errorHandler->all();
    }

    private function validate($item)
    {
        $value = $item['value'];
        $field = $item['field'];

        foreach ($item['rules'] as $rule => $satisfier)
        {
            if (in_array($rule, $this->rules)) {

                if (!call_user_func_array([$this, $rule], [$field, $value, $satisfier]))
                {
                    $this->errorHandler->addError(str_replace([':field', ':satisfier'], [$field, $satisfier],

                        $this->messages[$rule]));
                }

            }
        }
    }

    private function required ($field, $value, $satisfier)
    {
        return !empty(trim($value));
    }

    private function minlength ($field, $value, $satisfier)
    {
        return mb_strlen($value) >= $satisfier;
    }

    private function maxlength ($field, $value, $satisfier)
    {
        return mb_strlen($value) <= $satisfier;
    }

    private function email ($field, $value, $satisfier)
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }

    private function match($field, $value, $satisfier)
    {
        return ($value == $this->items[$satisfier]) ;
    }

    private function alnum($field, $value, $satisfier)
    {
        return ctype_alnum($value);
    }

    private function unique($field, $value, $satisfier)
    {
        $sql = "SELECT * FROM {$satisfier} WHERE $field = ?";
        return !DatabaseModel::read($sql, PDO::FETCH_ASSOC, null, [$field]) ? true : false;
    }
}