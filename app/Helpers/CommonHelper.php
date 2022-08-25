<?php
namespace App\Helpers;

class CommonHelper 
{
    public static function convertNameToSlug( $name ) {
        
        $string = utf8_encode($name);
        $string = iconv('UTF-8', 'ASCII//TRANSLIT', $string);   
        $string = preg_replace('/[^a-z0-9- ]/i', '', $string);
        $string = str_replace(' ', '-', $string);
        $string = trim($string, '-');
        $string = strtolower($string);

        if (empty($string)) {
        return 'n-a';
        }

        return $string;
    }
    
    public static function getFundedPledged($pledged, $funded) {
        $fun = $funded * 100;
        $percentage = round($fun / $pledged);
        return $percentage;
    }
    
    public static function convertToDBInt($value) {
        $newValue = $value*100;
        return $newValue;
    }
    
    public static function revertDBIntToValue($value) {
        $newValue = $value/100;
        return $newValue;
    }
    
    public static function currencySymbol($currency) {
        return $currency->symbol_left?$currency->symbol_left:$currency->symbol_right;
    }
}