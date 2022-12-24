<style>
    [data-type="imagePost"]{
        object-fit: cover;
    }
    .carousel img, .carousel video{
        width:100%;
        aspect-ratio:1/1;
    }
    [cursor="pointer"]{
        cursor:pointer;
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
    .socialMedias i{
        font-size:1.5rem;
        cursor:pointer;
    }
    [data-small-button='hidden'].dropdown-toggle::after{
        display:none!important;
    }
</style>
<?php
/*
for sharing on social media.
use the domain name in the url down below. and use /SinglePost/po([0-9]+)st as post link
https://www.facebook.com/sharer/sharer.php?u=url
*/
$products = new Products();
switch($_SESSION["posts"]){
    case "all":
        $items = $products->showProducts();
        break;
    case "profile":
        $items = $products->showProductsProfile($_SESSION['username']);
        break;
        case "visit":
            $items = $products->showProductsProfile($_SESSION['visit']);
        break;
    case "Filter":
            $items = $products->Filter($_SESSION['category'], $_SESSION['model']);
        break;
    case "Search":
            $items = $products->Search(mysqli_real_escape_string($products->getConnect(), $_SESSION['search']));
        break;
}
if(count($items) == 0){
    echo "<section dir='rtl' data-type='productNotFound'>ببورە هییچ کاڵایەت نە دۆزراییەوە<br/>";
    if($_SESSION['posts'] == "Filter"){
        echo "گەڕان بە دوای بەشی ".$_SESSION['category']." جۆری ".$_SESSION['model']."</section>";
    }
}else if($_SESSION['posts'] == "Filter" || $_SESSION['posts'] == "Search"){
    echo "<section dir='rtl'>".count($items); 
    echo "کاڵا دۆزرایەوە. <hr/></section>";
}
foreach($items as $item){
    echo "<section class='border post p-2 mt-3 rounded position-relative'>";
    $product_id = $item[0];
    if($_SESSION['posts'] == "Filter" || $_SESSION['posts'] == "Search"){
        $addViews = new Products();
        $addViews->addViewsToFilteredProduct($product_id);
    }
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
    $address = $item[12];
    $city = $item[13];
    $state = $item[14];
    $country = $item[15];
    $imageLength = Count(explode(",", $images)) - 1;
    echo "<section class='border-bottom position-relative p-1 d-flex justify-content-between align-items-center'>
    <section class='d-flex'>
    <section class='btn material-icons dropdown-toggle' data-small-button='hidden' data-bs-toggle='dropdown'>more_horiz</section>
    <ul class='dropdown-menu'>
    <li><a class='dropdown-item text-end' href='#' onclick='sendReport($product_id)'>ڕاپۆرت</a></li>
    ";
    if(isset($_SESSION['username']) && $_SESSION['username'] == $username){
        echo "
        <li><a name='removePost' class='dropdown-item text-end' onclick='deletePost($product_id)'>لابردن</a></li>";
    }
    echo " 
    </ul>
    </section>
    <section onclick='visit(`$username`)' class='border ps-3 pe-3 rounded d-flex justify-content-between align-items-center' cursor='pointer'><img width='50' height='50' class='border rounded-circle m-2 user-profile' draggable='false' src='src/images/users/$username/profile/profile.png'/>$username</section>
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
        $active = true;
        if($image != ""){        
            echo "<div class='carousel-item'>";
        if((preg_match("/.png/i", $image) || preg_match("/.jpeg/i", $image) || preg_match("/.jpg/i", $image) || preg_match("/.jfif/i", $image) || preg_match("/.gif/i", $image))){
            echo "
            <img loading='lazy' src='./src/images/users/$username/products/$image' class='d-block w-100' draggable='false'/>
            ";
        }else{
            echo "
            <video controls class='image-fluid' draggable='false' loading='lazy'>
            <source src='./src/images/users/$username/products/$image' class='d-block w-100'/>
            </video>
            ";
        }
        echo "</div>";
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

    echo "<section class='w-10 border ps-3 pe-3 fs-4 rounded-start desc'>$title</section>";
    echo "<section class='float-end border ps-3 pe-3 rounded-bottom' data-change-time='simplify'>$publish</section>";
    echo "<section class='row'><section class='float-left col-2 border rounded-bottom' style='max-height:40px; text-align:center; line-height:20px;'>$$price</section><section class='desc col-10'>$desc</section></section>";
    echo "";
    echo "<section dir='rtl' class='d-flex flex-column w-100'>
    <span dir='rtl' class='row'>
        <section class='col-6 border'>
            <span>بەش: </span><span>$category</span> 
        </section>
        <section class='col-6 border'>
            <span>جۆر: </span><span>$model</span>   
        </section>
    </span>

    <span class='row'>
        <section class='col-6 border'>
            <span><span>ساڵ: </span><span>$year</span></span>  
        </section>
        <section class='col-6 border'>
            <span><span>حاڵەت: </span><span>$condition</span></span>
        </section>
    </span>


    <span class='row'>
        <section class='col-6 border'>
            <span>ناوونیشان: </span><span>$address</span>
        </section>
        <section class='col-6 border'>
            <span>شار: </span><span>$city</span>
        </section>
    </span>

    <span class='row'>
        <section class='col-6 border'>
            <span>پارێزگا: </span><span>$state</span>
        </section>
        <section class='col-6 border'>
            <span>وڵات: </span><span>$country</span>
        </section>
    </span>

    </section>";
    echo "<section dir='rtl'><span>ژمارەی بینەر: </span><span>$views</span></section>";
    
    /*          Like / Comment / Share          */
    $current_user = isset($_SESSION["username"]) ? $_SESSION["username"] : null;
    $isuserliked = new PostActivity();
    $flag = $current_user? $isuserliked->isUserLiked($current_user, $product_id): 0;
    echo "<section>

    <section style='display:none;' class='w-100 justify-content-around p-3 socialMedias bg-warning rounded bg-gradient' id='share$product_id'><i class='fab fa-facebook' style='color:#3b5998;' ></i><i class='fab fa-twitter' style='color:#55acee'></i><i class='fab fa-instagram' style='color:#3f729b;'></i><i class='fab fa-whatsapp' style='color:#43d854'></i><i class='fab fa-google' style='color:#dc4e41;'></i><i class='fab fa-telegram' style='color:#00405d;'></i></section>
    
    <section class='btn-group border w-100'>
    <button data-role='posts' data-post='post$product_id' onclick='likePost(`$current_user`, `$product_id`, this, `$current_user`)' name='likeProduct' class='btn btn-dark d-flex justify-content-center align-items-center hover'><span class='pe-2'>0</span><i class='";
    if($flag > 0){
        echo "text-primary ";
    }
    echo"fas fa-thumbs-up'></i></button>
    <span class='btn btn-dark d-flex justify-content-center align-items-center' data-bs-toggle='collapse' data-bs-target='#commentCollapse$product_id'><span class='pe-2' data-type='commentNumbers' data-post='$product_id'>0</span><i class='fa fa-comment' aria-hidden='true'></i></span>
    <span class='btn btn-dark d-flex justify-content-center align-items-center' onclick='document.getElementById(`share$product_id`).classList.toggle(`d-flex`)'><span class='pe-2'>0</span><i class='material-icons'>share</i></span>

    </section>
    <section>
    </section>
<section data-type='comment-layout' >
  <section class='collapse collapse-vertical' id='commentCollapse$product_id'>
    <section class='card card-body' style='width: 100%; max-height:400px; overflow-y:scroll' data-role='commendHolder' data-post='$product_id'>
      No Comments Yet...
    </section>
    <section class='d-flex flex-row'>
    <input type='text' data-type='comment' data-post='$product_id' class='form-control' placeholder='کۆمێنت'/><button class='btn btn-success' onclick='commentToPost($product_id, this)'>Send</button>
    </section>
  </section>
</section>
    </section>";
    echo "</section>";
}
?>
<script async src="src/script/index.js"></script>
<script async src="src/script/main.js"></script>
<script>
    carousel_inner = document.getElementsByClassName("carousel-inner");
    for(let i = 0; i < carousel_inner.length; i++){
        carousel_inner[i].children[0].classList.add("active");
    }
    const visit = (to) =>{
        window.location = "User/"+to;
    }
    var videos = document.querySelectorAll('video');
for(var i=0; i<videos.length; i++)
   videos[i].addEventListener('play', function(){pauseAll(this)}, true);


function pauseAll(elem){
	for(var i=0; i<videos.length; i++){
		//Is this the one we want to play?
		if(videos[i] == elem) continue;
		//Have we already played it && is it already paused?
		if(videos[i].played.length > 0 && !videos[i].paused){
		// Then pause it now
		  videos[i].pause();
		}
	}
  }
  let descs = document.querySelectorAll(".desc");
  descs.forEach((elem)=>{
    if(elem.innerHTML.charCodeAt(0) > 127){
        elem.setAttribute("dir", "rtl");
    }
  })
</script>