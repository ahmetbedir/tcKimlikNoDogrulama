<?php

/**
 * TC Kimlik No Doğruluma Sınıfı
 * İlk olarak TC Kimlik No'yu algoritmaya göre doğrulama yapalım:
 * İlk hanedeki ve 9.hanedeki sayı 0 olamaz.
 * 1,3,5,7,9 yani tek sayı sistemindeki sayıları topluyoruz ve 7 ile çarpıyoruz. 
 * Çıkan sonucu 2,4,6,9 çift sayı sistemindeki sayılar ile birlikte çıkartıyoruz.
 * Çıkan sonucun birler basamağındaki sayı tc kimlik numarasının 10. hanesindeki sayı ile aynı olmalıdır.
 * 1,2,3,4,5,6,7,8,9 ve 10 sayılarının toplamından çıkan sonucun birler basamağı tc kimlik numarasının 11. hanesidir.
 *
 * Yukarı işlemler doğru ise geçerli bir tc kimlik numarası girilmiştir.
 *
 * Bu işlemlerden sonra Kimlik Bilgilerini SOAP ile kontrol ediyoruz..
 */


/**
* @author Ahmet Bedir <ahmetbedir16@gmail.com>
*/

class tcKimlik
{
    /**
     * Tc Kimlik Numarası
     * @var int
     */
    private $tcKimlikNo;
    
    /**
     * TC Kimlik No Uzunluk doğrulama
     *
     * Değişken tipi -integer- uzunluk probleminden dolayı -double- olarak ayarlanmıştır.
     * @param double $tcKimlikNo 
     */
    function __construct($tcKimlikNo)
    {
        if(strlen($tcKimlikNo) != 11){
            return false;
        }
        if(strstr($tcKimlikNo, '.') || strstr($tcKimlikNo, ',')){
            return false;
        }
        $this->tcKimlikNo = (double)$tcKimlikNo;
    }

    /**
     * TC Kimlik No'yu algoritmaya göre kontrol et
     * @return bool 
     */
    private function kontrol()
    {
        $tekSayilarToplam = 0;
        $cifSayilarToplam = 0;

        if(substr($this->tcKimlikNo, 0, 1) == 0){
            return false;
        }
        if(substr($this->tcKimlikNo, 8,1) == 0){
            return false;
        }
        for($i = 0; $i <= 8; $i++){
         if(($i % 2) == 0){
            $tekSayilarToplam += substr($this->tcKimlikNo, $i,1);
         }else{
            $cifSayilarToplam += substr($this->tcKimlikNo, $i,1);
         }
        }

        $onuncuSayi = ((($tekSayilarToplam * 7) + 10) - $cifSayilarToplam) % 10;
        if($onuncuSayi != substr($this->tcKimlikNo, 8,1)){
            return false;
        }

        $onbirinciSayi = ($tekSayilarToplam + $cifSayilarToplam + $onuncuSayi) % 10;

        if($onbirinciSayi != substr($this->tcKimlikNo, 9,1)){
            return false;
        }

        return true;
    }

    /**
     * Küçük karakterleri büyük yap
     * Türkçe karakterlerdeki sorunları çöz
     * @param  [type] $deger [description]
     * @return [type]        [description]
     */
    public function karakterBuyut($deger)
    {
        if(strstr($deger, 'i')){
            $deger = str_replace("i", "İ", $deger);
        }
        if(strstr($deger, 'ı')){
            $deger = str_replace("ı", "I", $deger);
        }
        return mb_convert_case($deger,MB_CASE_UPPER);
    }

    /**
     * Soap ile MERNİS Servisini kullanarak TC Kimlik doğrulama işlemi
     * 
     * @param  string $ad         Kimlik üzerindeki kişinin adı.
     * @param  string $soyad      Kimlik üzerindeki kişinin soyadı.
     * @param  string $dogumYili  Kimlik üzerindeki kişinin doğum yılı.
     * @return bool               Doğrulanmış ise 1(true), yanlış ise 0(false) değeri döner.
     */
    public function dogrula($ad,$soyad,$dogumYili)
    {
        if(!$this->kontrol()){
            return false;
        }
        $client = new SoapClient("https://tckimlik.nvi.gov.tr/Service/KPSPublic.asmx?WSDL");
        $result = $client->TCKimlikNoDogrula(array(
            'TCKimlikNo'    => $this->tcKimlikNo,
            'Ad'            => $this->karakterBuyut($ad),
            'Soyad'         => $this->karakterBuyut($soyad),
            'DogumYili'     => $dogumYili
        ));
        return $result->TCKimlikNoDogrulaResult;
    }


}
