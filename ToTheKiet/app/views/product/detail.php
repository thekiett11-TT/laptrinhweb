<?php include ROOT_PATH . 'app/views/shares/header.php'; ?>

<style>
    .product-detail {
        background: white;
        border-radius: 24px;
        padding: 30px;
        margin: 30px auto;
        max-width: 900px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.08);
    }
    .product-image {
        width: 100%;
        border-radius: 16px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    .product-price {
        font-size: 1.8rem;
        color: var(--primary);
        font-weight: 700;
    }
    .btn-cart-large {
        background: var(--primary);
        color: white;
        padding: 12px 30px;
        border-radius: 40px;
        font-weight: 600;
        transition: 0.3s;
        display: inline-block;
    }
    .btn-cart-large:hover {
        background: var(--primary-dark);
        transform: scale(1.02);
    }
</style>

<div class="container">
    <div class="product-detail">
        <div class="row">
            <div class="col-md-5">
                <?php if (!empty($product->image)): ?>
                    <img src="/ToTheKiet/<?php echo ltrim($product->image, '/'); ?>" class="product-image" alt="<?php echo htmlspecialchars($product->name); ?>">
                <?php else: ?>
                    <div class="product-image bg-light d-flex align-items-center justify-content-center" style="height: 300px;">
                        <i class="fas fa-image fa-4x text-muted"></i>
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-md-7">
                <h1 class="mb-3" style="font-family: 'Playfair Display', serif;"><?php echo htmlspecialchars($product->name); ?></h1>
                <p class="text-muted"><i class="fas fa-tag"></i> Danh mục: <?php echo htmlspecialchars($product->category_name ?? 'Chưa có'); ?></p>
                <div class="product-price mb-3">
                    <?php echo number_format($product->price, 0, ',', '.'); ?> ₫
                </div>
                <div class="mb-4">
                    <h5>Mô tả sản phẩm</h5>
                    <p><?php echo nl2br(htmlspecialchars($product->description)); ?></p>
                </div>
                <div class="d-flex gap-3">
                    <a href="/ToTheKiet/product/addToCart/<?php echo $product->id; ?>" class="btn-cart-large">
                        <i class="fas fa-cart-plus"></i> Thêm vào giỏ hàng
                    </a>
                    <?php if (SessionHelper::isAdmin()): ?>
                        <a href="/ToTheKiet/product/edit/<?php echo $product->id; ?>" class="btn btn-warning btn-lg">
                            <i class="fas fa-edit"></i> Sửa
                        </a>
                        <a href="/ToTheKiet/product/delete/<?php echo $product->id; ?>" class="btn btn-danger btn-lg" onclick="return confirm('Xóa sản phẩm này?')">
                            <i class="fas fa-trash"></i> Xóa
                        </a>
                    <?php endif; ?>
                </div>
                <div class="mt-4">
                    <a href="/ToTheKiet/product" class="text-decoration-none">← Quay lại danh sách</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include ROOT_PATH . 'app/views/shares/footer.php'; ?>