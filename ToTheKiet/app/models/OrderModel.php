<?php
require_once 'app/config/database.php';

class OrderModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // ✅ FIX: o.* đã bao gồm status, thêm rõ ràng để chắc chắn
    public function getAllOrders() {
        $query = "
            SELECT o.id, o.name, o.phone, o.address, o.status,
                   o.created_at,
                   u.username as user_username,
                   u.fullname as user_fullname,
                   COALESCE(SUM(od.quantity * od.price), 0) as total
            FROM orders o
            LEFT JOIN users u ON o.user_id = u.id
            LEFT JOIN order_details od ON o.id = od.order_id
            GROUP BY o.id, o.name, o.phone, o.address, o.status, o.created_at, u.username, u.fullname
            ORDER BY o.created_at DESC
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($orders as &$order) {
            $detailQuery = "
                SELECT p.name, od.quantity, od.price, p.image
                FROM order_details od
                JOIN product p ON od.product_id = p.id
                WHERE od.order_id = :order_id
            ";
            $detailStmt = $this->conn->prepare($detailQuery);
            $detailStmt->bindParam(':order_id', $order['id']);
            $detailStmt->execute();
            $order['items'] = $detailStmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return $orders;
    }

    public function updateOrderStatus($orderId, $status) {
        $query = "UPDATE orders SET status = :status WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $orderId);
        return $stmt->execute();
    }
}
?>