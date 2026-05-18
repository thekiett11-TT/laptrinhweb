<?php
require_once 'app/helpers/SessionHelper.php';

class DefaultController {
    public function index() {
        if (SessionHelper::isLoggedIn()) {
            if (SessionHelper::isAdmin()) {
                header('Location: /ToTheKiet/admin/dashboard');
            } else {
                header('Location: /ToTheKiet/account/profile');
            }
        } else {
            header('Location: /ToTheKiet/account/login');
        }
        exit;
    }
}