<style>
    [data-type="imagePost"]{
        object-fit: cover;
    }
    .carousel img{
        width:100%;
        aspect-ratio:1/1;
    }
    [cursor="default"]{
        cursor:default;
    }
    [data-bs-slide='next'], [data-bs-slide='prev']{
        background-color:hsl(0 100% 0% / 0.5);
        backdrop-filter: blur(2px);
        height:50%;
        margin-top:25%;
        border-radius:25px;
    }
    @media screen and (max-width:56em){
        .posts{
            width:100%!important;
        }
    }
</style>
<?php
$products = new Products();
switch($_SESSION["posts"]){
    case "all":
        $items = $products->showProducts();
        break;
    case "profile":
        $items = $products->showProductsProfile($_SESSION['user_ID']);
        break;
}
foreach($items as $item){
    echo "<section class='border post p-2 mt-3 rounded position-relative'>";
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
    echo "<section class='border-bottom position-relative p-1 d-flex justify-content-between align-items-center'>";
    if(isset($_SESSION['username']) && $_SESSION['username'] == $username){
        echo "
        <section class=''><button name='removePost' class='btn btn-danger float-left' onclick='deletePost($product_id)'>&times;</button></section>";
    }else{
        echo "<section></section>";
    }
    echo "
    <section class='border ps-3 pe-3 rounded d-flex justify-content-between align-items-center' cursor='default'><img width='50' height='50' class='border rounded-circle m-2 user-profile' draggable='false' src='src/images/users/$username/profile/profile.jpg'/>$username</section>
    </section>
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
            <img src='./src/images/users/$username/products/$image' class='d-block w-100' draggable='false'/>
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
    
    /*          Like / Comment / Share          */
    $current_user = isset($_SESSION["username"]) ? $_SESSION["username"] : null;
    $isuserliked = new PostActivity();
    $flag = $current_user? $isuserliked->isUserLiked($current_user, $product_id): 0;
    echo "<section>
    <section class='btn-group border w-100'>
    <button data-role='posts' data-post='post$product_id' onclick='likePost(`$current_user`, `$product_id`, this, `$current_user`)' name='likeProduct' class='btn btn-dark d-flex justify-content-center align-items-center hover'><span class='pe-2'>0</span><i class='";
    if($flag > 0){
        echo "text-primary ";
    }
    echo"fas fa-thumbs-up'></i></button>
    <span class='btn btn-dark d-flex justify-content-center align-items-center'><span class='pe-2'>0</span><i class='fa fa-comment' aria-hidden='true'></i></span>
    <span class='btn btn-dark d-flex justify-content-center align-items-center'><span class='pe-2'>0</span><i class='fas fa-share'></i></span>

    </section>
    </section>";
    echo "</section>";
}
?>
<script>
    carousel_inner = document.getElementsByClassName("carousel-inner");
    for(let i = 0; i < carousel_inner.length; i++){
        carousel_inner[i].children[0].classList.add("active");
    }
    
</script>