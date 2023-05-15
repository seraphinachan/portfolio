<?php
require('../dbconfig.php');

/* 상품 정보 삭제 */
if(isset($_POST['delete_item']))
{
  $item_idx = mysqli_real_escape_string($conn, $_POST['delete_item']);

  $query = "DELETE FROM products WHERE idx='$item_idx'";
  $result = mysqli_query($conn, $query);

  if($result)
  {
    header('Location: items.php');
    exit;
  }
  else if(!$result)
  {
    die("오류가 발생하였습니다. 다시 시도해주세요." . mysqli_error($conn));
  }
}

/* 회원 정보 삭제 */
if(isset($_POST['delete_user']))
{
  $user_idx = mysqli_real_escape_string($conn, $_POST['delete_user']);

  $query = "DELETE FROM user_info WHERE idx='$user_idx'";
  $result = mysqli_query($conn, $query);

  if($result)
  {
    header('Location: users.php');
    exit;
  }
  else if(!$result)
  {
    die("오류가 발생하였습니다. 다시 시도해주세요." . mysqli_error($conn));
  }
}

/* 상품 정보 등록 */
if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != '') {
    $upload_file_name = date('YmdHis') . '.jpg';
    copy($_FILES['image']['tmp_name'], "../data/seller_upload/" . $upload_file_name);
} else {
    $upload_file_name = ''; // Set default value if file is not uploaded
}

$name = (isset($_POST['name']) && $_POST['name'] != '') ? $_POST['name'] : '';
$price = (isset($_POST['price']) && $_POST['price'] != '') ? $_POST['price'] : '';
$qty = (isset($_POST['qty']) && $_POST['qty'] != '') ? $_POST['qty'] : '';
$description = (isset($_POST['description']) && $_POST['description'] != '') ? $_POST['description'] : '';

// Prepare the SQL statement
$sql = "INSERT INTO products (name, price, qty, description, image) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $name, $price, $qty, $description, $upload_file_name);
$result = $stmt->execute();

if (!$result) {
    die("오류가 발생하였습니다. 다시 시도해주세요." . mysqli_error($conn));
}

$stmt->close();
$conn->close();

// Redirect the user to items.php if the query was successful
header('Location: items.php');
exit;
?>
