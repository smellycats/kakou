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
     * ��ʽ�������ASSOC��ʽ
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
		//���ݽ�ɫID��ȡ����ID����
		$query = $this->ci->Msyst->get_config_info4('��������');
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
	
	#����ˮӡ
    function wm_text($name,$text){
    	$path = $this->ci->config->item('wm_path').'text/';
    	$text = iconv('GB2312','UTF-8',$text);
    	if (!is_dir($path)) mkdir($path,NULL,TRUE); // ����������򴴽�
    	copy('images/bg9x6.png',$path.$name);
    	
    	$align = array(
    				0 => array('vrt' => 'top','hor'=>'left'),
    				1 => array('vrt' => 'middle','hor'=>'center'),
    				2 => array('vrt' => 'bottom','hor'=>'right')
    				);
    	foreach($align as $r){
			 $config['source_image'] = $path.$name;
			 $config['new_image'] = $path.$name;;//����ͼ���Ŀ����/·����
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
    
	#����ˮӡ
    function create_stamp($name,$text){
    	$path = $this->ci->config->item('wm_path').'text/';
    	$text = iconv('GB2312','UTF-8',$text);
    	if (!is_dir($path)) mkdir($path,NULL,TRUE); // ����������򴴽�
    	copy('images/bg9x6.png',$path.$name);
    	
    	$align = array(
    				0 => array('vrt' => 'top','hor'=>'left'),
    				1 => array('vrt' => 'middle','hor'=>'center'),
    				2 => array('vrt' => 'bottom','hor'=>'right')
    				);
    	foreach($align as $r){
			 $config['source_image'] = $path.$name;
			 $config['new_image'] = $path.$name;;//����ͼ���Ŀ����/·����
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
   		
    	// ����Ҫ��ˮӡ��ͼ��
		$im = imagecreatefromjpeg($img_path);
		$stamp = imagecreatefrompng($stamp_path);

		$dst_w = imagesx($im);    //Ŀ��ͼƬ��
		$dst_h = imagesx($im);    //Ŀ��ͼƬ��
		$sx = imagesx($stamp);    //ˮӡͼƬ��
		$sy = imagesy($stamp);    //ˮӡͼƬ��
		$marge_right = round(($dst_w - $sx)/2);        //��ƫ��
		$marge_bottom = round(($dst_h - $sy)/2);       //��ƫ��
		
		imagecopymerge($im, $stamp, $dst_w - $sx - $marge_right, $dst_h - $sy - $marge_bottom, 0, 0, $sx, $sy, $this->ci->config->item('wm_opacity'));
    	
		imagejpeg($im);
    }
    
    function create_wm($img_path,$user_id,$user_name,$ip){
        $date = mdate("%Y-%m-%d %H:%i:%s");
    	$text = $user_name.' '.$date.' '.$ip;
   		
    	// ����Ҫ��ˮӡ��ͼ��
		$im = imagecreatefromjpeg($img_path);
		$im2 = imagecreatetruecolor(imagesx($im), imagesy($im));
		imagecopy($im2, $im, 0, 0, 0, 0, imagesx($im), imagesy($im));
		
		$font_color = $this->ci->config->item('wm_font_color');
		#����ˮӡ������ɫ
    	$color = imagecolorallocatealpha($im2,$font_color[0],$font_color[1],$font_color[2],$this->ci->config->item('wm_alpha'));
    	#ˮӡ����
    	$str = iconv('gbk', 'utf-8', $text);
		#���������ļ�·��
    	$fontfile = $this->ci->config->item('wm_font_file');
    	$size = $this->ci->config->item('wm_font_size');
    	$angle = $this->ci->config->item('wm_angle');
    	#��ˮӡ
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
   		
    	// ����Ҫ��ˮӡ��ͼ��
		$im = imagecreatefromjpeg($img_path);
		$stamp = imagecreatefrompng($stamp_path);

		$dst_w = imagesx($im);    //Ŀ��ͼƬ��
		$dst_h = imagesy($im);    //Ŀ��ͼƬ��
		$sx = imagesx($stamp);    //ˮӡͼƬ��
		$sy = imagesy($stamp);    //ˮӡͼƬ��
		$marge_right = round(($dst_w - $sx)/2);        //��ƫ��
		$marge_bottom = round(($dst_h - $sy)/2);       //��ƫ��
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
		$width_orig = imagesx($image);    //Ŀ��ͼƬ��
		$height_orig = imagesy($image);    //Ŀ��ͼƬ��

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
	     �ַ���GBKת��ΪUTF-8������ת��Ϊ���֡�
	*/
	function ct2($s){
	     if(is_numeric($s)) {
	         return intval($s);
	     } else {
	         return iconv("GBK","UTF-8//IGNORE",$s);
	     }
	}
	
	 /*
	     ��������gbk->utf-8
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
