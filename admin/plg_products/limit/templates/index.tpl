<script>
{literal}
	function table_plugin() {	
	}
{/literal}
</script>
<div class="ibox float-e-margins">
	<div class="ibox-title">
		<h5>Ažuriranje limita za poštarine</h5>
		<div class="ibox-tools">
			<a class="collapse-link">
					<i class="fa fa-chevron-up"></i>
			</a>
			<a class="fullscreen-link">
                <i class="fa fa-expand"></i>
            </a>
			<a class="close-link">
				<i class="fa fa-times"></i>
			</a>
		</div>
	</div>

	<div class="ibox-content">
			<div class="table-responsive">
				<div id="content">

				<form action="modify_final.php" method="POST" name="formTable">
					<table class="tablemodify">
						<tr>
							<td>Limit: <input name="price" id="price" type="text" value="{$price}" class="form-control"><input name="priceid" id="priceid" type="hidden" value="{$priceid}"></td>

						<td><input type="submit" value="Potvrdi promenu" name="submit" id="submit" class="btn btn-default"></td>
						</tr>
					</table>
				</form>
			</div>
		</div>
	</div>
</div>