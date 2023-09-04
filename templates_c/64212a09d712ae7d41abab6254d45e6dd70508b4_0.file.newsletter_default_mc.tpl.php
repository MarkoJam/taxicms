<?php
/* Smarty version 3.1.32, created on 2023-04-03 13:47:22
  from 'C:\wamp\www\taxicms\templates\newsletter_default_mc.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_642abcca861a89_09882273',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '64212a09d712ae7d41abab6254d45e6dd70508b4' => 
    array (
      0 => 'C:\\wamp\\www\\taxicms\\templates\\newsletter_default_mc.tpl',
      1 => 1666778094,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_642abcca861a89_09882273 (Smarty_Internal_Template $_smarty_tpl) {
?><section class="newsletter-area">
	<div class="container">
		<div class="row">
			<div class="newsletter-title text-center">
				<h2><?php echo $_smarty_tpl->tpl_vars['PLG_NEWSLETTER_HEADER']->value;?>
</h2>
			</div>
			<div class="newsletter-box text-center">
				<form  action="#" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
					<div class="form-input">
						<input type="text" class="input" value="" name="FNAME" placeholder="<?php echo $_smarty_tpl->tpl_vars['PLG_NAMESURNAME']->value;?>
" id="mce-FNAME"><input type="email" type="email" value="" name="EMAIL" placeholder="E-mail" class="input required email" id="mce-EMAIL"><button type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" ><?php echo $_smarty_tpl->tpl_vars['PLG_SUBMIT']->value;?>
</button>
					</div>
					<div id="mce-responses" class="clear">
						<div class="response" id="mce-error-response" style="display:none"></div>
						<div class="response" id="mce-success-response" style="display:none"></div>
					</div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
						<div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_1738979734d1f67b38213ee0f_6824e8aebf" tabindex="-1" value=""></div>
			  </form>
			</div>
		</div>
	</div>
</section>

<?php echo '<script'; ?>
 type='text/javascript' src='//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js'><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type='text/javascript'>

(function($) {window.fnames = new Array(); window.ftypes = new Array();fnames[0]='EMAIL';ftypes[0]='email';fnames[1]='FNAME';ftypes[1]='text';}(jQuery));var $mcj = jQuery.noConflict(true);

<?php echo '</script'; ?>
>
<!--End mc_embed_signup-->
<?php }
}
