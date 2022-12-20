<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Post - <?php echo $_SESSION['username']?></title>
    <?php include "./head.php";?>
    <style>
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
    <form action="./include/validator.php" method="POST" enctype="multipart/form-data">
        <section class="form-floating">
            <input id="title" type="text" name="title" class="form-control" placeholder="John" required/>
            <label for="title" class="form-label">Title</label>
        </section>
        <section  class="form-floating">
            <input id="desc" type="text" name="desc" class="form-control" placeholder="Doe" required/>
            <label for="desc" class="form-label">Description</label>
        </section>
        <section  class="form-floating">
            <input id="price" type="text" name="price" class="form-control" placeholder="$9.99" required/>
            <label for="price" class="form-label">Price</label>
        </section>
        <section>
            <input id="image" type="file" name="image[]" accept="image/*" multiple class="form-control" placeholder="image.png" required/>
        </section>
        <section class="row">
            <section class="col-6 form-floating">
                <select name="category" class="form-select" id='category' required>
                    <option value="" default> Choose Category</option>
                    <option value="Car">ئۆتۆمبیل</option>
                    <option value="Asset">موڵک</option>
                    <option value="Clothes">پۆشاك</option>
                    <option value="Electronics">ئەلیکترۆنی</option>
                    <option value="Items">کەلووپەل</option>
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
        <section class="row">
            <section class="col-6 form-floating">
                <input id="year" type="number" name="year" min="1950" max="2023" step="1" class="form-control" placeholder="Year" required />
                <label for="year" class="form-label">Year</label>
            </section>
            <section class="col-6 d-flex align-items-center form-floating">
                <select id="condition" name="condition" class="form-select" required>
                    <option value="new">Condition - New</option>
                    <option value="usednew">Condition - Used Like New</option>
                    <option value="usedold">Condition - Used Old</option>
                    <option value="old">Condition - Old</option>
                </select>
            </section>
        </section>
        <button name="postProduct" class="btn btn-success">Post</button>
        <?php
        if(isset($_COOKIE["productpost"])){
            echo '<p class="text-success">The Post Was Succesfully Added!</p>';
        }
        ?>
    </form>
    <section class="bg-success text-white p-2 rounded" style="position:fixed; bottom:1em; right:1em; cursor:pointer" onclick="window.location = './Home'">
    Home
    </section>
    <script>
        document.getElementById('category').addEventListener("change", (elem)=>{
            let chosen = document.getElementById('category').value;
            let model = document.getElementById('model');
            switch(chosen){
                case "Car":
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
                    <option value="Others">Others</option>
`;
                break;
                case "Asset":
                    model.innerHTML = `
                    <option value="Land">زەوی</option>
                    <option value="House">خانوو</option>
                    <option value="Shop">دووکان</option>
                    <option value="Others">هیتر</option>


                    `;
                break;
                case "Clothes":
                    model.innerHTML = `
                    <option value="Men">پیاوان</option>
                    <option value="Women">ئافرەتان</option>
                    <option value="Children">مناڵان</option>
                    `;
                    break;
                case "Electronics":
                    model.innerHTML = `
                    <option value="Mobile">موبایل</option>
                    <option value="Laptop">لاپتۆپ</option>
                    <option value="Smartwatch">کاتژمێری زیرەک</option>
                    <option value="Tablet">تابلێت</option>
                    <option value="Console">کۆنسۆل</option>
                    <option value="Others">هیتر</option>


                    `;
                    break;
                    case "Items":
                        model.innerHTML = `
                        <option value="House">کەلووپەلی ناو ماڵ</option>
                        <option value="Livingroom">ژووری میوان</option>
                        <option value="Kitchen">چێشتخانە</option>
                        <option value="Bedroom">ژووری نووستن</option>
                        <option value="Others">دیکۆراتیتر</option>

                        `;
            }
        })
    </script>
</body>
</html>