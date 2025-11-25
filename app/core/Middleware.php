<?php

class Middleware {

    public static function checkAuth() : void {
        if (!isset($_SESSION['USER_ID'])) {
            redirect('auth/login');
        }
    }

    public static function isAdmin() : bool {
        return isset($_SESSION['ROLE']) && $_SESSION['ROLE'] === RoleModel::ROLE_ADMIN;
    }

    public static function isUser() : bool {
        return isset($_SESSION['ROLE']) && ($_SESSION['ROLE'] === RoleModel::ROLE_USER);
    }

    public static function checkRole(int $role) : void {
        if (!isset($_SESSION['ROLE']) || $_SESSION['ROLE'] !== $role) {
            redirect('auth/login');
        }
    }

    public static function isLoggedIn() : bool {
        return isset($_SESSION['USER_ID']);
    }

    public static function getUser() : int {
        if (isset($_SESSION['USER_ID'])) {
            return $_SESSION['USER_ID'];
        }
        return -1;
    }
}