<?php
require_once 'app/config/database.php';

class UserModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getUserByUsername($username) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function register($username, $fullname, $password) {
        if ($this->getUserByUsername($username)) {
            return ['success' => false, 'message' => 'Tên đăng nhập đã tồn tại!'];
        }

        $stmt = $this->conn->prepare("SELECT id FROM users WHERE fullname = :fullname");
        $stmt->bindParam(':fullname', $fullname);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return ['success' => false, 'message' => 'Họ tên đã được sử dụng!'];
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $role = 0;

        $stmt = $this->conn->prepare(
            "INSERT INTO users (username, fullname, password, ROLE) VALUES (:username, :fullname, :password, :role)"
        );
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':fullname', $fullname);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':role', $role);

        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'Đăng ký thành công!'];
        }
        return ['success' => false, 'message' => 'Đăng ký thất bại, vui lòng thử lại!'];
    }

    public function login($username, $password) {
        $user = $this->getUserByUsername($username);
        if (!$user) {
            return ['success' => false, 'message' => 'Tài khoản không tồn tại!'];
        }
        if (!password_verify($password, $user['password'])) {
            return ['success' => false, 'message' => 'Mật khẩu không chính xác!'];
        }

        require_once 'app/utils/JWTHandler.php';
        $jwtHandler = new JWTHandler();
        $token = $jwtHandler->encode([
            'id' => $user['id'],
            'username' => $user['username'],
            'role' => $user['ROLE'] ?? 0
        ]);

        return ['success' => true, 'user' => $user, 'token' => $token];
    }

    public function getAllUsers() {
        $stmt = $this->conn->prepare("SELECT id, username, fullname, ROLE, created_at FROM users ORDER BY created_at DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteUser($id) {
        $stmt = $this->conn->prepare("DELETE FROM users WHERE id = :id AND ROLE != 1");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // ✅ FIX: Gán biến TRƯỚC khi bindParam
    public function createDefaultAdmin() {
        $admin = $this->getUserByUsername('admin');
        if (!$admin) {
            $username       = 'admin';
            $fullname       = 'Quản trị viên';
            $hashedPassword = password_hash('admin123', PASSWORD_DEFAULT);
            $role           = 1;

            $stmt = $this->conn->prepare(
                "INSERT INTO users (username, fullname, password, ROLE) VALUES (:username, :fullname, :password, :role)"
            );
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':fullname', $fullname);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':role', $role);
            $stmt->execute();
        }
    }
}
?>