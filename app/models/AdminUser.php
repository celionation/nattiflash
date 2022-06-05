<?php

namespace app\models;

use core\Model;

class AdminUser extends Model
{
    protected static $table = "users", $_current_user = false;
    public $id, $created_at, $updated_at, $fullname, $fname, $lname, $email, $password, $confirmPassword, $img, $acl, $gender, $ref_link, $state, $country, $address, $blocked, $terms, $verified;

    const GUESTS_PERMISSION = 'guests';
    const AUTHOR_PERMISSION = 'author';
    const ADMIN_PERMISSION = 'admin';

    const MALE_GENDER = 'male';
    const FEMALE_GENDER = 'female';

}