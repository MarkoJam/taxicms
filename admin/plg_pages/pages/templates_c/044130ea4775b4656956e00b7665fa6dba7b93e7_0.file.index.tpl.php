<?php
/* Smarty version 3.1.32, created on 2023-04-03 13:31:45
  from 'C:\wamp\www\taxicms\admin\plg_pages\pages\templates\index.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_642ab9214f4ba9_51696069',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '044130ea4775b4656956e00b7665fa6dba7b93e7' => 
    array (
      0 => 'C:\\wamp\\www\\taxicms\\admin\\plg_pages\\pages\\templates\\index.tpl',
      1 => 1666177686,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_642ab9214f4ba9_51696069 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'C:\\wamp\\www\\taxicms\\common\\libs\\plugins\\function.html_table_advanced.php','function'=>'smarty_function_html_table_advanced',),));
echo '<script'; ?>
>

	function table_plugin() {
		move_rows();
		// Collapse ibox function
				$('.collapse-link').on('click', function () {
					var ibox = $(this).closest('div.ibox');
					var button = $(this).find('i');
					var content = ibox.children('.ibox-content1');
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
		<h5><?php echo $_smarty_tpl->tpl_vars['PLG_POSITION']->value;?>
&nbsp;<strong><?php echo $_smarty_tpl->tpl_vars['tbl_title']->value;?>
</strong></h5>
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
					<a class="btn btn-info buttons-html5" tabindex="0" href="<?php echo $_smarty_tpl->tpl_vars['ModifyScript']->value;?>
?parent=1&page_id=<?php echo $_smarty_tpl->tpl_vars['page_id']->value;?>
">
						<i class="fa fa-paste"></i> <span><?php echo $_smarty_tpl->tpl_vars['PLG_MODIFY']->value;?>
 / <?php echo $_smarty_tpl->tpl_vars['PLG_PAGES']->value;?>
</span>
					</a>
					<a class="btn btn-success buttons-html5" tabindex="0" href="modify_grp.php?parent_id=<?php echo $_smarty_tpl->tpl_vars['page_id']->value;?>
&pagetypeid=<?php echo @constant('PAGE_TYPE_PAGE');?>
">
						<i class="fa fa-file-text-o" ></i> <span><?php echo $_smarty_tpl->tpl_vars['PLG_ADD']->value;?>
 / <?php echo $_smarty_tpl->tpl_vars['PLG_PAGES']->value;?>
</span>
					</a>
					<a class="btn btn-success buttons-html5" tabindex="0" href="modify_categ.php?parent_id=<?php echo $_smarty_tpl->tpl_vars['page_id']->value;?>
&pagetypeid=<?php echo @constant('PAGE_TYPE_CATEGORY');?>
">
						<i class="fa fa-folder-open-o" aria-hidden="true"></i> <span><?php echo $_smarty_tpl->tpl_vars['PLG_ADD']->value;?>
 / <?php echo $_smarty_tpl->tpl_vars['PLG_CATEGORY']->value;?>
</span>
					</a>
					<a class="btn btn-success buttons-html5" tabindex="0"  href="modify_link.php?parent_id=<?php echo $_smarty_tpl->tpl_vars['page_id']->value;?>
&pagetypeid=<?php echo @constant('PAGE_TYPE_LINK');?>
">
						<i class="fa fa-link" aria-hidden="true"></i> <span><?php echo $_smarty_tpl->tpl_vars['PLG_ADD']->value;?>
 / <?php echo $_smarty_tpl->tpl_vars['PLG_LINKS']->value;?>
</span>
					</a>
			</div>
		</div>
		<div class="table-responsive">
		<?php if ($_smarty_tpl->tpl_vars['page_id']->value != '') {?>
			<div id="content">
				<?php echo smarty_function_html_table_advanced(array('filter'=>$_smarty_tpl->tpl_vars['filter']->value,'cnt_all_rows'=>$_smarty_tpl->tpl_vars['tbl_all_rows_count']->value,'browseString'=>$_smarty_tpl->tpl_vars['tbl_browseString']->value,'scriptName'=>$_smarty_tpl->tpl_vars['scriptName']->value,'cnt_rows'=>$_smarty_tpl->tpl_vars['tbl_row_count']->value,'rowOffset'=>$_smarty_tpl->tpl_vars['tbl_offset']->value,'tr_attr'=>$_smarty_tpl->tpl_vars['tbl_tr_attributes']->value,'td_attr'=>$_smarty_tpl->tpl_vars['tbl_td_attributes']->value,'loop'=>$_smarty_tpl->tpl_vars['tbl_content']->value,'cols'=>$_smarty_tpl->tpl_vars['tbl_cols_count']->value,'tableheader'=>$_smarty_tpl->tpl_vars['tbl_header']->value,'exportlinks'=>$_smarty_tpl->tpl_vars['tbl_show_export_links']->value,'table_attr'=>'cellspacing=0 class="index" id="normal"','message'=>$_smarty_tpl->tpl_vars['poruka']->value),$_smarty_tpl);?>

				<input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['page_id']->value;?>
" name="page_id"/>

			</div>
		<?php }?>
		</div>
	</div>
</div>
<?php }
}
