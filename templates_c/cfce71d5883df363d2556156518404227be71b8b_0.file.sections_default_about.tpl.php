<?php
/* Smarty version 3.1.32, created on 2023-10-17 09:25:25
  from 'C:\wamp\www\taxicms\templates\sections_default_about.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_652e36e50a8c20_19588319',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'cfce71d5883df363d2556156518404227be71b8b' => 
    array (
      0 => 'C:\\wamp\\www\\taxicms\\templates\\sections_default_about.tpl',
      1 => 1694591098,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_652e36e50a8c20_19588319 (Smarty_Internal_Template $_smarty_tpl) {
?><section class="about">
  <div class="container">
		<?php
$__section_pom_5_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['data']->value['sections_all']) ? count($_loop) : max(0, (int) $_loop));
$__section_pom_5_total = $__section_pom_5_loop;
$_smarty_tpl->tpl_vars['__smarty_section_pom'] = new Smarty_Variable(array());
if ($__section_pom_5_total !== 0) {
for ($__section_pom_5_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] = 0; $__section_pom_5_iteration <= $__section_pom_5_total; $__section_pom_5_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']++){
?>
    <div class="row">
      <div class="col-lg-4 itemheight about-home-image" style="background:url(<?php echo $_smarty_tpl->tpl_vars['ROOT_WEB']->value;
echo $_smarty_tpl->tpl_vars['data']->value['sections_all'][(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['slika'];?>
)  center center / cover ">

      </div>
			<div class="col-lg-8 itemheight">
			  <div class="about-content ps-5">
			        <?php echo $_smarty_tpl->tpl_vars['data']->value['sections_all'][(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['shorthtml'];?>

						<a class="carousel-button" href="<?php echo $_smarty_tpl->tpl_vars['data']->value['sections_all'][(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['sectionlink'];?>
"><?php echo $_smarty_tpl->tpl_vars['PLG_VIEW_MORE']->value;?>
</a>
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
