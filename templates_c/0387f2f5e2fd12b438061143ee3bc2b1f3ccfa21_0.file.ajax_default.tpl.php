<?php
/* Smarty version 3.1.32, created on 2023-04-03 14:13:10
  from 'C:\wamp\www\taxicms\templates\ajax_default.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_642ac2d64a2117_17909095',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '0387f2f5e2fd12b438061143ee3bc2b1f3ccfa21' => 
    array (
      0 => 'C:\\wamp\\www\\taxicms\\templates\\ajax_default.tpl',
      1 => 1666778094,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_642ac2d64a2117_17909095 (Smarty_Internal_Template $_smarty_tpl) {
?>	<?php echo '<script'; ?>
 type="text/javascript">
	
		$('#ajax_default').ready(function(){
			$('#main_category_id').val($('#categoryid').val());
			rootweb=$('#rootweb').val();
			var link=rootweb+'/plugins/plg_<?php echo $_smarty_tpl->tpl_vars['data']->value['plugin'];?>
/<?php echo $_smarty_tpl->tpl_vars['data']->value['plugin'];?>
Ajax.php';
			var param=$('form').serialize();
			console.log(link+'?'+param);
			$.ajax({
				type : 'POST',
				url : link,
				data : param,
				success: function(data) {
					$('#ajax_default').html(data);
					$('.loader').css("display","none");
					$('.itemheight').matchHeight({
										 byRow: true,
								property: 'height',
								target: null,
								remove: false
								});
				}
			})
		})
	
	<?php echo '</script'; ?>
>
	<div class="loader"><div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>
	<form id="" action="" method="post">
				<input id='statusarchive' type='hidden' name='statusarchive' value='<?php echo $_smarty_tpl->tpl_vars['ss']->value;?>
'/>
		<input id='lang' type='hidden' name='lang' value='<?php echo $_smarty_tpl->tpl_vars['language']->value;?>
'/>
		<input id='offset' type='hidden' name='offset' value='0'/>
		<input id='main_category_id' type='hidden' name='main_category_id' value=''/>
		<input id='language' type='hidden' name='language' value='<?php echo $_smarty_tpl->tpl_vars['language']->value;?>
'/>
		<input id='pathurl' type='hidden' name='pathurl' value='<?php echo $_smarty_tpl->tpl_vars['pathurl']->value;?>
'/>
		<?php if ($_smarty_tpl->tpl_vars['filterid']->value) {?><input id='filterid' type='hidden' name='filterid' value='<?php echo $_smarty_tpl->tpl_vars['filterid']->value;?>
'/><?php }?>
	</form>
<?php }
}
