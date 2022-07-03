<?php

function dayofweek($y,$m,$d){
    $numberOfLeap=0;
    $numberOfNormal=0;
    
    for($i=0;$i<$y;$i++){
        if($i%4==0)
            $numberOfLeap++;
        else
            $numberOfNormal++;
    }

    $totalDayByYear= $numberOfLeap*366 + $numberOfNormal*365;
    
    

}