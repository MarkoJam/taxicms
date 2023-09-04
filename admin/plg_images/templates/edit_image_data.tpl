<div class="image-modal">
	<div class="modal inmodal fade" id="myModal7" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title">{$PLG_IMAGE_ATTR}</h4>
				</div>
				<div class="modal-body">
					<div class="form-group"><label>{$PLG_IMAGE_TITLE}</label><textarea type="text" id='image-title' name="image-title"  class="form-control" placeholder="{$PLG_IMAGE_TITLE}">{$image}</textarea></div>
					<div class="form-group"><label>{$PLG_IMAGE_ALT}</label><input type="text" id='description' name="description" value="{$description}" class="form-control" placeholder="{$PLG_IMAGE_ALT}"></div>	
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-white" id="close_pass" data-dismiss="modal">{$PLG_CLOSE}</button>
					<button type="button" name="promeni" id="promeni"  class="btn btn-primary">{$PLG_SAVE}</button>
				</div>
				<input id='url' value='' type='hidden'>
			</div>
		</div>
	</div>
</div>