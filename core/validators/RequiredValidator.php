<?php

namespace core\validators;

class RequiredValidator extends Validator
{
    public function runValidation()
    {
        $value = trim($this->_obj->{$this->field});
        return $value != '';
    }
}