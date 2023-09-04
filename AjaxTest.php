
Test Ajax Poziva
<head>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-migrate/3.3.0/jquery-migrate.min.js" integrity="sha256-lubBd1CVmtB9FHh+c1CWkr4jCSiszGj7bhzWPpNgw1A=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" integrity="sha256-KM512VNnjElC30ehFwehXjx1YCHPiQkOPmqnrWtpccM=" crossorigin="anonymous"></script>
</head>
<body>
	<form>
		Uneti tekst malim slovima<input name='test' id='test' />
		Rezultat iz AJAX-a (Ajax konvertuje u velika slova)<input id='test2' />
	</form>	
</body>
<script>
	$('#test').change(function(){
		
		var link='http://localhost/taxicms/AjaxTest2.php';
		var param=$('form').serialize();
		console.log(link+'?'+param)
		$.ajax({
			type : 'POST',
			url : link,
			data : param,
			success: function(data) {
				$('#test2').val(data);
			},			
			false: function(data) {
				$('#test2').val('Nema odgovora od AJAX skripte');
			}
		})		
	})	
</script>
