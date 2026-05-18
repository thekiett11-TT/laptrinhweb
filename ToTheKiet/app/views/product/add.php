<?php include ROOT_PATH . 'app/views/shares/header.php'; ?>

<style>
    .form-container {
        max-width: 700px;
        margin: 40px auto;
        background: white;
        border-radius: 24px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.08);
        padding: 30px;
    }
    .form-label {
        font-weight: 600;
        color: var(--dark);
    }
    .form-control, .form-select {
        border-radius: 12px;
        border: 1px solid #dee2e6;
        padding: 10px 15px;
    }
    .form-control:focus, .form-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(255,107,53,0.1);
    }
    .image-preview {
        max-width: 200px;
        margin-top: 10px;
        border-radius: 12px;
        border: 1px solid #dee2e6;
        padding: 5px;
    }
    .btn-submit {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        border: none;
        padding: 12px;
        border-radius: 40px;
        font-weight: 600;
        width: 100%;
    }
    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(255,107,53,0.3);
    }
</style>

<div class="container">
    <div class="form-container">
        <h2 class="text-center mb-4" style="font-family: 'Playfair Display', serif;">Thêm sản phẩm mới</h2>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST" action="/ToTheKiet/product/save" enctype="multipart/form-data" id="productForm">
            <div class="mb-3">
                <label for="name" class="form-label">Tên sản phẩm *</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Mô tả</label>
                <textarea class="form-control" id="description" name="description" rows="4"></textarea>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Giá (VNĐ) *</label>
                <input type="number" class="form-control" id="price" name="price" step="1000" required>
            </div>
            <div class="mb-3">
                <label for="category_id" class="form-label">Danh mục *</label>
                <select class="form-select" id="category_id" name="category_id" required>
                    <option value="">-- Chọn danh mục --</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?php echo $cat->id; ?>"><?php echo htmlspecialchars($cat->name); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Hình ảnh</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*" onchange="previewImage(this)">
                <img id="preview" class="image-preview" style="display:none;">
            </div>
            <button type="submit" class="btn btn-submit text-white">Thêm sản phẩm</button>
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
document.getElementById('add-product-form').addEventListener('submit',
function(event) {
event.preventDefault();
const formData = new FormData(this);
const jsonData = {};
formData.forEach((value, key) => {



jsonData[key] = value;
});

fetch('/ToTheKiet/api/product', {
method: 'POST',
headers: {
'Content-Type': 'application/json'
},
body: JSON.stringify(jsonData)
})
.then(response => response.json())
.then(text => {
console.log('Raw response:', text); // Log the raw response text
try {
const data = text;
if (data.message === 'Product created successfully') {
location.href = '/ToTheKiet/Product';
} else {
alert('Thêm sản phẩm thất bại');
}
} catch (error) {
console.error('Error parsing JSON:', error);
alert('Lỗi: Không thể phân tích JSON từ phản hồi của máy chủ.');
}
});
});
});
</script>