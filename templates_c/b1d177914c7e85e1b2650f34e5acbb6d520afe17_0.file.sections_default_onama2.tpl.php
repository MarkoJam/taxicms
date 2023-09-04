<?php
/* Smarty version 3.1.32, created on 2023-04-03 14:13:36
  from 'C:\wamp\www\taxicms\templates\sections_default_onama2.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_642ac2f027c064_13938355',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b1d177914c7e85e1b2650f34e5acbb6d520afe17' => 
    array (
      0 => 'C:\\wamp\\www\\taxicms\\templates\\sections_default_onama2.tpl',
      1 => 1666778094,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_642ac2f027c064_13938355 (Smarty_Internal_Template $_smarty_tpl) {
?><section class="about-area2">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h2><?php echo $_smarty_tpl->tpl_vars['PLG_SECTION_BENEFITS']->value;?>
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
			<div class="col-md-6">
			  <div class="about-content text-center">
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
