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
		$inputname = 'filedata';				//���ļ���name
		$attachdir = 'js/xhedit1.1.0/upload';	//�ϴ��ļ�����·������β��Ҫ��/
		$dirtype = 2;							//1:�������Ŀ¼ 2:���´���Ŀ¼ 3:����չ����Ŀ¼  ����ʹ�ð����
		$maxattachsize = 2097152;				//����ϴ���С��Ĭ����2M
		$upext = 'txt,rar,zip,jpg,jpeg,gif,png,swf,wmv,avi,wma,mp3,mid';	//�ϴ���չ��
		$msgtype = 2;							//�����ϴ������ĸ�ʽ��1��ֻ����url��2�����ز�������
		$immediate = isset($_GET['immediate']) ? $_GET['immediate'] : 0;	//�����ϴ�ģʽ����Ϊ��ʾ��

		$err = "";
		$msg = "''";

		$upfile = @$_FILES[$inputname];

		if (!isset($upfile))
		{
			$err = '�ļ����name����';
		}
		elseif (!empty($upfile['error']))
		{
			switch ($upfile['error'])
			{
			case '1':
				$err = '�ļ���С������php.ini�����upload_max_filesizeֵ';
				break;
			case '2':
				$err = '�ļ���С������HTML�����MAX_FILE_SIZEֵ';
				break;
			case '3':
				$err = '�ļ��ϴ�����ȫ';
				break;
			case '4':
				$err = '���ļ��ϴ�';
				break;
			case '6':
				$err = 'ȱ����ʱ�ļ���';
				break;
			case '7':
				$err = 'д�ļ�ʧ��';
				break;
			case '8':
				$err = '�ϴ���������չ�ж�';
				break;
			case '999':
			default:
				$err = '����Ч�������';
			}
		}
		elseif (empty($upfile['tmp_name']) || $upfile['tmp_name'] == 'none')
		{
			$err = '���ļ��ϴ�';
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
					$err = '�벻Ҫ�ϴ���С����' . formatBytes($maxattachsize) . '���ļ�';
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
						//id�����̶����䣬������ʾ��ʵ����Ŀ�п��������ݿ�ID
				}
			}
			else
				$err = '�ϴ��ļ���չ������Ϊ��' . $upext;

			@unlink($temppath);
		}

		echo "{'err':'" . preg_replace("/([\\\\\/'])/", '\\\$1', $err) . "','msg':" . $msg . "}";
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
?>
