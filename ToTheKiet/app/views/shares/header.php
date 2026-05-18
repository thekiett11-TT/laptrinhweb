<?php
require_once ROOT_PATH . 'app/helpers/SessionHelper.php';
$__user  = SessionHelper::getCurrentUser();
$__login = SessionHelper::isLoggedIn();
$__admin = SessionHelper::isAdmin();

$currentUrl = $_GET['url'] ?? '';
$isActive = function($pattern) use ($currentUrl) {
    return strpos($currentUrl, $pattern) === 0 ? 'active' : '';
};
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ToTheKiet Shop - Thời trang & Công nghệ</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* Giữ nguyên CSS như bạn đã có, không thay đổi */
        :root {
            --primary: #ff6b35;
            --primary-dark: #e55a2b;
            --secondary: #2c3e50;
            --dark: #1a1a2e;
            --light: #f8f9fa;
            --gray: #6c757d;
            --success: #2ecc71;
            --danger: #e74c3c;
            --warning: #f39c12;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e9ecef 100%);
            color: var(--dark);
        }
        
        /* Header Styles */
        .top-bar {
            background: var(--dark);
            color: white;
            padding: 8px 0;
            font-size: 13px;
        }
        
        .top-bar a {
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .top-bar a:hover {
            color: var(--primary);
        }
        
        .main-header {
            background: white;
            box-shadow: 0 2px 15px rgba(0,0,0,0.08);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        
        /* .logo h1 {
            font-family: 'Playfair Display', serif;
            font-size: 28px;
            font-weight: 700;
            margin: 0;
            background: linear-gradient(135deg, var(--primary), #ff9a6e);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
         */
        .logo p {
            font-size: 11px;
            color: var(--gray);
            margin: 0;
            letter-spacing: 1px;
        }
        
        .nav-menu {
            display: flex;
            gap: 30px;
            align-items: center;
        }
        
        .nav-menu a {
            color: var(--secondary);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
            position: relative;
        }
        
        .nav-menu a:hover,
        .nav-menu a.active {
            color: var(--primary);
        }
        
        .nav-menu a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--primary);
            transition: width 0.3s;
        }
        
        .nav-menu a:hover::after,
        .nav-menu a.active::after {
            width: 100%;
        }
        
        .cart-icon {
            position: relative;
        }
        
        .cart-badge {
            position: absolute;
            top: -8px;
            right: -12px;
            background: var(--primary);
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .user-menu {
            position: relative;
            cursor: pointer;
        }
        
        .user-dropdown {
            position: absolute;
            top: 100%;
            right: 0;
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
            min-width: 200px;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s;
            z-index: 100;
        }
        
        .user-menu:hover .user-dropdown {
            opacity: 1;
            visibility: visible;
        }
        
        .user-dropdown a {
            display: block;
            padding: 10px 20px;
            color: var(--dark);
            text-decoration: none;
            transition: background 0.3s;
        }
        
        .user-dropdown a:hover {
            background: #f8f9fa;
            color: var(--primary);
        }
        
        .user-dropdown hr {
            margin: 0;
        }
        
        .btn-primary-custom {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border: none;
            padding: 10px 25px;
            border-radius: 25px;
            color: white;
            font-weight: 600;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255,107,53,0.3);
            color: white;
        }
        
        .btn-outline-custom {
            border: 2px solid var(--primary);
            background: transparent;
            padding: 8px 20px;
            border-radius: 25px;
            color: var(--primary);
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-outline-custom:hover {
            background: var(--primary);
            color: white;
        }
        
        /* Footer Styles */
        .footer {
            background: var(--dark);
            color: rgba(255,255,255,0.7);
            padding: 60px 0 20px;
            margin-top: 60px;
        }
        
        .footer h5 {
            color: white;
            margin-bottom: 20px;
            font-weight: 600;
        }
        
        .footer a {
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .footer a:hover {
            color: var(--primary);
        }
        
        .social-links a {
            display: inline-block;
            width: 35px;
            height: 35px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            text-align: center;
            line-height: 35px;
            margin-right: 10px;
            transition: all 0.3s;
        }
        
        .social-links a:hover {
            background: var(--primary);
            transform: translateY(-3px);
        }
        
        .copyright {
            border-top: 1px solid rgba(255,255,255,0.1);
            padding-top: 20px;
            margin-top: 40px;
            text-align: center;
            font-size: 13px;
        }
        
        @media (max-width: 768px) {
            .nav-menu {
                display: none;
            }
        }
    </style>
</head>
<body>

<!-- Top Bar -->
<div class="top-bar">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <i class="fas fa-truck"></i> Miễn phí vận chuyển cho đơn hàng trên 500K
            </div>
            <div class="col-md-6 text-end">
                <a href="#" class="me-3"><i class="fas fa-phone"></i> 1900 1234</a>
                <a href="#"><i class="fas fa-envelope"></i> support@tothekiet.com</a>
            </div>
        </div>
    </div>
</div>

<!-- Main Header -->
<div class="main-header py-3">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-3">
                <div class="logo">
                    <h1>ToTheKiet</h1>
                    <p>PREMIUM SHOP</p>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="nav-menu justify-content-center">
                    <!-- <a href="/ToTheKiet/category/listPublic" class="<?php echo $isActive('category/listPublic'); ?>">Danh mục</a> -->
                  
                    <a href="/ToTheKiet/product/index" class="<?php echo $isActive('product/index'); ?>">Sản phẩm</a>
                    <a href="/ToTheKiet/product/cart" class="<?php echo $isActive('product/cart'); ?>">Giỏ hàng</a>
                    <?php if ($__login): ?>
                        <a href="/ToTheKiet/product/orderHistory" class="<?php echo $isActive('product/orderHistory'); ?>">Lịch sử đơn hàng</a>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="col-md-3 text-end">
                <div class="d-flex align-items-center justify-content-end gap-3">
                    <a href="/ToTheKiet/product/cart" class="cart-icon" style="color: var(--dark);">
                        <i class="fas fa-shopping-cart fa-lg"></i>
                        <?php
                        $cartCount = isset($_SESSION['cart']) ? count(array_filter($_SESSION['cart'], function($item) {
                            return empty($item['cancelled']);
                        })) : 0;
                        ?>
                        <?php if ($cartCount > 0): ?>
                            <span class="cart-badge"><?php echo $cartCount; ?></span>
                        <?php endif; ?>
                    </a>
                    
                    <?php if ($__login): ?>
                        <div class="user-menu">
                            <div class="d-flex align-items-center gap-2">
                                <div style="width: 35px; height: 35px; background: linear-gradient(135deg, var(--primary), var(--primary-dark)); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white;">
                                    <?php echo mb_strtoupper(mb_substr($__user['fullname'], 0, 1)); ?>
                                </div>
                                <span style="font-weight: 500;"><?php echo htmlspecialchars($__user['fullname']); ?></span>
                                <i class="fas fa-chevron-down fa-xs"></i>
                            </div>
                            <div class="user-dropdown">
                                <?php if ($__admin): ?>
                                    <a href="/ToTheKiet/admin/dashboard">
                                        <i class="fas fa-tachometer-alt me-2"></i> Dashboard Admin
                                    </a>
                                    <hr>
                                <?php endif; ?>
                                <a href="/ToTheKiet/account/profile">
                                    <i class="fas fa-user-circle me-2"></i> Trang cá nhân (Lấy Token)
                                </a>
                                <hr>
                                <a href="/ToTheKiet/product/orderHistory">
                                    <i class="fas fa-history me-2"></i> Lịch sử đơn hàng
                                </a>
                                <hr>
                                <a href="/ToTheKiet/account/logout" style="color: var(--danger);">
                                    <i class="fas fa-sign-out-alt me-2"></i> Đăng xuất
                                </a>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="/ToTheKiet/account/login" class="btn-outline-custom">Đăng nhập</a>
                        <a href="/ToTheKiet/account/register" class="btn-primary-custom">Đăng ký</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<main>
    <script>
        // Tự động lưu Token vào LocalStorage để dễ dùng Postman
        <?php if (SessionHelper::getToken()): ?>
        localStorage.setItem('jwtToken', '<?php echo SessionHelper::getToken(); ?>');
        <?php else: ?>
        localStorage.removeItem('jwtToken');
        <?php endif; ?>

        function logout() {
            localStorage.removeItem('jwtToken');
            location.href = '/ToTheKiet/account/login';
        }
    </script>
<div class="container mt-4">