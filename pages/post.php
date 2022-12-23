<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Post - <?php echo $_SESSION['username']?></title>
    <?php include "./head.php";?>
    <style>
        @import "./src/css/root.css";
        body{
            height:100vh;
        }
        form{
            width:400px;
        }
        form > *{
            margin:0.5em;
            
        }
    </style>
</head>
<body class="d-flex justify-content-center align-items-center">
    <?php include "./header.php";?>
    <form action="./include/validator.php" method="POST" enctype="multipart/form-data">
        <section class="form-floating">
            <input id="title" type="text" name="title" class="form-control" placeholder="John" required/>
            <label for="title" class="form-label">سەردێڕ</label>
        </section>
        <section  class="form-floating">
            <input id="desc" type="text" name="desc" class="form-control" placeholder="Doe" required/>
            <label for="desc" class="form-label">وەسف</label>
        </section>
        <section  class="form-floating">
            <input id="price" type="text" name="price" class="form-control" placeholder="$9.99" required/>
            <label for="price" class="form-label">نرخ</label>
        </section>
        <section>
            <input id="image" type="file" name="image[]" accept="image/*,video/*" multiple class="form-control <?php if(isset($_COOKIE["fileuploaderr"])){echo ' is-invalid';}?> " placeholder="image.png" required/>
            <?php
                        if(isset($_COOKIE["fileuploaderr"])){
                            if($_COOKIE["fileuploaderr"] == "size"){
                                echo '<section class=" invalid-feedback text-white bg-danger rounded mt-2 p-2 border">File is too big!</section>';
                            }else{
                                echo '<section class=" invalid-feedback text-white bg-danger rounded mt-2 p-2 border">File type is not supported!</section>';
                            }
                        }
                ?>
        </section>
        <section class="row" style="width:100%; margin-left:auto; margin-right:auto;">
            <section class="col-6 form-floating">
                <select name="category" class="form-select" id='category' required>
                    <option value="" default> بەشێك هەلبژێرە</option>
                    <option value="ئۆتۆمبیل">ئۆتۆمبیل</option>
                    <option value="موڵک">موڵک</option>
                    <option value="پۆشاک">پۆشاك</option>
                    <option value="ئەلیکترۆنی">ئەلیکترۆنی</option>
                    <option value="کەلووپەل">کەلووپەل</option>
                </select>
            </section>
            <section class="col-6 form-floating">
                <select name="model" id="model" class="form-select">
                    <option value="BMW">BMW</option>
                    <option value="Ford">Ford</option>
                    <option value="GMC">GMC</option>
                    <option value="Honda">Honda</option>
                    <option value="Hyndai">Hyundai</option>
                    <option value="Infinity">Infinity</option>
                    <option value="KIA">KIA</option>
                    <option value="Lexus">Lexus</option>
                    <option value="Mitsubishi">Mitsubishi</option>
                    <option value="Toyota">Toyota</option>
                    <option value="Others">Others</option>

                </select>
            </section>
        </section>
        <section class="row" style="width:100%; margin-left:auto; margin-right:auto;">
            <section class="col-6 form-floating">
                <input id="year" type="number" name="year" min="1950" max="2023" step="1" class="form-control" placeholder="Year" required />
                <label for="year" class="form-label">ساڵ</label>
            </section>
            <section class="col-6 d-flex align-items-center form-floating">
                <select id="condition" name="condition" class="form-select" required>
                    <option value="نوێ">حاڵەت - نوێ</option>
                    <option value="بەکارهێنراوە و نوێیە">حاڵەت - بەکارهێنراوە و نوێە</option>
                    <option value="بەکارهێنراوە و کۆنە">حاڵەت - بەکارهێنراوە و کۆنە</option>
                    <option value="old">حاڵەت - کۆنە</option>
                </select>
            </section>
        </section>
        <button name="postProduct" class="btn btn-success">بەڵاوکردنەوە</button>
        <?php
        if(isset($_COOKIE["productpost"])){
            echo '<p class="text-success">The Post Was Succesfully Added!</p>';
        }
        ?>
    </form>
    <section class="bg-success text-white p-2 rounded nonmobile" style="position:fixed; bottom:1em; right:1em; cursor:pointer" onclick="window.location = './Home'">
    ماڵەوە
    </section>
    <script>
        document.getElementById('category').addEventListener("change", (elem)=>{
            let chosen = document.getElementById('category').value;
            let model = document.getElementById('model');
            switch(chosen){
                case "ئۆتۆمبیل":
                    model.innerHTML = `                    <option value="BMW">BMW</option>
                    <option value="Ford">Ford</option>
                    <option value="GMC">GMC</option>
                    <option value="Honda">Honda</option>
                    <option value="Hyndai">Hyundai</option>
                    <option value="Infinity">Infinity</option>
                    <option value="KIA">KIA</option>
                    <option value="Lexus">Lexus</option>
                    <option value="Mitsubishi">Mitsubishi</option>
                    <option value="Toyota">Toyota</option>
                    <option value="هیتر">هیتر</option>
`;
                break;
                case "موڵک":
                    model.innerHTML = `
                    <option value="زەوی">زەوی</option>
                    <option value="خانوو">خانوو</option>
                    <option value="دووکان">دووکان</option>
                    <option value="هیتر">هیتر</option>


                    `;
                break;
                case "پۆشاک":
                    model.innerHTML = `
                    <option value="پیاوان">پیاوان</option>
                    <option value="ئافرەتان">ئافرەتان</option>
                    <option value="مناڵان">مناڵان</option>
                    `;
                    break;
                case "ئەلیکترۆنی":
                    model.innerHTML = `
                    <option value="موبایل">موبایل</option>
                    <option value="لاپتۆپ">لاپتۆپ</option>
                    <option value="کاتژمێری زیرەک">کاتژمێری زیرەک</option>
                    <option value="تابلێت">تابلێت</option>
                    <option value="کۆنسۆل">کۆنسۆل</option>
                    <option value="هیتر">هیتر</option>


                    `;
                    break;
                    case "کەلووپەل":
                        model.innerHTML = `
                        <option value="کەلووپەلی ناو ماڵ">کەلووپەلی ناو ماڵ</option>
                        <option value="ژووری موان">ژووری میوان</option>
                        <option value="چێشتخانە">چێشتخانە</option>
                        <option value="ژووری نووستن">ژووری نووستن</option>
                        <option value="دیکۆراتیتر">دیکۆراتیتر</option>

                        `;
            }
        })
    </script>
     <?php include "./mobileFooter.php";?>
</body>
</html>