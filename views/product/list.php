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
					<select class="form-control">
						<option value="">-All-</option>
						<option value="1">Floor titles</option>
						<option value="2">Wall titles</option>
						<option value="3">Mosaic</option>
						<option value="4">Porcelain</option>
					</select>
				</div>
				<div class="col-md-3 form-group">
					<label>Size</label>
					<select class="form-control">
						<option value="">-All-</option>

						<option value="1">8x8</option>
						<option value="2">12x12</option>
						<option value="3">13x13</option>
						<option value="4">16x16</option>
						<option value="2">50x50</option>
						<option value="2">60x60</option>

						<option value="1">8x10</option>
						<option value="2">8x12</option>
						<option value="3">8x16</option>
						<option value="4">10x16</option>
						<option value="1">30x60</option>
					</select>
				</div>
				<div class="col-md-3 form-group">
					<label>Style</label>
					<select class="form-control">
						<option value="">-All-</option>
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
					</select>
				</div>
				<div class="col-md-3 form-group">
					<label>Company</label>
					<select class="form-control">
						<option value="">-All-</option>
						<option value="1">Company 1</option>
						<option value="2">Company 2</option>
					</select>
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
				<th>Picture</th>
				<th>Thumb</th>
				<th>Size</th>
				<th>Style</th>
				<th>Type</th>
				<th>Company</th>
				<th>Price</th>
				<th>Hot</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			{foreach key=key item=item from=$items}
			<tr>
				<td>{$item->id}</td>
				<td>{$item->code}</td>
				<td>{$item->name}</td>
				<td><img src="upload/{$item->picture}" width="80" height="60"></td>
				<td><img src="upload/{$item->thumb}" width="80" height="60"></td>
				<td>{$item->size}</td>
				<td>{$item->style}</td>
				<td>{$item->type}</td>
				<td>{$item->company}</td>
				<td>{$item->price}</td>
				<td>{$item->is_hot}</td>
				<td>
					<a href="{siteUrl url="/product/edit/{$item->id}"}"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
					<a class="confirm-beforeclick" href="{siteUrl url="/product/delete/{$item->id}"}"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
				</td>
			</tr>
			{/foreach}
		</tbody>
	</table>
	<ul class="pagination">
    {if $page gt 1}
    <li>
      <a href="{siteUrl url="/product?page={$page-1}"}" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
      </a>
    </li>
    {/if}
    {for $i=1 to $maxPage}
    <li><a href="{siteUrl url="/product?page=$i"}">{$i}</a></li>
    {/for}
    {if $maxPage gt $page}
    <li>
      <a href="{siteUrl url="/product?page={$page+1}"}" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
      </a>
    </li>
    {/if}
  </ul>
</div>
<script>

</script>
{/block}
