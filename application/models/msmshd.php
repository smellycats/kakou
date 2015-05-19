<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Msmshd extends CI_Model
{
	private $sms_db;
	
	function __construct()
	{
		parent::__construct();

		$this->sms_db = $this->load->database('sms_db', TRUE);
	}


	function send_sms($data)
	{
		return $this->sms_db->insert('sms2',$data);
	}
}
?>
