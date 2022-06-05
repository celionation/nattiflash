<?php

namespace core\validators;

class MaxValidator extends Validator
{
    public function runValidation()
    {
        $value = $this->_obj->{$this->field};
        return strlen($value) <= $this->rule;
    }
}