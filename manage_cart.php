<?php
session_start();
include('./dbconfig.php');

if (isset($_POST['Add_To_Cart']))
{
  if (!isset($_SESSION['user_id']))
  {
    // session user_id 가 없다면 로그인 페이지로 이동
    echo "<script>
        alert('로그인이 필요합니다.');
        window.location.href='login.php';
      </script>";
  }
  else
  {
    $user_id = $_SESSION['user_id'];
    $product_id = $_POST['idx'];
    $product_image = $_POST['image'];
    $product_name = $_POST['name'];
    $product_price = $_POST['price'];
    $product_qty = 1;

    // product_id, user_id 가 이미 cart 에 있는지 확인하기
    $check_cart = "SELECT * FROM cart WHERE product_id='$product_id' AND user_id='$user_id'";
    $check_cart_run = mysqli_query($conn, $check_cart);
    if (mysqli_num_rows($check_cart_run) > 0) {
      echo "<script>
          alert('상품이 이미 장바구니에 있습니다.');
          window.location.href='items.php';
        </script>";
    } else {
      $insert_query = "INSERT INTO cart (user_id, product_id, product_name, product_image, product_qty, product_price) VALUES (?, ?, ?, ?, ?, ?)";
      $stmt = $conn->prepare($insert_query);
      $stmt->bind_param("ssssii", $user_id, $product_id, $product_name, $product_image, $product_qty, $product_price);
      $stmt->execute();

      echo "<script>
          alert('상품을 장바구니에 추가했습니다.');
          window.location.href='mycart.php';
        </script>";
    }
  }
}

if (isset($_POST['Remove_Items']))
{
  $product_id = $_POST['delete_item'];
  $user_id = $_SESSION['user_id'];

  $delete_query = "DELETE FROM cart WHERE product_id='$product_id' AND user_id='$user_id'";
  $result = mysqli_query($conn, $delete_query);

  if($result)
  {
    echo "<script>
        alert('상품이 장바구니에서 삭제되었습니다.');
        window.location.href='mycart.php';
      </script>";
  }
  else
  {
    echo "<script>
        alert('오류가 발생했습니다. 다시 시도해 주세요.');
        window.location.href='mycart.php';
      </script>";
  }
}


?>


