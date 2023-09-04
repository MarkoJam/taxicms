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
						<table class="tablemodify">
							<tr>
								<td>{$PLG_EXRATE}<input name="kurs" id="kurs" type="text" value="{$kurs}" class="form-control"><input name="kursid" id="kursid" type="hidden" value="{$kursid}" ></td>
								<td colspan=4><div id="potvrdi" class="btn btn-success">{$PLG_SAVE}</div></td>
							</tr>
						</table>
					</form>
			</div>
		</div>
	</div>
</div>