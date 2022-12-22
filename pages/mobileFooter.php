<style>
    .mobileFooter{
        position:fixed;
        bottom:0;
        left:0;
        width:100vw;
        height:60px;
        display:none;
        z-index:999;
        justify-content: space-around;
        align-items:center;
        background-image:var(--header-primary-background-color);
    }
    .sidemenumobile{
        display:flex;
        position:fixed;
        width:0;
        left:0;
        top:60px;
        height:calc(100% - 120px);
        transition: width 0.3s linear;
        z-index:999;
        background-image: var(--header-primary-background-color);
        overflow:hidden;
    }
    .sidemenumobile.active{
        width:60vw;
    }
</style>
<aside class="sidemenumobile d-flex justify-content-between align-items-center flex-column">
    <section style="display:flex" class="form flex-row">
        <input class="form-control" type="search" id="asideSearch"/>
        <button class="material-icons btn btn-info" onclick="asideSearch()">search</button>
    </section>
    <section>
    <?php
    if(isset($_SESSION['username'])){
        echo '
        <span cursor="pointer" class="btn btn-success" onclick="window.location = `KurdMessenger`">
            <i class="fa fa-comment" aria-hidden="true"></i>
            نامەبەری کورد
        </span>   
        ';
    }
    ?>
    </section>
</aside>
<footer class="mobileFooter">
    <section class="material-icons" data-type="menubar" onclick="activateMenu(this)">
        menu
    </section>

    <section>
        <?php 
        if(isset($_SESSION['username'])){
            echo '
            <button class="btn btn-secondary" onclick="window.location = `Post`">دانانی بابەت</button>
            ';
        }
        ?>
    </section>

    <section class="btn btn-secondary ms-2" onclick="window.location = `./Home`">ماڵەوە</section>
</footer>
<script>
    const activateMenu = (elem)=>{
        if(elem.innerHTML == "menu"){
            elem.innerHTML = "close";
            document.querySelector("aside.sidemenumobile").classList.add("active");
        }else{
            elem.innerHTML = "menu";
            document.querySelector("aside.sidemenumobile").classList.remove("active");
        }
    }
    const asideSearch = ()=>{
        let searching = document.getElementById(`asideSearch`).value;
        if(searching != ""){
            window.location = `./Search/`+searching;
        }
    }
</script>