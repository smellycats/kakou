<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * News publishing system
 *
 * @package		News
 * @subpackage	Helpers
 * @category	Helpers
 * @author
 * @link
 */

// ------------------------------------------------------------------------

/**
 * Check
 *
 * Check if user has logon status of manager, redirect to home page if not.
 *
 * @access	public
 * @param	none
 * @return	none
 */
if ( ! function_exists('check'))
{
	function check()
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
if ( ! function_exists('showmessage'))
{
	function showmessage($msg, $goto = '', $auto = true)
	{
		$CI =& get_instance();

		$CI->load->view('admin/body_message', array('msg'=>$msg, 'goto'=>site_url($goto), 'auto'=>$auto));
	}
}

/* End of file news_helper.php */
/* Location: ./application/helpers/news_helper.php */
?>
