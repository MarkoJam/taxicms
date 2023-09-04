<?php
/* Smarty version 3.1.32, created on 2023-09-01 11:06:36
  from 'C:\wamp\www\taxicms\templates\news_default_home.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_64f1a99cb16557_10690131',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ff486ded3e6396f07db799f93c7d8c98996977f3' => 
    array (
      0 => 'C:\\wamp\\www\\taxicms\\templates\\news_default_home.tpl',
      1 => 1693558530,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_64f1a99cb16557_10690131 (Smarty_Internal_Template $_smarty_tpl) {
?><section class="news-area">
	<div class="container">
		<div class="row">
		<?php
$__section_pom_2_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['data']->value['news_all']) ? count($_loop) : max(0, (int) $_loop));
$__section_pom_2_total = $__section_pom_2_loop;
$_smarty_tpl->tpl_vars['__smarty_section_pom'] = new Smarty_Variable(array());
if ($__section_pom_2_total !== 0) {
for ($__section_pom_2_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] = 0; $__section_pom_2_iteration <= $__section_pom_2_total; $__section_pom_2_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']++){
?>
		<div class="row">
				<div class="col-md-4">
					<div class="news-image">
						<img src="<?php echo $_smarty_tpl->tpl_vars['ROOT_WEB']->value;
echo $_smarty_tpl->tpl_vars['data']->value['news_all'][(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['slika'];?>
" />
					</div>
				</div>	
				<div class="col-md-8">
					<a href="<?php echo $_smarty_tpl->tpl_vars['data']->value['news_all'][(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['link_print_dt'];?>
"><?php echo $_smarty_tpl->tpl_vars['data']->value['news_all'][(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['header'];?>
</a>
					<?php echo $_smarty_tpl->tpl_vars['data']->value['news_all'][(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['shorthtml'];?>

				</div>
		</div>
		<?php
}
}
?>
		</div>
		<div class="row">
			<div class="col-md-12 text-center pt-5">
				<a class="news-button" href="<?php echo $_smarty_tpl->tpl_vars['ROOT_WEB']->value;
echo $_smarty_tpl->tpl_vars['lang']->value;
echo $_smarty_tpl->tpl_vars['PLG_LINK_NEWS']->value;?>
" >
					<?php echo $_smarty_tpl->tpl_vars['PLG_SEE_ALL']->value;?>

				</a>
			</div>
		</div>
	</div>
</section>
<?php }
}
