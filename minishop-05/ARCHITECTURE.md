# Kiến Trúc MVC Mini - MiniShop (Phiếu 05)

## 1. Sơ đồ Luồng Request: Thêm Danh Mục Mới (Create Category)

```text
Browser POST → minishop-05/public/index.php → CategoryController::create
             → CategoryModel::create → MySQL
             → redirect index → CategoryModel::all → View list