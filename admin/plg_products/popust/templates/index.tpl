<script type="text/javascript">
{literal}
	$(document).ready(function(){
		$('#potvrdi').click(function() {
			modify();
		})
	});
{/literal}
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
			<div class="table-responsive">
				<div id="content">
					<form id='inner' action="modify_final.php" method="POST" name="formTable">
						<div class="row">
							<div class="col-lg-12">
								<div class="form-group"><label class="col-sm-2 control-label">Popust za plaćanje karticama</label>
									<div class="col-sm-1"><input name="popust" id="popust" type="text" value="{$popust}" class="form-control"></div><div class="col-sm-1" style="padding: 0;margin: 8px 0px;font-size: larger;">%</div>
									<div class="col-sm-2"><div id="potvrdi" class="btn btn-success">{$PLG_SAVE}</div></div>
									<input name="popustid" id="id" type="hidden" value="{$popustid}" >
								</div>
							</div>
						</div>
					</form>
			</div>
		</div>
	</div>
</div>
