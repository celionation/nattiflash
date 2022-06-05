<?php

namespace app\models;

use core\Config;
use core\Cookie;
use core\Model;
use core\Session;
use core\validators\EmailValidator;
use core\validators\MatchesValidator;
use core\validators\MinValidator;
use core\validators\RequiredValidator;
use core\validators\UniqueValidator;
use Exception;

class Users extends Model
{
    protected static $table = "users", $_current_user = false;
    public $id, $created_at, $updated_at, $fname, $lname, $email, $acl, $password, $blocked = 0, $user_id, $confirmPassword, $remember = '';

    const GUESTS_PERMISSION = 'guests';
    const AUTHOR_PERMISSION = 'author';
    const ADMIN_PERMISSION = 'admin';

    const MALE_GENDER = 'male';
    const FEMALE_GENDER = 'female';

    /**
     * @throws Exception
     */
    public function beforeSave()
    {
        $this->timeStamps();

        $this->runValidation(new RequiredValidator($this, ['field' => 'fname', 'msg' => "First Name is a required field."]));
        $this->runValidation(new RequiredValidator($this, ['field' => 'lname', 'msg' => "Last Name is a required field."]));
        $this->runValidation(new RequiredValidator($this, ['field' => 'email', 'msg' => "Email is a required field."]));
        $this->runValidation(new EmailValidator($this, ['field' => 'email', 'msg' => 'You must provide a valid email.']));
        $this->runValidation(new UniqueValidator($this, ['field' => ['email'], 'msg' => 'A user with that email address already exists.']));
        $this->runValidation(new RequiredValidator($this, ['field' => 'acl', 'msg' => "Role is a required field."]));

        if ($this->isNew() || $this->resetPassword) {
            $this->runValidation(new RequiredValidator($this, ['field' => 'password', 'msg' => "Password is a required field."]));
            $this->runValidation(new RequiredValidator($this, ['field' => 'confirmPassword', 'msg' => "Confirm Password is a required field."]));
            $this->runValidation(new MatchesValidator($this, ['field' => 'confirmPassword', 'rule' => $this->password, 'msg' => "Your passwords do not match."]));
            $this->runValidation(new MinValidator($this, ['field' => 'password', 'rule' => 6, 'msg' => "Password must be at least 6 characters."]));

            $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        } else {
            $this->_skipUpdate = ['password'];
        }
    }


    /**
     * @throws Exception
     */
    public function validateLogin()
    {
        $this->runValidation(new RequiredValidator($this, ['field' => 'email', 'msg' => "Email is a required field."]));
        $this->runValidation(new RequiredValidator($this, ['field' => 'password', 'msg' => "Password is a required field."]));
    }

    public function login($remember = false)
    {
        Session::set('logged_in_user', $this->id);
        self::$_current_user = $this;
        if ($remember) {
            $now  = time();
            $newHash = md5("{$this->id}_{$now}");
            $session = UserSessions::findByUserId($this->id);
            if (!$session) {
                $session = new UserSessions();
            }
            $session->user_id = $this->id;
            $session->hash = $newHash;
            $session->save();
            Cookie::set(Config::get('login_cookie_name'), $newHash, 60 * 60 * 24 * 30);
        }
    }

    public static function loginFromCookie()
    {
        $cookieName = Config::get('login_cookie_name');
        if (!Cookie::exists($cookieName)) return false;
        $hash = Cookie::get($cookieName);
        $session = UserSessions::findByHash($hash);
        if (!$session) return false;
        $user = self::findById($session->user_id);
        if ($user) {
            $user->login(true);
        }
    }

    public static function getCurrentUser()
    {
        if (!self::$_current_user && Session::exists('logged_in_user')) {
            $user_id = Session::get('logged_in_user');
            self::$_current_user = self::findById($user_id);
        }
        if (!self::$_current_user) self::loginFromCookie();
        if (self::$_current_user && self::$_current_user->blocked) {
            self::$_current_user->logout();
            Session::msg("You are currently blocked. Please talk to an admin to resolve this.");
        }
        return self::$_current_user;
    }

}