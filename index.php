<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

  <!-- jQuery -->
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>

  <?php
    include('header.php');
  ?>

  <!-- 이미지 슬라이드 -->
  <div id="index-carousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="css/images/carousel/2.jpg" class="d-block w-100" alt="...">
      </div>
      <div class="carousel-item">
        <img src="css/images/carousel/3.jpg" class="d-block w-100" alt="...">
      </div>
      <div class="carousel-item">
        <img src="css/images/carousel/4.jpg" class="d-block w-100" alt="...">
      </div>
    </div>
  </div>

  <!-- 상품 미리 보기 -->
  <?php
  require('dbconfig.php');

  $limit = 4;
  $offset = 0;

  $query = mysqli_query($conn, "SELECT * FROM products ORDER BY idx LIMIT $limit OFFSET $offset");
  ?>
  <h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">OUR PRODUCTS</h2>
  <div class="container">
    <div class="d-flex flex-wrap" id="product-container">
      <?php
      while($row=mysqli_fetch_array($query)){
      ?>
      <div class="card border-0 shadow mx-3 my-3" style="width: 280px;">
        <img src="./data/seller_upload/<?= $row['image']; ?>" data-idx="<?= $row['idx']; ?>" class="card-img-top" id="view" style="height: 190px; object-fit: cover; cursor: pointer;">
        <div class="card-body">
          <h5 class="text-center"><?= $row['name']; ?></h5>
          <div class="d-grid gap-2 col-8 mx-auto">
            <button type="button" class="btn btn-outline-dark shadow-none" onclick="location.href='register.php'">
              바로 구매하기
            </button>
            <button type="button" class="btn btn-outline-dark shadow-none" onclick="location.href='register.php'">
              장바구니 담기
            </button>
          </div>
        </div>
      </div>
      <?php
        }
      ?>
    </div>
  </div>



      <div class="col-lg-12 text-center mt-5">
        <button class="btn btn-light shadow-none loadmore" data-offset="<?= $limit ?>">더보기</button>
      </div>

    </div>
  </div>


  <?php
    include('footer.php');
  ?>
</body>
</html>

<script>
$(document).on("click", ".loadmore", function() {
  var offset = $(this).data("offset");

  $.ajax({
    url: "loadmore.php",
    type: "POST",
    data: { offset: offset },
    success: function(data) {
      $("#product-container").append(data);
      $(".loadmore").data("offset", offset + <?= $limit ?>);
    },
    error: function() {
      alert("Error fetching products.");
    }
  });
});
</script>
