<?php

namespace app\classes;

use app\models\Users;
use core\Router;
use core\Session;

class Permission
{
    public static function permRedirect($perm, $redirect, $msg = "You do not have access to this page.")
    {
        /** @var mixed $user */

        $user = Users::getCurrentUser();
        $allowed = $user && $user->hasPermission($perm);
        if (!$allowed) {
            Session::msg($msg);
            Router::redirect($redirect);
        }
    }
}