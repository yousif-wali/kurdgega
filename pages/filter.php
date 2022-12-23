<!DOCTYPE html>
<html lang="en">
<head>
    <?php session_start(); include "head.php"; require "./../include/database.php";?>
    <title>Filter</title>
    <style>
        @import "./src/css/root.css";
    </style>
</head>
<body>
    <?php include "header.php"; $_SESSION['posts'] = "Filter";
    switch($_REQUEST['category']){
        case "Car":
            $_SESSION['category'] = "ئۆتۆمبیل";
            break;
        case "Asset":
            $_SESSION['category'] = "موڵک";
            break;
            case "Clothes":
                $_SESSION['category'] = "پۆشاک";
                break;
        case "Electronics":
            $_SESSION['category'] = "ئەلیکترۆنی";
            break;
        case "Items":
                $_SESSION['category'] = "کەلووپەل";
                break;
        default:
        $_SESSION['category'] = $_REQUEST['category'];
    }
    switch($_REQUEST['model']){
        //      موڵك
        case "Land":
            $_SESSION['model'] = "زەوی";
            break;
            case "House":
                $_SESSION['model'] = "خانوو";
                break;
                case "Shop":
                    $_SESSION['model'] = "دووکان";
                    break;
                    case "Others":
                        $_SESSION['model'] = "هیتر";
                        break;
        //          پۆشاک
        case "Men":
            $_SESSION['model'] = "پیاوان";
            break;
            case "Women":
                $_SESSION['model'] = "ئافرەتان";
                break;
                case "Children":
                    $_SESSION['model'] = "مناڵان";
                    break;
        //          Electronics
                    case "Mobile":
                        $_SESSION['model'] = "موبایل";
                        break;
                        case "Laptop":
                            $_SESSION['model'] = "لاپتۆپ";
                            break;
                            case "Smartwatch":
                                $_SESSION['model'] = "کاتژمێری زیرەک";
                                break;
                                case "Tablet":
                                    $_SESSION['model'] = "تابلێت";
                                    break;
                                    case "Console":
                                        $_SESSION['model'] = "کۆنسۆل";
                                        break;
                        //          کەلووپەل
                        case "HouseItems":
                            $_SESSION['model'] = "کەلووپەلی ناو ماڵ";
                            break;
                            case "Livingroom":
                                $_SESSION['model'] = "ژووری میوان";
                                break;
                                case "Kitchen":
                                    $_SESSION['model'] = "چێشتخانە";
                                    break;
                                    case "Bedroom":
                                        $_SESSION['model'] = "ژووری نووستن";
                                        break;
        default:
            $_SESSION['model'] = $_REQUEST['model'];
    }?>
    <main style="margin-top:60px;">
    <section class="posts container" style="width:40%">
        <?php include "./products.php";?>
</section>
    </main>
</body>
</html>