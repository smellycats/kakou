<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Kakou publishing system
 *
 * @package		Kakou
 * @subpackage	Helpers
 * @category	Helpers
 * @author      Fire
 * @link
 */

/**
 * Check
 *
 * Check if user has logon status of manager, redirect to home page if not.
 *
 * @access	public
 * @param	none
 * @return	none
 */
if ( ! function_exists('check2'))
{
	function check2()
	{
		$CI =& get_instance();

		if ($CI->session->userdata('manager')=="")
		{
			redirect('home/index');
		}
	}
}

// ------------------------------------------------------------------------

/**
 * Showmessage
 *
 * Show a message, redirect to given page as provided
 *
 * @access	public
 * @param	string
 * @param	string
 * @param	boolean
 * @return	none
 */
if ( ! function_exists('showmessage2'))
{
	function showmessage2($msg, $goto = '', $auto = true)
	{
		$CI =& get_instance();

		$CI->load->view('admin/body_message', array('msg'=>$msg, 'goto'=>site_url($goto), 'auto'=>$auto));
	}
}

if ( ! function_exists('showmessage3'))
{
	function showmessage3($msg, $goto = '', $auto = true)
	{
		$CI =& get_instance();

		$CI->load->view('admin/show_message', array('msg'=>$msg, 'goto'=>site_url($goto), 'auto'=>$auto));
	}
}

/**
  * 数组转换成字符串
  *
  * @param array 输入数组。
  * 
  * @return string 返回','为分隔符的字符串。
  */
if( ! function_exists('array_to_string'))
{
	function array_to_string($array)
	{
		if ($array AND is_array($array))
		{
			return implode(',', $array);	
		}
		else
		{
			return '0';	
		}
	}
}

/**
 * IP字符串转换成浮点型
 *
 * @param string IP字符串。
 * 
 * @return double 返回IP数值。
 */
if( ! function_exists('ip_to_double'))
{
	function ip_to_double($ip)
	{
		$CI =& get_instance();
		
    	if($ip != '' AND $CI->input->valid_ip($ip))
    	{
     	    $str_ip = '';
        	$arr_ip = explode('.', $ip);
    	
        	foreach ($arr_ip as $part)
        	{
        		if(strlen($part) == 1)
        		{
    	    		$str_ip = $str_ip . '00' . $part;
        		}
        		elseif(strlen($part) == 2)
        	    {
    	    		$str_ip = $str_ip . '0' . $part;
        		}
    	    	else 
    	    	{
    	    		$str_ip = $str_ip . $part;
    	    	}
        	}
        	return (double)$str_ip;
    	}
    	else 
    	{
    		return (double)0;
    	}
	}

/**
 * 生成图片路径
 *
 * @param string $path1 路径名
 * @param string $path2 路径名
 * @param string $path3 路径名
 * 
 * @return string 返回图片url路径。
 */
if( ! function_exists('get_picurl'))
{
	function get_picurl($path1, $path2, $path3)
	{
		$CI = & get_instance();
		
		return 'http://'.$path1 .'/'. $path2. '/' . $path3;
		//return $CI->config->base_url() . $path1 . "/" . $path2;
	}
}

/**
 * 生成图片url
 *
 * @param boolean $wm_open 是否开启水印。
 * @param string $address 图片地址。
 * @param object $carinfo 车辆信息对象。
 * 
 * @return string 返回图片url路径。
 */
if( ! function_exists('h_create_img'))
{
	function h_create_img($wm_open=FALSE, $address, $carinfo)
	{	
		$CI = & get_instance();
		$CI->load->helper('url');
		
		if($wm_open){
			return base_url() . 'index.php/watermark/wm_img?id=' . $carinfo->ID;
		}else{
			return 'http://' . $address . '/' . $carinfo->QMTP. '/' . $carinfo->TJTP;
		}
	}
}

/**
 * 批量下载图片
 *
 * @access		public
 * @param	    array
 * @return	    null
 */
if( ! function_exists('download_img'))
{
	function download_img($kakou)
	{
		$CI = & get_instance();
		
		$CI->load->helper('kakou');
		$CI->load->helper('date');
		
		$time = mdate("%Y-%m-%d-%H-%i-%s");
		$path = "C:/kakouimgs" . $time . '/';
		
	    if (!file_exists($path))
	    {   
	    	//createFolder(dirname($path)); 
	    	mkdir($path, 0777);
	    }
		
		set_time_limit(60);
		//$imagesURLArray = array_unique($imagesURLArray);
		foreach ($kakou as $row)
		{
			$imagesURL = get_picurl($row->QMTP, $row->TJTP);
			echo $imagesURL;
			echo $path;
			echo "";
			file_put_contents($path . basename($imagesURL), file_get_contents($imagesURL));
		}
	}
}

/**
 * 数组转化为加单引号字符串
 *
 * $param array $array 输入数组
 * 
 * $return string 返回','分割后的字符串。
 * 
 */
if( ! function_exists('arr_to_sigquostr'))
{
	function arr_to_sigquostr($array)
	{
		$str = join(",",$array);
		return "'".str_replace(",","','",$str)."'";
	}
}

if( ! function_exists('change_to_quotes'))
{
	function change_to_quotes($array)
	{
		$str = join(",",$array);
		$inStr = "'".str_replace(",","','",$str)."'";
		return $inStr;
	}
}

if( ! function_exists('change_to_quotes2'))
{
	function change_to_quotes2($array)
	{
		$str = join(",",$array);
		$inStr = "''".str_replace(",","'',''",$str)."''";
		return $inStr;
	}
}

/**
 * 按,号分隔字符串生成数组并删除空白符
 * 
 * $param string $value 输入字符串
 * 
 * $return array 返回','分割后的数组。
 * 
 */
if( ! function_exists('trim_arr'))
{
	function trim_arr($value)
	{
		$arr = explode(",", str_replace('，', ',', $value));
		foreach($arr as $id=>$item) {
			$t_arr[$id] = trim($item);
		}
		return $t_arr;
	}
}

/**
 * 车牌号码转换成数据库查询用的字符。
 * 
 * $param string $value1 车牌号码1
 * $param string $value2 车牌号码2
 * 
 * $return string 返回一个完成的车牌号码。
 */
if( ! function_exists('format_carnum'))
{
	function format_carnum($value1,$value2)
	{
		$number = str_replace('?', '%', $value1);
       	$carnum = str_replace('*', '%', $number.$value2);
        $carnum = str_replace('?', '_', $carnum);
        $carnum = str_replace('？', '_', $carnum);
        
		return $carnum;
	}
}

/**
 * 车牌号码转换成数据库查询用的字符。
 * 
 * @param string $number 车牌号码1
 * @param string $carnum 车牌号码2
 * 
 * @return string 返回一个完整的车牌号码。
 */
if( ! function_exists('h_create_platename'))
{
	function h_create_platename($number,$carnum)
	{
		$number = str_replace('?', '%', $number);
		$number = str_replace('？', '%', $number);
       	$carnum = str_replace('*', '%', $carnum);
        $carnum = str_replace('?', '_', $carnum);
        $carnum = str_replace('？', '_', $carnum);
        
		return $number . $carnum;
	}
}

/**
 * 发送post请求
 * 
 * @param string $url 请求地址
 * @param array $post_data POST键值对数据
 * @param int $timeout 超时
 * 
 * @return string 返回响应信息或者在失败时返回 FALSE。
 */
if( ! function_exists('h_send_post'))
{
	function h_send_post($url, $post_data, $timeout=120) {
	
		$postdata = http_build_query($post_data);
		$options = array(
			'http' => array(
				'method' => 'POST',
				'header' => 'Content-type:application/x-www-form-urlencoded',
				'content' => $postdata,
				'timeout' => $timeout // 超时时间（单位:s）
			)
		);
		$context = stream_context_create($options);
		$result = file_get_contents($url, false, $context);
	
		return $result;
	}
}

/**
 * 发送post请求
 * 
 * @param string $url 请求地址
 * @param array $post_data POST键值对数据
 * @param int $timeout 超时
 * 
 * @return string 返回响应信息或者在失败时返回 FALSE。
 */
if( ! function_exists('h_send_json_post'))
{
	function h_send_json_post($url, $post_data, $timeout=120) {
	
		//$postdata = http_build_query($post_data);
		$options = array(
			'http' => array(
				'method' => 'POST',
				'header' => 'Content-type:application/json',
				'content' => $post_data,
				'timeout' => $timeout // 超时时间（单位:s）
			)
		);
		$context = stream_context_create($options);
		$result = file_get_contents($url, false, $context);
	
		return $result;
	}
}


/**
 * 字符串GBK转码为UTF-8，数字转换为数字。
 * 
 * @param string $s GBK字符类型
 * 
 * @return string 返回UTF-8字符类型。
 */
if( ! function_exists('ct2'))
{
	function ct2($s){
	     if(is_numeric($s)) {
	         return intval($s);
	     } else {
	         return iconv("GBK","UTF-8",$s);
	     }
	 }
}

/**
 * 字符数组GBK转码为UTF-8。
 * 
 * @param array $s GBK字符数组
 * 
 * @return array 返回UTF-8字符数组。
 */
if( ! function_exists('icon_to_utf8'))
{
	function icon_to_utf8($s) {
		if(is_array($s)) {
	    	foreach($s as $key => $val) {
				$s[$key] = icon_to_utf8($val);
	    	}
	    } else {
	   		return Null;
	    }
	    return $s;
	}
}

}