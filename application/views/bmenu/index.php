<div id="bodyBottom">
<!--news start -->

<div id="member">
<h2>¹ÜÀíµÇÂ½<?php echo $this->session->userdata('manager'); ?></h2>
<form action="<?php echo site_url('admin/check_login'); ?>" method="post" name="member_log_in" id="member_log_in">
<label>Name:</label>
<input type="text" name="user" class="txtBox" />
<label>Password:</label>
<input type="password" name="password" class="txtBox" />
<input type="submit" name="go" value="" class="go" />
<br class="spacer" />
</form>
<br class="spacer" />
</div>
<br class="spacer" />
</div>
