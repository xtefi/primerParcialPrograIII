<?php

class Herramientas{
    
    public static function NuevoID($array){
        $idMaximo=0;
        if(count($array)>0){
            foreach($array as $item){
                if ($idMaximo === 0 || $item->id > $idMaximo) {
                    $idMaximo = $item->id;
                }
            }
            return $idMaximo + 1;
        }else{
            return $idMaximo=10000;
        }
    }
    
}

?>