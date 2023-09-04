<?php
/* Smarty version 3.1.32, created on 2020-09-04 22:23:47
  from 'C:\wamp\www\mobillwood\admin\plg_products\kurs\templates\index.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5f52a2530cfc52_83738056',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '72c5d3b4f7939ab85a25982c7d41a94d1c36da36' => 
    array (
      0 => 'C:\\wamp\\www\\mobillwood\\admin\\plg_products\\kurs\\templates\\index.tpl',
      1 => 1576216810,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f52a2530cfc52_83738056 (Smarty_Internal_Template $_smarty_tpl) {
echo '<script'; ?>
>

	function table_plugin() {	
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
			<div class="table-responsive">
				<div id="content">
					<form action="modify_final.php" method="POST" name="formTable">
						<table class="tablemodify">
							<tr>
								<td><?php echo $_smarty_tpl->tpl_vars['PLG_EXRATE']->value;?>
<input name="kurs" id="kurs" type="text" value="<?php echo $_smarty_tpl->tpl_vars['kurs']->value;?>
" class="form-control"><input name="kursid" id="kursid" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['kursid']->value;?>
" ></td>
							<td><input type="submit" value="<?php echo $_smarty_tpl->tpl_vars['PLG_SAVE']->value;?>
" name="submit" id="submit" class="btn btn-default"></td>
							</tr>
						</table>
					</form>
			</div>
		</div>
	</div>
</div><?php }
}
