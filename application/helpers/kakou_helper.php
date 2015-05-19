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
  * ����ת�����ַ���
  *
  * @param array �������顣
  * 
  * @return string ����','Ϊ�ָ������ַ�����
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
 * IP�ַ���ת���ɸ�����
 *
 * @param string IP�ַ�����
 * 
 * @return double ����IP��ֵ��
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
 * ����ͼƬ·��
 *
 * @param string $path1 ·����
 * @param string $path2 ·����
 * @param string $path3 ·����
 * 
 * @return string ����ͼƬurl·����
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
 * ����ͼƬurl
 *
 * @param boolean $wm_open �Ƿ���ˮӡ��
 * @param string $address ͼƬ��ַ��
 * @param object $carinfo ������Ϣ����
 * 
 * @return string ����ͼƬurl·����
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
 * ��������ͼƬ
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
 * ����ת��Ϊ�ӵ������ַ���
 *
 * $param array $array ��������
 * 
 * $return string ����','�ָ����ַ�����
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
 * ��,�ŷָ��ַ����������鲢ɾ���հ׷�
 * 
 * $param string $value �����ַ���
 * 
 * $return array ����','�ָ������顣
 * 
 */
if( ! function_exists('trim_arr'))
{
	function trim_arr($value)
	{
		$arr = explode(",", str_replace('��', ',', $value));
		foreach($arr as $id=>$item) {
			$t_arr[$id] = trim($item);
		}
		return $t_arr;
	}
}

/**
 * ���ƺ���ת�������ݿ��ѯ�õ��ַ���
 * 
 * $param string $value1 ���ƺ���1
 * $param string $value2 ���ƺ���2
 * 
 * $return string ����һ����ɵĳ��ƺ��롣
 */
if( ! function_exists('format_carnum'))
{
	function format_carnum($value1,$value2)
	{
		$number = str_replace('?', '%', $value1);
       	$carnum = str_replace('*', '%', $number.$value2);
        $carnum = str_replace('?', '_', $carnum);
        $carnum = str_replace('��', '_', $carnum);
        
		return $carnum;
	}
}

/**
 * ����post����
 * 
 * @param string $url �����ַ
 * @param array $post_data POST��ֵ������
 * @param int $timeout ��ʱ
 * 
 * @return string ������Ӧ��Ϣ������ʧ��ʱ���� FALSE��
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
				'timeout' => $timeout // ��ʱʱ�䣨��λ:s��
			)
		);
		$context = stream_context_create($options);
		$result = file_get_contents($url, false, $context);
	
		return $result;
	}
}

/**
 * ����post����
 * 
 * @param string $url �����ַ
 * @param array $post_data POST��ֵ������
 * @param int $timeout ��ʱ
 * 
 * @return string ������Ӧ��Ϣ������ʧ��ʱ���� FALSE��
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
				'timeout' => $timeout // ��ʱʱ�䣨��λ:s��
			)
		);
		$context = stream_context_create($options);
		$result = file_get_contents($url, false, $context);
	
		return $result;
	}
}


/**
 * �ַ���GBKת��ΪUTF-8������ת��Ϊ���֡�
 * 
 * @param string $s GBK�ַ�����
 * 
 * @return string ����UTF-8�ַ����͡�
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
 * �ַ�����GBKת��ΪUTF-8��
 * 
 * @param array $s GBK�ַ�����
 * 
 * @return array ����UTF-8�ַ����顣
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