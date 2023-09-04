<script>

		$('#sbm').click(function() {
			var book = $('#dokument').val();
			var sheet = $('#sheet').val();
			var param = 'book='+book+'&sheet='+sheet;
			$('#alink').attr('data-param',param);
			$('#alink').trigger('click');
		})

</script>

<div class="ibox float-e-margins">
	<div class="ibox-title">
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
		<div class="row">
            <div class="col-lg-12">
				<div class="panel-body">

				<form name="editproizvod" action="plg_products/sinhronizacija/modify.php" method="post" enctype="multipart/form-data">
					<div class="form-group row">
						<label class="col-sm-2 control-label">{$PLG_BOOK_NAME}</label>
						<div class="col-sm-8"><input id="dokument" name="book" type="text" value="{$dokument}" class="form-control"></div>
						<div class="col-sm-2"><a class="btn btn-success" href="javascript:BrowseFileServer(this);"><i class="fa fa-plus-square-o" ></i> {$PLG_ADD}</a>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 control-label">{$PLG_SHEET_NAME}</label>
								<div class="col-sm-10"><input name="sheet" type="text" id='sheet' value="lagerlista"  class="form-control"></div>
					</div>
					<div class="form-group row sinhro">
						<div class="col-sm-12">
						<a style="display:none" class="naziv" id='alink' data-link="modify.php" >{$PLG_IMPORT_EXCEL}</a>
						<button type="button" id="sbm"  class="btn btn-default" >{$PLG_IMPORT_EXCEL}</button>
					</div>

				</form>
				</div>
			</div>
		</div>
	</div>
</div>
