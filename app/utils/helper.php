<?php
function seatToInt(string $seat, int $row, int $level, int $line) : int {
    $chars = str_split($seat);
    return $line*$level*(ord($chars[0])-65) + $line*($chars[1]-1) + $chars[2];
}

function intToSeat(int $num, int $row, int $level, int $line) : string {
    $elem1 = floor(($num-1) / ($line*$level));
    $elem2 = floor((($num-1) % ($line*$level)) / $line);
    $elem3 = ($num-1) % $line;

    return chr(65+$elem1).($elem2+1).($elem3+1);
}