<?php include ROOT_PATH . 'app/views/shares/header.php'; ?>

<style>
/* Copy style từ login/register, nhưng thêm biến thể */
:root {
    --ink: #1a1a2e;
    --ink-soft: #4a4a6a;
    --ink-mute: #9090a8;
    --surface: #f7f7fb;
    --card: #ffffff;
    --accent: #ff6b35;
    --accent-soft: #fff0f1;
    --success: #2d6a4f;
    --success-soft: #d8f3dc;
    --border: #e8e8f0;
    --shadow-sm: 0 2px 8px rgba(26,26,46,0.06);
    --shadow-md: 0 8px 32px rgba(26,26,46,0.10);
    --radius: 16px;
    --radius-sm: 10px;
}

body {
    background: var(--surface);
}

.oh-wrapper {
    max-width: 1200px;
    margin: 0 auto;
    padding: 48px 24px 80px;
}

/* Header */
.oh-header {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    margin-bottom: 48px;
    gap: 16px;
    flex-wrap: wrap;
}

.oh-header-left h1 {
    font-family: 'Playfair Display', serif;
    font-size: 2.4rem;
    font-weight: 700;
    color: var(--ink);
    line-height: 1.1;
}

.oh-header-left p {
    color: var(--ink-mute);
    font-size: 0.95rem;
    margin-top: 6px;
}

.oh-back-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    border: 1.5px solid var(--border);
    border-radius: 50px;
    color: var(--ink-soft);
    text-decoration: none;
    font-size: 0.88rem;
    font-weight: 500;
    background: var(--card);
    transition: all 0.2s;
}

.oh-back-btn:hover {
    border-color: var(--accent);
    color: var(--accent);
    text-decoration: none;
}

/* Stats bar */
.oh-stats {
    display: flex;
    gap: 16px;
    margin-bottom: 36px;
    flex-wrap: wrap;
}

.oh-stat {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: var(--radius-sm);
    padding: 16px 24px;
    flex: 1;
    min-width: 150px;
    box-shadow: var(--shadow-sm);
}

.oh-stat-label {
    font-size: 0.78rem;
    color: var(--ink-mute);
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    margin-bottom: 6px;
}

.oh-stat-value {
    font-size: 1.5rem;
    font-weight: 600;
    color: var(--ink);
}

.oh-stat-value.accent { color: var(--accent); }

/* Order card */
.oh-order-card {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    margin-bottom: 20px;
    box-shadow: var(--shadow-sm);
    overflow: hidden;
    transition: box-shadow 0.25s, transform 0.25s;
}

.oh-order-card:hover {
    box-shadow: var(--shadow-md);
    transform: translateY(-2px);
}

.oh-order-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 22px 28px;
    cursor: pointer;
    gap: 16px;
    flex-wrap: wrap;
    user-select: none;
}

.oh-order-id {
    font-family: 'Playfair Display', serif;
    font-size: 1.15rem;
    font-weight: 600;
    color: var(--ink);
    min-width: 110px;
}

.oh-order-id span {
    font-family: 'DM Sans', sans-serif;
    font-size: 0.78rem;
    font-weight: 400;
    color: var(--ink-mute);
    display: block;
    margin-top: 2px;
}

.oh-order-customer {
    display: flex;
    flex-direction: column;
    gap: 3px;
    flex: 1;
    min-width: 140px;
}

.oh-order-customer strong {
    font-size: 0.95rem;
    color: var(--ink);
}

.oh-order-customer small {
    font-size: 0.82rem;
    color: var(--ink-mute);
}

.oh-order-meta {
    display: flex;
    align-items: center;
    gap: 16px;
    flex-wrap: wrap;
}

.oh-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 5px 12px;
    border-radius: 50px;
    font-size: 0.78rem;
    font-weight: 600;
    background: #e9ecef;
    color: #495057;
}

.oh-badge.pending { background: #fff3cd; color: #856404; }
.oh-badge.processing { background: #cce5ff; color: #004085; }
.oh-badge.completed { background: #d4edda; color: #155724; }
.oh-badge.cancelled { background: #f8d7da; color: #721c24; }

.oh-order-total {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--accent);
    white-space: nowrap;
}

.oh-chevron {
    width: 28px;
    height: 28px;
    border: 1.5px solid var(--border);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--ink-mute);
    transition: transform 0.3s, background 0.2s;
    flex-shrink: 0;
    font-style: normal;
}

.oh-order-card.open .oh-chevron {
    transform: rotate(180deg);
    background: var(--surface);
}

.oh-divider {
    height: 1px;
    background: var(--border);
    margin: 0 28px;
    display: none;
}

.oh-order-card.open .oh-divider { display: block; }

.oh-order-body {
    display: none;
    padding: 28px 28px 24px;
}

.oh-order-card.open .oh-order-body { display: block; }

/* Info grid */
.oh-info-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
    margin-bottom: 28px;
}

@media (max-width: 600px) {
    .oh-info-grid { grid-template-columns: 1fr; }
}

.oh-info-item {
    background: var(--surface);
    border-radius: var(--radius-sm);
    padding: 14px 18px;
}

.oh-info-item label {
    font-size: 0.75rem;
    color: var(--ink-mute);
    text-transform: uppercase;
    letter-spacing: 0.06em;
    font-weight: 500;
    display: block;
    margin-bottom: 5px;
}

.oh-info-item p {
    font-size: 0.92rem;
    color: var(--ink);
    font-weight: 500;
}

/* Product list */
.oh-product-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.oh-product-item {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 14px 18px;
    background: var(--surface);
    border-radius: var(--radius-sm);
    border: 1px solid var(--border);
    transition: background 0.2s;
}

.oh-product-img {
    width: 60px;
    height: 60px;
    border-radius: 10px;
    object-fit: cover;
    background: var(--border);
    flex-shrink: 0;
    border: 1px solid var(--border);
}

.oh-product-info {
    flex: 1;
    min-width: 0;
}

.oh-product-info strong {
    font-size: 0.95rem;
    color: var(--ink);
    display: block;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.oh-product-qty {
    font-size: 0.85rem;
    color: var(--ink-soft);
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 6px;
    padding: 4px 10px;
    white-space: nowrap;
}

.oh-product-price {
    font-size: 0.95rem;
    font-weight: 600;
    color: var(--ink);
    white-space: nowrap;
    min-width: 110px;
    text-align: right;
}

/* Admin status form */
.admin-status-form {
    margin-top: 20px;
    padding-top: 16px;
    border-top: 1px solid var(--border);
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    align-items: center;
}

.admin-status-form select {
    padding: 8px 12px;
    border-radius: 8px;
    border: 1px solid var(--border);
    background: white;
    font-size: 0.85rem;
}

.admin-status-form button {
    background: var(--accent);
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 8px;
    cursor: pointer;
    transition: background 0.2s;
}

.admin-status-form button:hover {
    background: var(--primary-dark);
}

/* Empty state */
.oh-empty {
    text-align: center;
    padding: 80px 24px;
    background: var(--card);
    border-radius: var(--radius);
    border: 1px solid var(--border);
}

.oh-empty-icon {
    font-size: 3.5rem;
    margin-bottom: 20px;
    opacity: 0.3;
}

.oh-shop-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 28px;
    background: var(--accent);
    color: #fff;
    border-radius: 50px;
    text-decoration: none;
    font-weight: 500;
    font-size: 0.92rem;
    transition: background 0.2s, transform 0.2s;
}
</style>

<div class="oh-wrapper">
    <div class="oh-header">
        <div class="oh-header-left">
            <h1>Lịch sử đơn hàng</h1>
            <p>Theo dõi các đơn hàng đã đặt</p>
        </div>
        <a href="/ToTheKiet/Product" class="oh-back-btn">← Tiếp tục mua sắm</a>
    </div>

    <?php if (!empty($orderHistory)): ?>
        <?php
            $totalOrders = count($orderHistory);
            $totalRevenue = array_sum(array_column($orderHistory, 'total'));
            $totalItems = array_sum(array_map(fn($o) => array_sum(array_column($o['items'], 'quantity')), $orderHistory));
        ?>
        <div class="oh-stats">
            <div class="oh-stat">
                <div class="oh-stat-label">Tổng đơn hàng</div>
                <div class="oh-stat-value"><?php echo $totalOrders; ?></div>
            </div>
            <div class="oh-stat">
                <div class="oh-stat-label">Sản phẩm đã mua</div>
                <div class="oh-stat-value"><?php echo $totalItems; ?></div>
            </div>
            <div class="oh-stat">
                <div class="oh-stat-label">Tổng chi tiêu</div>
                <div class="oh-stat-value accent"><?php echo number_format($totalRevenue, 0, ',', '.'); ?> ₫</div>
            </div>
        </div>

        <?php foreach ($orderHistory as $index => $order): ?>
        <div class="oh-order-card" id="order-card-<?php echo $index; ?>">
            <div class="oh-order-head" onclick="toggleOrder(<?php echo $index; ?>)">
                <div class="oh-order-id">
                    Đơn #<?php echo str_pad($order['id'], 4, '0', STR_PAD_LEFT); ?>
                    <span><?php echo date('d/m/Y H:i', strtotime($order['date'])); ?></span>
                </div>
                <div class="oh-order-customer">
                    <strong><?php echo htmlspecialchars($order['name']); ?></strong>
                    <small>📞 <?php echo htmlspecialchars($order['phone']); ?></small>
                </div>
                <div class="oh-order-meta">
                    <span class="oh-badge <?php echo $order['status']; ?>">
                        <?php
                            $statusText = [
                                'pending' => 'Chờ xử lý',
                                'processing' => 'Đang xử lý',
                                'completed' => 'Hoàn thành',
                                'cancelled' => 'Đã hủy'
                            ][$order['status']] ?? $order['status'];
                            echo $statusText;
                        ?>
                    </span>
                    <span class="oh-order-total"><?php echo number_format($order['total'], 0, ',', '.'); ?> ₫</span>
                </div>
                <i class="oh-chevron">▾</i>
            </div>
            <div class="oh-divider"></div>
            <div class="oh-order-body">
                <div class="oh-info-grid">
                    <div class="oh-info-item">
                        <label>👤 Người nhận</label>
                        <p><?php echo htmlspecialchars($order['name']); ?></p>
                    </div>
                    <div class="oh-info-item">
                        <label>📞 Số điện thoại</label>
                        <p><?php echo htmlspecialchars($order['phone']); ?></p>
                    </div>
                    <div class="oh-info-item">
                        <label>📍 Địa chỉ giao hàng</label>
                        <p><?php echo htmlspecialchars($order['address']); ?></p>
                    </div>
                    <?php if (SessionHelper::isAdmin() && isset($order['user_username'])): ?>
                    <div class="oh-info-item">
                        <label>👥 Khách hàng</label>
                        <p><?php echo htmlspecialchars($order['user_fullname']); ?> (@<?php echo htmlspecialchars($order['user_username']); ?>)</p>
                    </div>
                    <?php endif; ?>
                </div>

                <div class="oh-product-list">
                    <?php foreach ($order['items'] as $item): ?>
                    <div class="oh-product-item">
                        <?php if (!empty($item['image'])): ?>
                            <img src="/ToTheKiet/<?php echo ltrim($item['image'], '/'); ?>" class="oh-product-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div class="oh-product-img-placeholder" style="display:none;">🖼</div>
                        <?php else: ?>
                            <div class="oh-product-img-placeholder">🛍</div>
                        <?php endif; ?>
                        <div class="oh-product-info">
                            <strong><?php echo htmlspecialchars($item['name']); ?></strong>
                            <small><?php echo number_format($item['price'], 0, ',', '.'); ?> ₫ / sản phẩm</small>
                        </div>
                        <span class="oh-product-qty">x<?php echo $item['quantity']; ?></span>
                        <div class="oh-product-price">
                            <?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?> ₫
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <?php if (SessionHelper::isAdmin()): ?>
                <form method="POST" action="/ToTheKiet/admin/updateorderstatus" class="admin-status-form">
                    <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                    <select name="status">
                        <option value="pending" <?php echo $order['status'] == 'pending' ? 'selected' : ''; ?>>Chờ xử lý</option>
                        <option value="processing" <?php echo $order['status'] == 'processing' ? 'selected' : ''; ?>>Đang xử lý</option>
                        <option value="completed" <?php echo $order['status'] == 'completed' ? 'selected' : ''; ?>>Hoàn thành</option>
                        <option value="cancelled" <?php echo $order['status'] == 'cancelled' ? 'selected' : ''; ?>>Đã hủy</option>
                    </select>
                    <button type="submit">Cập nhật</button>
                </form>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="oh-empty">
            <div class="oh-empty-icon"></div>
            <h2>Chưa có đơn hàng nào</h2>
            <p>Bắt đầu mua sắm ngay để có đơn hàng đầu tiên.</p>
            <a href="/ToTheKiet/Product" class="oh-shop-btn">Mua sắm ngay</a>
        </div>
    <?php endif; ?>
</div>

<script>
function toggleOrder(index) {
    const card = document.getElementById('order-card-' + index);
    card.classList.toggle('open');
}
</script>

<?php include ROOT_PATH . 'app/views/shares/footer.php'; ?>