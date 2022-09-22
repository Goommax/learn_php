<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
ini_set('error_log', __DIR__ . '/php-errors.log');
require_once("helpers.php");
require_once("functions.php");
require_once("data.php");
require_once("init.php");

$sql = "SELECT character_code, name_category FROM categories";
$res = mysqli_query($con, $sql);
$categories = mysqli_fetch_assoc($res);

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if ($id) {
  $sql = "SELECT l.title, l.start_price, l.img, l.lot_description, l.date_finish, c.name_category FROM lots l JOIN categories c ON l.category_id = c.id WHERE l.id = $id";
} else {
  http_response_code(404);
  die();
}
$result = mysqli_query($con, $sql);
$lot = mysqli_fetch_assoc($result);
if (!$lot) {
  http_response_code(404);
  die();
}

$page_content = include_template("lot.php", [
   'categories' => $categories,
   'lot' => $lot
]);
$layout_content = include_template("layout.php", [
   'content' => $page_content,
   'categories' => $categories,
   'title' => "Главная",
   'is_auth' => $is_auth,
   'user_name' => $user_name
]);

print($layout_content);
