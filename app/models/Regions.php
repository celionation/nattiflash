<?php

namespace app\models;

use core\Model;
use core\validators\RequiredValidator;
use core\validators\UniqueValidator;
use Exception;

class Regions extends Model
{
    protected static $table = "regions";
    public $id, $name;

    /**
     * @throws Exception
     */
    public function beforeSave()
    {
        $this->runValidation(new RequiredValidator($this, ['field' => 'name', 'msg' => "Name is a required field."]));
        $this->runValidation(new UniqueValidator($this, ['field' => 'name', 'msg' => "That region already exists."]));
    }

}