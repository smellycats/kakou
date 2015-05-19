<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Lib_kakou
{
	function Lib_Kakou()
	{
		$this->ci =& get_instance();

		//log_message('debug', 'DX Auth Initialized');
		$this->ci->load->helper('date');
		// Load required library
		$this->ci->load->library('Session');
		$this->ci->load->library('Lib_kakou');
		$this->ci->load->library('image_lib');
		$this->ci->load->database();
		
		$this->ci->load->config('kakou');

	}
	
    /**
     * 格式化数组成ASSOC方式
     *
     * @access  private
     * @param   array
     * @param   string
     * @param   string
     * @return  array
     */
	function _re_parse_array($array, $key, $value)
	{
		$data = array();
		foreach ($array as $v)
		{
			$data[$v->$key] = $v->$value;	
		}
		return $data;
	}
	// Check if user is logged in
	function is_logged_in()
	{
		return $this->ci->session->userdata('DX_logged_in');
	}
	
	function openkakou2arr($id)
	{
		$this->ci->load->model('Muser');
		//根据角色ID获取卡口ID数组
		$query = $this->ci->Msyst->get_config_info4('卡口名称');
		foreach ($query->result() as $row) {
			$role_openkakou[$row->ID] = $row->TYPE_VALUE;
		}
		
		if ($id == 1) {
			return $role_openkakou;
		}
		else {
			$role = $this->ci->Muser->get_role_by_id($id);
			if ($role->openkakou == '0' or $role->openkakou == '') {
				return array();
			}
			else {
				foreach (explode(',',$role->openkakou) as $row){
					$openkakou[$row] = $role_openkakou[$row];
				}
				return $openkakou;
			}
			//return $openkakou;
			//$role_openkakou = $data->role_openkakou;
		}
	}
	
	#创建水印
    function wm_text($name,$text){
    	$path = $this->ci->config->item('wm_path').'text/';
    	$text = iconv('GB2312','UTF-8',$text);
    	if (!is_dir($path)) mkdir($path,NULL,TRUE); // 如果不存在则创建
    	copy('images/bg9x6.png',$path.$name);
    	
    	$align = array(
    				0 => array('vrt' => 'top','hor'=>'left'),
    				1 => array('vrt' => 'middle','hor'=>'center'),
    				2 => array('vrt' => 'bottom','hor'=>'right')
    				);
    	foreach($align as $r){
			 $config['source_image'] = $path.$name;
			 $config['new_image'] = $path.$name;;//设置图像的目标名/路径。
			 $config['wm_text'] = $text;
			 $config['wm_type'] = 'text';
			 
			 $config['wm_font_path'] = 'font/WRYH.ttf';
			 $config['wm_font_size'] = $this->ci->config->item('wm_font_size');
			 $config['wm_font_color'] = $this->ci->config->item('wm_font_color');
			 $config['wm_vrt_alignment'] = $r['vrt'];
			 $config['wm_hor_alignment'] = $r['hor'];
			 $config['wm_hor_offset'] = 20;
			 $config['wm_vrt_offset'] = 0;
			 $config['wm_padding'] = '0';
			
			 $this->ci->image_lib->initialize($config); 
	  		
			 $this->ci->image_lib->watermark();
    	}
    }
    
	#创建水印
    function create_stamp($name,$text){
    	$path = $this->ci->config->item('wm_path').'text/';
    	$text = iconv('GB2312','UTF-8',$text);
    	if (!is_dir($path)) mkdir($path,NULL,TRUE); // 如果不存在则创建
    	copy('images/bg9x6.png',$path.$name);
    	
    	$align = array(
    				0 => array('vrt' => 'top','hor'=>'left'),
    				1 => array('vrt' => 'middle','hor'=>'center'),
    				2 => array('vrt' => 'bottom','hor'=>'right')
    				);
    	foreach($align as $r){
			 $config['source_image'] = $path.$name;
			 $config['new_image'] = $path.$name;;//设置图像的目标名/路径。
			 $config['wm_text'] = $text;
			 $config['wm_type'] = 'text';
			 
			 $config['wm_font_path'] = 'font/WRYH.ttf';
			 $config['wm_font_size'] = $this->ci->config->item('wm_font_size');
			 $config['wm_font_color'] = $this->ci->config->item('wm_font_color');
			 $config['wm_vrt_alignment'] = $r['vrt'];
			 $config['wm_hor_alignment'] = $r['hor'];
			 $config['wm_hor_offset'] = 20;
			 $config['wm_vrt_offset'] = 0;
			 $config['wm_padding'] = '0';
			
			 $this->ci->image_lib->initialize($config); 
	  		
			 $this->ci->image_lib->watermark();
    	}
    }
    
    function create_wm2($img_path,$user_id,$user_name){
        $date = mdate("%Y-%m-%d");
    	$text_name = $date.'_'.$user_id.'.png';
    	$stamp_path = $this->ci->config->item('wm_path').'text/'.$text_name;
    	#var_dump(file_exists($text_path));
    	if(file_exists($stamp_path)){
    		$stamp_path = $stamp_path;
    	}else{
    		$this->wm_text($text_name, $user_name.' '.$date);
    	}
   		
    	// 加载要加水印的图像
		$im = imagecreatefromjpeg($img_path);
		$stamp = imagecreatefrompng($stamp_path);

		$dst_w = imagesx($im);    //目标图片宽
		$dst_h = imagesx($im);    //目标图片长
		$sx = imagesx($stamp);    //水印图片宽
		$sy = imagesy($stamp);    //水印图片长
		$marge_right = round(($dst_w - $sx)/2);        //右偏移
		$marge_bottom = round(($dst_h - $sy)/2);       //下偏移
		
		imagecopymerge($im, $stamp, $dst_w - $sx - $marge_right, $dst_h - $sy - $marge_bottom, 0, 0, $sx, $sy, $this->ci->config->item('wm_opacity'));
    	
		imagejpeg($im);
    }
    
    function create_wm($img_path,$user_id,$user_name,$ip){
        $date = mdate("%Y-%m-%d %H:%i:%s");
    	$text = $user_name.' '.$date.' '.$ip;
   		
    	// 加载要加水印的图像
		$im = imagecreatefromjpeg($img_path);
		$im2 = imagecreatetruecolor(imagesx($im), imagesy($im));
		imagecopy($im2, $im, 0, 0, 0, 0, imagesx($im), imagesy($im));
		
		$font_color = $this->ci->config->item('wm_font_color');
		#设置水印字体颜色
    	$color = imagecolorallocatealpha($im2,$font_color[0],$font_color[1],$font_color[2],$this->ci->config->item('wm_alpha'));
    	#水印内容
    	$str = iconv('gbk', 'utf-8', $text);
		#设置字体文件路径
    	$fontfile = $this->ci->config->item('wm_font_file');
    	$size = $this->ci->config->item('wm_font_size');
    	$angle = $this->ci->config->item('wm_angle');
    	#打水印
    	imagettftext($im2,$size,$angle,20,100,$color,$fontfile,$str);
    	imagettftext($im2,$size,$angle,30,200,$color,$fontfile,$str);
    	imagettftext($im2,$size,$angle,40,300,$color,$fontfile,$str);
    	
		imagejpeg($im2);
    }
    
    function create_wm3($img_path,$user_id,$user_name){
        $date = mdate("%Y-%m-%d");
    	$text_name = $date.'_'.$user_id.'.png';
    	$stamp_path = $this->ci->config->item('wm_path').'text/'.$text_name;
    	#var_dump(file_exists($text_path));
    	if(file_exists($stamp_path)){
    		$stamp_path = $stamp_path;
    	}else{
    		$this->wm_text($text_name, $user_name.' '.$date);
    	}
   		
    	// 加载要加水印的图像
		$im = imagecreatefromjpeg($img_path);
		$stamp = imagecreatefrompng($stamp_path);

		$dst_w = imagesx($im);    //目标图片宽
		$dst_h = imagesy($im);    //目标图片长
		$sx = imagesx($stamp);    //水印图片宽
		$sy = imagesy($stamp);    //水印图片长
		$marge_right = round(($dst_w - $sx)/2);        //右偏移
		$marge_bottom = round(($dst_h - $sy)/2);       //下偏移
		imagealphablending($stamp,false);
		imagesavealpha($stamp,true);
		imagecopymerge($im, $stamp, $dst_w - $sx - $marge_right, $dst_h - $sy - $marge_bottom, 0, 0, $sx, $sy, $this->ci->config->item('wm_opacity'));
    	
		imagejpeg($im);
    }
    
    function wm_overlay($source_path,$user_id,$user_name){
    	$date = mdate("%Y-%m-%d");
    	$text_name = $date.'_'.$user_id.'.png';
    	$text_path = $this->ci->config->item('wm_path').'text/'.$text_name;
    	#var_dump(file_exists($text_path));
    	if(file_exists($text_path)){
    		$text_path = $text_path;
    	}else{
    		$this->wm_text($text_name, $user_name.' '.$date);
    	}
		 $config['source_image'] = $source_path;
		 $config['dynamic_output'] = TRUE;
		 $config['wm_type'] = 'overlay';
		 
		 $config['wm_overlay_path'] = $text_path;
		 $config['wm_opacity'] = $this->ci->config->item('wm_opacity');
		 $config['wm_vrt_alignment'] = 'middle';
		 $config['wm_hor_alignment'] = 'center';
		 $config['wm_padding'] = '0';
		
		 $this->ci->image_lib->initialize($config); 
  		
		 $this->ci->image_lib->watermark();
    }
    
    function img_resize($img_path,$height)
    {
		$image = imagecreatefromjpeg($img_path);
		$width_orig = imagesx($image);    //目标图片宽
		$height_orig = imagesy($image);    //目标图片长

		//list($width_orig, $height_orig) = getimagesize($img_url);
		/*
		if ($width && ($width_orig < $height_orig)) {
		   $width = ($height / $height_orig) * $width_orig;
		} else {
		   $height = ($width / $width_orig) * $height_orig;
		} */
		$width = ($height / $height_orig) * $width_orig;
		// Resample
		$image_p = imagecreatetruecolor($width, $height);
		//$image = imagecreatefromjpeg($path.$filename);
		imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
		
		imagejpeg($image_p, null, 100);
		
		imagedestroy ($image_p);
    }
    
    function create_img($img_path)
    {
    	$im = imagecreatefromjpeg($img_path);
    	imagejpeg($im);
    }
    
	/*
	     字符串GBK转码为UTF-8，数字转换为数字。
	*/
	function ct2($s){
	     if(is_numeric($s)) {
	         return intval($s);
	     } else {
	         return iconv("GBK","UTF-8//IGNORE",$s);
	     }
	}
	
	 /*
	     批量处理gbk->utf-8
	 */
	function icon_to_utf8($s) {
		if(is_array($s)) {
	     foreach($s as $key => $val) {
	        $s[$key] = $this->icon_to_utf8($val);
	     	}
	    } else {
	    	$s = $this->ct2($s);
	    }
	    return $s;
	}
}
?>
