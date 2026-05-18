<?php include ROOT_PATH . 'app/views/shares/header.php'; ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h4 class="mb-0"><i class="fas fa-tachometer-alt me-2" style="color: var(--primary);"></i> Admin Dashboard</h4>
                </div>
                <div class="card-body">
                    <?php if ($flash): ?>
                        <div class="alert alert-<?php echo $flash['type'] == 'success' ? 'success' : 'danger'; ?> alert-dismissible fade show" role="alert">
                            <?php echo htmlspecialchars($flash['message']); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Stats -->
                    <div class="row mb-4">
                        <div class="col-md-3 mb-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <h5 class="card-title">Tổng người dùng</h5>
                                    <h2 class="mb-0"><?php echo count($users); ?></h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <h5 class="card-title">Tổng sản phẩm</h5>
                                    <h2 class="mb-0"><?php echo count($products); ?></h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card bg-info text-white">
                                <div class="card-body">
                                    <h5 class="card-title">Khách hàng</h5>
                                    <h2 class="mb-0"><?php echo count(array_filter($users, fn($u) => $u['ROLE'] == 0)); ?></h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card bg-warning text-white">
                                <div class="card-body">
                                    <h5 class="card-title">Quản trị viên</h5>
                                    <h2 class="mb-0"><?php echo count(array_filter($users, fn($u) => $u['ROLE'] == 1)); ?></h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Tabs -->
                    <ul class="nav nav-tabs" id="adminTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="users-tab" data-bs-toggle="tab" data-bs-target="#users" type="button" role="tab">
                                <i class="fas fa-users me-1"></i> Quản lý người dùng
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="products-tab" data-bs-toggle="tab" data-bs-target="#products" type="button" role="tab">
                                <i class="fas fa-box me-1"></i> Quản lý sản phẩm
                            </button>
                        </li>
                    </ul>
                    
                    <div class="tab-content mt-3">
                        <!-- Users Tab -->
                        <div class="tab-pane fade show active" id="users" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Tên đăng nhập</th>
                                            <th>Họ tên</th>
                                            <th>Vai trò</th>
                                            <th>Ngày tạo</th>
                                            <th>Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($users as $i => $u): ?>
                                        <tr>
                                            <td><?php echo $i + 1; ?></td>
                                            <td><strong><?php echo htmlspecialchars($u['username']); ?></strong></td>
                                            <td><?php echo htmlspecialchars($u['fullname']); ?></td>
                                            <td>
                                                <?php if ($u['ROLE'] == 1): ?>
                                                    <span class="badge bg-danger">Admin</span>
                                                <?php else: ?>
                                                    <span class="badge bg-info">Khách hàng</span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo date('d/m/Y', strtotime($u['created_at'])); ?></td>
                                            <td>
                                                <?php if ($u['ROLE'] != 1): ?>
                                                    <form action="/ToTheKiet/admin/deleteuser/<?php echo $u['id']; ?>" method="POST" style="display: inline;" onsubmit="return confirm('Bạn có chắc muốn xóa người dùng này?');">
                                                        <button type="submit" class="btn btn-danger btn-sm">
                                                            <i class="fas fa-trash"></i> Xóa
                                                        </button>
                                                    </form>
                                                <?php else: ?>
                                                    <span class="text-muted">Không thể xóa</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <!-- Products Tab -->
                        <div class="tab-pane fade" id="products" role="tabpanel">
                            <div class="mb-3">
                                <a href="/ToTheKiet/product/add" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Thêm sản phẩm mới
                                </a>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>ID</th>
                                            <th>Tên sản phẩm</th>
                                            <th>Giá</th>
                                            <th>Danh mục</th>
                                            <th>Hình ảnh</th>
                                            <th>Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($products as $product): ?>
                                        <tr>
                                            <td><?php echo $product->id; ?></td>
                                            <td><strong><?php echo htmlspecialchars($product->name); ?></strong></td>
                                            <td><?php echo number_format($product->price, 0, ',', '.'); ?> VND</td>
                                            <td><?php echo htmlspecialchars($product->category_name); ?></td>
                                            <td>
                                                <?php if (!empty($product->image)): ?>
                                                    <img src="/ToTheKiet/<?php echo ltrim($product->image, '/'); ?>" width="50" alt="">
                                                <?php else: ?>
                                                    <span class="text-muted">No image</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <a href="/ToTheKiet/product/edit/<?php echo $product->id; ?>" class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit"></i> Sửa
                                                </a>
                                                <a href="/ToTheKiet/product/delete/<?php echo $product->id; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?');">
                                                    <i class="fas fa-trash"></i> Xóa
                                                </a>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include ROOT_PATH . 'app/views/shares/footer.php'; ?>