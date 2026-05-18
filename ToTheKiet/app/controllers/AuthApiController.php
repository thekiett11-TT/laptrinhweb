<?php
require_once 'app/models/UserModel.php';

class AuthApiController {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    // POST /api/auth
    public function store() {
        header('Content-Type: application/json');
        
        // Hỗ trợ cả application/json và application/x-www-form-urlencoded
        $data = json_decode(file_get_contents("php://input"), true);
        
        $username = $data['username'] ?? $_POST['username'] ?? '';
        $password = $data['password'] ?? $_POST['password'] ?? '';

        if (empty($username) || empty($password)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Vui lòng cung cấp username và password']);
            return;
        }

        $result = $this->userModel->login($username, $password);

        if ($result['success']) {
            http_response_code(200);
            echo json_encode([
                'success' => true,
                'message' => 'Đăng nhập thành công',
                'token' => $result['token'],
                'user' => [
                    'id' => $result['user']['id'],
                    'username' => $result['user']['username'],
                    'fullname' => $result['user']['fullname'],
                    'role' => $result['user']['ROLE'] ?? $result['user']['role']
                ]
            ]);
        } else {
            http_response_code(401);
            echo json_encode([
                'success' => false,
                'message' => $result['message']
            ]);
        }
    }
}
?>
