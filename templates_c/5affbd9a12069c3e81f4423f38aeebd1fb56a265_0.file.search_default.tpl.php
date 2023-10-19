<?php
/* Smarty version 3.1.32, created on 2023-10-17 09:25:26
  from 'C:\wamp\www\taxicms\templates\search_default.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_652e36e6861867_93796385',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5affbd9a12069c3e81f4423f38aeebd1fb56a265' => 
    array (
      0 => 'C:\\wamp\\www\\taxicms\\templates\\search_default.tpl',
      1 => 1694591103,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_652e36e6861867_93796385 (Smarty_Internal_Template $_smarty_tpl) {
?>

<!-- Modal -->
<div class="modal fade" id="search" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog container" role="document">
    <div class="modal-content">
      <div class="modal-header">

        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
           <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
				<form action="<?php echo $_smarty_tpl->tpl_vars['link_search']->value;?>
" method="POST" >
					<input class="search-input" placeholder="<?php echo $_smarty_tpl->tpl_vars['PLG_SEARCH_KEYWORD']->value;?>
" type="text" value="" name="search_text" id="search">
					<input class="search-submit" type="submit" name="trazi" id="trazi" value="<?php echo $_smarty_tpl->tpl_vars['PLG_SEARCH_FIND']->value;?>
">
				</form>
      </div>

    </div>
  </div>
</div>
<?php }
}
