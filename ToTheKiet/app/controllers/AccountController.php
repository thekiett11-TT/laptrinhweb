<?php
// Thêm dòng require này vào đầu file
require_once 'app/models/UserModel.php';
require_once 'app/helpers/SessionHelper.php';
require_once('app/utils/JWTHandler.php');

class AccountController {
    private $userModel;
    private $jwtHandler;
   
    public function __construct() {
        $this->userModel = new UserModel();
        $this->jwtHandler = new JWTHandler();   
        $this->userModel->createDefaultAdmin();
    }

    // GET /account/login
    public function login() {
        if (SessionHelper::isLoggedIn()) {
            header('Location: /ToTheKiet/');
            exit;
        }
        $flash = SessionHelper::getFlash();
        include ROOT_PATH . 'app/views/account/login.php';
    }

    // POST /account/checklogin
    public function checklogin() {
        $username = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if (empty($username) || empty($password)) {
            SessionHelper::setFlash('error', 'Vui lòng nhập đầy đủ thông tin!');
            header('Location: /ToTheKiet/account/login');
            exit;
        }

        $result = $this->userModel->login($username, $password);

        if ($result['success']) {
            SessionHelper::setUser($result['user']);
            SessionHelper::setToken($result['token']);
            // Admin về trang quản lý, user thường về trang chủ
            if (SessionHelper::isAdmin()) {
                header('Location: /ToTheKiet/admin/dashboard');
            } else {
                header('Location: /ToTheKiet/');
            }
        } else {
            SessionHelper::setFlash('error', $result['message']);
            header('Location: /ToTheKiet/account/login');
        }
        exit;
    }

    // GET /account/register
    public function register() {
        if (SessionHelper::isLoggedIn()) {
            header('Location: /ToTheKiet/');
            exit;
        }
        $flash = SessionHelper::getFlash();
        include ROOT_PATH . 'app/views/account/register.php';
    }

    // POST /account/doregister
    public function doregister() {
        $username = trim($_POST['username'] ?? '');
        $fullname = trim($_POST['fullname'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $confirm  = trim($_POST['confirm_password'] ?? '');

        // Validation
        if (empty($username) || empty($fullname) || empty($password) || empty($confirm)) {
            SessionHelper::setFlash('error', 'Vui lòng nhập đầy đủ thông tin!');
            header('Location: /ToTheKiet/account/register');
            exit;
        }

        if (strlen($password) < 6) {
            SessionHelper::setFlash('error', 'Mật khẩu phải có ít nhất 6 ký tự!');
            header('Location: /ToTheKiet/account/register');
            exit;
        }

        if ($password !== $confirm) {
            SessionHelper::setFlash('error', 'Mật khẩu xác nhận không khớp!');
            header('Location: /ToTheKiet/account/register');
            exit;
        }

        $result = $this->userModel->register($username, $fullname, $password);

        if ($result['success']) {
            SessionHelper::setFlash('success', 'Đăng ký thành công! Vui lòng đăng nhập.');
            header('Location: /ToTheKiet/account/login');
        } else {
            SessionHelper::setFlash('error', $result['message']);
            header('Location: /ToTheKiet/account/register');
        }
        exit;
    }

    public function profile() {
        SessionHelper::requireLogin();
        $user = SessionHelper::getCurrentUser();
        $flash = SessionHelper::getFlash();
        include ROOT_PATH . 'app/views/account/profile.php';
    }

    // GET /account/logout
    public function logout() {
        SessionHelper::logout();
        SessionHelper::setFlash('success', 'Đã đăng xuất thành công!');
        header('Location: /ToTheKiet/account/login');
        exit;
 
    }

}