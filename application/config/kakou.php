<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| Kakou Config
| -------------------------------------------------------------------
*/


$config['title'] = '惠州市治安卡口系统';
/*
|--------------------------------------------------------------------------
| Images url
|--------------------------------------------------------------------------
|
| These details are used in images.
|
*/

$config['kakou_img_base_url'] = 'http://10.44.249.227:81/';
$config['kakou_img_num']      = 1000;
$config['kakou_download_ip']  = '10.44.249.227:8083';

$config['kakou_xls_num'] = 4000;

/*
|--------------------------------------------------------------------------
| wm config
|--------------------------------------------------------------------------
|
| These details are used in watermark.
|	
|   ['wm_open']       是否开启水印。
|	['wm_font_size']  字体的尺寸。
|	['wm_font_color'] 颜色索引数组：red,green,blue。
|	['wm_font_file']  是想要使用的 TrueType 字体的路径。
|	['wm_alpha']      透明度参数 alpha，其值从 0 到 127。0 表示完全不透明，127 表示完全透明。
|	['wm_angle']      角度制表示的角度，0 度为从左向右读的文本。更高数值表示逆时针旋转。
		     	 	     例如 90 度表示从下向上读的文本。
|
*/

$config['wm_open']       = FALSE;
$config['wm_font_size']  = '32';
$config['wm_font_color'] = array(255,255,255);
$config['wm_font_file']  = 'font/WRYH.ttf';
$config['wm_alpha']      = 100;
$config['wm_angle']      = 30;

/*
|--------------------------------------------------------------------------
| jQuery easyui config
|--------------------------------------------------------------------------
|
| These details are used in watermark.
|	
|   ['ui_themes']     样式
|
*/
$config['ui_themes'] = 'bootstrap';

/*
|--------------------------------------------------------------------------
| URLImgPackage config
|--------------------------------------------------------------------------
|
| These details are used in watermark.
|	
|   ['package_url']     url地址
|
*/
$config['package_url'] = 'http://127.0.0.1:8017/package';

