<?php

require_once "includes/cloudinary.php";

echo "<pre>";

try {
    print_r($cloudinary->adminApi()->ping());
    echo "\n✅ Cloudinary Connected Successfully!";
} catch (Exception $e) {
    echo "Connection Failed:\n";
    echo $e->getMessage();
}