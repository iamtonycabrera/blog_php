<?php

    // Formatear fecha
    function formatearFecha($fecha){
        return date('d M, Y', strtotime($fecha));
    }

    // Recortar texto
    function textoCorto($texto, $chars = 100){
        $texto = $texto."";
        $texto = substr($texto, 0, $chars);
        $texto = substr($texto, 0, strrpos($texto, ' '));
        $texto = $texto. "...";
        return $texto;
    }

?>