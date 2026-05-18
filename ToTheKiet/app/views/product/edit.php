<?php include ROOT_PATH . 'app/views/shares/header.php'; ?>

<style>
    /* giống như add.php */
    .form-container { max-width: 700px; margin: 40px auto; background: white; border-radius: 24px; box-shadow: 0 20px 40px rgba(0,0,0,0.08); padding: 30px; }
    .form-label { font-weight: 600; color: var(--dark); }
    .form-control, .form-select { border-radius: 12px; border: 1px solid #dee2e6; padding: 10px 15px; }
    .form-control:focus, .form-select:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(255,107,53,0.1); }
    .image-preview { max-width: 200px; margin-top: 10px; border-radius: 12px; border: 1px solid #dee2e6; padding: 5px; }
    .btn-submit { background: linear-gradient(135deg, var(--primary), var(--primary-dark)); border: none; padding: 12px; border-radius: 40px; font-weight: 600; width: 100%; }
    .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(255,107,53,0.3); }
    .existing-image { max-width: 150px; margin-bottom: 10px; border-radius: 8px; }
</style>

<div class="container">
    <div class="form-container">
        <h2 class="text-center mb-4" style="font-family: 'Playfair Display', serif;">Sửa sản phẩm</h2>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST" action="/ToTheKiet/product/update" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $product->id; ?>">

            <div class="mb-3">
                <label for="name" class="form-label">Tên sản phẩm *</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($product->name); ?>" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Mô tả</label>
                <textarea class="form-control" id="description" name="description" rows="4"><?php echo htmlspecialchars($product->description); ?></textarea>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Giá (VNĐ) *</label>
                <input type="number" class="form-control" id="price" name="price" step="1000" value="<?php echo $product->price; ?>" required>
            </div>
            <div class="mb-3">
                <label for="category_id" class="form-label">Danh mục *</label>
                <select class="form-select" id="category_id" name="category_id" required>
                    <option value="">-- Chọn danh mục --</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?php echo $cat->id; ?>" <?php echo ($cat->id == $product->category_id) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($cat->name); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Hình ảnh hiện tại</label><br>
                <?php if (!empty($product->image)): ?>
                    <img src="/ToTheKiet/<?php echo ltrim($product->image, '/'); ?>" class="existing-image">
                <?php else: ?>
                    <p class="text-muted">Chưa có ảnh</p>
                <?php endif; ?>
                <input type="hidden" name="existing_image" value="<?php echo $product->image; ?>">
                <label for="image" class="form-label mt-2">Thay ảnh mới (nếu muốn)</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*" onchange="previewImage(this)">
                <img id="preview" class="image-preview" style="display:none;">
            </div>
            <button type="submit" class="btn btn-submit text-white">Cập nhật</button>
            <div class="text-center mt-3">
                <a href="/ToTheKiet/product" class="text-decoration-none">← Quay lại danh sách</a>
            </div>
        </form>
    </div>
</div>

<script>
    function previewImage(input) {
        var preview = document.getElementById('preview');
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.style.display = 'none';
        }
    }
</script>

<?php include ROOT_PATH . 'app/views/shares/footer.php'; ?>

<script>
document.addEventListener("DOMContentLoaded", function() {
// const urlParams = new URLSearchParams(window.location.search);
const productId = <?= $editId ?>;

fetch(`/ToTheKiet/api/product/${productId}`)
.then(response => response.json())
.then(data => {
document.getElementById('id').value = data.id;
document.getElementById('name').value = data.name;
document.getElementById('description').value = data.description;
document.getElementById('price').value = data.price;
document.getElementById('category_id').value = data.category_id;
});
fetch('/ToTheKiet/api/category')
.then(response => response.json())
.then(data => {
const categorySelect = document.getElementById('category_id');
data.forEach(category => {
const option = document.createElement('option');
option.value = category.id;
option.textContent = category.name;
categorySelect.appendChild(option);
});
});



document.getElementById('edit-product-form').addEventListener('submit',
function(event) {
event.preventDefault();
const formData = new FormData(this);
const jsonData = {};
formData.forEach((value, key) => {
jsonData[key] = value;
});
fetch(`/ToTheKiet/api/product/${jsonData.id}`, {
method: 'PUT',
headers: {
'Content-Type': 'application/json'
},
body: JSON.stringify(jsonData)
})
.then(response => response.json())
.then(data => {
if (data.message === 'Product updated successfully') {
location.href = '/ToTheKiet/Product';
} else {
alert('Cập nhật sản phẩm thất bại');
}
});
});
});
</script>