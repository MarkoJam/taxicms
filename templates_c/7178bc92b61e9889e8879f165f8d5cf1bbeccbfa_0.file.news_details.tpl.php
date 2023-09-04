<?php
/* Smarty version 3.1.32, created on 2023-04-03 14:13:29
  from 'C:\wamp\www\taxicms\templates\news_details.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_642ac2e9bf3578_05444529',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '7178bc92b61e9889e8879f165f8d5cf1bbeccbfa' => 
    array (
      0 => 'C:\\wamp\\www\\taxicms\\templates\\news_details.tpl',
      1 => 1666778094,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_642ac2e9bf3578_05444529 (Smarty_Internal_Template $_smarty_tpl) {
if ($_smarty_tpl->tpl_vars['plugin_view']->value == "news_details") {?>
<section class="news-details-area">
<div class="container">
  <div class="row position-relative">
		<div class="path path-news">
					<ul>
						<li><a href="<?php echo $_smarty_tpl->tpl_vars['ROOT_WEB']->value;
echo $_smarty_tpl->tpl_vars['lang']->value;
echo $_smarty_tpl->tpl_vars['PLG_LINK_NEWS']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['PLG_NEWS']->value;?>
</a></li>
						<li><?php echo $_smarty_tpl->tpl_vars['news_detail']->value['header'];?>
</li>
					</ul>
		</div>
	</div>
		<div class="row">
		<div class="col-md-12">
			<div class="gp-title">
				<h2><?php echo $_smarty_tpl->tpl_vars['news_detail']->value['header'];?>
</h2>
			</div>
		</div>
	</div>
	<div class="row">
			<div class="col-lg-12 col-md-12 col-12 content-gallery">
				<p class="date"><?php echo $_smarty_tpl->tpl_vars['news_detail']->value['date'];?>
</p>
				<img src="<?php echo $_smarty_tpl->tpl_vars['ROOT_WEB']->value;
echo $_smarty_tpl->tpl_vars['news_detail']->value['slika'];?>
" class="mb-10 w-100" />
							<?php echo $_smarty_tpl->tpl_vars['news_detail']->value['html'];?>

			</div>
		</div>
							<?php if ($_smarty_tpl->tpl_vars['news_detail']->value['img_rows'] != '') {?>
            <div class="row">
              <div class="col-lg-12 col-md-12">
                  <div class="g-title">
                    <h2><?php echo $_smarty_tpl->tpl_vars['PLG_VIEW']->value;?>
</h2>
                  </div>
							<div id="gallery" class="row content-gallery">
									<?php
$__section_cnt_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['images']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_cnt_0_total = $__section_cnt_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_cnt'] = new Smarty_Variable(array());
if ($__section_cnt_0_total !== 0) {
for ($__section_cnt_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] = 0; $__section_cnt_0_iteration <= $__section_cnt_0_total; $__section_cnt_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']++){
?>
									<div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 galerija-wrap">
										<div class="galerija">
											<a class="example-image-link" href="<?php echo $_smarty_tpl->tpl_vars['ROOT_WEB']->value;
echo $_smarty_tpl->tpl_vars['images']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)];?>
" data-lightbox="example-1">
												<div class="image-wrap">
												<img class="example-image" alt="" src="<?php echo $_smarty_tpl->tpl_vars['ROOT_WEB']->value;
echo $_smarty_tpl->tpl_vars['images_thumb']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)];?>
">
											</div>
											</a>
										</div>
									</div>
									 <?php
}
}
?>

							</div>
              </div>
              </div>
							<?php }?>

							<?php if ($_smarty_tpl->tpl_vars['news_detail']->value['vid_rows'] != "<div class='res_vid'></div>") {?>
							<div class="col-md-12">
								<?php echo $_smarty_tpl->tpl_vars['news_detail']->value['vid_rows'];?>

							</div>
							<?php }?>

							<?php echo $_smarty_tpl->tpl_vars['news_detail']->value['doc_rows'];?>


							<?php echo $_smarty_tpl->tpl_vars['news_detail']->value['web_rows'];?>

              
				</div>
			</div>
		</div>
	</div>
</section>
<?php }
}
}
