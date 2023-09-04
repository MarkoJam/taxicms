<?php
/* Smarty version 3.1.32, created on 2023-04-03 14:03:46
  from 'C:\wamp\www\taxicms\admin\plg_images\templates\edit_image_data.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_642ac0a2ca55f7_18564312',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '7da7cd65a516a1c96c4be3d2f307461cba6ec7ff' => 
    array (
      0 => 'C:\\wamp\\www\\taxicms\\admin\\plg_images\\templates\\edit_image_data.tpl',
      1 => 1666177686,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_642ac0a2ca55f7_18564312 (Smarty_Internal_Template $_smarty_tpl) {
?><div class="image-modal">
	<div class="modal inmodal fade" id="myModal7" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title"><?php echo $_smarty_tpl->tpl_vars['PLG_IMAGE_ATTR']->value;?>
</h4>
				</div>
				<div class="modal-body">
					<div class="form-group"><label><?php echo $_smarty_tpl->tpl_vars['PLG_IMAGE_TITLE']->value;?>
</label><textarea type="text" id='image-title' name="image-title"  class="form-control" placeholder="<?php echo $_smarty_tpl->tpl_vars['PLG_IMAGE_TITLE']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['image']->value;?>
</textarea></div>
					<div class="form-group"><label><?php echo $_smarty_tpl->tpl_vars['PLG_IMAGE_ALT']->value;?>
</label><input type="text" id='description' name="description" value="<?php echo $_smarty_tpl->tpl_vars['description']->value;?>
" class="form-control" placeholder="<?php echo $_smarty_tpl->tpl_vars['PLG_IMAGE_ALT']->value;?>
"></div>	
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-white" id="close_pass" data-dismiss="modal"><?php echo $_smarty_tpl->tpl_vars['PLG_CLOSE']->value;?>
</button>
					<button type="button" name="promeni" id="promeni"  class="btn btn-primary"><?php echo $_smarty_tpl->tpl_vars['PLG_SAVE']->value;?>
</button>
				</div>
				<input id='url' value='' type='hidden'>
			</div>
		</div>
	</div>
</div><?php }
}
