<script>
{literal}
	function table_plugin() {
		move_rows();
		// Collapse ibox function
				$('.collapse-link').on('click', function () {
					var ibox = $(this).closest('div.ibox');
					var button = $(this).find('i');
					var content = ibox.children('.ibox-content1');
					content.slideToggle(200);
					button.toggleClass('fa-chevron-up').toggleClass('fa-chevron-down');
					ibox.toggleClass('').toggleClass('border-bottom');
					setTimeout(function () {
						ibox.resize();
					}, 50);
				});
	}
{/literal}
</script>

<div class="ibox float-e-margins">
	<div class="ibox-title">
		<h5>{$PLG_POSITION}&nbsp;<strong>{$tbl_title}</strong></h5>
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
		<div class="html5buttons">
			<div class="dt-buttons btn-group">
					<a class="btn btn-info buttons-html5" tabindex="0" href="{$ModifyScript}?parent=1&page_id={$page_id}">
						<i class="fa fa-paste"></i> <span>{$PLG_MODIFY} / {$PLG_PAGES}</span>
					</a>
					<a class="btn btn-success buttons-html5" tabindex="0" href="modify_grp.php?parent_id={$page_id}&pagetypeid={$smarty.const.PAGE_TYPE_PAGE}">
						<i class="fa fa-file-text-o" ></i> <span>{$PLG_ADD} / {$PLG_PAGES}</span>
					</a>
					<a class="btn btn-success buttons-html5" tabindex="0" href="modify_categ.php?parent_id={$page_id}&pagetypeid={$smarty.const.PAGE_TYPE_CATEGORY}">
						<i class="fa fa-folder-open-o" aria-hidden="true"></i> <span>{$PLG_ADD} / {$PLG_CATEGORY}</span>
					</a>
					<a class="btn btn-success buttons-html5" tabindex="0"  href="modify_link.php?parent_id={$page_id}&pagetypeid={$smarty.const.PAGE_TYPE_LINK}">
						<i class="fa fa-link" aria-hidden="true"></i> <span>{$PLG_ADD} / {$PLG_LINKS}</span>
					</a>
			</div>
		</div>
		<div class="table-responsive">
		{if $page_id neq ""}
			<div id="content">
				{html_table_advanced
					filter=$filter		  
					cnt_all_rows=$tbl_all_rows_count
					browseString=$tbl_browseString
					scriptName=$scriptName
					cnt_rows=$tbl_row_count
					rowOffset=$tbl_offset
					tr_attr=$tbl_tr_attributes
					td_attr=$tbl_td_attributes
					loop=$tbl_content
					cols=$tbl_cols_count
					tableheader=$tbl_header
					exportlinks=$tbl_show_export_links
					table_attr='cellspacing=0 class="index" id="normal"'
					message=$poruka
				}
				<input type="hidden" value="{$page_id}" name="page_id"/>

			</div>
		{/if}
		</div>
	</div>
</div>
