<?php include ROOT_PATH . 'app/views/shares/header.php'; ?>

<div class="container mt-4">
    <h1 class="mb-4"><i class="bi bi-cart3"></i> Giỏ hàng</h1>

    <?php if (!empty($cart)): ?>
        <!-- Bảng giỏ hàng -->
        <div class="card shadow-sm mb-4">
            <div class="card-body p-0">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Ảnh</th>
                            <th>Đơn giá</th>
                            <th>Số lượng</th>
                            <th>Thành tiền</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $total = 0;
                            foreach ($cart as $id => $item): 
                                $subtotal = $item['price'] * $item['quantity'];
                                $total += $subtotal;
                                $cancelled = isset($item['cancelled']) && $item['cancelled'];
                        ?>
                        <tr class="<?php echo $cancelled ? 'table-secondary text-muted' : ''; ?>" id="row-<?php echo $id; ?>">
                            <td>
                                <strong><?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?></strong>
                            </td>
                            <td>
                                <?php if (!empty($item['image'])): ?>
                                    <img src="/ToTheKiet/<?php echo ltrim($item['image'], '/'); ?>"
                                         alt="Product Image"
                                         style="max-width: 70px; max-height: 70px; object-fit: cover; border-radius: 6px;"
                                         onerror="this.src='/ToTheKiet/uploads/no-image.png'; this.onerror=null;">
                                <?php else: ?>
                                    <span class="text-muted">Không có ảnh</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo number_format($item['price'], 0, ',', '.'); ?> VND</td>
                            <td>
                                <?php if (!$cancelled): ?>
                                <div class="input-group" style="width: 120px;">
                                    <a href="/ToTheKiet/Product/decreaseQuantity/<?php echo $id; ?>" 
                                       class="btn btn-outline-secondary btn-sm">−</a>
                                    <input type="text" class="form-control form-control-sm text-center" 
                                           value="<?php echo $item['quantity']; ?>" readonly>
                                    <a href="/ToTheKiet/Product/increaseQuantity/<?php echo $id; ?>" 
                                       class="btn btn-outline-secondary btn-sm">+</a>
                                </div>
                                <?php else: ?>
                                    <span><?php echo $item['quantity']; ?></span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if (!$cancelled): ?>
                                    <strong><?php echo number_format($subtotal, 0, ',', '.'); ?> VND</strong>
                                <?php else: ?>
                                    <del class="text-muted"><?php echo number_format($subtotal, 0, ',', '.'); ?> VND</del>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($cancelled): ?>
                                    <span class="badge bg-secondary">Đã Xoá</span>
                                <?php else: ?>
                                    <span class="badge bg-success">Đang chọn</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if (!$cancelled): ?>
                                    <a href="/ToTheKiet/Product/cancelItem/<?php echo $id; ?>" 
                                       class="btn btn-warning btn-sm"
                                       onclick="return confirm('Hủy sản phẩm này khỏi giỏ hàng?');">
                                       <i class="bi bi-x-circle"></i> Xoá
                                    </a>
                                <?php else: ?>
                                    <a href="/ToTheKiet/Product/restoreItem/<?php echo $id; ?>" 
                                       class="btn btn-info btn-sm">
                                       <i class="bi bi-arrow-counterclockwise"></i> Khôi phục
                                    </a>
                                <?php endif; ?>
                                
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <td colspan="4" class="text-end fw-bold">Tổng cộng:</td>
                            <td colspan="3" class="fw-bold text-danger fs-5">
                                <?php echo number_format($total, 0, ',', '.'); ?> VND
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Nút hành động -->
        <div class="d-flex gap-2 mb-5">
            <a href="/ToTheKiet/Product" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Tiếp tục mua sắm
            </a>
            <a href="/ToTheKiet/Product/clearCart" class="btn btn-outline-danger"
               onclick="return confirm('Bạn có chắc muốn hủy toàn bộ giỏ hàng?');">
                <i class="bi bi-trash3"></i> Xoá toàn bộ
            </a>
            <a href="/ToTheKiet/Product/checkout" class="btn btn-success ms-auto">
                <i class="bi bi-credit-card"></i> Thanh toán
            </a>
        </div>

    <?php else: ?>
        <div class="alert alert-info text-center py-5">
            <i class="bi bi-cart-x fs-1"></i>
            <p class="mt-3 fs-5">Giỏ hàng của bạn đang trống.</p>
            <a href="/ToTheKiet/Product" class="btn btn-primary mt-2">Mua sắm ngay</a>
        </div>
    <?php endif; ?>

    <!-- Lịch sử đơn hàng -->
    <div class="mt-4">
        <h3 class="mb-3"><i class="bi bi-clock-history"></i> Lịch sử đơn hàng</h3>
        <?php if (!empty($orderHistory)): ?>
            <div class="accordion" id="orderAccordion">
                <?php foreach ($orderHistory as $index => $order): ?>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading-<?php echo $index; ?>">
                        <button class="accordion-button collapsed" type="button"
                                data-bs-toggle="collapse" data-bs-target="#collapse-<?php echo $index; ?>">
                            <span class="me-3">🧾 Đơn hàng #<?php echo htmlspecialchars($order['id'], ENT_QUOTES, 'UTF-8'); ?></span>
                            <span class="me-3 text-muted"><?php echo htmlspecialchars($order['date'], ENT_QUOTES, 'UTF-8'); ?></span>
                            <span class="badge 
                                <?php 
                                    echo match($order['status']) {
                                        'completed' => 'bg-success',
                                        'pending'   => 'bg-warning text-dark',
                                        'cancelled' => 'bg-danger',
                                        default     => 'bg-secondary'
                                    };
                                ?>">
                                <?php 
                                    echo match($order['status']) {
                                        'completed' => 'Hoàn thành',
                                        'pending'   => 'Đang xử lý',
                                        'cancelled' => 'Đã hủy',
                                        default     => 'Không rõ'
                                    };
                                ?>
                            </span>
                            <span class="ms-auto fw-bold text-danger">
                                <?php echo number_format($order['total'], 0, ',', '.'); ?> VND
                            </span>
                        </button>
                    </h2>
                    <div id="collapse-<?php echo $index; ?>" class="accordion-collapse collapse"
                         data-bs-parent="#orderAccordion">
                        <div class="accordion-body">
                            <table class="table table-sm">
                                <thead><tr><th>Sản phẩm</th><th>Số lượng</th><th>Đơn giá</th><th>Thành tiền</th></tr></thead>
                                <tbody>
                                    <?php foreach ($order['items'] as $item): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?php echo $item['quantity']; ?></td>
                                        <td><?php echo number_format($item['price'], 0, ',', '.'); ?> VND</td>
                                        <td><?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?> VND</td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-secondary text-center">
                <i class="bi bi-inbox fs-4"></i>
                <p class="mt-2 mb-0">Bạn chưa có đơn hàng nào.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include ROOT_PATH . 'app/views/shares/footer.php'; ?>