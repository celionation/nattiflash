<?php

namespace app\models;

use core\Model;
use core\validators\RequiredValidator;
use Exception;

class Articles extends Model
{
    protected static $table = "articles";
    public $id, $created_at, $updated_at, $user_id, $title, $body, $img, $status = 'private', $category_id = 0, $region_id = 0;

    /**
     * @throws Exception
     */
    public function beforeSave()
    {
        $this->timeStamps();
        $this->runValidation(new RequiredValidator($this, ['field' => 'title', 'msg' => 'Title is a required field']));
        $this->runValidation(new RequiredValidator($this, ['field' => 'body', 'msg' => 'Body is a required field.']));
    }
}