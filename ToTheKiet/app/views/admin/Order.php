<?php include ROOT_PATH . 'app/views/shares/header.php'; ?>
<style>
/* CSS tương tự như orderHistory.php, nhưng thêm style riêng */
</style>
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-white py-3">
            <h4 class="mb-0"><i class="fas fa-boxes me-2" style="color: var(--primary);"></i> Quản lý đơn hàng</h4>
        </div>
        <div class="card-body">
            <?php if ($flash): ?>
                <div class="alert alert-<?php echo $flash['type'] == 'success' ? 'success' : 'danger'; ?> alert-dismissible fade show" role="alert">
                    <?php echo htmlspecialchars($flash['message']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Người dùng</th>
                            <th>Người nhận</th>
                            <th>SĐT</th>
                            <th>Địa chỉ</th>
                            <th>Ngày đặt</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                         <tr>
                             <td><?php echo $order['id']; ?></td>
                             <td><?php echo htmlspecialchars($order['user_fullname']); ?> (<?php echo htmlspecialchars($order['username']); ?>)</td>
                             <td><?php echo htmlspecialchars($order['name']); ?></td>
                             <td><?php echo htmlspecialchars($order['phone']); ?></td>
                             <td><?php echo htmlspecialchars($order['address']); ?></td>
                             <td><?php echo date('d/m/Y H:i', strtotime($order['created_at'])); ?></td>
                             <td><?php echo number_format($order['total'], 0, ',', '.'); ?> VND</td>
                             <td>
                                 <span class="badge bg-<?php
                                    switch($order['status']) {
                                        case 'pending': echo 'warning'; break;
                                        case 'processing': echo 'info'; break;
                                        case 'completed': echo 'success'; break;
                                        case 'cancelled': echo 'danger'; break;
                                        default: echo 'secondary';
                                    }
                                 ?>">
                                     <?php echo $order['status']; ?>
                                 </span>
                             </td>
                             <td>
                                 <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#orderModal<?php echo $order['id']; ?>">Chi tiết</button>
                             </td>
                         </tr>
                         <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php foreach ($orders as $order): ?>
<div class="modal fade" id="orderModal<?php echo $order['id']; ?>" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Chi tiết đơn hàng #<?php echo $order['id']; ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p><strong>Người nhận:</strong> <?php echo htmlspecialchars($order['name']); ?></p>
                <p><strong>SĐT:</strong> <?php echo htmlspecialchars($order['phone']); ?></p>
                <p><strong>Địa chỉ:</strong> <?php echo htmlspecialchars($order['address']); ?></p>
                <p><strong>Ngày đặt:</strong> <?php echo date('d/m/Y H:i', strtotime($order['created_at'])); ?></p>
                <p><strong>Trạng thái hiện tại:</strong> <span class="badge bg-<?php
                    switch($order['status']) {
                        case 'pending': echo 'warning'; break;
                        case 'processing': echo 'info'; break;
                        case 'completed': echo 'success'; break;
                        case 'cancelled': echo 'danger'; break;
                        default: echo 'secondary';
                    }
                ?>"><?php echo $order['status']; ?></span></p>
                
                <h6>Sản phẩm:</h6>
                <table class="table table-sm">
                    <thead>
                        <tr><th>Sản phẩm</th><th>Số lượng</th><th>Đơn giá</th><th>Thành tiền</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach ($order['items'] as $item): ?>
                         <tr>
                             <td><?php echo htmlspecialchars($item['name']); ?></td>
                             <td><?php echo $item['quantity']; ?></td>
                             <td><?php echo number_format($item['price'], 0, ',', '.'); ?> VND</td>
                             <td><?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?> VND</td>
                         </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                
                <form action="/ToTheKiet/admin/order/updateStatus" method="POST" class="mt-3">
                    <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                    <div class="row">
                        <div class="col-md-6">
                            <select name="status" class="form-select">
                                <option value="pending" <?php echo $order['status'] == 'pending' ? 'selected' : ''; ?>>Chờ xử lý</option>
                                <option value="processing" <?php echo $order['status'] == 'processing' ? 'selected' : ''; ?>>Đang xử lý</option>
                                <option value="completed" <?php echo $order['status'] == 'completed' ? 'selected' : ''; ?>>Hoàn thành</option>
                                <option value="cancelled" <?php echo $order['status'] == 'cancelled' ? 'selected' : ''; ?>>Đã hủy</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary">Cập nhật trạng thái</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>

<?php include ROOT_PATH . 'app/views/shares/footer.php'; ?>