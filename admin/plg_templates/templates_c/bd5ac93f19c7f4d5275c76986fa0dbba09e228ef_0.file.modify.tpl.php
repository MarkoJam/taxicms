<?php
/* Smarty version 3.1.32, created on 2023-04-04 08:24:40
  from 'C:\wamp\www\taxicms\admin\plg_templates\templates\modify.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_642bc2a8ed2726_03940616',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'bd5ac93f19c7f4d5275c76986fa0dbba09e228ef' => 
    array (
      0 => 'C:\\wamp\\www\\taxicms\\admin\\plg_templates\\templates\\modify.tpl',
      1 => 1666177686,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_642bc2a8ed2726_03940616 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'C:\\wamp\\www\\taxicms\\common\\libs\\plugins\\function.html_options.php','function'=>'smarty_function_html_options',),1=>array('file'=>'C:\\wamp\\www\\taxicms\\common\\libs\\plugins\\function.html_table_advanced.php','function'=>'smarty_function_html_table_advanced',),));
echo '<script'; ?>
>
	
	function param_partial() {
		var title = $('#inner #title').val();
		var description = $('#description').val();
		return '&title='+title+'&description='+description;
	}
	function modify_plugin() {
		$(document).ready(function() {
		
			$('#inner table .naziv').click(function() {
				link = window.folder+"/"+'modify.php';
				var param = $(this).attr('data-param')+param_partial();
				update(link,param);
			})
			$('table #delete_plugin').click(function() {
				link = window.folder+"/"+'delete_plugin.php';
				var param = $(this).attr('data-param');
				update2(link,param);
			})
			$('table #modifybutt').click(function() {
				link = window.folder+"/"+'modify_plugin.php';
				var tmplplgid = $(this).attr('data-param');
				var pid = $('#pluginid option:selected').val();
				var sid = $('#selectionid option:selected').val();
				var posid = $('#position option:selected').val();
				var tid = $('#template_id').val();
				var param = 'tmplplgid='+tmplplgid+'&pluginid='+pid+'&selectionid='+sid+'&position='+posid+'&template_id='+tid+param_partial();
				window.param2='mode='+mode+'&pluginid1='+pid+'&template_id='+tid+param_partial();				
				update2(link,param);
			})
			$('.title-actionplugin #insert_plugin').click(function() {
				var pid = $('#pluginid1 option:selected').val();
				var tid = $('#template_id').val();
				var mode = $('#mode').val(); 
				var link = window.folder+"/"+'insert_plugin.php';
				var param = 'pluginid1='+pid+'&template_id='+tid+'&mode='+mode;
				if (mode=='insert') mode='insert2';
				window.param2='mode='+mode+'&pluginid1='+pid+'&template_id='+tid+param_add();
				update2(link,param);
			})
		});
	}

<?php echo '</script'; ?>
>

<div id="content">
	<form  id='inner' action="modify_final.php" method="post" enctype="multipart/form-data" >
		<input name="mode" type="hidden" id="mode" value="<?php echo $_smarty_tpl->tpl_vars['mode']->value;?>
">
		<div class="row wrapper  page-heading">
			<div class="col-lg-8">
				<h2 id="modi_title"></h2>
			</div>
			<div class="col-lg-4">
				<div class="title-action">
					<div name="promeni" id="promeni" class="btn btn-primary "><i class="fa fa-check"></i>&nbsp;<?php echo $_smarty_tpl->tpl_vars['PLG_SAVE']->value;?>
</div>
					<div class="btn btn-default close-modal" type="button"><i class="fa fa-times"></i>&nbsp;<?php echo $_smarty_tpl->tpl_vars['PLG_CLOSE']->value;?>
</div>
				</div>
			</div>
		</div>			
			<div class="row">
                <div class="col-lg-12">
					 <div class="panel-body">
                           <fieldset class="form-horizontal">
                                 <div class="form-group"><label class="col-sm-2 control-label"><?php echo $_smarty_tpl->tpl_vars['PLG_NAME']->value;?>
</label>
                                        <div class="col-sm-10">
											<input name="title" type="text" id="title" value="<?php echo $_smarty_tpl->tpl_vars['Title']->value;?>
" size="40" class="title form-control" placeholder="<?php echo $_smarty_tpl->tpl_vars['PLG_NAME']->value;?>
">
										</div>
                                  </div>
								  <div class="form-group"><label class="col-sm-2 control-label"><?php echo $_smarty_tpl->tpl_vars['PLG_DESCRIPTION']->value;?>
</label>
                                        <div class="col-sm-10">
											<textarea name="description" cols="50" rows="3" id="description" class="form-control"><?php echo $_smarty_tpl->tpl_vars['Description']->value;?>
</textarea>
										</div>
                                 </div>
                            </fieldset>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<h2><?php echo $_smarty_tpl->tpl_vars['PLG_CHANGEPLUGIN']->value;?>
</h2>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="panel-body">
							<fieldset class="form-horizontal">
								<div class="form-group">
									<label class="col-sm-2 control-label" for="Pitanje"> <?php echo $_smarty_tpl->tpl_vars['PLG_NAME']->value;?>
 </label> 
									
									<div class="col-sm-8">
										<select id="pluginid1" name="pluginid1" class="form-control">
											<?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['sel_values_plg']->value,'selected'=>$_smarty_tpl->tpl_vars['sel_selected_plg']->value,'output'=>$_smarty_tpl->tpl_vars['sel_output_plg']->value),$_smarty_tpl);?>
  
										</select>
									</div>
									<div class="col-sm-2">
										<div class="title-actionplugin">
											<div name="promeni" id="insert_plugin" class="btn btn-primary "><i class="fa fa-plus-square-o"></i>&nbsp;<?php echo $_smarty_tpl->tpl_vars['PLG_ADD']->value;?>
</div>
										</div>
									</div>
								</div>
							</fieldset>
						</div>
					</div>
				</div>
    			<div class="table-responsive">
					<?php if ($_smarty_tpl->tpl_vars['tbl_all_rows_count']->value > 0) {?>
					<?php echo smarty_function_html_table_advanced(array('filter'=>$_smarty_tpl->tpl_vars['filter']->value,'cnt_all_rows'=>$_smarty_tpl->tpl_vars['tbl_all_rows_count']->value,'browseString'=>$_smarty_tpl->tpl_vars['tbl_browseString']->value,'scriptName'=>$_smarty_tpl->tpl_vars['scriptName']->value,'cnt_rows'=>$_smarty_tpl->tpl_vars['tbl_row_count']->value,'rowOffset'=>$_smarty_tpl->tpl_vars['tbl_offset']->value,'tr_attr'=>$_smarty_tpl->tpl_vars['tbl_tr_attributes']->value,'td_attr'=>$_smarty_tpl->tpl_vars['tbl_td_attributes']->value,'loop'=>$_smarty_tpl->tpl_vars['tbl_content']->value,'cols'=>$_smarty_tpl->tpl_vars['tbl_cols_count']->value,'tableheader'=>$_smarty_tpl->tpl_vars['tbl_header']->value,'exportlinks'=>$_smarty_tpl->tpl_vars['tbl_show_export_links']->value,'table_attr'=>'cellspacing=0 class="index" id="normal"','message'=>$_smarty_tpl->tpl_vars['poruka']->value),$_smarty_tpl);?>

						<?php }?>

					<input name="template_id" type="hidden" id="template_id" value="<?php echo $_smarty_tpl->tpl_vars['TemplateID']->value;?>
">
				</div>

</form>
</div>
<?php }
}
