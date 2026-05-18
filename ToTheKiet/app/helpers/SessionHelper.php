<?php
class SessionHelper {

    // Lưu thông tin user vào session sau khi đăng nhập
    public static function setUser($user) {
        $_SESSION['user_id']       = $user['id'];
        $_SESSION['user_username'] = $user['username'];
        $_SESSION['user_fullname'] = $user['fullname'];
        $_SESSION['user_role']     = $user['ROLE'];
        $_SESSION['logged_in']     = true;
    }

    public static function setToken($token) {
        $_SESSION['jwt_token'] = $token;
    }

    public static function getToken() {
        return $_SESSION['jwt_token'] ?? null;
    }

    // Kiểm tra đã đăng nhập chưa
    public static function isLoggedIn() {
        return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
    }

    // Kiểm tra có phải admin không (ROLE = 1)
    public static function isAdmin() {
        return self::isLoggedIn() && $_SESSION['user_role'] == 1;
    }

    // Lấy thông tin user hiện tại
    public static function getCurrentUser() {
        if (!self::isLoggedIn()) return null;
        return [
            'id'       => $_SESSION['user_id'],
            'username' => $_SESSION['user_username'],
            'fullname' => $_SESSION['user_fullname'],
            'role'     => $_SESSION['user_role'],
        ];
    }

    // Đăng xuất
    public static function logout() {
        $_SESSION = [];
        session_destroy();
    }

    // Bắt buộc đăng nhập - redirect nếu chưa login
    public static function requireLogin() {
        if (!self::isLoggedIn()) {
            header('Location: /ToTheKiet/account/login');
            exit;
        }
    }

    // Bắt buộc quyền admin
    public static function requireAdmin() {
        if (!self::isAdmin()) {
            header('Location: /ToTheKiet/');
            exit;
        }
    }

    // Lưu flash message
    public static function setFlash($type, $message) {
        $_SESSION['flash'] = ['type' => $type, 'message' => $message];
    }

    // Lấy và xóa flash message
    public static function getFlash() {
        if (isset($_SESSION['flash'])) {
            $flash = $_SESSION['flash'];
            unset($_SESSION['flash']);
            return $flash;
        }
        return null;
    }
}