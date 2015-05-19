<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
	<title><?php echo $this->config->item('title');?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() . "js/jquery-easyui/themes/" . $this->config->item('ui_themes') . "/easyui.css"?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() . "js/jquery-easyui/themes/icon.css"?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() . "js/jquery-easyui/themes/color.css"?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() . "js/jquery-easyui/themes/main.css"?>" />
	<script type="text/javascript" src="<?php echo base_url() . "js/jquery-easyui/jquery.min.js"?>"></script>
	<script type="text/javascript" src="<?php echo base_url() . "js/jquery-easyui/jquery.easyui.min.js"?>"></script>
	<script type="text/javascript" src="<?php echo base_url() . "js/jquery-easyui/locale/easyui-lang-zh_CN_GBK.js"?>"></script>

</head>

<body>
	<div id="p" class="easyui-panel" style="width:100%;">
		<table id="tt" class="easyui-datagrid" style="width:100%;" toolbar="#tb" >
			<thead>
				<tr>
					<th field="hphm" width="80" align="center">���ƺ���</th>
					<th field="hpys" width="50" align="center">������ɫ</th>
					<th field="passtime" width="120" align="center">ͨ��ʱ��</th>
					<th field="place" width="120" align="center">���ڵص�</th>
					<th field="clpp" width="80" align="center" sortable="true">������־</th>
					<th field="clpp_son" width="120" align="center" sortable="true">Ʒ������</th>
					<th field="cllx" width="100" align="center">��������</th>
					<th field="csys" width="60" align="center">������ɫ</th>
					<th field="dire" width="60" align="center">����</th>
					<th field="lane" width="40" align="center">����</th>
				</tr>
			</thead>
		</table>
	</div>
	
	<div id="tb" style="padding:3px">
		<div align="center">
			<span>���ڵص�:</span>
			<input id="place" class="easyui-combobox"
					url = "<?php echo base_url() . 'index.php/basedata/get_place_logo';?>" 
					method = "get" valueField = "id" textField = "text" />		
			<span>����:</span>
			<input id="lane" class="easyui-combobox" style="width:50px"
					url = "<?php echo base_url() . 'index.php/basedata/get_lane';?>" 
					method = "get" valueField = "id" textField = "text" />		
			<span>����:</span>
			<input id="dire" class="easyui-combobox" style="width:80px"
					url = "<?php echo base_url() . 'index.php/basedata/get_dire_logo';?>" 
					method = "get" valueField = "id" textField = "text" panelHeight = "auto" />
			<span>������ɫ:</span>
			<input id="hpys" class="easyui-combobox" style="width:50px"
					url = "<?php echo base_url() . 'index.php/basedata/get_hpys_logo';?>" 
					method = "get" valueField = "id" textField = "text" panelHeight = "auto" />
		</div>
		<div align="center">
			<span>������־:</span>
			<input id="ppdm" class="easyui-combobox" style="width:100px"
					url = "<?php echo base_url() . 'index.php/basedata/get_ppdm';?>" 
					method = "get" valueField = "id" textField = "text" />
			<span>��������:</span>
			<input id="cllx" class="easyui-combobox" style="width:140px"
					url = "<?php echo base_url() . 'index.php/basedata/get_cllx_logo';?>" 
					method = "get" valueField = "id" textField = "text" />
			<span>������ɫ:</span>
			<input id="csys" class="easyui-combobox" style="width:50px"
					url = "<?php echo base_url() . 'index.php/basedata/get_csys_logo';?>" 
					method = "get" valueField = "id" textField = "text" />
		</div>
		<div align="center">
			<span>��ʼʱ��:</span>
			<input id="st" class="easyui-datetimebox" required="true" value="<?php echo $lgquery['st'];?>" style="width:150px" />
			<span>����ʱ��:</span>
			<input id="et" class="easyui-datetimebox" required="true" value="<?php echo $lgquery['et'];?>" style="width:150px" />
			<span>���ƺ���:</span>
			<input id="number" class="easyui-combobox" style="width:50px"
					url = "<?php echo base_url() . 'index.php/basedata/get_number';?>" 
					method = "get" valueField = "id" textField = "text" />
			<input id="carnum" class="easyui-textbox" data-options="prompt:'���복�ƺ���'" style="width:120px;" />
			<a href="#" title="���ƺ���֧��ģ����ѯ,��ȷ�����ַ�(��������,����)����'?'����;��������Ĳ�ȷ��λ,����һ��'*'����;������ѡ��'-'�ɵ�����ѯ��ʶ�����ļ�¼" class="easyui-tooltip" position="bottom">��ʾ</a>
			
			<a href="#" class="easyui-linkbutton" iconCls="icon-search" onclick="doSearch();">��ѯ</a>
		</div>
	</div>


	<script type="text/javascript">

		function doSearch(){ 
			$('#tt').datagrid('load',{ 
				place:$('#place').combobox('getValue'),
				lane:$('#lane').combobox('getValue'),
				dire:$('#dire').combobox('getValue'),
				hpys:$('#hpys').combobox('getValue'),
				ppdm:$('#ppdm').combobox('getValue'),
				cllx:$('#cllx').combobox('getValue'),
				csys:$('#csys').combobox('getValue'),
				st:$('#st').combobox('getValue'),
				et:$('#et').combobox('getValue'),
				number:$('#number').combobox('getValue'),
				carnum:$('#carnum').val()
			}); 
		} 

		$('#tt').datagrid({
			title:<?php echo "'".$title."'";?>,
			url:<?php echo "'".base_url() . 'index.php/logo/load_lgquery'."'";?>,
			method:'post',
			pagination:true, 
			singleSelect:true,
			rownumbers:true, 
			fitColumns:true,
			sortName: <?php echo "'".$lgquery['sort']."'";?>,
			sortOrder: <?php echo "'".$lgquery['order']."'";?>,
			toolbar:"#tb",
			pageSize: <?php echo $lgquery['rows'];?>,
			onDblClickRow: function(index, row) {
				showDetail();
			}
		});

		$(function(){
			var pager = $('#tt').datagrid('getPager');	// get the pager of datagrid
			pager.pagination({
				buttons:[{
					id:'btn_add',
					text:'�鿴',
					iconCls:'icon-search',
					handler:function(){
						addUser();
					}
				},{
					id:'btn_xls',
					text:'������',
					iconCls:'icon-excel',
					handler:function(){
						exportExcel();
						return false;
					}
				},{
					id:'btn_img',
					text:'����ͼƬ',
					iconCls:'icon-pic',
					handler:function(){
						exportImg();
						return false;
					}
				}]
			});			
		})
		
        function showDetail(){  
			var row = $('#tt').datagrid('getSelected');
			if (row){
				var alldata = $("#tt").datagrid("getRows");
				var index = $('#tt').datagrid('getRowIndex', row);
				var ids = '';
				for(var key in alldata){  
					ids += alldata[key].id+',';
				} 

	            window.location.replace('<?php echo base_url() . "index.php/logo/lgdetail?"."'";?>+"ids="+ids+"&id="+row.id+"&index="+index);
			}
        }
 		
		function exportExcel(){
			var alldata = $("#tt").datagrid("getRows");
			
			if (alldata.length > 0){
				window.location.replace(<?php echo "'".base_url() ."index.php/export2/exportexcel"."'";?>);
			} else {
                $.messager.show({
                    title: '��ʾ��Ϣ',
                    msg: 'û������'
                });
			}
		}
		
		function exportImg(){
			var alldata = $("#tt").datagrid("getRows");
			
			if (alldata.length > 0){
				window.location.replace(<?php echo "'".base_url() ."index.php/export2/exportimg"."'";?>);
			} else {
                $.messager.show({
                    title: '��ʾ��Ϣ',
                    msg: 'û������'
                });
			}
		}
				
		function deleterow(target){
			$.messager.confirm('��ʾ','ȷ��ɾ��?',function(r){
				if (r){
					$('#tt').datagrid('deleteRow', getRowIndex(target));
				}
			});
		}

	</script>

</body>
</html>