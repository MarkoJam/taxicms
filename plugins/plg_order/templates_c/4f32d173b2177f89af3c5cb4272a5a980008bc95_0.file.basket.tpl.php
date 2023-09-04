<?php
/* Smarty version 3.1.32, created on 2022-10-26 12:05:27
  from 'C:\wamp\www\taxicms\templates\order\basket.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_63590667dfb579_53794504',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4f32d173b2177f89af3c5cb4272a5a980008bc95' => 
    array (
      0 => 'C:\\wamp\\www\\taxicms\\templates\\order\\basket.tpl',
      1 => 1666778094,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:order/checkout.tpl' => 1,
  ),
),false)) {
function content_63590667dfb579_53794504 (Smarty_Internal_Template $_smarty_tpl) {
if ($_smarty_tpl->tpl_vars['orderfinish']->value) {?>
	<?php $_smarty_tpl->_subTemplateRender("file:order/checkout.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
} else { ?>
	<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['ROOT_WEB']->value;?>
includes/js/jquery.validate.js"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
>
	
	$("form").validate();
	$(document).ready(function() {
		//$('#button-submit').click(function() {
	//		$('.login-form').addClass('open');
	//	})
	$('.add').click(function () {
			if ($(this).prev().val() < 100) {
			$(this).prev().val(+$(this).prev().val() + 1);
				$(this).prev().trigger('change');
			}
	});
	$('.sub').click(function () {
			if ($(this).next().val() > 1) {
			if ($(this).next().val() > 1) $(this).next().val(+$(this).next().val() - 1);
				$(this).next().trigger('change');
			}
	});

		$('.deleteproduct').click(function() {
			var id=$(this).attr('data-id');
			var selector='#id'+id;
			$(selector).hide(2000);
			selector=selector+' .quantity';
			$(selector).val(0);
			$(selector).trigger('change');
		})

		$('.quantity').change(function() {
			var kol=$(this).val();
			if (kol<0) $(this).val(0);
			var id=$(this).attr('data-id');
			var url = '<?php echo $_smarty_tpl->tpl_vars['ROOT_WEB']->value;?>
plugins/plg_order/sessionUpdateAjax.php?proizvodid='+id+'&kolicina='+kol;
			update_basket(url);

			var url2 = '<?php echo $_smarty_tpl->tpl_vars['ROOT_WEB']->value;?>
plugins/plg_order/basketUpdateAjax.php';
			$.ajax({
				type: 'GET',
				url: url2,
				async: false,
				success: function(data) {
					$('#order_basket').html(data);
				}
			})
		})

		$('.same_address').click(function() {
			if( $(this).is(':checked')) {
			$(".shipping_body").show();
			$('#shipaddress').val($('#address').val());
			$('#shipcity').val($('#city').val());
			$('#shippostalcode ').val($('#postalcode' ).val());
			$('#shipcountry ').val($('#country' ).val());
			} else {
			$(".shipping_body").hide();
			}
		});
		$('.order-proceed').click(function() {
			$("#orderdata").show();
			$(this).hide();
		});
	})
	
	<?php echo '</script'; ?>
>
	<?php if ($_smarty_tpl->tpl_vars['message_unsucsesfull']->value) {?>
		<p style='color:red;'>Plaćanje je neuspešno, molimo ponovite!</p>
	<?php }?>

	<div class="basket-area">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="entry-header-title">
						<h2>Pregled korpe</h2>
					</div>
				</div>
			</div>

		<?php if ($_smarty_tpl->tpl_vars['editbasket_message']->value != '') {?>
			<div class="basket_message">
				<?php echo $_smarty_tpl->tpl_vars['editbasket_message']->value;?>

			</div>
		<?php }?>
	</div>
		<?php if ($_smarty_tpl->tpl_vars['empty_basket']->value == "false") {?>
		<div class="container">
		<form action="" name="korpaEdit" method="POST" id="form">
				<div class="row">
					<div class="col-lg-12">
							<div class="table-content table-responsive">
									<table class="w-100">
										<thead>
											<tr>
												<th class="product-remove"></th>
												<th class="product-thumbnail"></th>
												<th class="product-name"><?php echo $_smarty_tpl->tpl_vars['PLG_PRODUCT']->value;?>
</th>
												<th class="product-code"><?php echo $_smarty_tpl->tpl_vars['PLG_PRODUCT_CODE']->value;?>
</th>
												<th class="product-price"><?php echo $_smarty_tpl->tpl_vars['PLG_PRODUCT_ORDER_PRICE']->value;?>
</th>
												<th class="product-quantity"><?php echo $_smarty_tpl->tpl_vars['PLG_PRODUCT_ORDER_QUANTITY']->value;?>
</th>
												<th class="product-subtotal"><?php echo $_smarty_tpl->tpl_vars['PLG_PRODUCT_ORDER_TOTAL']->value;?>
</th>
											</tr>
										</thead>
										<tbody>

					<?php
$__section_cnt_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['proizvodi_basket']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_cnt_0_total = $__section_cnt_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_cnt'] = new Smarty_Variable(array());
if ($__section_cnt_0_total !== 0) {
for ($__section_cnt_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] = 0; $__section_cnt_0_iteration <= $__section_cnt_0_total; $__section_cnt_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']++){
?>

					<tr class="row-basket" id='id<?php echo $_smarty_tpl->tpl_vars['proizvodi_basket']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['proizvodid'];?>
'>
						<td class="product-remove">
								<i data-id='<?php echo $_smarty_tpl->tpl_vars['proizvodi_basket']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['proizvodid'];?>
' class="fa fa-times deleteproduct"></i>
						</td>
						<td class="product-thumbnail">
							<?php if ($_smarty_tpl->tpl_vars['proizvodi_basket']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['slika'] == '') {?>
								<img src="<?php echo $_smarty_tpl->tpl_vars['ROOT_WEB']->value;?>
files/Image/product-noimage.png"  />
							<?php } else { ?>
								<img src="<?php echo $_smarty_tpl->tpl_vars['ROOT_WEB']->value;
echo $_smarty_tpl->tpl_vars['proizvodi_basket']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['slikathumb'];?>
" />
							<?php }?>
						</td>
						<td class="product-name">
								<a href='<?php echo $_smarty_tpl->tpl_vars['proizvodi_basket']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['link'];?>
'><?php echo $_smarty_tpl->tpl_vars['proizvodi_basket']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['naziv'];?>
</a>
						</td>
						<td class="product-code">
								<?php echo $_smarty_tpl->tpl_vars['proizvodi_basket']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['sifra'];?>

						</td>
						<td class="product-price"><span class="amount"><?php echo $_SESSION['currency'];?>
 €  <?php echo number_format($_smarty_tpl->tpl_vars['proizvodi_basket']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['cenabasket'],2,",",".");?>
 </span>
							<?php if ($_smarty_tpl->tpl_vars['proizvodi_basket']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['popust'] > 0) {?>
								<?php if ($_smarty_tpl->tpl_vars['proizvodi_basket']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['cenaosnovnab'] > 0) {?>
									<br>€ <?php echo number_format($_smarty_tpl->tpl_vars['proizvodi_basket']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['cenaosnovnab'],2,",",".");?>

								<?php } else { ?>
									<br>€ <?php echo number_format($_smarty_tpl->tpl_vars['proizvodi_basket']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['cenaosnovnaa'],2,",",".");?>

								<?php }?>
								<br><?php echo $_smarty_tpl->tpl_vars['proizvodi_basket']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['popustopis'];?>
 <?php echo number_format($_smarty_tpl->tpl_vars['proizvodi_basket']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['popust'],0,",",".");?>
%
							<?php }?>
						</td>
						<td class="product-quantity">
							<button type="button" id="sub" class="sub"><i class="fa-solid fa-chevron-down"></i></button>
							<input type='text' name='quantity' class='quantity' data-price='<?php echo $_smarty_tpl->tpl_vars['proizvodi_basket']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['cenabasket'];?>
' data-id='<?php echo $_smarty_tpl->tpl_vars['proizvodi_basket']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['proizvodid'];?>
' value='<?php echo $_smarty_tpl->tpl_vars['proizvodi_basket']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['kolicinabasket'];?>
'/>
							<button type="button" id="add" class="add"><i class="fa-solid fa-chevron-up"></i></button>
						</td>
						<input name="proizvod_id" type="hidden" id="proizvod_id" value="<?php echo $_smarty_tpl->tpl_vars['proizvodi_basket']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['proizvodid'];?>
">
						<td id='row_total-<?php echo $_smarty_tpl->tpl_vars['proizvodi_basket']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['proizvodid'];?>
' class="product-subtotal">€  <?php echo number_format($_smarty_tpl->tpl_vars['proizvodi_basket']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['medjuzbirbasket'],2,",",'');?>
</td>
					</tr>
					<?php
}
}
?>
					<tr>
						<td></td>
						<td colspan="5"><?php echo $_smarty_tpl->tpl_vars['PLG_PRODUCT_ORDER_TEXT']->value;?>
 </br><?php echo $_smarty_tpl->tpl_vars['PLG_PRODUCT_ORDER_TEXT2']->value;?>
</td>
						<td class="total-amount">€  <input readonly id='totalprice' class="amount" value='<?php echo number_format($_smarty_tpl->tpl_vars['ukupna_cena']->value,2,",",".");?>
'/></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	</div>
	<div class="row mt-10">
				<div class="col-lg-6 col-md-6 col-12">
					<div class="buttons-cart mb-30">
					  <a href="<?php echo $_smarty_tpl->tpl_vars['ROOT_WEB']->value;
echo $_smarty_tpl->tpl_vars['lang']->value;
echo $_smarty_tpl->tpl_vars['PLG_LINK_PRODUCTS']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['PLG_PRODUCT_ORDER_CONTINUE']->value;?>
</a>
					</div>
							</div>
							<div class="col-lg-6 col-md-6 col-12">
									<div class="wc-proceed-to-checkout">
											<a href="#orderdata" class="order-proceed"><?php echo $_smarty_tpl->tpl_vars['PLG_PRODUCT_ORDER_PROCEED']->value;?>
</a>
									</div>
								</div>
							</div>
	</div>
	<div  id="orderdata" style="display:none;">
	<div class="container" >
	<div class="row">
		<div class="col-lg-12">
			<div class="entry-header-title">
				<h2><?php echo $_smarty_tpl->tpl_vars['PLG_PRODUCT_ORDER_DATA']->value;?>
</h2>
			</div>
		</div>
	</div>
	</div>
	<div class="container order-data" >
	<div class="row">
		<div class="col-lg-6 col-md-6 col-12 ">
				<div class="checkout-form-list">
						<label><?php echo $_smarty_tpl->tpl_vars['PLG_COMPANY']->value;?>
</label>
						<input name="company" type="text" value="<?php echo $_smarty_tpl->tpl_vars['company']->value;?>
">
				</div>
		</div>
		<div class="col-lg-6 col-md-6 col-12">
				<div class="checkout-form-list">
						<label><?php echo $_smarty_tpl->tpl_vars['PLG_PIB']->value;?>
 </label>
						<input name="pib" type="text" value="<?php echo $_smarty_tpl->tpl_vars['pib']->value;?>
">
				</div>
		</div>

			<div class="col-lg-6 col-md-6 col-12 ">
					<div class="checkout-form-list">
							<label><?php echo $_smarty_tpl->tpl_vars['PLG_NAME']->value;?>
</label>
							<input name="name" type="text" value="<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
" required />
					</div>
			</div>
			<div class="col-lg-6 col-md-6 col-12">
					<div class="checkout-form-list">
							<label><?php echo $_smarty_tpl->tpl_vars['PLG_ADDRESS']->value;?>
 </label>
							<input name="address" id="address" type="text" value="<?php echo $_smarty_tpl->tpl_vars['address']->value;?>
" required />
					</div>
			</div>

			<div class="col-lg-6 col-md-6 col-12">
					<div class="checkout-form-list">
							<label><?php echo $_smarty_tpl->tpl_vars['PLG_SURNAME']->value;?>
</label>
							<input name="surname" type="text" value="<?php echo $_smarty_tpl->tpl_vars['surname']->value;?>
" required />
					</div>
			</div>
			<div class="col-lg-6 col-md-6 col-12">
					<div class="checkout-form-list">
							<label><?php echo $_smarty_tpl->tpl_vars['PLG_POSTALCODE']->value;?>
 </label>
							<input name="postalcode" id="postalcode" type="text" value="<?php echo $_smarty_tpl->tpl_vars['postalcode']->value;?>
" required />
					</div>
			</div>
			<div class="col-lg-6 col-md-6 col-12">
					<div class="checkout-form-list">
							<label><?php echo $_smarty_tpl->tpl_vars['PLG_EMAIL']->value;?>
 </label>
							<input name="email" type="email" id="email" value="<?php echo $_smarty_tpl->tpl_vars['email']->value;?>
" required email />
					</div>
			</div>
			<div class="col-lg-6 col-md-6 col-12">
					<div class="checkout-form-list">
							<label><?php echo $_smarty_tpl->tpl_vars['PLG_CITY']->value;?>
 </label>
							<input name="city" id="city" type="text" value="<?php echo $_smarty_tpl->tpl_vars['city']->value;?>
" required />
					</div>
			</div>

			<div class="col-lg-6 col-md-6 col-12">
					<div class="checkout-form-list">
							<label><?php echo $_smarty_tpl->tpl_vars['PLG_PHONE']->value;?>
  </label>
							<input name="phone" type="text" value="<?php echo $_smarty_tpl->tpl_vars['phone']->value;?>
" required />
					</div>
			</div>
			<div class="col-lg-6 col-md-6 col-12">
					<div class="checkout-form-list">
							<label><?php echo $_smarty_tpl->tpl_vars['PLG_STATE']->value;?>
  </label>
							<input name="country" id="country" type="text" value="<?php echo $_smarty_tpl->tpl_vars['country']->value;?>
" required />
					</div>
			</div>
	</div>
	<div class="row">
		<div class="col-12">
			<div class="sameaddress tick d-flex justify-content-start">
				<input type="checkbox" name="sameaddress" class="same_address mt-4 align-self-start" /> <label class="ms-4 mt-3"><?php echo $_smarty_tpl->tpl_vars['PLG_ADDRESS_CHECKED']->value;?>
</label>
			</div>
		</div>
	</div>

	<div class="row shipping_body mt-5" style="display:none;">
			<div class="col-lg-6 col-md-6 col-12">
					<div class="checkout-form-list">
							<label><?php echo $_smarty_tpl->tpl_vars['PLG_ADDRESS']->value;?>
 </label>
							<input name="shipaddress" id="shipaddress" type="text" value="<?php echo $_smarty_tpl->tpl_vars['shipaddress']->value;?>
">
					</div>
			</div>
			<div class="col-lg-6 col-md-6 col-12">
					<div class="checkout-form-list">
							<label><?php echo $_smarty_tpl->tpl_vars['PLG_POSTALCODE']->value;?>
 </label>
							<input name="shippostalcode" id="shippostalcode" type="text" value="<?php echo $_smarty_tpl->tpl_vars['shippostalcode']->value;?>
">
					</div>
			</div>
			<div class="col-lg-6 col-md-6 col-12">
					<div class="checkout-form-list">
							<label><?php echo $_smarty_tpl->tpl_vars['PLG_CITY']->value;?>
</label>
							<input name="shipcity" id="shipcity" type="text" value="<?php echo $_smarty_tpl->tpl_vars['shipcity']->value;?>
">
					</div>
			</div>
			<div class="col-lg-6 col-md-6 col-12">
					<div class="checkout-form-list">
							<label><?php echo $_smarty_tpl->tpl_vars['PLG_STATE']->value;?>
  </label>
							<input name="shipcountry" id="shipcountry" type="text" value="<?php echo $_smarty_tpl->tpl_vars['shipcountry']->value;?>
">
					</div>
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<div class="gdpr-click d-flex">
					<input type="checkbox" class="checkbox gdpr mt-4 align-self-start" id="agree" name="agree" required  />
				<label class="ms-4 mt-3"><?php echo $_smarty_tpl->tpl_vars['PLG_CONTACT_INFO']->value;?>
</label>
			</div>
		</div>
		<div class="col-12">
			<input type="submit" value="<?php echo $_smarty_tpl->tpl_vars['PLG_PRODUCT_ORDER_FINISH']->value;?>
" name="order_finish" id="order_finish" />
		</div>
	</div>
				<input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['order_type']->value;?>
" name="order_type" id="order_type" />
				<input type="hidden" value="<?php echo $_SERVER['QUERY_STRING'];?>
" name="backurl" id="backurl" />
			</form>
			</div>
		</div>
		<?php } else { ?>
		<div class="container">
			<p class="korpa">Dear customer, <br> shopping cart is empty</p>
		</div>
		<?php }?>
	</div>
<?php }
}
}
