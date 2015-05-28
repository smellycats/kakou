<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<base href="<?php echo base_url(); ?>"/>
	<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
	<link rel="stylesheet" href="style/alogin.css"  type="text/css" />
	<title><?php echo $this->config->item('title'); ?></title>
	<style type="text/css">
	.banner { position: relative; overflow: auto; }
	    .banner li { list-style: none; }
	        .banner ul li { float: left; }
	</style>
</head>
<body>

	<div>
	    <form method="post" action="<?php echo site_url('home/index'); ?>">
	    <div class="Main">
	        <ul>
	            <li class="top">
	            </li>	
	            <li class="top2">
	               	<div align="center">
	                	<img src="images/login/title8.png" alt="" style="" />
	            	</div>
	            </li>
	            <li class="topA"></li>
	            <li class="topB">
					<div class="banner">
						<?php if (!empty($adv)): ?>
						<?php foreach ($adv as $s):?>
					    <ul>
					        <li><h1><?php echo $s->CONTENT;?></h1></li>
					    </ul>
					    <?php endforeach;?>
						<?php endif;?>
					</div>
	            </li>
	            <li class="topC"></li>
	            <li class="topD">
	                <ul class="login">
	                    <li>
	                    	<div align="center">
								<span style="color:red">
								    <?php if($message != ''){echo $message;}?>
								    <?php echo form_error('username'); ?>
								    <?php echo form_error('password'); ?>
							    </span>
							</div>
	                    </li>
	                    <li>
	                    	<span class="left">用户名：</span> <span style="left">
	                        	<input value="<?php echo set_value('username'); ?>" class="txt" type="text" name="username" alt="请填写用户名" /> 
							</span>
	                    </li>
	                    <li>
	                    	<span class="left">密 码：</span> <span style="left">
	                       		<input class="txt" type="password" name="password" alt="请填写密码" /> 
	                    	</span>
	                    </li>
	                    
	                </ul>
	            </li>
	            <li class="topE"></li>
	            <li class="middle_A"></li>
	            <li class="middle_B"></li>
	            <li class="middle_C">
	            	<div align = "center">
	            	<input style="margin-right:5px;vertical-align:middle" class="submit" type="submit" value="登录" />
	            	<input style="margin-right:5px;vertical-align:middle" class="button" type="reset" value="取消" />
	            	</div>
	            </li>
	            <li class="middle_D"></li>
	            <li class="bottom_A"></li>
	            <li class="bottom_B">
	            Power by 实现科技有限公司  Copyright &copy; 2009 - 2015
	            </li>
	        </ul>
	    </div>
	    </form>
    </div>
    
	<script type="text/javascript" src=<?php echo base_url('js/jQuery1.7.1/jquery-1.7.1.min.js'); ?>></script>
	<script type="text/javascript" src=<?php echo base_url('js/unslider/unslider.js'); ?>></script>
	<script type="text/javascript">
	$('.banner').unslider({
		speed: 500,               //  The speed to animate each slide (in milliseconds)
		delay: 5000,              //  The delay between slide animations (in milliseconds)
		complete: function() {},  //  A function that gets called after every slide animation
		keys: true,               //  Enable keyboard (left, right) arrow shortcuts
		dots: true,               //  Display dot navigation
		fluid: false              //  Support responsive design. May break non-responsive designs
	});
	</script>
</body>
</html>
