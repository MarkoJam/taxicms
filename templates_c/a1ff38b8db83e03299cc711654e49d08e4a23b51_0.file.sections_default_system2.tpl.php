<?php
/* Smarty version 3.1.32, created on 2023-04-05 12:18:19
  from 'C:\wamp\www\taxicms\templates\sections_default_system2.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_642d4aeb223214_43302793',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a1ff38b8db83e03299cc711654e49d08e4a23b51' => 
    array (
      0 => 'C:\\wamp\\www\\taxicms\\templates\\sections_default_system2.tpl',
      1 => 1666778094,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_642d4aeb223214_43302793 (Smarty_Internal_Template $_smarty_tpl) {
?><section class="system-area2">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h2><?php echo $_smarty_tpl->tpl_vars['PLG_SECTION_BENEFITS2']->value;?>
</h2>
      </div>
    </div>
    <div class="row">
		<?php
$__section_pom_1_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['data']->value['sections_all']) ? count($_loop) : max(0, (int) $_loop));
$__section_pom_1_total = $__section_pom_1_loop;
$_smarty_tpl->tpl_vars['__smarty_section_pom'] = new Smarty_Variable(array());
if ($__section_pom_1_total !== 0) {
for ($__section_pom_1_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] = 0; $__section_pom_1_iteration <= $__section_pom_1_total; $__section_pom_1_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']++){
?>
			<div class="col-md-4">
			  <div class="system-content text-center">
          <img src="<?php echo $_smarty_tpl->tpl_vars['ROOT_WEB']->value;
echo $_smarty_tpl->tpl_vars['data']->value['sections_all'][(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['slika'];?>
" height="140"/>
			     <h3><?php echo $_smarty_tpl->tpl_vars['data']->value['sections_all'][(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['header'];?>
</h3>
			   </div>
			</div>
		<?php
}
}
?>
    </div>
  </div>
</section>
<?php }
}
