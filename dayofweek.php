<?php

function isLeapYear (int $y): bool {    
    if ($y%100==0) return  $y%400==0;
    return $y%4==0 ;
}

function dayByMonthExplicit (int $m,bool $yIsLeap): int {
    if( $m==2)
        return $yIsLeap ? 29 : 28;

    return ($m==4||$m==6||$m==9||$m==11) ?30:31;
}

function dayByMonth(int $m,int $y):int{
    $yIsLeap=isLeapYear($y);
    
    return dayByMonthExplicit($m,$yIsLeap);
}

function dayOfWeek(int $y,int $m,int $d):int{
    //todo: how to do this function =))
    $numberOfLeap=0;
    $numberOfNormal=0;
    for($i=0;$i<$y;$i++){        
        $isLeap= isLeapYear($i);
        if( $isLeap)
            $numberOfLeap++;
        else
            $numberOfNormal++;
    }

    $totalDayByYear= $numberOfLeap*366 + $numberOfNormal*365;   
    
    $y_isleap=isLeapYear($y);

    $totalDayByMonth=0;
    for($i=0;$i<$m;$i++){
        
        $totalDayByMonth=$totalDayByMonth+ dayByMonthExplicit($i+1,$y_isleap);
    }

    $total= $totalDayByYear+$totalDayByMonth+$d;

    return $total%7;
}
echo "day of week: " . dayOfWeek(2022,7,4);

// //test leap year
// for($i=1;$i<2022;$i++){
//     $leap=isLeapYear($i);
//     if ($leap)
//         echo $i."-Leap ";
//     else 
//         echo $i." ";
// }

////test days by month

// for($i=0;$i<12;$i++)
// {
//     echo dayByMonthExplicit($i+1,false)."\r\n";
// }

// for($i=0;$i<12;$i++)
// {
//     echo dayByMonthExplicit($i+1,true)."\r\n";
// }

