<?php
/* Smarty version 3.1.32, created on 2023-04-03 14:13:36
  from 'C:\wamp\www\taxicms\templates\sections_default_onama3.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_642ac2f0464dc0_95650676',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'fe40e31a5679c78fbfb8b42048d40b555668473f' => 
    array (
      0 => 'C:\\wamp\\www\\taxicms\\templates\\sections_default_onama3.tpl',
      1 => 1671542194,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_642ac2f0464dc0_95650676 (Smarty_Internal_Template $_smarty_tpl) {
?><section class="about-area3">
  <div class="container">
		<?php
$__section_pom_2_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['data']->value['sections_all']) ? count($_loop) : max(0, (int) $_loop));
$__section_pom_2_total = $__section_pom_2_loop;
$_smarty_tpl->tpl_vars['__smarty_section_pom'] = new Smarty_Variable(array());
if ($__section_pom_2_total !== 0) {
for ($__section_pom_2_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] = 0; $__section_pom_2_iteration <= $__section_pom_2_total; $__section_pom_2_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']++){
?>
    <div class="row about-box">
      <div class="col-lg-5 p-0 about-image" <?php if (!(1 & (isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null))) {?>style="background:url(<?php echo $_smarty_tpl->tpl_vars['ROOT_WEB']->value;
echo $_smarty_tpl->tpl_vars['data']->value['sections_all'][(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['slika'];?>
) center center / cover" <?php } else { ?>style="order:2;background:url(<?php echo $_smarty_tpl->tpl_vars['ROOT_WEB']->value;
echo $_smarty_tpl->tpl_vars['data']->value['sections_all'][(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['slika'];?>
) center center / cover"<?php }?>>
      </div>
			<div class="col-lg-7 p-5">
			  <div class="about-content ps-5">
			     <h2><?php echo $_smarty_tpl->tpl_vars['data']->value['sections_all'][(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['header'];?>
</h2>
			        <?php echo $_smarty_tpl->tpl_vars['data']->value['sections_all'][(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['shorthtml'];?>

			   </div>
			</div>
		</div>
		<?php
}
}
?>
  </div>
</section>
<?php }
}
