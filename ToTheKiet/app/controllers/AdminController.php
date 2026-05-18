<?php
require_once 'app/models/UserModel.php';
require_once 'app/models/ProductModel.php';
require_once 'app/models/OrderModel.php';
require_once 'app/helpers/SessionHelper.php';

class AdminController {
    private $userModel;
    private $productModel;
    private $orderModel;

    public function __construct() {
        SessionHelper::requireAdmin();
        $this->userModel    = new UserModel();
        $this->productModel = new ProductModel();
        $this->orderModel   = new OrderModel();
    }

    // GET /admin/dashboard
    public function dashboard() {
        $users    = $this->userModel->getAllUsers();
        $products = $this->productModel->getProducts();
        $flash    = SessionHelper::getFlash();
        include ROOT_PATH . 'app/views/admin/dashboard.php';
    }

    // POST /admin/deleteuser/{id}
    public function deleteuser($id) {
        $result = $this->userModel->deleteUser($id);
        if ($result) {
            SessionHelper::setFlash('success', 'Đã xóa người dùng thành công!');
        } else {
            SessionHelper::setFlash('error', 'Không thể xóa người dùng này!');
        }
        header('Location: /ToTheKiet/admin/dashboard');
        exit;
    }

    // POST /admin/deleteproduct/{id}
    public function deleteproduct($id) {
        $result = $this->productModel->deleteProduct($id);
        if ($result) {
            SessionHelper::setFlash('success', 'Đã xóa sản phẩm thành công!');
        } else {
            SessionHelper::setFlash('error', 'Không thể xóa sản phẩm này!');
        }
        header('Location: /ToTheKiet/admin/dashboard');
        exit;
    }

    // ✅ POST /admin/updateorderstatus  ← form action phải trỏ về đây
    public function updateorderstatus() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $orderId = $_POST['order_id'] ?? 0;
            $status  = $_POST['status'] ?? '';

            $allowedStatuses = ['pending', 'processing', 'completed', 'cancelled'];
            if (!in_array($status, $allowedStatuses)) {
                SessionHelper::setFlash('error', 'Trạng thái không hợp lệ!');
                header('Location: /ToTheKiet/product/orderHistory');
                exit;
            }

            $result = $this->orderModel->updateOrderStatus($orderId, $status);
            if ($result) {
                SessionHelper::setFlash('success', 'Cập nhật trạng thái thành công!');
            } else {
                SessionHelper::setFlash('error', 'Cập nhật thất bại!');
            }
        }
        header('Location: /ToTheKiet/product/orderHistory');
        exit;
    }
}
?>