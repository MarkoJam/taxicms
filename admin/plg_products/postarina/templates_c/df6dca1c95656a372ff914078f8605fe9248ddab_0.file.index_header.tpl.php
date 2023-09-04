<?php
/* Smarty version 3.1.32, created on 2019-07-20 11:02:20
  from 'C:\wamp\www\reimstore\admin\plg_products\postarina\templates\index_header.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5d32d89cd27bb8_78769040',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'df6dca1c95656a372ff914078f8605fe9248ddab' => 
    array (
      0 => 'C:\\wamp\\www\\reimstore\\admin\\plg_products\\postarina\\templates\\index_header.tpl',
      1 => 1561551738,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5d32d89cd27bb8_78769040 (Smarty_Internal_Template $_smarty_tpl) {
?>
	<?php echo '<script'; ?>
 type="text/javascript">
	
		$(document).ready(function(){
			$('.new_pos_show').hide();
			$('.new_pos').click(function() {
				$('.new_pos_show').show();
			});
				$('#potvrdi').click(function() {
				modify();	
			})
			
		});
		
	
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



<form id='inner' action="modify_final.php" method="POST" name="formTable">

	<table class="pos table table-bordered">
		<tr><th><?php echo $_smarty_tpl->tpl_vars['PLG_RANGE']->value;?>
</th><th><?php echo $_smarty_tpl->tpl_vars['PLG_FROM']->value;?>
</th><th><?php echo $_smarty_tpl->tpl_vars['PLG_TO']->value;?>
</th><th><?php echo $_smarty_tpl->tpl_vars['PLG_PRICE']->value;?>
</th></tr>


<?php }
}
