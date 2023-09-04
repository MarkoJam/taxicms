<?php
/* Smarty version 3.1.32, created on 2019-07-20 11:02:20
  from 'C:\wamp\www\reimstore\admin\plg_products\postarina\templates\index_footer.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5d32d89ce509d6_00676948',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c6e7490ecf58da3a3d805d37f4e621c833fcaed8' => 
    array (
      0 => 'C:\\wamp\\www\\reimstore\\admin\\plg_products\\postarina\\templates\\index_footer.tpl',
      1 => 1561551738,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5d32d89ce509d6_00676948 (Smarty_Internal_Template $_smarty_tpl) {
?>		
		<tr >
			<td colspan=4><p>&nbsp;</p></td>
		</tr>
		<tr >
			<td colspan=4><div class="btn btn-success new_pos"><i class="fa fa-plus-square-o" ></i> <?php echo $_smarty_tpl->tpl_vars['PLG_ADD_RANGE']->value;?>
</div></td>
		</tr>
		<tr class="new_pos_show">
			<td><input name="<?php echo $_smarty_tpl->tpl_vars['pi']->value;?>
" size="7" type="text" value="<?php echo $_smarty_tpl->tpl_vars['priceid']->value;?>
" disabled></td>
			<td><input name="<?php echo $_smarty_tpl->tpl_vars['wf']->value;?>
" size="3" type="text" value="<?php echo $_smarty_tpl->tpl_vars['weightfrom']->value;?>
" ></td>
			<td><input name="<?php echo $_smarty_tpl->tpl_vars['wt']->value;?>
" size="3" type="text" value="<?php echo $_smarty_tpl->tpl_vars['weightto']->value;?>
" ></td>
			<td><input name="<?php echo $_smarty_tpl->tpl_vars['npp']->value;?>
" size="5" type="text" value="<?php echo $_smarty_tpl->tpl_vars['postprice']->value;?>
" ></td>
			
		</tr>
		<tr>
		   <div class="form-group post"><label class="col-sm-2 control-label"><?php echo $_smarty_tpl->tpl_vars['PLG_POST_PRICE_LIMIT']->value;?>
</label>
				<div class="col-sm-8">
					<input name="price" class="form-control" type="text" value="<?php echo $_smarty_tpl->tpl_vars['price']->value;?>
" ><input name="priceid2" id="priceid" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['priceid']->value;?>
">
				</div>
			</div>		
		</tr>	
		<tr>
			<td colspan=4><div id="potvrdi" class="btn btn-success"><?php echo $_smarty_tpl->tpl_vars['PLG_SAVE']->value;?>
</div></td>
		</tr>
	</table>
</form>
</div>
<?php }
}
