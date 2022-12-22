<style>
    [data-role="header"]{
        border-bottom:1px solid white;
        background-image:var(--header-primary-background-color);
        backdrop-filter: blur(1px);
        z-index:999;
        position:fixed;
        width:100vw;
        padding:0 2em;
        height:60px;
        top:0;
    }
    .profile > *{
        margin:0 1em;
        cursor:pointer; 
    }
    [cursor="pointer"]{
        cursor:pointer;
    }
</style>
<header data-role="header" class="d-flex flex-row justify-content-between align-items-center">
    <section class="d-flex flex-row align-items-center justify-contents-between">
        <?php 
        if(isset($_SESSION['username'])){
            echo '
            <section>
            <button class="btn btn-secondary nonmobile" onclick="window.location = `Post`">دانانی بابەت</button>
            </section>
            ';
        }
        $current_file = $_SERVER["PHP_SELF"];
        if(!preg_match_all("/index.php/i", $current_file)){
            echo '<section class="btn btn-secondary ms-2 nonmobile" onclick="window.location = `./Home`">ماڵەوە</section>';
        }
        ?>
    </section>
    <section>
    </section>
    <section class="d-flex justify-content-between align-items-center">
        <span>
        <section style="display:flex" class="form  flex-row nonmobile">
        <input class="form-control" type="search" id="search"/>
        <button class="material-icons btn btn-info me-1" onclick="search()">search</button>
        </section>
        </span>
    <?php
    if(isset($_SESSION['username'])){
    echo '
    <span cursor="pointer" class="btn btn-success nonmobile" onclick="window.location = `KurdMessenger`">
        <i class="fa fa-comment" aria-hidden="true"></i>
        نامەبەری کورد
    </span>  
    ';
    } 
    ?>
    <section class="d-flex justify-content-between p-2 profile">
            <?php if(isset($_SESSION['username'])){
            echo '
        <button class="btn btn-primary me-0 dropdown-toggle sans-serif" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            '.$_SESSION['username'].'
          </button>

        <section class="dropdown-menu">
            <form action="./include/validator.php" method="post">
            <button name="logout" class="dropdown-item">چوونە دەرەوە</button>
            </form>
            <hr class="dropdown-divider">
            <button class="dropdown-item" onclick="window.location=`Profile`">پەڕەی تایبەتی</button>
          </section>
            ';
        }else{echo '
            <button class="btn btn-primary me-0 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                پەڕەی تایبەتی
              </button>
    
            <section class="dropdown-menu">               
                <button class="dropdown-item" onclick="window.location=`Login`">چوونە ژوورەوە</button>
                <button class="dropdown-item" onclick="window.location=`Signup`">تۆمارکردن</button>            
              </section>
                ';
        }?>
        </section>
    </section>
</header>
<script>
    const search = ()=>{
        let searching = document.getElementById(`search`).value;
        if(searching != ""){
            window.location = `./Search/`+searching;
        }
    }
</script>