<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh sách danh mục - MiniShop MVC</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; line-height: 1.6; }
        table { border-collapse: collapse; width: 100%; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 8px 12px; text-align: left; }
        th { background-color: #f4f4f4; }
        .alert-success { color: #155724; background-color: #d4edda; padding: 10px; margin-bottom: 15px; border-radius: 4px; }
        .alert-error { color: #721c24; background-color: #f8d7da; padding: 10px; margin-bottom: 15px; border-radius: 4px; }
        .btn { display: inline-block; padding: 6px 12px; text-decoration: none; border-radius: 4px; color: white; border: none; cursor: pointer; }
        .btn-add { background: #28a745; margin-bottom: 15px; }
        .btn-edit { background: #007bff; font-size: 13px; margin-right: 5px; }
        .btn-delete { background: #dccb35; font-size: 13px; }
        .action-form { display: inline; }
    </style>
</head>
<body>

    <h2>Quản lý danh mục (MiniShop MVC)</h2>

    <?php if (isset($_SESSION['flash_success'])): ?>
        <div class="alert-success"><?= htmlspecialchars($_SESSION['flash_success']) ?></div>
        <?php unset($_SESSION['flash_success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['flash_error'])): ?>
        <div class="alert-error"><?= htmlspecialchars($_SESSION['flash_error']) ?></div>
        <?php unset($_SESSION['flash_error']); ?>
    <?php endif; ?>

    <a href="index.php?controller=category&action=create" class="btn btn-add">+ Thêm danh mục mới</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên danh mục</th>
                <th>Mô tả</th>
                <th>Ngày tạo</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($categories)): ?>
                <tr><td colspan="5">Chưa có danh mục nào trong CSDL.</td></tr>
            <?php else: ?>
                <?php foreach ($categories as$cat): ?>
                    <tr>
                        <td><?= htmlspecialchars($cat['id']) ?></td>
                        <td><strong><?= htmlspecialchars($cat['name']) ?></strong></td>
                        <td><?= htmlspecialchars($cat['description'] ?? '') ?></td>
                        <td><?= htmlspecialchars($cat['created_at']) ?></td>
                        <td>
                            <a href="index.php?controller=category&action=edit&id=<?= $cat['id'] ?>" class="btn btn-edit">Sửa</a>
                            <form action="index.php?controller=category&action=delete&id=<?= $cat['id'] ?>" method="POST" class="action-form" onsubmit="return confirm('Bạn chắc chắn muốn xóa danh mục này?');">
                                <button type="submit" class="btn btn-delete">Xóa</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

</body>
</html>