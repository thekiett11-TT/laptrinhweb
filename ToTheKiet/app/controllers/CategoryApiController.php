<?php

require_once 'app/config/database.php';

require_once 'app/models/CategoryModel.php';



class CategoryApiController

{

    private $categoryModel;

    private $db;



    public function __construct()

    {

        $this->db = (new Database())->getConnection();

        $this->categoryModel = new CategoryModel($this->db);

    }



    public function index()

    {

        header('Content-Type: application/json');

        echo json_encode($this->categoryModel->getCategories());

    }



    public function show($id)

    {

        header('Content-Type: application/json');

        $category = $this->categoryModel->getCategoryById($id);

        if ($category) {

            echo json_encode($category);

        } else {

            http_response_code(404);

            echo json_encode(['message' => 'Category not found']);

        }

    }



    public function store()

    {

        header('Content-Type: application/json');

        $data = json_decode(file_get_contents("php://input"), true);

       

        $name = $data['name'] ?? '';

        $description = $data['description'] ?? ''; // Lấy description



        if (empty($name)) {

            http_response_code(400);

            echo json_encode(['message' => 'Name is required']);

            return;

        }



        $result = $this->categoryModel->addCategory($name, $description);

        if ($result) {

            http_response_code(201);

            echo json_encode(['message' => 'Category created successfully']);

        } else {

            http_response_code(500);

            echo json_encode(['message' => 'Failed to create category']);

        }

    }



    public function update($id)

    {

        header('Content-Type: application/json');

        $data = json_decode(file_get_contents("php://input"), true);

       

        $name = $data['name'] ?? '';

        $description = $data['description'] ?? ''; // Lấy description



        if (empty($name)) {

            http_response_code(400);

            echo json_encode(['message' => 'Name is required']);

            return;

        }



        // Gọi hàm updateCategory đã được thêm ở Model

        $result = $this->categoryModel->updateCategory($id, $name, $description);

        if ($result) {

            echo json_encode(['message' => 'Category updated successfully']);

        } else {

            http_response_code(500);

            echo json_encode(['message' => 'Failed to update category']);

        }

    }



    public function destroy($id)

    {

        header('Content-Type: application/json');

        $result = $this->categoryModel->deleteCategory($id);

        if ($result) {

            echo json_encode(['message' => 'Category deleted successfully']);

        } else {

            http_response_code(500);

            echo json_encode(['message' => 'Failed to delete category']);

        }

    }

}

?>