<?php
/* Smarty version 3.1.32, created on 2023-04-03 14:08:46
  from 'C:\wamp\www\taxicms\templates\products\filters.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_642ac1ce5e1bc0_25128933',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'fa87af289d8a62d1b312b6832f70b1ad75eeda70' => 
    array (
      0 => 'C:\\wamp\\www\\taxicms\\templates\\products\\filters.tpl',
      1 => 1666608896,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_642ac1ce5e1bc0_25128933 (Smarty_Internal_Template $_smarty_tpl) {
?><!-- sidebar area start -->
<?php if ($_smarty_tpl->tpl_vars['data']->value['hasKarakteristikeFilter']) {?>
<div class="filter-box">
	<?php echo '<script'; ?>
 type="text/javascript">
	
		jQuery(function($) {
			$("#frmFilter input, #frmFilter select").change(function() {
				var change_field = $(this).attr('id');
				var field_content = $(this).val();
				var sList='';
				$(":checkbox:checked").each(function () {
					sList += $(this).attr('data-eid')+',';
				});
				var gpid = $("#grupaproizvodaid").val();
				var p_ids = $("#p_ids").val();
				var st= $(".search-field").val();

				var parameter = "gpid="+gpid+"&p_ids="+p_ids+"&change_field="+change_field+"&field_content="+field_content+"&check_elements="+sList;
				var url = "<?php echo $_smarty_tpl->tpl_vars['ROOT_WEB']->value;?>
plugins/plg_products/filterAjax.php"
				console.log (url+'?'+parameter)				;
				$.ajax({
					type: "POST",
					url: url,
					data: parameter,
					success: function(data) {
						if (data != "ERROR") {
							$('#catalog-details').html(data);						
							//$('form').submit();
							//$('#submit').trigger('click');
						}
					},
				});
			});

			$("#clear_filters").click(function() {
				$('#fields_form input').val('');
				$('#fields_form select').val(0);
				var gpid = $("#grupaproizvodaid").val();
				var parameter = "gpid="+gpid+"&cf=1";
				var url = "<?php echo $_smarty_tpl->tpl_vars['ROOT_WEB']->value;?>
plugins/plg_products/filterAjax.php"
				console.log (url+'?'+parameter);
				$.ajax({
					type: "POST",
					url: url,
					data: parameter,
					success: function(data) {
						if (data != "ERROR") {
							$('#num').html($('#grupaproizvoda_count').val());
							$('#catalog-details').html(data);
							$(":checkbox:checked").each(function () {
								$(this).prop( "checked", false );
							});								
							//$('form').submit();
							//$('#submit').trigger('click');
						}
					},
				});
			});


		});

	
	<?php echo '</script'; ?>
>
		<?php if ($_smarty_tpl->tpl_vars['data']->value['countProizvodiGrupe'] != 0) {?>

	<form id="frmFilter" action="<?php echo $_smarty_tpl->tpl_vars['data']->value['current_link'];?>
" method="post">

		<input type="hidden" id="grupaproizvodaid" name="grupaproizvodaid" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['grupaProizvoda']['grupaproizvodaid'];?>
" />
		<input type="hidden" id="grupaproizvoda_count"  value="<?php echo $_smarty_tpl->tpl_vars['data']->value['countProizvodiGrupe'];?>
" />
		<input type="hidden" id="p_ids" name="p_ids" value="<?php echo $_smarty_tpl->tpl_vars['p_ids']->value;?>
" />

		<div id='fields_form' class="widget-filter-size">

	
		<div class="sidebar-single">
			<?php
$__section_cnt_3_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['data']->value['filterItems']) ? count($_loop) : max(0, (int) $_loop));
$__section_cnt_3_total = $__section_cnt_3_loop;
$_smarty_tpl->tpl_vars['__smarty_section_cnt'] = new Smarty_Variable(array());
if ($__section_cnt_3_total !== 0) {
for ($__section_cnt_3_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] = 0; $__section_cnt_3_iteration <= $__section_cnt_3_total; $__section_cnt_3_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']++){
$_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index_prev'] = $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] - 1;
$_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index_next'] = $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] + 1;
?>
				<?php if ($_smarty_tpl->tpl_vars['data']->value['filterItems'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['filtername'] == "karakteristika-free") {?>
					<?php if ($_smarty_tpl->tpl_vars['data']->value['filterItems'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index_prev']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index_prev'] : null)]['subtitle'] != $_smarty_tpl->tpl_vars['data']->value['filterItems'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['subtitle']) {?>

						<?php if ($_smarty_tpl->tpl_vars['data']->value['filterItems'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['vrsta'] == 16) {?>
							<label class="label-select"><?php echo $_smarty_tpl->tpl_vars['data']->value['filterItems'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['subtitle'];?>
</label>
							<?php $_smarty_tpl->_assignInScope('XX1', (('kX').($_smarty_tpl->tpl_vars['data']->value['filterItems'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['id'])).('search'));?>
							<div class="single-input-item">
								<input id="kX<?php echo $_smarty_tpl->tpl_vars['data']->value['filterItems'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['id'];?>
-search" name="kX<?php echo $_smarty_tpl->tpl_vars['data']->value['filterItems'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['id'];?>
-search" type="text" value="<?php echo $_SESSION['fields'][$_smarty_tpl->tpl_vars['XX1']->value];?>
" placeholder="Search" value="">
							</div>
						<?php } else { ?>
							<label><?php echo $_smarty_tpl->tpl_vars['data']->value['filterItems'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['subtitle'];?>
</label>
							<?php $_smarty_tpl->_assignInScope('XX1', (('kX').($_smarty_tpl->tpl_vars['data']->value['filterItems'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['id'])).('from'));?>
							<div class="single-input-item">
								<div class="double-input-item">
									<input id="kX<?php echo $_smarty_tpl->tpl_vars['data']->value['filterItems'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['id'];?>
-from" name="kX<?php echo $_smarty_tpl->tpl_vars['data']->value['filterItems'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['id'];?>
-from" type="number" value="<?php echo $_SESSION['fields'][$_smarty_tpl->tpl_vars['XX1']->value];?>
"  placeholder="From">
								</div>
							<?php $_smarty_tpl->_assignInScope('XX1', (('kX').($_smarty_tpl->tpl_vars['data']->value['filterItems'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['id'])).('to'));?>
								<div class="double-input-item">
									<input id="kX<?php echo $_smarty_tpl->tpl_vars['data']->value['filterItems'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['id'];?>
-to" name="kX<?php echo $_smarty_tpl->tpl_vars['data']->value['filterItems'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['id'];?>
-to" type="number"  value="<?php echo $_SESSION['fields'][$_smarty_tpl->tpl_vars['XX1']->value];?>
" placeholder="To" >
								</div>
							</div>
						<?php }?>
					<?php }?>
				<?php }?>
				<?php if ($_smarty_tpl->tpl_vars['data']->value['filterItems'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['filtername'] == "karakteristika") {?>
					<?php if ($_smarty_tpl->tpl_vars['data']->value['filterItems'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index_prev']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index_prev'] : null)]['subtitle'] != $_smarty_tpl->tpl_vars['data']->value['filterItems'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['subtitle']) {?>
						<h2 class="label-select"><?php echo $_smarty_tpl->tpl_vars['data']->value['filterItems'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['subtitle'];?>
</h2>
						<ul>
					<?php }?>
						<li>
						<input 
							<?php if (in_array($_smarty_tpl->tpl_vars['data']->value['filterItems'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['elementid'],$_SESSION['check_elements'])) {?>
								checked 
							<?php }?>
							type="checkbox" class="filter-select" data-eid="<?php echo $_smarty_tpl->tpl_vars['data']->value['filterItems'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['elementid'];?>
" id="kX<?php echo $_smarty_tpl->tpl_vars['data']->value['filterItems'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['id'];?>
-select" name="kX<?php echo $_smarty_tpl->tpl_vars['data']->value['filterItems'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['id'];?>
-select">
						<label class="label-check"><?php echo $_smarty_tpl->tpl_vars['data']->value['filterItems'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['title'];?>
</label>
					</li>
					<?php if ($_smarty_tpl->tpl_vars['data']->value['filterItems'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index_next']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index_next'] : null)]['subtitle'] != $_smarty_tpl->tpl_vars['data']->value['filterItems'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['subtitle']) {?>
				</ul>
					<?php }?>

				<?php }?>
			<?php
}
}
?>
		</div>
		<?php }?>

		<?php if ($_SESSION['fields']) {?><div class="filter_no">Filtriranih proizvoda:<span id='num' ><?php echo $_SESSION['count_products'];?>
</span></div><?php }?>

		<div class="clear-btn">
			<button class="btn btn__bg" id='clear_filters' type='button'>Clear filters</button>
		</div>
		<div class="submit-btn">
					</div>
	</div>

	</form>

</div>
<?php }
}
}
