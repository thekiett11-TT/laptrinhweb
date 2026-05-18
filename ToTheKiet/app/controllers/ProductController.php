<?php
require_once('app/config/database.php');
require_once('app/models/ProductModel.php');
require_once('app/models/CategoryModel.php');
require_once('app/helpers/SessionHelper.php');

class ProductController
{
    private $productModel;
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->productModel = new ProductModel($this->db);
    }

   public function index($category_id = null)
{
    $categoryModel = new CategoryModel($this->db);
    $categories = $categoryModel->getCategories(); // lấy tất cả danh mục cho sidebar

    if ($category_id) {
        $products = $this->productModel->getProductsByCategory($category_id);
        $cat = $categoryModel->getCategoryById($category_id);
        $category_name = $cat ? $cat->name : null;
    } else {
        $products = $this->productModel->getProducts();
        $category_name = null;
    }

    include 'app/views/product/list.php';
}

    public function show($id)
    {
        $product = $this->productModel->getProductById($id);
        if ($product) {
            include 'app/views/product/detail.php';
        } else {
            echo "Không thấy sản phẩm.";
        }
    }

    public function add()
    {
        if (!SessionHelper::isAdmin()) {
            header('Location: /ToTheKiet/');
            exit;
        }
        $categories = (new CategoryModel($this->db))->getCategories();
        include_once 'app/views/product/add.php';
    }

    public function save()
    {
        if (!SessionHelper::isAdmin()) {
            header('Location: /ToTheKiet/');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name        = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $price       = $_POST['price'] ?? '';
            $category_id = $_POST['category_id'] ?? null;

            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $image = $this->uploadImage($_FILES['image']);
            } else {
                $image = "";
            }

            $result = $this->productModel->addProduct($name, $description, $price, $category_id, $image);

            if (is_array($result)) {
                $errors     = $result;
                $categories = (new CategoryModel($this->db))->getCategories();
                include 'app/views/product/add.php';
            } else {
                header('Location: /ToTheKiet/Product');
            }
        }
    }

    public function edit($id)
    {
        if (!SessionHelper::isAdmin()) {
            header('Location: /ToTheKiet/');
            exit;
        }

        $product    = $this->productModel->getProductById($id);
        $categories = (new CategoryModel($this->db))->getCategories();
        if ($product) {
            include 'app/views/product/edit.php';
        } else {
            echo "Không thấy sản phẩm.";
        }
    }

    public function update()
    {
        if (!SessionHelper::isAdmin()) {
            header('Location: /ToTheKiet/');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id          = $_POST['id'];
            $name        = $_POST['name'];
            $description = $_POST['description'];
            $price       = $_POST['price'];
            $category_id = $_POST['category_id'];

            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $image = $this->uploadImage($_FILES['image']);
            } else {
                $image = $_POST['existing_image'];
            }

            $edit = $this->productModel->updateProduct($id, $name, $description, $price, $category_id, $image);

            if ($edit) {
                header('Location: /ToTheKiet/Product');
            } else {
                echo "Đã xảy ra lỗi khi lưu sản phẩm.";
            }
        }
    }

    public function delete($id)
    {
        if (!SessionHelper::isAdmin()) {
            header('Location: /ToTheKiet/');
            exit;
        }

        if ($this->productModel->deleteProduct($id)) {
            header('Location: /ToTheKiet/Product');
        } else {
            echo "Đã xảy ra lỗi khi xóa sản phẩm.";
        }
    }

    private function uploadImage($file)
    {
        $target_dir = "public/images/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $target_file   = $target_dir . basename($file["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $check = getimagesize($file["tmp_name"]);
        if ($check === false) {
            throw new Exception("File không phải là hình ảnh.");
        }
        if ($file["size"] > 10 * 1024 * 1024) {
            throw new Exception("Hình ảnh có kích thước quá lớn.");
        }
        if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
            throw new Exception("Chỉ cho phép các định dạng JPG, JPEG, PNG và GIF.");
        }
        if (!move_uploaded_file($file["tmp_name"], $target_file)) {
            throw new Exception("Có lỗi xảy ra khi tải lên hình ảnh.");
        }
        return $target_file;
    }

    public function addToCart($id)
    {
        $product = $this->productModel->getProductById($id);
        if (!$product) {
            echo "Không tìm thấy sản phẩm.";
            return;
        }
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity']++;
        } else {
            $_SESSION['cart'][$id] = [
                'name'      => $product->name,
                'price'     => $product->price,
                'quantity'  => 1,
                'image'     => $product->image,
                'cancelled' => false
            ];
        }
        header('Location: /ToTheKiet/product/cart');
    }

    public function increaseQuantity($id)
    {
        if (isset($_SESSION['cart'][$id]) && !$_SESSION['cart'][$id]['cancelled']) {
            $_SESSION['cart'][$id]['quantity']++;
        }
        header('Location: /ToTheKiet/product/cart');
    }

    public function decreaseQuantity($id)
    {
        if (isset($_SESSION['cart'][$id]) && !$_SESSION['cart'][$id]['cancelled']) {
            if ($_SESSION['cart'][$id]['quantity'] > 1) {
                $_SESSION['cart'][$id]['quantity']--;
            }
        }
        header('Location: /ToTheKiet/product/cart');
    }

    public function cancelItem($id)
    {
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['cancelled'] = true;
        }
        header('Location: /ToTheKiet/product/cart');
    }

    public function restoreItem($id)
    {
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['cancelled'] = false;
        }
        header('Location: /ToTheKiet/product/cart');
    }

    public function removeFromCart($id)
    {
        if (isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
        }
        header('Location: /ToTheKiet/product/cart');
    }

    public function clearCart()
    {
        unset($_SESSION['cart']);
        header('Location: /ToTheKiet/product/cart');
    }

    // ✅ FIX: Thêm o.status vào query, lọc theo user nếu không phải admin
    public function orderHistory()
    {
        SessionHelper::requireLogin();

        $orderHistory = [];
        try {
            if (SessionHelper::isAdmin()) {
                // Admin xem tất cả đơn hàng + thông tin user
                $query = "
                    SELECT o.id, o.name, o.phone, o.address,
                           o.status,
                           o.created_at as date,
                           COALESCE(SUM(od.quantity * od.price), 0) as total,
                           u.username as user_username,
                           u.fullname as user_fullname
                    FROM orders o
                    LEFT JOIN order_details od ON o.id = od.order_id
                    LEFT JOIN users u ON o.user_id = u.id
                    GROUP BY o.id, o.name, o.phone, o.address, o.status, o.created_at, u.username, u.fullname
                    ORDER BY o.created_at DESC
                ";
                $stmt = $this->db->prepare($query);
                $stmt->execute();
            } else {
                // User chỉ xem đơn hàng của mình
                $currentUser = SessionHelper::getCurrentUser();
                $userId = $currentUser['id'];
                $query = "
                    SELECT o.id, o.name, o.phone, o.address,
                           o.status,
                           o.created_at as date,
                           COALESCE(SUM(od.quantity * od.price), 0) as total
                    FROM orders o
                    LEFT JOIN order_details od ON o.id = od.order_id
                    WHERE o.user_id = :user_id
                    GROUP BY o.id, o.name, o.phone, o.address, o.status, o.created_at
                    ORDER BY o.created_at DESC
                ";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':user_id', $userId);
                $stmt->execute();
            }

            $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($orders as $order) {
                $detailQuery = "
                    SELECT p.name, od.quantity, od.price, p.image
                    FROM order_details od
                    JOIN product p ON od.product_id = p.id
                    WHERE od.order_id = :order_id
                ";
                $detailStmt = $this->db->prepare($detailQuery);
                $detailStmt->bindParam(':order_id', $order['id']);
                $detailStmt->execute();
                $order['items'] = $detailStmt->fetchAll(PDO::FETCH_ASSOC);
                $orderHistory[] = $order;
            }
        } catch (Exception $e) {
            $orderHistory = [];
            $error = $e->getMessage();
        }

        include 'app/views/product/orderHistory.php';
    }

    public function cart()
    {
        $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
        include 'app/views/product/cart.php';
    }

    public function checkout()
    {
        if (!SessionHelper::isLoggedIn()) {
            SessionHelper::setFlash('error', 'Vui lòng đăng nhập để thanh toán!');
            header('Location: /ToTheKiet/account/login');
            exit;
        }

        $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
        if (empty($cart)) {
            header('Location: /ToTheKiet/product/cart');
            exit;
        }

        include 'app/views/product/checkout.php';
    }

    // ✅ FIX: Thêm user_id và status vào INSERT orders
    public function processCheckout()
    {
        if (!SessionHelper::isLoggedIn()) {
            header('Location: /ToTheKiet/account/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name    = $_POST['name'];
            $phone   = $_POST['phone'];
            $address = $_POST['address'];

            if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
                echo "Giỏ hàng trống.";
                return;
            }

            $currentUser = SessionHelper::getCurrentUser();
            $userId = $currentUser['id'];

            $this->db->beginTransaction();
            try {
                // ✅ Thêm user_id và status mặc định 'pending'
                $query = "INSERT INTO orders (user_id, name, phone, address, status) VALUES (:user_id, :name, :phone, :address, 'pending')";
                $stmt  = $this->db->prepare($query);
                $stmt->bindParam(':user_id', $userId);
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':phone', $phone);
                $stmt->bindParam(':address', $address);
                $stmt->execute();
                $order_id = $this->db->lastInsertId();

                $cart = $_SESSION['cart'];
                foreach ($cart as $product_id => $item) {
                    if (!empty($item['cancelled'])) continue;

                    $query = "INSERT INTO order_details (order_id, product_id, quantity, price) VALUES (:order_id, :product_id, :quantity, :price)";
                    $stmt  = $this->db->prepare($query);
                    $stmt->bindParam(':order_id', $order_id);
                    $stmt->bindParam(':product_id', $product_id);
                    $stmt->bindParam(':quantity', $item['quantity']);
                    $stmt->bindParam(':price', $item['price']);
                    $stmt->execute();
                }

                unset($_SESSION['cart']);
                $this->db->commit();
                header('Location: /ToTheKiet/product/orderConfirmation');
            } catch (Exception $e) {
                $this->db->rollBack();
                echo "Đã xảy ra lỗi khi xử lý đơn hàng: " . $e->getMessage();
            }
        }
    }

    public function orderConfirmation()
    {
        include 'app/views/product/orderConfirmation.php';
    }
}
?>