<?php
/* Smarty version 3.1.32, created on 2023-04-05 12:18:19
  from 'C:\wamp\www\taxicms\templates\sections_default_system4.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_642d4aeb736234_76035877',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a9314ebd2a6f1854778679b32fbb58a11f60ed81' => 
    array (
      0 => 'C:\\wamp\\www\\taxicms\\templates\\sections_default_system4.tpl',
      1 => 1671542194,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_642d4aeb736234_76035877 (Smarty_Internal_Template $_smarty_tpl) {
?><section class="system-area4" id="catalogue">
  <div class="container">
    <div class="row">
		<?php
$__section_pom_2_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['data']->value['sections_all']) ? count($_loop) : max(0, (int) $_loop));
$__section_pom_2_total = $__section_pom_2_loop;
$_smarty_tpl->tpl_vars['__smarty_section_pom'] = new Smarty_Variable(array());
if ($__section_pom_2_total !== 0) {
for ($__section_pom_2_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] = 0; $__section_pom_2_iteration <= $__section_pom_2_total; $__section_pom_2_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']++){
?>
			<div class="col-lg-6 catalogue">
        <div class="row">
          <div class="col-md-6 col-lg-12 col-xl-6 catalogue-item">
            <img src="<?php echo $_smarty_tpl->tpl_vars['ROOT_WEB']->value;
echo $_smarty_tpl->tpl_vars['data']->value['sections_all'][(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['slika'];?>
"/>
          </div>
          <div class="col-md-6 col-lg-12 col-xl-6 catalogue-item">
			     <h3><?php echo $_smarty_tpl->tpl_vars['data']->value['sections_all'][(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['header'];?>
</h3>
           <a class="carousel-button" href="<?php echo $_smarty_tpl->tpl_vars['data']->value['sections_all'][(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['sectionlink'];?>
" target="_blank"><i class="fa-solid fa-arrow-down"></i> <?php echo $_smarty_tpl->tpl_vars['PLG_SECTION_PDF']->value;?>
</a>
         </div>
			  </div>
			</div>
		<?php
}
}
?>
    </div>
  </div>
</div>
</section>
<?php }
}
