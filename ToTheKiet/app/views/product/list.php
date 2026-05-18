<?php include ROOT_PATH . 'app/views/shares/header.php'; ?>

<style>
    /* Sidebar danh mục */
    .category-sidebar {
        background: white;
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        position: sticky;
        top: 100px;
    }
    .category-sidebar h5 {
        font-weight: 700;
        margin-bottom: 20px;
        color: var(--dark);
    }
    .category-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .category-list li {
        margin-bottom: 12px;
    }
    .category-list a {
        text-decoration: none;
        color: var(--gray);
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 8px 12px;
        border-radius: 8px;
        transition: all 0.2s;
    }
    .category-list a i {
        width: 24px;
        font-size: 1.1rem;
    }
    .category-list a:hover,
    .category-list a.active {
        background: var(--primary);
        color: white;
    }
    .category-list a:hover i,
    .category-list a.active i {
        color: white;
    }
    
    /* Grid sản phẩm (giữ nguyên style cũ) */
    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 30px;
    }
    .product-card {
        background: #fff;
        border-radius: 20px;
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    }
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.12);
    }
    .product-img {
        height: 220px;
        background-size: cover;
        background-position: center;
        background-color: #f8f9fa;
        position: relative;
    }
    .product-info {
        padding: 20px;
    }
    .product-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 10px;
        color: var(--dark);
        text-decoration: none;
        display: block;
    }
    .product-title:hover {
        color: var(--primary);
    }
    .product-price {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--primary);
        margin: 15px 0;
    }
    .product-actions {
        display: flex;
        gap: 10px;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
    }
    .btn-sm-custom {
        padding: 6px 12px;
        border-radius: 25px;
        font-size: 0.85rem;
    }
    .btn-cart {
        background: var(--primary);
        color: white;
        border: none;
        transition: 0.3s;
    }
    .btn-cart:hover {
        background: var(--primary-dark);
        transform: scale(1.02);
    }
    .admin-bar {
        margin-bottom: 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .page-title {
        font-family: 'Playfair Display', serif;
        font-size: 2rem;
        font-weight: 700;
    }
    @media (max-width: 768px) {
        .product-grid {
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 20px;
        }
    }
</style>

<div class="container mt-4">
    <div class="row">
        <!-- Sidebar danh mục -->
        <div class="col-md-3 mb-4">
            <div class="category-sidebar">
                <h5><i class="fas fa-list me-2"></i> Danh mục</h5>
                <ul class="category-list">
                    <li>
                        <a href="/ToTheKiet/product/index" class="<?php echo !isset($category_id) ? 'active' : ''; ?>">
                            <i class="fas fa-th-large"></i> Tất cả sản phẩm
                        </a>
                    </li>
                    <?php foreach ($categories as $cat): ?>
                    <li>
                        <a href="/ToTheKiet/product/index/<?php echo $cat->id; ?>" 
                           class="<?php echo (isset($category_id) && $category_id == $cat->id) ? 'active' : ''; ?>">
                            <i class="fas <?php 
                                $icon = 'fa-tag';
                                switch (strtolower($cat->name)) {
                                    case 'điện tử': $icon = 'fa-mobile-alt'; break;
                                    case 'thời trang': $icon = 'fa-tshirt'; break;
                                    case 'gia dụng': $icon = 'fa-utensils'; break;
                                    case 'điện thoại & phụ kiện': $icon = 'fa-mobile'; break;
                                    case 'máy tính & laptop': $icon = 'fa-laptop'; break;
                                    case 'đồng hồ': $icon = 'fa-clock'; break;
                                    case 'giày dép nam': $icon = 'fa-shoe-prints'; break;
                                    case 'thiết bị điện gia dụng': $icon = 'fa-blender'; break;
                                    case 'thể thao & du lịch': $icon = 'fa-futbol'; break;
                                    case 'ô tô & xe máy & xe đạp': $icon = 'fa-motorcycle'; break;
                                    case 'thời trang nữ': $icon = 'fa-female'; break;
                                    case 'mẹ & bé': $icon = 'fa-baby'; break;
                                    case 'nhà cửa & đời sống': $icon = 'fa-home'; break;
                                    case 'sắc đẹp': $icon = 'fa-spa'; break;
                                    case 'sức khỏe': $icon = 'fa-heartbeat'; break;
                                    case 'giày dép nữ': $icon = 'fa-shoe-prints'; break;
                                    case 'túi ví nữ': $icon = 'fa-bag-shopping'; break;
                                    case 'phụ kiện & trang sức nữ': $icon = 'fa-gem'; break;
                                   
                                    default: $icon = 'fa-tag';
                                }
                                echo $icon;
                            ?>"></i>
                            <?php echo htmlspecialchars($cat->name); ?>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <!-- Danh sách sản phẩm -->
        <div class="col-md-9">
            <div class="admin-bar">
                <h1 class="page-title">
                    <?php if ($category_name): ?>
                        <?php echo htmlspecialchars($category_name); ?>
                    <?php else: ?>
                        Sản phẩm
                    <?php endif; ?>
                </h1>
                <?php if (SessionHelper::isAdmin()): ?>
                    <a href="/ToTheKiet/product/add" class="btn btn-primary-custom">
                        <i class="fas fa-plus-circle"></i> Thêm sản phẩm mới
                    </a>
                <?php endif; ?>
            </div>

            <div class="product-grid">
                <?php foreach ($products as $product): ?>
                    <div class="product-card">
                        <div class="product-img" style="background-image: url('/ToTheKiet/<?php echo ltrim($product->image, '/'); ?>');">
                            <?php if (empty($product->image)): ?>
                                <div style="height:100%; display: flex; align-items: center; justify-content: center; background: #e9ecef;">
                                    <i class="fas fa-image fa-3x text-muted"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="product-info">
                            <a href="/ToTheKiet/product/show/<?php echo $product->id; ?>" class="product-title">
                                <?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>
                            </a>
                            <div class="product-price">
                                <?php echo number_format($product->price, 0, ',', '.'); ?> ₫
                            </div>
                            <div class="product-actions">
                                <a href="/ToTheKiet/product/addToCart/<?php echo $product->id; ?>" class="btn btn-cart btn-sm-custom">
                                    <i class="fas fa-cart-plus"></i> Thêm vào giỏ
                                </a>
                                <?php if (SessionHelper::isAdmin()): ?>
                                    <div class="d-flex gap-2">
                                        <a href="/ToTheKiet/product/edit/<?php echo $product->id; ?>" class="btn btn-warning btn-sm-custom">
                                            <i class="fas fa-edit"></i> Sửa
                                        </a>
                                        <a href="/ToTheKiet/product/delete/<?php echo $product->id; ?>" class="btn btn-danger btn-sm-custom" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">
                                            <i class="fas fa-trash"></i> Xóa
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<?php include ROOT_PATH . 'app/views/shares/footer.php'; ?>