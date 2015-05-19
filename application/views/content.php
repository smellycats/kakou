<h2>content视图</h2>

<?php echo $test; ?><!--这个就是test方法中的$data['test']传递过来的，具体在layout的

view方法里的$data['content'] = $ci->load->view($view, $data, true);这个就是把我们

视图文件赋值给变量$data['content'];然后把$data['content']传递给layout下的视图，在

layout的视图文件里通过$content输出-->
