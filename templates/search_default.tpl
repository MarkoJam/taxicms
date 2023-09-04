

<!-- Modal -->
<div class="modal fade" id="search" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog container" role="document">
    <div class="modal-content">
      <div class="modal-header">

        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
           <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
				<form action="{$link_search}" method="POST" >
					<input class="search-input" placeholder="{$PLG_SEARCH_KEYWORD}" type="text" value="" name="search_text" id="search">
					<input class="search-submit" type="submit" name="trazi" id="trazi" value="{$PLG_SEARCH_FIND}">
				</form>
      </div>

    </div>
  </div>
</div>
