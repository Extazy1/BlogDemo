<?php
// download.php
$uploadsDir = __DIR__ . '/'; // 确保这是正确的上传目录路径
$fileName = basename($_GET['file']); // 使用 basename 来防止路径遍历攻击

$filePath = $uploadsDir . $fileName;

if (file_exists($filePath)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . $fileName . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($filePath));
    readfile($filePath);
    exit;
}
// 如果文件不存在，可以适当处理，比如显示错误消息
echo "File not found.";
