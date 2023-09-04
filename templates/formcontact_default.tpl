<link href="{$ROOT_WEB}admin/css/plugins/toastr/toastr.min.css" rel="stylesheet">
<script src="{$ROOT_WEB}includes/js/jquery.validate.js"></script>
<script type="text/javascript" >
	{literal}

	// provera formata e-mail-a
	function isEmail(email) {
	  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	  return regex.test(email);
	}
	$(document).ready(function()
	{
		// dogadjaji nad input poljima
		window.error=1;
		$('#forma input,textarea').change(function() {
			$(this).parent().children('.message').remove();
			// provera da li su sva polja uneta
			window.error=0;
			$('#forma input,textarea').each(function() {
				var value= $(this).val();
				var name= $(this).attr('name');
				if(!$.trim(this.value).length && name !='g-recaptcha-response')  window.error=1;
			});
			// provera ispravnosti unosa za polja pod posebnom proverom (e-mail)
			if (window.error==0) {
				if (!(isEmail($('#forma #email').val())) ) window.error=2;
			}
		});
		$('#promeni').click(function() {
			if (window.error==0) {
				var param = $( "form" ).serialize();
				var link = '{/literal}{$ROOT_WEB}{literal}plugins/plg_formcontact/formcontactSend.php'
				$.ajax({
					type: "POST",
					url: link,
					data: param,
					success: function(data) {
						if (data=="OK") {
							$('.controls').remove();
							var msg= $("#msg1").text();
							var html = "<div class='message3'>"+msg+"</div>";
							//$('#forma').append(html);
							window.location.href='{/literal}{$ROOT_WEB}{$lang}{literal}/adminpage/contact_success/1';
						}
						else {
							console.log("Fail");
							var msg= $("#msg4").text();
							var html = "<div class='message2'>"+msg+"</div>";
							$('#forma .g-recaptcha').append(html);

						}
					}
				})
			}

			$('#forma input,textarea').each(function() {
				$(this).parent().children('.message').remove();
			})

			if (window.error==1) {
				console.log('eror na poljima');
				$('#forma input,textarea.textInput').each(function() {
					var value= $(this).val();
					if(!$.trim(this.value).length) {
						var ma=$(this).parent().children('label').text();
						var msg= $("#msg2").text();
						var html = "<div class='message'>"+msg+" "+ma+"</div>";
						$(this).parent().append(html);
						$('.message').hide().show('slow');
					};
				});
			}
			if (window.error==2) {
				var msg= $("#msg3").text();
				var html = "<div class='message'>"+msg+"</div>";
				$('#forma #email').parent().append(html);
				$('.message').hide().show('slow');
			}
		})

	})
	{/literal}
	</script>
<div class="contact-form">
<div class="container contact-form-wrapper">
	<div class="row">
		<div class="col-lg-6 itemheight" style="background:url({$ROOT_WEB}files/Image/contact/contact-back.jpg) center / cover;">
		</div>
		<div class="col-lg-6 itemheight ps-lg-10">
			<h3>{$PLG_CONTACT}</h3>
						<form  method="POST" id="forma" name="forma" class="uniForm">
              <div class="messages"></div>
							<div class="controls">
										<div class="name checkout-form-list">
											<label>{$PLG_NAME}</label>
                      <input name="name" id="name" value="{$name}" class="contact-form"  required="required" data-error="Firstname is required.">
                                        <div class="help-block with-errors"></div>
										</div>
										<div class="surname checkout-form-list">
											<label>{$PLG_SURNAME}</label>
                      <input name="surname" id="surname" value="{$surname}" class="contact-form"  required="required" data-error="Firstname is required.">
                                        <div class="help-block with-errors"></div>
										</div>

										<div class="email checkout-form-list">
											<label>{$PLG_EMAIL}</label>
                        <input name="email" id="email" value="{$email}" class="contact-form"  required="required" data-error="Valid email is required.">
                                        <div class="help-block with-errors"></div>
										</div>
										<div class="subject checkout-form-list">
											<label>{$PLG_SUBJECT}</label>
                        <input name="subject" id="subject" value="{$subject}" class="contact-form"  required="required" data-error="Valid subject is required.">
                                        <div class="help-block with-errors"></div>
										</div>

										<div class="question checkout-form-list">
											<label>{$PLG_MESSAGE}</label>
                          <textarea name="question" id="question" value="{$question}" class="contact-form"  rows="4" required="required" data-error="Please,leave us a message."></textarea>
                                        <div class="help-block with-errors"></div>
										</div>
										<div class=" tick d-flex justify-content-start">
										<input type="checkbox" name="sameaddress" class="same_address mt-4 align-self-start" required /> <label class="contact-form-info">{$PLG_CONTACT_INFO}</label>
										</div>

                      <input type="button" name="promeni" id="promeni" class="buttons-contact" value="{$PLG_SUBMIT}">
											<input type="hidden" name="recaptcha_response" id="recaptchaResponse">

									{*<div class="wrap-recaptcha"><div class="g-recaptcha" id="recaptcha"></div></div>*}
							</div>
						</form>
					</div>
				</div>
			</div>
</div>

{if $dkey3}
<script src="https://www.google.com/recaptcha/api.js?render={$dkey3}"></script>
<script>
	 {literal}
			 grecaptcha.ready(function () {
					 grecaptcha.execute('{/literal}{$dkey3}{literal}', { action: 'submit' }).then(function (token) {
							 var recaptchaResponse = document.getElementById('recaptchaResponse');
							 recaptchaResponse.value = token;
					 });
			 });
		{/literal}
	 </script>
{/if}

	<div id='msg1' style="display:none">{$PLG_SUCCESS_CONTACT}</div>
	<div id='msg2' style="display:none">{$PLG_NOINPUT}</div>
	<div id='msg3' style="display:none">{$PLG_WRONG_EMAIL}</div>
	<div id='msg4' style="display:none">{$PLG_NORECAPTCHA}</div>
