<?php
    require '../src/tcKimlik.class.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>TC Kimlik No Doğrulama</title>
    <style>
        body{
            background: #f1f1f1;  
            font-family: arial;
        }
        .ok{
            color:#fff;
            background: #0a0;
            border:2px solid #050;
            padding: 10px 15px;
            -webkit-border-radius: 3px;
                    border-radius: 3px;
        }
        .no{
            color:#fff;
            background: #d00;
            border:2px solid #900;
            padding: 10px 15px;
            -webkit-border-radius: 3px;
                    border-radius: 3px;
        }
    </style>
</head>
<body>
    <form action="" method="post">
        <table>
            <tr>
                <td align="right">TC Kimlik No : </td>
                <td><input type="text" name="tcNo" maxlength="11"></td>
            </tr>
            <tr>
                <td align="right">Ad : </td>
                <td><input type="text" name="ad"></td>
            </tr>
            <tr>
                <td align="right">Soyad : </td>
                <td> <input type="text" name="soyad"></td>
            </tr>
            <tr>
                <td align="right">Doğum Yılı : </td>
                <td><input type="text" name="dogumYili"></td>
            </tr>
            <tr>
                <td></td>
                <td><button type="submit">Kontrol Et</button></td>
            </tr>
        </table>
    </form>
    <br> <br>
    <?php
        if($_POST){
            $tcNo   = $_POST['tcNo'];
            $ad     = $_POST['ad'];
            $soyad  = $_POST['soyad'];
            $dogumYili = $_POST['dogumYili'];

            $tc = new tcKimlik($tcNo);

            $sonuc = $tc->dogrula($ad,$soyad,$dogumYili);
            if($sonuc){
                echo '<span class="ok">TC kimlik no doğrulandı.</span>';
            }else{
                echo '<span class="no">TC kimlik no doğrulanmadı!!</span>';
            }
        }
    ?>

</body>
</html>
