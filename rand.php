<?php
function numberGen($x, $y) {
    $length = rand($x, $y);
    $value = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randResult = '';

    for ($i = 0; $i < $length; $i++) {
        $randResult .= $value[rand(0, strlen($value) -1)];
    }

    return $randResult;
}

echo numberGen(6, 6);

echo "<br><br>";


function numberGen2($length) {
    $randResult = '';
    $value = array_merge(range(0, 9), range('a', 'z'), range('A', 'Z'));

    for ($i = 0; $i < $length; $i++) {
        $randResult .= $value[array_rand($value)];
    }

    return $randResult;
}

echo numberGen2(4);
?>