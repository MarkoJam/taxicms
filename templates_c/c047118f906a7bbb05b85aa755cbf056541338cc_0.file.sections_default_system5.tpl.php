<?php
/* Smarty version 3.1.32, created on 2023-04-05 12:18:19
  from 'C:\wamp\www\taxicms\templates\sections_default_system5.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_642d4aeb9ab6a2_05033231',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c047118f906a7bbb05b85aa755cbf056541338cc' => 
    array (
      0 => 'C:\\wamp\\www\\taxicms\\templates\\sections_default_system5.tpl',
      1 => 1666778094,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_642d4aeb9ab6a2_05033231 (Smarty_Internal_Template $_smarty_tpl) {
?><section class="system-area5">
  <div class="container">
    <div class="row">
		<?php
$__section_pom_3_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['data']->value['sections_all']) ? count($_loop) : max(0, (int) $_loop));
$__section_pom_3_total = $__section_pom_3_loop;
$_smarty_tpl->tpl_vars['__smarty_section_pom'] = new Smarty_Variable(array());
if ($__section_pom_3_total !== 0) {
for ($__section_pom_3_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] = 0; $__section_pom_3_iteration <= $__section_pom_3_total; $__section_pom_3_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']++){
?>
			<div class="col-md-12">
            <?php echo $_smarty_tpl->tpl_vars['data']->value['sections_all'][(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['shorthtml'];?>

 			        <?php echo $_smarty_tpl->tpl_vars['data']->value['sections_all'][(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['html'];?>

 						<a class="carousel-button" href="<?php echo $_smarty_tpl->tpl_vars['data']->value['sections_all'][(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['sectionlink'];?>
"><?php echo $_smarty_tpl->tpl_vars['PLG_VIEW_MORE']->value;?>
</a>
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
