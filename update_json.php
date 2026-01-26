<?php
$jsonFile = 'latest_version.json';

if (!file_exists($jsonFile)) {
    die("ملف JSON غير موجود.");
}

$currentData = json_decode(file_get_contents($jsonFile), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $currentData['show_update_message'] = isset($_POST['show_update_message']) ? $_POST['show_update_message'] === 'true' : false;
    $currentData['latest_version'] = $_POST['latest_version'] ?? $currentData['latest_version'];
    $currentData['update_url'] = $_POST['update_url'] ?? $currentData['update_url'];
    $currentData['message'] = $_POST['message'] ?? $currentData['message'];
    $currentData['is_mandatory'] = isset($_POST['is_mandatory']) ? $_POST['is_mandatory'] === 'true' : false;

    file_put_contents($jsonFile, json_encode($currentData, JSON_PRETTY_PRINT));
    echo "<p>تم تحديث ملف JSON بنجاح!</p>";
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تعديل ملف JSON</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        form { max-width: 500px; margin: 0 auto; }
        label { display: block; margin-top: 10px; }
        input[type="text"], textarea { width: 100%; padding: 8px; margin-top: 5px; }
        button { margin-top: 20px; padding: 10px 15px; background-color: #4CAF50; color: white; border: none; cursor: pointer; }
        button:hover { background-color: #45a049; }
        .checkbox-container { margin: 10px 0; }
    </style>
</head>
<body>
    <h1>تعديل ملف JSON</h1>
    <form method="POST">
        <label>
            <input type="checkbox" name="show_update_message" <?php echo $currentData['show_update_message'] ? 'checked' : ''; ?>>
            عرض رسالة التحديث
        </label>

        <label for="latest_version">الإصدار الأخير:</label>
        <input type="text" id="latest_version" name="latest_version" value="<?php echo $currentData['latest_version']; ?>" required>

        <label for="update_url">رابط التحديث:</label>
        <input type="text" id="update_url" name="update_url" value="<?php echo $currentData['update_url']; ?>" required>

        <label for="message">رسالة التحديث:</label>
        <textarea id="message" name="message" required><?php echo $currentData['message']; ?></textarea>

        <div class="checkbox-container">
            <label>
                <input type="checkbox" name="is_mandatory" <?php echo $currentData['is_mandatory'] ? 'checked' : ''; ?>>
                التحديث إجباري
            </label>
        </div>

        <button type="submit">حفظ التغييرات</button>
    </form>
</body>
</html>
