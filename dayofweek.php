<?php

function isLeapYear(int $y): bool
{
    return ($y % 100 == 0) ? ($y % 400 == 0) : ($y % 4 == 0);
}

function dayByMonthExplicit(int $m, bool $yIsLeap): int
{
    if ($m == 2)
        return $yIsLeap ? 29 : 28;

    return ($m == 4 || $m == 6 || $m == 9 || $m == 11) ? 30 : 31;
}

function yearToDays($y)
{
    $totalDayByYear = 0;
    for ($i = 1; $i < $y; $i++) {
        $isLeap = isLeapYear($i);
        if ($isLeap) {
            $totalDayByYear = $totalDayByYear + 366;
        } else {
            $totalDayByYear = $totalDayByYear + 365;
        }
    }

    return $totalDayByYear;
}

function yearToDaysFormular($y)
{
    //fomular
    $yBefore = $y - 1;
    $century = (int) ($yBefore / 100);
    $yearTodays = $yBefore * 365 + ((int)($yBefore / 4)) - $century + (int) ($century / 4);
    // 1 năm 365 ngày, thêm 4 năm nhuận 1 lần, 100 năm thì bớt ngày nhuận, 400 năm cộng thêm 1 ngày nhuận

    return $yearTodays;
}

function dayOfWeek(int $y, int $m, int $d): int
{

    $yearTodays= yearToDaysFormular($y);
    $totalDayByYear= yearToDays($y);

    echo "\r\nyou should choose formular: " . $yearTodays . " or use for loop to sum:" . $totalDayByYear . "\r\n";

    $y_isleap = isLeapYear($y);
    $totalDayByMonth = 0;
    $mBefore = $m - 1;
    for ($i = 0; $i < $mBefore; $i++) {
        $dim = dayByMonthExplicit($i + 1, $y_isleap);        
        $totalDayByMonth = $totalDayByMonth + $dim;
    }

    $total = $yearTodays + $totalDayByMonth + $d;

    return $total % 7;
}

$mapDoW = array(0 => "Chu Nhat", 1 => "Thu 2", 2 => "Thu 3", 3 => "Thu 4", 4 => "Thu 5", 5 => "Thu 6", 6 => "Thu 7");

$r = dayOfWeek(2022, 7, 5);
$rt = $mapDoW[$r];

echo "\r\nDoW: " . $r . "=>" . $rt . "\r\n";

$r = dayOfWeek(1984, 12, 21);
$rt = $mapDoW[$r];

echo "\r\nDoW: " . $r . "=>" . $rt . "\r\n";


echo "\r\n 2000 is leap " . (isLeapYear(2000) ? "ok" : "no") . "\r\n";
echo "\r\n 1700 is leap " . (isLeapYear(1700) ? "ok" : "no") . "\r\n";

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
