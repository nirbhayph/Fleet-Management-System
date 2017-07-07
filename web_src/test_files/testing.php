<?php 
echo exec('sudo python pickups-test.py 14098 1 1 2>&1',$retArr);
print_r($retArr);
$val = round($retArr[0]);
?>
