<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
ini_set('error_log', __DIR__ . '/php-errors.log');
require_once("helpers.php");
require_once("functions.php");
require_once("data.php");
require_once("init.php");
require_once("db_queries.php");
$sql = cat_query();
$res = mysqli_query($con, $sql);
$categories = mysqli_fetch_all($res, MYSQLI_ASSOC);
$page_content = include_template("add-lot.php", [
   'categories' => $categories ]);

if ($_SERVER ['REQUEST_METHOD'] == 'POST') {
  $errors = [];
  $rules = [
        
        "lot-rate" => function($value) {
            return val_number ($value);
        },
        "lot-step" => function($value) {
            return val_number ($value);
        },
        "lot-date" => function($value) {
            return val_date ($value);
        }
    ];
  $lot = filter_input_array(INPUT_POST,
    [
        "lot-name"=>FILTER_DEFAULT,
        "category"=>FILTER_DEFAULT,
        "message"=>FILTER_DEFAULT,
        "lot-rate"=>FILTER_DEFAULT,
        "lot-step"=>FILTER_DEFAULT,
        "lot-date"=>FILTER_DEFAULT
    ], true);

foreach ($lot as $field => $value) {
  if (isset($rules[$field])) {
      $rule = $rules[$field];
      $errors[$field] = $rule($value);
  }
  if (in_array($field, $required) && empty($value)) {
      $errors[$field] = "Поле $field нужно заполнить";
  }
}

    $errors = array_filter($errors);
var_dump();
die;

if (!empty($_FILES ['lot_img']['name'])) {
  $tmp_name = $_FILES ['lot_img']['tmp_name'];
  $path = $_FILES ['lot_img']['name'];
  $file_info = finfo_open(FILEINFO_MIME_TYPE);
  $file_type = finfo_file($file_info, $tmp_name);


if ($file_type == 'image/jpeg') { $ext = '.jpg'; }
elseif ($file_type == 'image/png') { $ext = '.png'; }

if($ext) {
  $filename = uniqid() . $ext;
  $lot ['path'] =  'uploads/' . $filename;
  move_uploaded_file($FILES ['lot_img']['tmp_name'], 'uploads/' . $filename);
} else { $errors ['lot_img'] = 'Допустимые форматы файлов: jpg, jpeg, png'; }
} else {
  $errors["lot_img"] = "Вы не загрузили изображение";
}
if (count($errors)) {
  $page_content = include_template("add-lot.php", [
    'categories' => $categories,
    'lot' => $lot,
    'errors' => $errors]);
} else {
  $sql = lot_add_query(2);
  $stmt = db_get_prepare_stmt($con, $sql, $lot);
  $res = mysqli_stmt_execute($stmt);
  if($res) {
    $lot_id = mysqli_insert_id($con);
    header("Location: /lot.php?id=" .$lot_id);
  } else { $error = mysqli_error($con);}
}
}

$layout_content = include_template("layout.php", [
   'content' => $page_content,
   'categories' => $categories,
   'title' => "Главная",
   'is_auth' => $is_auth,
   'user_name' => $user_name
]);

print($layout_content);
