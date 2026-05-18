<?php
require_once 'app/models/OrderModel.php';
require_once 'app/helpers/SessionHelper.php';

class AdminOrderController {
    private $orderModel;

    public function __construct() {
        SessionHelper::requireAdmin();
        $this->orderModel = new OrderModel();
    }

    // GET /admin/orders
    public function index() {
        $orders = $this->orderModel->getAllOrders();
        $flash = SessionHelper::getFlash();
        include ROOT_PATH . 'app/views/admin/orders.php';
    }

    // POST /admin/order/updateStatus
    public function updateStatus() {
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
                SessionHelper::setFlash('success', 'Cập nhật trạng thái đơn hàng thành công!');
            } else {
                SessionHelper::setFlash('error', 'Cập nhật thất bại!');
            }
            // ✅ FIX: Redirect về orderHistory (nơi form được render)
            header('Location: /ToTheKiet/product/orderHistory');
            exit;
        }
    }
}
?>