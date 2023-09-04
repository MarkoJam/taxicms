<?php
/* Smarty version 3.1.32, created on 2019-08-13 08:08:20
  from 'C:\wamp\www\kleos\admin\plg_products\grupaproizvoda\templates\index.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5d5253d4b32550_19380139',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '1d83fb00ea42c905d886ed23a96cd340d1666a64' => 
    array (
      0 => 'C:\\wamp\\www\\kleos\\admin\\plg_products\\grupaproizvoda\\templates\\index.tpl',
      1 => 1565242413,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5d5253d4b32550_19380139 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'C:\\wamp\\www\\kleos\\common\\libs\\plugins\\function.html_table_advanced.php','function'=>'smarty_function_html_table_advanced',),));
echo '<script'; ?>
>

	function table_plugin() {	
		move_rows();
	
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
		
		<div class="table-responsive">
			<div id="content">
			
			<?php echo smarty_function_html_table_advanced(array('filter'=>$_smarty_tpl->tpl_vars['filter']->value,'browseString'=>$_smarty_tpl->tpl_vars['tbl_browseString']->value,'scriptName'=>$_smarty_tpl->tpl_vars['scriptName']->value,'cnt_rows'=>$_smarty_tpl->tpl_vars['tbl_row_count']->value,'rowOffset'=>$_smarty_tpl->tpl_vars['tbl_offset']->value,'tr_attr'=>$_smarty_tpl->tpl_vars['tbl_tr_attributes']->value,'td_attr'=>$_smarty_tpl->tpl_vars['tbl_td_attributes']->value,'loop'=>$_smarty_tpl->tpl_vars['tbl_content']->value,'cols'=>$_smarty_tpl->tpl_vars['tbl_cols_count']->value,'tableheader'=>$_smarty_tpl->tpl_vars['tbl_header']->value,'table_attr'=>'cellspacing=0 class="index" id="normal"','message'=>$_smarty_tpl->tpl_vars['poruka']->value,'cnt_all_rows'=>$_smarty_tpl->tpl_vars['tbl_all_rows_count']->value),$_smarty_tpl);?>

		</div>
	</div>
</div>
</div>
		

<?php }
}
