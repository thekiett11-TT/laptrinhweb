<?php include ROOT_PATH . 'app/views/shares/header.php'; ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <div style="width: 80px; height: 80px; background: linear-gradient(135deg, var(--primary), var(--primary-dark)); border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; color: white; font-size: 32px;">
                            <?php echo mb_strtoupper(mb_substr($user['fullname'], 0, 1)); ?>
                        </div>
                    </div>
                    <h4><?php echo htmlspecialchars($user['fullname']); ?></h4>
                    <p class="text-muted">@<?php echo htmlspecialchars($user['username']); ?></p>
                    <p><span class="badge bg-info">Thành viên</span></p>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-user-circle me-2"></i> Thông tin tài khoản</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="150">Họ tên:</th>
                            <td><?php echo htmlspecialchars($user['fullname']); ?></td>
                        </tr>
                        <tr>
                            <th>Tên đăng nhập:</th>
                            <td><?php echo htmlspecialchars($user['username']); ?></td>
                        </tr>
                        <tr>
                            <th>Vai trò:</th>
                            <td><?php echo $user['role'] == 1 ? '<span class="badge bg-danger">Quản trị viên</span>' : '<span class="badge bg-primary">Khách hàng</span>'; ?></td>
                        </tr>
                        <tr>
                            <th>API Token:</th>
                            <td>
                                <div class="input-group">
                                    <input type="text" class="form-control bg-light text-muted" style="font-size: 0.85rem;" value="<?php echo htmlspecialchars(SessionHelper::getToken() ?? ''); ?>" readonly id="jwtTokenInput">
                                    <button class="btn btn-outline-secondary" type="button" onclick="copyToken()" title="Copy Token">
                                        <i class="fas fa-copy"></i> Copy
                                    </button>
                                </div>
                                <script>
                                function copyToken() {
                                    var copyText = document.getElementById("jwtTokenInput");
                                    copyText.select();
                                    navigator.clipboard.writeText(copyText.value).then(() => {
                                        alert("Đã copy token!");
                                    });
                                }
                                </script>
                            </td>
                        </tr>
                    </table>
                    <hr>
                    <div class="row mt-3">
                        <div class="col-md-6 mb-2">
                            <a href="/ToTheKiet/product/orderHistory" class="btn btn-outline-primary w-100">
                                <i class="fas fa-history me-2"></i> Lịch sử đơn hàng
                            </a>
                        </div>
                        <div class="col-md-6 mb-2">
                            <a href="/ToTheKiet/product/cart" class="btn btn-outline-success w-100">
                                <i class="fas fa-shopping-cart me-2"></i> Giỏ hàng của tôi
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include ROOT_PATH . 'app/views/shares/footer.php'; ?>