<?php
/* Smarty version 3.1.32, created on 2023-10-17 09:25:24
  from 'C:\wamp\www\taxicms\templates\sections_default_slide.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_652e36e4800315_33521567',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e67b25f3ab529af74c7c2168ded167f136edeb9d' => 
    array (
      0 => 'C:\\wamp\\www\\taxicms\\templates\\sections_default_slide.tpl',
      1 => 1694591102,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_652e36e4800315_33521567 (Smarty_Internal_Template $_smarty_tpl) {
?><div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="false">

  <div class="carousel-inner">
		<?php
$__section_pom_3_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['data']->value['sections_all']) ? count($_loop) : max(0, (int) $_loop));
$__section_pom_3_total = $__section_pom_3_loop;
$_smarty_tpl->tpl_vars['__smarty_section_pom'] = new Smarty_Variable(array());
if ($__section_pom_3_total !== 0) {
for ($__section_pom_3_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] = 0; $__section_pom_3_iteration <= $__section_pom_3_total; $__section_pom_3_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']++){
?>
    <div class="carousel-item active">
      <video class="img-fluid w-100" autoplay loop muted>
        <source src="<?php echo $_smarty_tpl->tpl_vars['ROOT_WEB']->value;
echo $_smarty_tpl->tpl_vars['data']->value['sections_all'][(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['slika'];?>
" type="video/mp4" />
      </video>

			<div class="layout"></div>
			<div class="container carousel-wrap">
				<div class="row">
					<div class="col-md-6">
			      <div class="carousel-caption d-flex justify-content-center flex-column">
			        <?php echo $_smarty_tpl->tpl_vars['data']->value['sections_all'][(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['shorthtml'];?>

			        <?php echo $_smarty_tpl->tpl_vars['data']->value['sections_all'][(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['html'];?>

							<a class="carousel-button" href="<?php echo $_smarty_tpl->tpl_vars['data']->value['sections_all'][(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['sectionlink'];?>
"><?php echo $_smarty_tpl->tpl_vars['PLG_CHECK_PRODUCTS']->value;?>
</a>
			      </div>
					</div>
				</div>
			</div>

    </div>
		<?php
}
}
?>
  </div>

</div>
<?php }
}
