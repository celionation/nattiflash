<?php

namespace app\models;

use core\Model;
use core\validators\RequiredValidator;
use core\validators\UniqueValidator;
use Exception;

class Categories extends Model
{
    protected static $table = "categories";
    public $id, $name;

    /**
     * @throws Exception
     */
    public function beforeSave()
    {
        $this->runValidation(new RequiredValidator($this, ['field' => 'name', 'msg' => "Name is a required field."]));
        $this->runValidation(new UniqueValidator($this, ['field' => 'name', 'msg' => "That category already exists."]));
    }
}