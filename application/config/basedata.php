<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['platetype'] = array ( 1 => '大型汽车号牌', 2 => '小型汽车号牌', 3 => '使馆汽车号牌', 4 => '领馆汽车号牌', 5 => '境外汽车号牌', 6 => '外籍汽车号牌', 7 => '两、三轮摩托号牌', 8 => '轻便摩托车号牌', 9 => '使馆摩托车号牌', 10 => '领馆摩托车号牌', 11 => '境外摩托车号牌', 12 => '外籍摩托车号牌', 13 => '农用运输车号牌', 14 => '拖拉机号牌', 15 => '挂车号牌', 16 => '教练汽车号牌', 17 => '教练摩托车号牌', 18 => '试验汽车号牌', 19 => '试验摩托车号牌', 20 => '临时入境汽车号牌', 21 => '临时入境摩托车号牌', 22 => '临时行使车号牌', 23 => '警用汽车号牌', 24 => '警用摩托号牌', 99 => '其它号牌', );

$config['hpzl'] = array ( '01' => '大型汽车号牌', '02' => '小型汽车号牌', '03' => '使馆汽车号牌', '04' => '领馆汽车号牌', '05' => '境外汽车号牌', '06' => '外籍汽车号牌', '07' => '两、三轮摩托号牌', '08' => '轻便摩托车号牌', '09' => '使馆摩托车号牌', 10 => '领馆摩托车号牌', 11 => '境外摩托车号牌', 12 => '外籍摩托车号牌', 13 => '农用运输车号牌', 14 => '拖拉机号牌', 15 => '挂车号牌', 16 => '教练汽车号牌', 17 => '教练摩托车号牌', 18 => '试验汽车号牌', 19 => '试验摩托车号牌', 20 => '临时入境汽车号牌', 21 => '临时入境摩托车号牌', 22 => '临时行使车号牌', 23 => '警用汽车号牌', 24 => '警用摩托号牌', 26 => '香港入出境车', 99 => '其它号牌', 31 => '武警号牌', 32 => '军队号牌', );

$config['bodycolor'] = array ( 1 => '其他', 2 => '白色', 3 => '灰色', 4 => '黑色', 5 => '红色', 6 => '黄色', 7 => '蓝色', 8 => '绿色', 9 => '紫红', 10 => '棕色', 11 => '深灰色', 12 => '浅灰色', );

$config['csys'] = array ( 'A' => '白', 'B' => '灰', 'C' => '黄', 'D' => '粉', 'E' => '红', 'F' => '紫', 'G' => '绿', 'H' => '蓝', 'I' => '棕', 'J' => '黑', 'Z' => '其他', );

$config['cartype'] = array ( 1 => array ( 'code' => 'H', 'name' => '货车', ), 2 => array ( 'code' => 'H1', 'name' => '重型货车', ), 3 => array ( 'code' => 'H2', 'name' => '中型货车', ), 4 => array ( 'code' => 'H3', 'name' => '轻型货车', ), 5 => array ( 'code' => 'H4', 'name' => '微型货车', ), 6 => array ( 'code' => 'H5', 'name' => '低速货车', ), 7 => array ( 'code' => 'K1', 'name' => '大型客车', ), 8 => array ( 'code' => 'K2', 'name' => '中型客车', ), 9 => array ( 'code' => 'K3', 'name' => '小型客车', ), 10 => array ( 'code' => 'K31', 'name' => '小型普通客车', ), 11 => array ( 'code' => 'K32', 'name' => '小型越野客车', ), 12 => array ( 'code' => 'K33', 'name' => '小型轿车', ), 13 => array ( 'code' => 'M', 'name' => '摩托车', ), 14 => array ( 'code' => 'Q', 'name' => '其他', ), );

$config['cllx'] = array ( 'H' => '货车', 'H1' => '重型货车', 'H2' => '中型货车', 'H3' => '轻型货车', 'H4' => '微型货车', 'H5' => '低速货车', 'K1' => '大型客车', 'K2' => '中型客车', 'K3' => '小型客车', 'K31' => '小型普通客车', 'K32' => '小型越野客车', 'K33' => '小型轿车', 'M' => '摩托车', 'Q' => '其他', );

$config['platecolor'] = array(1=>'其他',2=>'蓝牌',3=>'黄牌',4=>'白牌',5=>'黑牌');

$config['number'] = array('R','？','-','WJ','闽','粤','苏','浙','沪','京','津','冀','晋','蒙','辽','吉','黑','皖','赣','鲁','豫','鄂','湘','桂','琼','川','贵','云','藏','陕','甘','青','宁','新','台','渝','港','澳','军','海','空','沈','北','兰','济','南','成','广');

$config['direction'] = array(1=>'其他', 2=>'进城', 3=>'出城', 4=>'由东往西', 5=>'由南往北', 6=>'由西往东', 7=>'由北往南');

$config['lane'] = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14');

$config['confirm']  = array('00'=>'未确认','1'=>'已确认');
$config['confirm2'] = array(0=>'未确认',1=>'已确认');

$config['clppflag']  = array('00'=>'不匹配','1'=>'匹配');
$config['clppflag2'] = array(0=>'否',1=>'是');

$config['smsflag']  = array('00'=>'未发送','1'=>'已发送');
$config['smsflag2'] = array(0=>'未发送',1=>'已发送');




