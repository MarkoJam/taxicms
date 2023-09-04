<?php
/* Smarty version 3.1.32, created on 2023-08-28 11:40:01
  from 'C:\wamp\www\taxicms\templates\module_default.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_64ec6b718f47f9_59934397',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2cd5a84ab8560e8aeeeab076ddb3e25200f7fdde' => 
    array (
      0 => 'C:\\wamp\\www\\taxicms\\templates\\module_default.tpl',
      1 => 1691498353,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_64ec6b718f47f9_59934397 (Smarty_Internal_Template $_smarty_tpl) {
echo '<script'; ?>
 type="text/javascript">
	
		$(document).ready(function(){
	/*		function formsubmit() {
				rootweb=$('#rootweb').val();
				var link=rootweb+'/plugins/plg_module/moduleAjax.php';
				var param=$('form').serialize();
				$.ajax({
					type : 'POST',
					url : link,
					data : param,
					success: function(data) {
						$('#ajax_default').html(data);
						$('.loader').css("display","none");
					}
				})
			}
			*/
			$('.pager').click(function() {
				var offset = $(this).attr('data-offset');
				$('#offset').val(offset);
				rootweb=$('#rootweb').val();
				var link=rootweb+'/plugins/plg_module/moduleAjax.php';
				var param=$('form').serialize();
				console.log (link+'?'+param)
				//alert (link+'?'+param);
				$.ajax({
					type : 'POST',
					url : link,
					data : param,
					success: function(data) {
						$('#ajax_default').html(data);
					}
				})
			})
		})
	
<?php echo '</script'; ?>
>
<section class="news-area page-top">
	<div class="container">
		<div class="row">
		<?php
$__section_pom_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['data']->value['module_all']) ? count($_loop) : max(0, (int) $_loop));
$__section_pom_0_total = $__section_pom_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_pom'] = new Smarty_Variable(array());
if ($__section_pom_0_total !== 0) {
for ($__section_pom_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] = 0; $__section_pom_0_iteration <= $__section_pom_0_total; $__section_pom_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']++){
?>
		<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 itemheight mb-6">
			<a href="<?php echo $_smarty_tpl->tpl_vars['data']->value['module_all'][(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['link_print_dt'];?>
">
				<div class="news-group-box">
					<div class="slika" style="background-image:url(<?php echo $_smarty_tpl->tpl_vars['ROOT_WEB']->value;
echo $_smarty_tpl->tpl_vars['data']->value['module_all'][(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['slika'];?>
)"></div>
					<div class="news-content">
						<h5><?php echo $_smarty_tpl->tpl_vars['data']->value['module_all'][(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['header'];?>
</h5>
						<?php echo $_smarty_tpl->tpl_vars['data']->value['module_all'][(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['shorthtml'];?>

						<div class="news-link"><i class="fa-solid fa-chevron-right"></i></div>
					</div>
				</div>	
			</a>
		</div>
		<?php
}
}
?>
	</div>
	<div class="row">
		<div class="col-12">
	 		<nav class="pagination-area ms-md-auto mt-3 mt-md-0">
	     	<?php echo $_smarty_tpl->tpl_vars['data']->value['pagination'];?>

	 		</nav>
		</div>
	</div>
	<form id="" action="" method="post">
		<input id='offset' name='offset' type='hidden' value=''/>
		<input id='reset' name='reset' type='hidden' value=''/>
		<input id='filter' name='filter' type='hidden' value=''/>
		<input id='language' type='hidden' name='language' value='<?php echo $_smarty_tpl->tpl_vars['language']->value;?>
'/>
		<input id='main_category_id' name='main_category_id' type='hidden' value='<?php echo $_REQUEST['main_category_id'];?>
'/>
	</form>
	</div>
</div>
</section>
<?php }
}
