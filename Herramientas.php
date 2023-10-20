<?php

class Herramientas{
    
    public static function NuevoID($array){
        $idMaximo=0;
        if($array != null){
            foreach($array as $item){
                if ($idMaximo === 0 || $item->id > $idMaximo) {
                    $idMaximo = $item->id;
                }
            }
        }
        return $idMaximo + 1;
    }

    
}

?>