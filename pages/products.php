<style>
    [data-type="imagePost"]{
        object-fit: cover;
    }
    .carousel img{
        width:100%;
        aspect-ratio:1/1;
    }
</style>
<?php
$products = new Products();
$items = $products->showProducts();
foreach($items as $item){
    echo "<section class='border p-2 mt-3 rounded'>";
    $product_id = $item[0];
    $username = $item[1];
    $title = $item[2];
    $desc = $item[3];
    $price = $item[4];
    $images = $item[5];
    $publish = $item[6];
    $views = $item[7];
    $category = $item[8];
    $model = $item[9];
    $year = $item[10];
    $condition = $item[11];
    $imageLength = Count(explode(",", $images)) - 1;
    echo "
    <section class='float-end border ps-3 pe-3 rounded-top'>$username</section>
    ";
    echo "<section id='carouselPost$product_id' class='carousel slide carousel-fade' data-bs-ride='carousel' data-type='imagePost'>
    <div class='carousel-indicators'>";
    for($i = 0; $i < $imageLength ; $i++){
        echo "
        <button type='button' data-bs-target='#carouselPost$product_id' data-bs-slide-to='$i' class='active' aria-current='true' aria-label='Slide ".($i + 1)."'></button>
      ";
    }

    echo "
    </div>
    <div class='carousel-inner'>
    ";
    foreach(explode(",", $images) as $image){
        if($image != ""){
            echo "
            <div class='carousel-item'>
            <img src='./src/images/users/$username/products/$image' class='d-block w-100'/>
            </div>
            ";
        }
    }
    echo "
    </div>
    <button class='carousel-control-prev' type='button' data-bs-target='#carouselPost$product_id' data-bs-slide='prev'>
    <span class='carousel-control-prev-icon'></span>
    <span class='visually-hidden'>Previous</span>
  </button>
  <button class='carousel-control-next' type='button' data-bs-target='#carouselPost$product_id' data-bs-slide='next'>
    <span class='carousel-control-next-icon' aria-hidden='true'></span>
    <span class='visually-hidden'>Next</span>
  </button>
    </div>
    </section>";

    echo "<section class='w-10 border ps-3 pe-3 fs-4 rounded-start'>$title</section>";
    echo "<section class='float-end border ps-3 pe-3 rounded-bottom'>$publish</section>";
    echo "<section>$desc</section>";
    echo "<section>$$price</section>";
    echo "<section>
    <span><span>Category: </span><span>$category</span></span>
    <span><span>Model: </span><span>$model</span></span>
    <span><span>Year: </span><span>$year</span></span>
    <span><span>Condition: </span><span>$condition</span></span>
    </section>";
    echo "<section><span>Views: </span><span>$views</span></section>";
    echo "</section>";
}
?>
<script>
    carousel_inner = document.getElementsByClassName("carousel-inner");
    for(let i = 0; i < carousel_inner.length; i++){
        carousel_inner[i].children[0].classList.add("active");
    }
    
</script>