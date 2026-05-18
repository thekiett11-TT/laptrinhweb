<?php
// Require SessionHelper và các tệp cần thiết
require_once('app/config/database.php');
require_once('app/models/CategoryModel.php');
require_once('app/helpers/SessionHelper.php'); // Thêm để kiểm tra quyền Admin nếu cần

class CategoryController
{
    private $categoryModel;
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->categoryModel = new CategoryModel($this->db);
    }

    // 1. Hiển thị danh sách danh mục
    public function list()
    {
        $categories = $this->categoryModel->getCategories();
        include 'app/views/category/list.php';
    }

    // 2. Hiển thị form thêm danh mục
    public function add()
    {
        include 'app/views/category/add.php';
    }

    // 3. Xử lý lưu danh mục mới (Có description)
    public function save()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? ''; // Lấy mô tả từ form

            if (!empty($name)) {
                $result = $this->categoryModel->addCategory($name, $description);
                if ($result) {
                    header('Location: /NguyenThaoHien/Category/list');
                    exit;
                }
            }
            // Nếu lỗi, quay lại trang add
            header('Location: /NguyenThaoHien/Category/add?error=failed');
        }
    }

    // 4. Hiển thị form chỉnh sửa
    public function edit($id)
    {
        $category = $this->categoryModel->getCategoryById($id);
        if ($category) {
            include 'app/views/category/edit.php';
        } else {
            header('Location: /NguyenThaoHien/Category/list');
        }
    }

    // 5. Xử lý cập nhật danh mục (Sửa lỗi undefined method updateCategory)
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'] ?? '';
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';

            if (!empty($id) && !empty($name)) {
                $result = $this->categoryModel->updateCategory($id, $name, $description);
                if ($result) {
                    header('Location: /NguyenThaoHien/Category/list');
                    exit;
                }
            }
            header('Location: /NguyenThaoHien/Category/list?error=update_failed');
        }
    }

    // 6. Xử lý xóa danh mục
    public function delete($id)
    {
        if ($id) {
            $this->categoryModel->deleteCategory($id);
        }
        header('Location: /NguyenThaoHien/Category/list');
        exit;
    }
}
?>