<?php
/* Smarty version 3.1.32, created on 2023-04-03 13:47:22
  from 'C:\wamp\www\taxicms\templates\news_default_notify.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_642abccaca5b49_16178517',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '20aedc2eed4a462f64a9f3704a6b421418612f00' => 
    array (
      0 => 'C:\\wamp\\www\\taxicms\\templates\\news_default_notify.tpl',
      1 => 1671542194,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_642abccaca5b49_16178517 (Smarty_Internal_Template $_smarty_tpl) {
if ($_smarty_tpl->tpl_vars['data']->value['news_all'][0]['header'] != '') {?>
<div class="soc inews"><div class="float-contact">
<div class="news-notify">
	<h2><a href="<?php echo $_smarty_tpl->tpl_vars['data']->value['news_all'][0]['link_print_dt'];?>
"><?php echo $_smarty_tpl->tpl_vars['data']->value['news_all'][0]['header'];?>
</a></h2>
					<img src="<?php echo $_smarty_tpl->tpl_vars['ROOT_WEB']->value;
echo $_smarty_tpl->tpl_vars['data']->value['news_all'][0]['slika'];?>
" />
				<?php echo $_smarty_tpl->tpl_vars['data']->value['news_all'][0]['shorthtml'];?>

</div>
</div>
	<img src="<?php echo $_smarty_tpl->tpl_vars['ROOT_WEB']->value;?>
images/icon-news.svg" width="22" height="22" />
</div>
<?php }
}
}
