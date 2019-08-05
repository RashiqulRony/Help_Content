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


// Cupone Code generate
 $randResult = '';
    $value = array_merge(range(0, 9), range('a', 'z'), range('A', 'Z'));
    for ($i = 0; $i < 16; $i++) {
        $randResult .= $value[array_rand($value)];
    }
    $code = str_split($randResult, 4);
    $cupon = $code[0].'-'.$code[1].'-'.$code[2].'-'.$code[3]; 
    print_r($cupon);

// Cupone code generate 2 
$value = array_merge(range(0, 9), range('a', 'z'), range('A', 'Z'));
    for ($i = 0; $i < 16; $i++) {
        $randResult .= $value[array_rand($value)];
    }
    $code = wordwrap($randResult,4,"-", true);
    print_r($code );

?>
