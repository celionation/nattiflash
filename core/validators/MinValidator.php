<?php

namespace core\validators;

class MinValidator extends Validator
{
    public function runValidation()
    {
        $value = $this->_obj->{$this->field};
        return strlen($value) >= $this->rule;
    }
}