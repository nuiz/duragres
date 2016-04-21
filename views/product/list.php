{extends file="template.php"}
{block name=body}
<h3>Product</h3>
<div>
	<div>
		<a href="{siteUrl url="/product/add"}" class="btn btn-info">
			<i class="glyphicon glyphicon-plus-sign"></i> เพิ่ม
		</a>
	<div>
	<div>
		<form>
			<div class="row">
				<div class="col-md-3 form-group">
					<label>Type</label>
					<select class="form-control chain-master" name="type" data-chain-name="type-size">
						<option value="">-All-</option>
						<option {if $form.type=='Floor Tiles'}selected{/if}>Floor Tiles</option>
						<option {if $form.type=='Wall Tiles'}selected{/if}>Wall Tiles</option>
						<option {if $form.type=='Mosaic'}selected{/if}>Mosaic</option>
						<option {if $form.type=='Porcelain'}selected{/if}>Porcelain</option>
					</select>
				</div>
				<div class="col-md-3 form-group">
					<label>Size (inch)</label>
					<select class="form-control chian-child" name="size" data-chain-name="type-size">
						<option value="">-Please Select-</option>

						<option data-chain-value="Floor Tiles" value="8x8">8x8 inch</option>
						<option data-chain-value="Floor Tiles" value="12x12">12x12 inch</option>
						<option data-chain-value="Floor Tiles" value="13x13">13x13 inch</optionh>
						<option data-chain-value="Floor Tiles" value="16x16">16x16 inch</option>
						<option data-chain-value="Floor Tiles" value="30x60">30x60 cm</option>
						<option data-chain-value="Floor Tiles" value="50x50">50x50 cm</option>
						<option data-chain-value="Floor Tiles" value="60x60">60x60 cm</option>


						<option data-chain-value="Wall Tiles" value="8x10">8x10 inch</option>
						<option data-chain-value="Wall Tiles" value="8x12">8x12 inch</option>
						<option data-chain-value="Wall Tiles" value="8x16">8x16 inch</option>
						<option data-chain-value="Wall Tiles" value="10x16">10x16 inch</option>
						<option data-chain-value="Wall Tiles" value="30x60">30x60 cm</option>

						<option data-chain-value="Mosaic" value="30x30">30x30 inch</option>

						<option data-chain-value="Porcelain" value="15x60">15x60 cm</option>
						<option data-chain-value="Porcelain" value="20x60">20x60 cm</option>
						<option data-chain-value="Porcelain" value="30x60">30x60 cm</option>
						<option data-chain-value="Porcelain" value="40x60">40x60 cm</option>
						<option data-chain-value="Porcelain" value="60x60">60x60 cm</option>

					</select>
				</div>
				<div class="col-md-3 form-group hidden">
					<label>Style</label>
					<select class="form-control" name="style">
						<option value="">-All-</option>
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
					</select>
				</div>
				<div class="col-md-3 form-group">
					<label>Company</label>
					<select class="form-control" name="company">
						<option value="">-All-</option>
						<option {if $form.company=='Duragres'}selected{/if}>Duragres</option>
						<option {if $form.company=='Cergres'}selected{/if}>Cergres</option>
					</select>
				</div>
				<div class="col-md-3 form-group">
					<label>Style</label>
					<input type="text" class="form-control" name="style" value="{$form.style}" placeholder="">
				</div>
				<div class="col-md-12 form-group">
					<label style="opacity: 0;">submit</label>
					<button type="submit" class="form-control btn btn-info">Filter</button>
				</div>
			</div>
		</form>
	</div>
	<table class="table">
		<thead>
			<tr>
				<th>#</th>
				<th>Code</th>
				<th>Name</th>
				<th>Name Eng</th>
				<th>Picture</th>
				<!-- <th>Thumb</th> -->
				<th>Size</th>
				<th>Type</th>
				<th>Company</th>
				<th>Price</th>
				<th>Hot</th>
				<th>New</th>
				<th>Group</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			{foreach key=key item=item from=$items}
			<tr>
				<td>{$item.id}</td>
				<td>{$item.code}</td>
				<td>{$item.name}</td>
				<td>{$item.name_eng}</td>
				<td><img src="upload/{$item.picture}" width="80" height="60"></td>
				<!-- <td><img src="upload/{$item.thumb}" width="80" height="60"></td> -->
				<td>{$item.size} ({$item.size_unit})</td>
				<td>{$item.type}</td>
				<td>{$item.company}</td>
				<td>{$item.price}</td>
				<td>{if $item.is_hot}<span class="badge" style="background: rgb(240, 154, 25);">Hot</span>{/if}</td>
				<td>{if $item.is_new}<span class="badge" style="background: rgb(240, 77, 25);">New</span>{/if}</td>
				<td>{if $item.is_group}<span class="badge" style="background: rgb(240, 77, 25);">Group</span>{/if}</td>
				<td>
					<a href="{siteUrl url="/product/edit/{$item.id}"}"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
					<a class="confirm-beforeclick" href="{siteUrl url="/product/delete/{$item.id}"}"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
				</td>
			</tr>
			{/foreach}
		</tbody>
	</table>
	<ul class="pagination">
    {if $page gt 1}
    <li>
      <a href="{siteUrl url="/product"}?{$form|@http_build_query:"_var1"}&page={$page-1}" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
      </a>
    </li>
    {/if}
    {for $i=1 to $maxPage}
    <li><a href="{siteUrl url="/product"}?{$form|@http_build_query:"_var1"}&page={$i}">{$i}</a></li>
    {/for}
    {if $maxPage gt $page}
    <li>
      <a href="{siteUrl url="/product"}?{$form|@http_build_query:"_var1"}&page={$page+1}" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
      </a>
    </li>
    {/if}
  </ul>
</div>
<script>
$(function(){
	var formType = "{$form.type}";
	var formSize = "{$form.size}";

	$('.chain-master').change(function(e){
		var name = $(this).data('chain-name');
		var $childSelect = $('.chian-child[data-chain-name="'+name+'"]');
		var value = $(this).val();

		$childSelect.val("");
		$('option', $childSelect).hide()
			.filter('[data-chain-value="'+value+'"], [value=""]').show();
	});

	 $('.chain-master').change();
	 $('option[data-chain-value="'+formType+'"][value="'+formSize+'"]').prop("selected", true);
});
</script>
{/block}
