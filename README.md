## TC Kimlik No Doğruma Sınıfı
T.C. İçişleri Bakanlığı Nüfus ve Vatandaşlık İşleri Genel Müdürlüğü tarafından kullanıma sunulan web servisini kullanarak basit ve kolay bir şekilde TC kimlik no doğrulama işlemini yapabilirsiniz.

## Kullanımı 

    $tc = new tcKimlik("tc kimlik no");  
    $sonuc = $tc->dogrula("ad","soyad","doğum yılı");  
    if($sonuc){  
        echo 'TC Kimlik No Doğrulandı';  
    }else{  
        echo 'Doğrulama işlemi başarısız!!';  
    }


## Open source licensing info
[LICENSE](https://github.com/ahmetbedir/tcKimlikNoDogrulama/edit/master/LICENSE "Open source licensing info")
