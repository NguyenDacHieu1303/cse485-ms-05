<?php
require_once __DIR__ . '/../models/CategoryModel.php';

class CategoryController {
    private CategoryModel $model;

    public function __construct() {
        $this->model = new CategoryModel();
    }

    public function index(): void {
        $categories =$this->model->all();
        $this->renderView('index', ['categories' =>$categories]);
    }

    public function create(): void {
        $errors = [];
        $name = '';$description = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $description = trim($_POST['description'] ?? '');

            if (empty($name)) {$errors[] = 'Tên danh mục không được để trống.';
            } elseif (mb_strlen($name) < 2 || mb_strlen($name) > 100) {$errors[] = 'Tên danh mục phải từ 2 đến 100 ký tự.';
            } elseif ($this->model->existsByName($name)) {$errors[] = "Tên danh mục '{$name}' đã tồn tại.";
            }

            if (empty($errors)) {
                if ($this->model->create($name, $description)) {$_SESSION['flash_success'] = 'Thêm danh mục thành công!';
                    header("Location: index.php?controller=category&action=index");
                    exit;
                } else {
                    $errors[] = 'Không thể lưu danh mục vào hệ thống.';
                }
            }
        }

        $this->renderView('create', [
            'errors'      => $errors,
            'name'        => $name,
            'description' => $description
        ]);
    }

    public function edit(): void {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if (!$id) {$this->notFound();
        }

        $category = $this->model->find($id);
        if (!$category) {$this->notFound();
        }

        $errors = [];
        $name =$category['name'];
        $description =$category['description'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $description = trim($_POST['description'] ?? '');

            if (empty($name)) {$errors[] = 'Tên danh mục không được để trống.';
            } elseif (mb_strlen($name) < 2 || mb_strlen($name) > 100) {$errors[] = 'Tên danh mục phải từ 2 đến 100 ký tự.';
            } elseif ($this->model->existsByName($name, $id)) {$errors[] = "Tên danh mục '{$name}' đã tồn tại.";
            }

            if (empty($errors)) {
                if ($this->model->update($id,$name, $description)) {$_SESSION['flash_success'] = 'Cập nhật danh mục thành công!';
                    header("Location: index.php?controller=category&action=index");
                    exit;
                } else {
                    $errors[] = 'Cập nhật thất bại.';
                }
            }
        }

        $this->renderView('edit', [
            'category'    => $category,
            'errors'      => $errors,
            'name'        => $name,
            'description' => $description
        ]);
    }

    public function delete(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?controller=category&action=index");
            exit;
        }

        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($id &&$this->model->delete($id)) {$_SESSION['flash_success'] = 'Đã xóa danh mục thành công!';
        } else {
            $_SESSION['flash_error'] = 'Xóa danh mục thất bại hoặc ID không hợp lệ.';
        }

        header("Location: index.php?controller=category&action=index");
        exit;
    }

    private function renderView(string $viewName, array$data = []): void {
        extract($data);
        require_once __DIR__ . "/../views/category/{$viewName}.php";
    }

    private function notFound(): void {
        http_response_code(404);
        echo "<h2>404 - Không tìm thấy trang yêu cầu!</h2>";
        echo "<a href='index.php?controller=category&action=index'>Quay lại danh sách</a>";
        exit;
    }
}