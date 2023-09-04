<script type="text/javascript" language="javascript1.2">
{literal}
	function modify_plugin() {
	}
{/literal}		
</script>
	
<div id="content">
	<form id='inner' name="editcategory" action="modify_final.php" method="post" enctype="multipart/form-data">
		<div class="row wrapper  page-heading">
			<div class="col-lg-8">
				<h2 id="modi_title"></h2>
			</div>
			<div class="col-lg-4">
				<div class="title-action">
					<div name="promeni" id="promeni" class="btn btn-primary "><i class="fa fa-check"></i>&nbsp;{$PLG_SAVE}</div>
					<div class="btn btn-default close-modal" type="button"><i class="fa fa-times"></i>&nbsp;{$PLG_CLOSE}</div>
				</div>
			</div>
		</div>   	
		{section name=tnc loop=$settingCovering}
			{assign var="tmpvar" value=$settingCovering[tnc].settingcoverid}
				{if !empty($setting[$tmpvar])}
					<h2>{$settingCovering[tnc].value}</h2>
				{/if}
				{assign var=grpname value=""}
				{* deo koji crta postavke trenutne oblasti *}
				{section name=cnt loop=$setting[$tmpvar]}
					{if  $grpname neq $setting[$tmpvar][cnt].settinggroupname and $field_open}
						{assign var=field_open value=false}
			    		</fieldset>
			    	{/if}
					{if $grpname neq $setting[$tmpvar][cnt].settinggroupname}
						{assign var=grpname value=$setting[$tmpvar][cnt].settinggroupname}
						<fieldset class="inlineLabels"><legend>{$setting[$tmpvar][cnt].settinggroupname}
						{assign var=field_open value=true}</legend>
					{/if}
					
					<div class="ctrlHolder {$name_error}">
						{if $name_error_message}
					    	<p id="error1" class="errorField"><strong> {$setting[$tmpvar][cnt].description} </strong></p>
					    {/if}
					    	
							<label for="{$setting[$tmpvar][cnt].name}"> <em>*</em> {$setting[$tmpvar][cnt].description}: </label>
							{if $setting[$tmpvar][cnt].ctrltype eq "combobox"}		
							<select name="VALUE_{$setting[$tmpvar][cnt].name}" id="VALUE_{$setting[$tmpvar][cnt].name}" >
								{$setting[$tmpvar][cnt].output}
							</select>
							{/if}
							{if $setting[$tmpvar][cnt].ctrltype eq "input"}
								<input name="VALUE_{$setting[$tmpvar][cnt].name}" id="VALUE_{$setting[$tmpvar][cnt].name}" value="{$setting[$tmpvar][cnt].output}" size="35" maxlength="50" 
									type="{if $setting[$tmpvar][cnt].name ne 'CONTACT_MAIL_PASSWORD'}text{else}password{/if}" 
									class="textInput" />
							{/if}
					</div>
			    	{assign var=grpname value=$setting[$tmpvar][cnt].settinggroupname}
			{/section}
			{if $field_open}
				{assign var=field_open value=false}
			    </fieldset>
			{/if}
		{/section}
		</br>
		<input type="hidden" value="modify_final" name="action" />
		<input type="hidden" value="{$pluginmoduleid}" name="pluginmoduleid" />
	</form>
				
</div>

