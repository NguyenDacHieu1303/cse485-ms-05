<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa danh mục</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .alert-error { color: #721c24; background-color: #f8d7da; padding: 10px; margin-bottom: 15px; border-radius: 4px; }
        form { background: #f9f9f9; padding: 20px; border: 1px solid #ccc; width: 420px; border-radius: 4px; }
        .form-group { margin-bottom: 12px; }
        label { display: block; font-weight: bold; margin-bottom: 5px; }
        input[type="text"], textarea { width: 100%; padding: 8px; box-sizing: border-box; }
        button { padding: 8px 15px; background: #007bff; color: white; border: none; border-radius: 3px; cursor: pointer; }
        a { text-decoration: none; color: #555; margin-left: 10px; }
    </style>
</head>
<body>

    <h2>Chỉnh sửa danh mục #<?= htmlspecialchars($category['id']) ?></h2>

    <?php if (!empty($errors)): ?>
        <div class="alert-error">
            <ul>
                <?php foreach ($errors as$err): ?>
                    <li><?= htmlspecialchars($err) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="index.php?controller=category&action=edit&id=<?= $category['id'] ?>" method="POST">
        <div class="form-group">
            <label for="name">Tên danh mục (*):</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($name) ?>" required>
        </div>
        <div class="form-group">
            <label for="description">Mô tả:</label>
            <textarea id="description" name="description" rows="3"><?= htmlspecialchars($description ?? '') ?></textarea>
        </div>
        <button type="submit">Cập nhật</button>
        <a href="index.php?controller=category&action=index">Hủy bỏ</a>
    </form>

</body>
</html>