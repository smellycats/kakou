<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller
{
	function Welcome()
	{
		parent::__construct();

		$this->load->helper('url');
	}

	function upload()
	{
		$inputname = 'filedata';				//表单文件域name
		$attachdir = 'js/xhedit1.1.0/upload';	//上传文件保存路径，结尾不要带/
		$dirtype = 2;							//1:按天存入目录 2:按月存入目录 3:按扩展名存目录  建议使用按天存
		$maxattachsize = 2097152;				//最大上传大小，默认是2M
		$upext = 'txt,rar,zip,jpg,jpeg,gif,png,swf,wmv,avi,wma,mp3,mid';	//上传扩展名
		$msgtype = 2;							//返回上传参数的格式：1，只返回url，2，返回参数数组
		$immediate = isset($_GET['immediate']) ? $_GET['immediate'] : 0;	//立即上传模式，仅为演示用

		$err = "";
		$msg = "''";

		$upfile = @$_FILES[$inputname];

		if (!isset($upfile))
		{
			$err = '文件域的name错误';
		}
		elseif (!empty($upfile['error']))
		{
			switch ($upfile['error'])
			{
			case '1':
				$err = '文件大小超过了php.ini定义的upload_max_filesize值';
				break;
			case '2':
				$err = '文件大小超过了HTML定义的MAX_FILE_SIZE值';
				break;
			case '3':
				$err = '文件上传不完全';
				break;
			case '4':
				$err = '无文件上传';
				break;
			case '6':
				$err = '缺少临时文件夹';
				break;
			case '7':
				$err = '写文件失败';
				break;
			case '8':
				$err = '上传被其它扩展中断';
				break;
			case '999':
			default:
				$err = '无有效错误代码';
			}
		}
		elseif (empty($upfile['tmp_name']) || $upfile['tmp_name'] == 'none')
		{
			$err = '无文件上传';
		}
		else
		{
			$temppath = $upfile['tmp_name'];
			$fileinfo = pathinfo($upfile['name']);
			$extension = $fileinfo['extension'];

			if (preg_match('/' . str_replace(',', '|', $upext) . '/i', $extension))
			{
				$bytes=filesize($temppath);

				if ($bytes > $maxattachsize)
				{
					$err = '请不要上传大小超过' . formatBytes($maxattachsize) . '的文件';
				}
				else
				{
					switch($dirtype)
					{
					case 1: $attach_subdir = 'day_'.date('ymd'); break;
					case 2: $attach_subdir = date('Ym'); break;
					case 3: $attach_subdir = 'ext_'.$extension; break;
					}
					$attach_dir = $attachdir.'/'.$attach_subdir;

					if (!is_dir($attach_dir))
					{
						@mkdir($attach_dir, 0777);
						//@fclose(fopen($attach_dir.'/index.htm', 'w'));
					}

					PHP_VERSION < '4.2.0' && mt_srand((double)microtime() * 1000000);
					$filename = date("YmdHis") . mt_rand(1000, 9999) . '.' . $extension;
					$target = $attach_dir . '/' . $filename;

					rename($upfile['tmp_name'], $target);
					@chmod($target, 0755);

					$target = preg_replace("/([\\\\\/'])/", '\\\$1', $target);
					$target = base_url() . $target;

					if ($immediate=='1')
						$target = '!' . $target;

					if ($msgtype==1)
						$msg="'$target'";
					else
						$msg="{'url':'" . $target . "', 'localname':'" . preg_replace("/([\\\\\/'])/",'\\\$1', $upfile['name']) . "','id':'1'}";
						//id参数固定不变，仅供演示，实际项目中可以是数据库ID
				}
			}
			else
				$err = '上传文件扩展名必需为：' . $upext;

			@unlink($temppath);
		}

		echo "{'err':'" . preg_replace("/([\\\\\/'])/", '\\\$1', $err) . "','msg':" . $msg . "}";
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
?>
