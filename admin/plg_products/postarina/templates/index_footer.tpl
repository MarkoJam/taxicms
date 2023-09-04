		
		<tr >
			<td colspan=4><p>&nbsp;</p></td>
		</tr>
		<tr >
			<td colspan=4><div class="btn btn-success new_pos"><i class="fa fa-plus-square-o" ></i> {$PLG_ADD_RANGE}</div></td>
		</tr>
		<tr class="new_pos_show">
			<td><input name="{$pi}" size="7" type="text" value="{$priceid}" disabled></td>
			<td><input name="{$wf}" size="3" type="text" value="{$weightfrom}" ></td>
			<td><input name="{$wt}" size="3" type="text" value="{$weightto}" ></td>
			<td><input name="{$npp}" size="5" type="text" value="{$postprice}" ></td>
			
		</tr>
		<tr>
		   <div class="form-group post"><label class="col-sm-2 control-label">{$PLG_POST_PRICE_LIMIT}</label>
				<div class="col-sm-8">
					<input name="price" class="form-control" type="text" value="{$price}" ><input name="priceid2" id="priceid" type="hidden" value="{$priceid}">
				</div>
			</div>		
		</tr>	
		<tr>
			<td colspan=4><div id="potvrdi" class="btn btn-success">{$PLG_SAVE}</div></td>
		</tr>
	</table>
</form>
</div>
