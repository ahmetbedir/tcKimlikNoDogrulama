<?php
    require '../src/tcKimlik.class.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>TC Kimlik No Doğrulama</title>
</head>
<body>
    
<?php
    $tc = new tcKimlik("50980075666");

    $sonuc = $tc->dogrula("ahmet","bedir","1995");
    if($sonuc){
        echo 'TC Kimlik Numarası Geçerlidir!';
    }else{
        echo 'TC kimlik numarası veya bilgiler yanlış!!';
    }
?>

</body>
</html>
