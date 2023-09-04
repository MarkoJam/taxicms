<?php
/* Smarty version 3.1.32, created on 2023-04-05 12:18:18
  from 'C:\wamp\www\taxicms\templates\sections_default_system1.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_642d4aeaed4850_35686309',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b3ee6e143cce8b66c78c79ac8428ccd2f622e555' => 
    array (
      0 => 'C:\\wamp\\www\\taxicms\\templates\\sections_default_system1.tpl',
      1 => 1671542194,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_642d4aeaed4850_35686309 (Smarty_Internal_Template $_smarty_tpl) {
?><section class="about">
  <div class="container">
		<?php
$__section_pom_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['data']->value['sections_all']) ? count($_loop) : max(0, (int) $_loop));
$__section_pom_0_total = $__section_pom_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_pom'] = new Smarty_Variable(array());
if ($__section_pom_0_total !== 0) {
for ($__section_pom_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] = 0; $__section_pom_0_iteration <= $__section_pom_0_total; $__section_pom_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']++){
?>
    <div class="row">
      <div class="col-lg-6 itemheight about-home-image" style="background:url(<?php echo $_smarty_tpl->tpl_vars['ROOT_WEB']->value;
echo $_smarty_tpl->tpl_vars['data']->value['sections_all'][(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['slika'];?>
)  center center / cover">
      </div>
			<div class="col-lg-6 itemheight">
			  <div class="about-content ps-5">
			        <?php echo $_smarty_tpl->tpl_vars['data']->value['sections_all'][(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['shorthtml'];?>

              <?php echo $_smarty_tpl->tpl_vars['data']->value['sections_all'][(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['html'];?>

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
