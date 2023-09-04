<?php
/* Smarty version 3.1.32, created on 2023-04-03 13:31:50
  from 'C:\wamp\www\taxicms\admin\plg_pages\pages\templates\modify_categ.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_642ab926a193a4_80303516',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '1f877a4758cb720080281923e5b44467363a742c' => 
    array (
      0 => 'C:\\wamp\\www\\taxicms\\admin\\plg_pages\\pages\\templates\\modify_categ.tpl',
      1 => 1666177686,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_642ab926a193a4_80303516 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'C:\\wamp\\www\\taxicms\\common\\libs\\plugins\\function.html_options.php','function'=>'smarty_function_html_options',),));
?>

<?php echo '<script'; ?>
>

	function modify_plugin() {


		var pid=$('#inner #page_id').val();
		var parid=$('#inner #parent_id').val();
		
		$('#inner #title').on('change', function () {
			var link = window.folder+'/check_title.php';
			var header = $(this).val();
			var param='header='+header+'&pid='+pid+'&parid='+parid;
			alert (param);
			$.ajax({
                type: 'POST',
                url: link,
                data: param,
				dataType: 'json',
                success: function(data) {			;
					if (data.tip!=2) 	{$('#inner #promeni').attr('disabled','disabled');
						toastr['warning'](data.msg); 
					}
					else $('#inner #promeni').attr('disabled', false);

                }
            });
		})	
	}

<?php echo '</script'; ?>
>

<div id="content">
	<form  id='inner' action="modify_final.php" method="post" enctype="multipart/form-data" >
		<input name="mode" type="hidden" id="mode" value="<?php echo $_smarty_tpl->tpl_vars['mode']->value;?>
">
		<div class="row wrapper  page-heading">
			<div class="col-lg-6">
				<h2 id="modi_title"></h2>			
			</div>
			<div class="col-lg-6">
				<div class="title-action">
					<div name="promeni" id="promeni" class="btn btn-primary "><i class="fa fa-check"></i>&nbsp;<?php echo $_smarty_tpl->tpl_vars['PLG_SAVE']->value;?>
</div>
					<div name="pretvori_u_stranicu" id="promeni" class="btn btn-info"><i class="fa fa-paste"></i>&nbsp;<?php echo $_smarty_tpl->tpl_vars['PLG_TRANSFORM']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['PLG_PAGE']->value;?>
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
								<input name="header" id='title' type="text" value="<?php echo $_smarty_tpl->tpl_vars['header']->value;?>
" size="40" class="title form-control" placeholder="<?php echo $_smarty_tpl->tpl_vars['PLG_NAME']->value;?>
">
							</div>
					   </div>
										
					   
					   <div class="form-group"><label class="col-sm-2 control-label"><?php echo $_smarty_tpl->tpl_vars['PLG_STATUS']->value;?>
</label>
							<div class="col-sm-10">
								<select name="statusid" class="form-control">
								  <?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['status_val']->value,'selected'=>$_smarty_tpl->tpl_vars['status_sel']->value,'output'=>$_smarty_tpl->tpl_vars['status_out']->value),$_smarty_tpl);?>

								</select>
							</div>
					   </div>
					   <div class="form-group"><label class="col-sm-2 control-label"><?php echo $_smarty_tpl->tpl_vars['PLG_PARENT']->value;?>
</label>
							<div class="col-sm-10">
								<?php echo $_smarty_tpl->tpl_vars['parentPageCmb']->value;?>

							</div>
					   </div>
					</fieldset>
				</div>
			</div>
		</div>

		<input name="page_id" type="hidden" id="page_id" value="<?php echo $_smarty_tpl->tpl_vars['page_id']->value;?>
">
		<input name="template_id" type="hidden" id="template_id" value="<?php echo $_smarty_tpl->tpl_vars['template_id']->value;?>
">
		<input name="order" type="hidden" id="order" value="<?php echo $_smarty_tpl->tpl_vars['order']->value;?>
">
		<input name="pagetypeid" type="hidden" id="pagetypeid" value="<?php echo $_smarty_tpl->tpl_vars['pagetypeid']->value;?>
">
		<input name="navigationtype" type="hidden" id="navigationtype" value="<?php echo $_smarty_tpl->tpl_vars['navigationtype']->value;?>
">

	</form>
</div>
<?php }
}
