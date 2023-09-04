<?php
/* Smarty version 3.1.32, created on 2023-04-03 13:47:17
  from 'c:\wamp\www\taxicms\templates\pagination.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_642abcc57602a2_87467663',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '0506a41ccc33a53cf90934f4badb3a53637553a2' => 
    array (
      0 => 'c:\\wamp\\www\\taxicms\\templates\\pagination.tpl',
      1 => 1666608896,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_642abcc57602a2_87467663 (Smarty_Internal_Template $_smarty_tpl) {
?><div class="pagination">
			<?php if ($_smarty_tpl->tpl_vars['first']->value) {?><a class='pager' href="<?php echo $_REQUEST['basicurl'];?>
/1"> << </a>|<?php }?>
		<?php if ($_smarty_tpl->tpl_vars['previous']->value) {?><a class='pager' href="<?php echo $_REQUEST['basicurl'];?>
/<?php echo $_smarty_tpl->tpl_vars['previous_offset']->value;?>
"> < </a><?php }?>
		<?php
$__section_pom1_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['pages_arr']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_pom1_0_total = $__section_pom1_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_pom1'] = new Smarty_Variable(array());
if ($__section_pom1_0_total !== 0) {
for ($__section_pom1_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_pom1']->value['index'] = 0; $__section_pom1_0_iteration <= $__section_pom1_0_total; $__section_pom1_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_pom1']->value['index']++){
?>
		|<a class='pager' href="<?php echo $_REQUEST['basicurl'];?>
/<?php echo $_smarty_tpl->tpl_vars['pages_arr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_pom1']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom1']->value['index'] : null)]['page'];?>
">
				<?php if ($_smarty_tpl->tpl_vars['current_page']->value == $_smarty_tpl->tpl_vars['pages_arr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_pom1']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom1']->value['index'] : null)]['page']) {?><strong><?php }
echo $_smarty_tpl->tpl_vars['pages_arr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_pom1']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom1']->value['index'] : null)]['page'];
if ($_smarty_tpl->tpl_vars['current_page']->value == $_smarty_tpl->tpl_vars['pages_arr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_pom1']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom1']->value['index'] : null)]['page']) {?></strong><?php }?>
			</a>
		<?php
}
}
?>
		<?php if ($_smarty_tpl->tpl_vars['next']->value) {?>|<a class='pager' href="<?php echo $_REQUEST['basicurl'];?>
/<?php echo $_smarty_tpl->tpl_vars['next_offset']->value;?>
"> > </a><?php }?>
		<?php if ($_smarty_tpl->tpl_vars['last']->value) {?>|<a class='pager' href="<?php echo $_REQUEST['basicurl'];?>
/<?php echo $_smarty_tpl->tpl_vars['last_offset']->value;?>
"> >> </a><?php }?>
</div>
<?php echo '<script'; ?>
>

$(document).ready(function() {
$(".pager").on('click', function(e) {
    $('html, body').animate({
        scrollTop: $(".pag-top").offset().top
    }, 500);
});

});

<?php echo '</script'; ?>
>
<?php }
}
