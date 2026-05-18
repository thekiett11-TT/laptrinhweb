<?php
class CategoryModel
{
    private $conn;
    private $table_name = "category";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getCategories()
    {
        $query = "SELECT id, name, description FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getCategoryById($id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function addCategory($name, $description = null)
    {
        // Xử lý dữ liệu đầu vào
        $name = trim($name);
        if (empty($name)) {
            return false; // Tên không được để trống
        }
        
        // Xử lý description: nếu null hoặc rỗng thì set thành chuỗi rỗng (hoặc null nếu DB cho phép)
        $description = ($description !== null && trim($description) !== '') ? trim($description) : '';
        
        // Lọc bỏ thẻ HTML và ký tự đặc biệt
        $name = htmlspecialchars(strip_tags($name), ENT_QUOTES, 'UTF-8');
        $description = htmlspecialchars(strip_tags($description), ENT_QUOTES, 'UTF-8');
        
        $query = "INSERT INTO " . $this->table_name . " (name, description) VALUES (:name, :description)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        return $stmt->execute();
    }

    public function updateCategory($id, $name, $description = null)
    {
        // Xử lý dữ liệu đầu vào
        $id = (int)$id;
        if ($id <= 0) return false;
        
        $name = trim($name);
        if (empty($name)) return false;
        
        $description = ($description !== null && trim($description) !== '') ? trim($description) : '';
        
        $id = htmlspecialchars(strip_tags($id), ENT_QUOTES, 'UTF-8');
        $name = htmlspecialchars(strip_tags($name), ENT_QUOTES, 'UTF-8');
        $description = htmlspecialchars(strip_tags($description), ENT_QUOTES, 'UTF-8');
        
        $query = "UPDATE " . $this->table_name . " SET name = :name, description = :description WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        return $stmt->execute();
    }

    public function deleteCategory($id)
    {
        $id = (int)$id;
        if ($id <= 0) return false;
        
        // Kiểm tra xem có sản phẩm nào thuộc danh mục này không
        $checkQuery = "SELECT COUNT(*) FROM product WHERE category_id = :id";
        $stmtCheck = $this->conn->prepare($checkQuery);
        $stmtCheck->bindParam(':id', $id);
        $stmtCheck->execute();
        $count = $stmtCheck->fetchColumn();
        if ($count > 0) {
            return false; // Không xóa vì đã có sản phẩm
        }
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>