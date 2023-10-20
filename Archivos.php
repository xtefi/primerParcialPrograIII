<?php

class Archivos{

    //Recibe ITEM y ARCHIVO por parámetro
    //Guarda el ITEM en el ARCHIVO - SOBREESCRIBE
    public static function GuardarJson($item, $archivo){
        try{
            if($item != null){
                $nuevoJson = json_encode($item, JSON_PRETTY_PRINT);
                file_put_contents($archivo, $nuevoJson);
            }
        }catch (Throwable $mensaje){          
            printf("Error al guardar el archivo: <br> $mensaje");
        }
    }

    // Recibe un archivo por parámetro
    //Devuelve un array de objetos: - lleno si el archivo contiene items
    //                              - vacio si el archivo está vacío
    public static function LeerJson($archivo){
        try{
            $jsonData = file_get_contents($archivo);
            if($jsonData !== false){  
                $data = json_decode($jsonData, true);                          
                return $data;
            }
            return ($data=[]);
        }catch(Throwable $mensaje){          
            echo "Error al leer el archivo: <br>" . $mensaje;
        }
    }
    
}


?>
