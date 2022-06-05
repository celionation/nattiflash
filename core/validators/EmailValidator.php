<?php

namespace core\validators;

class EmailValidator extends Validator
{
    public function runValidation()
    {
        $email = $this->_obj->{$this->field};
        $pass = true;
        if (!empty($email)) {
            $pass = filter_var($email, FILTER_VALIDATE_EMAIL);
        }
        return $pass;
    }
}