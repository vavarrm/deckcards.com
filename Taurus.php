<?php
$cards = str_split('1111222233334444555566667777888899990000JJJJQQQQKKKK');
// 洗牌
shuffle($cards);
// 假设游戏人数为4人 默认发排顺序为 A > B > C > D
$a = array($cards[0], $cards[4], $cards[8], $cards[12], $cards[16]);
$b = array($cards[1], $cards[5], $cards[9], $cards[13], $cards[17]);
$c = array($cards[2], $cards[6], $cards[10], $cards[14], $cards[18]);
$d = array($cards[3], $cards[7], $cards[11], $cards[15], $cards[19]);
// 随机抽取一张牌计算发牌顺序，0 J Q K 分别为10，11，12，13
# $number = $cards[rand(0, count($cards) - 1)];
$number = $cards[rand(0, count($cards) - 1)];
switch ($number) {
    case '1':case '5':case '9':case 'K':
        echo "发排顺序:A > B > C > D\r\n";
        $people = array("A" => $a, "B" => $b, "C" => $c, "D" => $d);
        break;
    case '2':case '6':case '0':
        echo "发排顺序:B > C > D > A\r\n";
        $people = array("B" => $a, "C" => $b, "D" => $c, "A" => $d);
        break;
    case '3':case '7':case 'J':
        echo "发排顺序:C > D > A > B\r\n";
        $people = array("C" => $a, "D" => $b, "A" => $c, "B" => $d);
        break;
    case '4':case '8':case 'Q':
        echo "发排顺序:D > A > B > C\r\n";
        $people = array("D" => $a, "A" => $b, "B" => $c, "C" => $d);
        break;
}
foreach ($people as $key => $value) {
	echo "<br>";
    echo "$key: " . implode(',', $value) . " " . taurus($value) . "<br>";
}
function taurus($cards){
    // 4带1
    $judge = array_values(array_count_values($cards));
    if($judge == array(1, 4) || $judge == array(4, 1)){
        return "4带1";
    }
    // 3带2
    if($judge == array(2, 3) || $judge == array(3, 2)){
        return "3带2";
    }
    // 处理数据
    foreach ($cards as $key => $value) {
        if(!is_numeric($value)){
            $cards[$key] = 0;
        }
        $cards[$key] = (int)$value;
    }
    $r = arrangement($cards, 3);
	var_dump($r);
    foreach ($r as $key => $value) {
        if(0 == (array_sum($value) % 10)){
            # $res = array_diff($cards, $value);
            $res = array_sum($cards) - array_sum($value);
            $taurus = 0;
            $tmp = $res % 10;
			// echo $res;
            if(0 == $tmp){
                return "牛牛";
            }
            if($res % 10 > $taurus){
                $taurus = $tmp;
            }
        }
    }
    if(isset($taurus)){
        return "牛$taurus";
    }
    return "没牛";
}
function arrangement($a, $m){
    $r = array();
    $n = count($a);
    if($m <= 0 || $m > $n){
        return $r;
    }
    for ($i=0; $i < $n; $i++) {
        $b = $a;
        $t = array_splice($b, $i, 1);
        if ($m == 1) {
            $r[] = $t;
        } else {
            $c = arrangement($b, $m - 1);
            foreach ($c as $v) {
                $r[] = array_merge($t, $v);
            }
        }
    }
    return $r;
}