<?php
/* Smarty version 3.1.32, created on 2023-04-03 13:39:52
  from 'C:\wamp\www\taxicms\admin\plg_products\grupaproizvoda\templates\index.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_642abb081b98c4_89060873',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c3fcf861646f04eb68d05d8ae5b143c27120e181' => 
    array (
      0 => 'C:\\wamp\\www\\taxicms\\admin\\plg_products\\grupaproizvoda\\templates\\index.tpl',
      1 => 1666608896,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_642abb081b98c4_89060873 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'C:\\wamp\\www\\taxicms\\common\\libs\\plugins\\function.html_options.php','function'=>'smarty_function_html_options',),1=>array('file'=>'C:\\wamp\\www\\taxicms\\common\\libs\\plugins\\function.html_table_advanced.php','function'=>'smarty_function_html_table_advanced',),));
echo '<script'; ?>
>

	function table_plugin() {
		var link = window.folder+"/index.php";
		$("#formRecordsPerPage").change(function(){
			var rpp = $("#formRecordsPerPage option:selected").val();
			var param= "records_per_page=" + rpp;
			table(link,param);
		})
		var move = $('#move').val();
		if (move==1) move_rows();

		// Collapse ibox function
		$('.collapse-link').on('click', function () {
			var ibox = $(this).closest('div.ibox');
			var button = $(this).find('i');
			var content = ibox.children('.ibox-content2');
			content.slideToggle(200);
			button.toggleClass('fa-chevron-up').toggleClass('fa-chevron-down');
			ibox.toggleClass('').toggleClass('border-bottom');
			setTimeout(function () {
				ibox.resize();
			}, 50);
		});
	}

<?php echo '</script'; ?>
>
<div class="ibox float-e-margins">
	<input type='hidden' name='move' id='move' value='<?php echo $_smarty_tpl->tpl_vars['move']->value;?>
'/>
	<div class="ibox-title">
		<div class="ibox-tools">
			<a class="collapse-link">
					<i class="fa fa-chevron-up"></i>
			</a>
			<a class="fullscreen-link">
                <i class="fa fa-expand"></i>
            </a>
			<a class="close-link">
				<i class="fa fa-times"></i>
			</a>
		</div>
	</div>

	<div class="ibox-content">
		<div class="row">
			<div class="col-lg-8">
		<div class="html5buttons">
			<div class="dt-buttons btn-group">
				<a class="btn btn-info buttons-html5" tabindex="0" href="<?php echo $_smarty_tpl->tpl_vars['modifyLink']->value;?>
">
					<i class="fa fa-paste"></i> <span><?php echo $_smarty_tpl->tpl_vars['PLG_CHANGE']->value;?>
</span>
				</a>
				<a class="btn btn-success buttons-html5" tabindex="0" href="modify.php?mode=insert&<?php echo $_smarty_tpl->tpl_vars['insertLink']->value;?>
">
					<i class="fa fa-file-text-o" ></i> <span><?php echo $_smarty_tpl->tpl_vars['PLG_ADD']->value;?>
</span>
				</a>
			</div>
		</div>
	</div>
	<div class="col-lg-4 pr-rec">
		<form name="formRecordsPerPage" id="formRecordsPerPage">
			<label class="perpage"><?php echo $_smarty_tpl->tpl_vars['PLG_RESULTS_PER_PAGE']->value;?>
 </label>
			<select class="form-control" name="records_per_page">
				<?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['recordsPerPage_val']->value,'selected'=>$_smarty_tpl->tpl_vars['recordsPerPage_sel']->value,'output'=>$_smarty_tpl->tpl_vars['recordsPerPage_out']->value),$_smarty_tpl);?>

			</select>
		</form>
	</div>
</div>

		<div class="table-responsive">
			<div id="content">

			<?php echo smarty_function_html_table_advanced(array('filter'=>$_smarty_tpl->tpl_vars['filter']->value,'browseString'=>$_smarty_tpl->tpl_vars['tbl_browseString']->value,'scriptName'=>$_smarty_tpl->tpl_vars['scriptName']->value,'cnt_rows'=>$_smarty_tpl->tpl_vars['tbl_row_count']->value,'rowOffset'=>$_smarty_tpl->tpl_vars['tbl_offset']->value,'tr_attr'=>$_smarty_tpl->tpl_vars['tbl_tr_attributes']->value,'td_attr'=>$_smarty_tpl->tpl_vars['tbl_td_attributes']->value,'loop'=>$_smarty_tpl->tpl_vars['tbl_content']->value,'cols'=>$_smarty_tpl->tpl_vars['tbl_cols_count']->value,'tableheader'=>$_smarty_tpl->tpl_vars['tbl_header']->value,'table_attr'=>'cellspacing=0 class="index" id="normal"','message'=>$_smarty_tpl->tpl_vars['poruka']->value,'cnt_all_rows'=>$_smarty_tpl->tpl_vars['tbl_all_rows_count']->value),$_smarty_tpl);?>

		</div>
	</div>
</div>
</div>
<?php }
}
