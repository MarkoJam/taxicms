<html>
<head>
<title>{$SITE_NAME} - {$header}</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="robots" content="noindex, nofollow" />
<meta name="googlebot" content="noindex, nofollow" />
</head>
<body onLoad="window.print()">

<h2>{$PLG_INVOICE}: {$invoice.invoiceid} / {$invoice.date|date_format:"%d.%m.%Y."}</h2>

<h2>{$user.firm}</h2>
<p>{$user.address}-{$user.place}</p>
<p>{$PLG_TAXID}: {$user.pib}</p>
<p>{$PLG_REGNO}: {$user.matbr}</p>

	<table width="100%"  border="0" cellpadding="5" cellspacing="0" class="table-bordered">
		<tbody>
			<tr>
				<th>{$PLG_CODE} {$PLG_NAME}</th>
				<th>{$PLG_QUANTITY}</th>
				<th>{$PLG_PRICE}</th>
				<th>{$PLG_VALUE}</th>
				
			</tr>
			{section name=pom loop=$items}
			<tr>
				<td>{$items[pom].productcode} {$items[pom].productname}</td>
				<td>{$items[pom].quantity}</td>
				<td>{$items[pom].price}</td>
				<td>{$items[pom].amount|number_format:2:",":""}</td>
			</tr>
			{/section}
			<tr>
				<td>{$PLG_TOTAL}:</td>
				<td></td>
				<td></td>
				<td>{$invoice.amount|number_format:2:",":""}</td>
			</tr>			
		</tbody>
	</table>
</body>
</html>