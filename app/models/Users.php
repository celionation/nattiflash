<?php

namespace app\models;

use core\Model;

class Users extends Model
{
    protected static $table = "users", $_current_user = false;
    public $id, $created_at, $updated_at, $fname, $lname, $email, $acl, $password, $blocked = 0, $user_id, $confirmPassword, $remember = '';

    const GUESTS_PERMISSION = 'guests';
    const AUTHOR_PERMISSION = 'author';
    const ADMIN_PERMISSION = 'admin';

    const MALE_GENDER = 'male';
    const FEMALE_GENDER = 'female';

    public function beforeSave()
    {
        $this->timeStamps();
        if ($this->isNew()) {
            $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        } else {
            $this->_skipUpdate = ['password'];
        }
    }
}