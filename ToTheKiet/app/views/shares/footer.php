</main>

<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <h5>Về ToTheKiet</h5>
                <p>Chúng tôi tự hào mang đến những sản phẩm chất lượng cao với giá cả hợp lý, phục vụ nhu cầu mua sắm của bạn.</p>
                <div class="social-links mt-3">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
            
            <div class="col-md-2 mb-4">
                <h5>Liên kết</h5>
                <ul class="list-unstyled">
                    <li><a href="/ToTheKiet/">Trang chủ</a></li>
                    <li><a href="/ToTheKiet/product/index">Sản phẩm</a></li>
                    <li><a href="/ToTheKiet/product/cart">Giỏ hàng</a></li>
                    <li><a href="/ToTheKiet/product/orderHistory">Lịch sử đơn hàng</a></li>
                </ul>
            </div>
            
            <div class="col-md-3 mb-4">
                <h5>Hỗ trợ</h5>
                <ul class="list-unstyled">
                    <li><a href="#">Chính sách đổi trả</a></li>
                    <li><a href="#">Chính sách vận chuyển</a></li>
                    <li><a href="#">Điều khoản dịch vụ</a></li>
                    <li><a href="#">Chính sách bảo mật</a></li>
                </ul>
            </div>
            
            <div class="col-md-3 mb-4">
                <h5>Liên hệ</h5>
                <ul class="list-unstyled">
                    <li><i class="fas fa-map-marker-alt me-2"></i> 123 Đường ABC, Quận 1, TP.HCM</li>
                    <li><i class="fas fa-phone me-2"></i> 1900 1234</li>
                    <li><i class="fas fa-envelope me-2"></i> support@tothekiet.com</li>
                </ul>
            </div>
        </div>
        
        <div class="copyright">
            <p>&copy; 2024 ToTheKiet Shop. All rights reserved.</p>
        </div>
    </div>
</footer>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Auto hide flash messages after 3 seconds
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 3000);
    
    // Add to cart animation
    $('.add-to-cart-btn').click(function(e) {
        e.preventDefault();
        var btn = $(this);
        btn.html('<i class="fas fa-spinner fa-spin"></i> Đang thêm...');
        setTimeout(function() {
            btn.html('<i class="fas fa-check"></i> Đã thêm');
            setTimeout(function() {
                btn.html('<i class="fas fa-shopping-cart"></i> Thêm vào giỏ');
            }, 2000);
        }, 500);
    });
</script>

</body>
</html>