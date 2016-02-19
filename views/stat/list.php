{extends file="template.php"}
{block name=body}
<h3>Stat</h3>
<div>
	<div>
		<form>
			<div class="row">
				<div class="col-md-3 form-group">
					<label>Month</label>
					<select class="form-control" name="month">
						<option value="">-All-</option>
						<option {if $form.month=='1'}selected{/if}>1</option>
						<option {if $form.month=='2'}selected{/if}>2</option>
						<option {if $form.month=='3'}selected{/if}>3</option>
						<option {if $form.month=='4'}selected{/if}>4</option>
						<option {if $form.month=='5'}selected{/if}>5</option>
						<option {if $form.month=='6'}selected{/if}>6</option>
						<option {if $form.month=='7'}selected{/if}>7</option>
						<option {if $form.month=='8'}selected{/if}>8</option>
						<option {if $form.month=='9'}selected{/if}>9</option>
						<option {if $form.month=='10'}selected{/if}>10</option>
						<option {if $form.month=='11'}selected{/if}>11</option>
						<option {if $form.month=='12'}selected{/if}>12</option>
					</select>
				</div>
				<div class="col-md-3 form-group">
					<label>Year</label>
					<select class="form-control" name="year">
						<option value="">-All-</option>
						<option {if $form.year=='2015'}selected{/if}>2015</option>
						<option {if $form.year=='2016'}selected{/if}>2016</option>
					</select>
				</div>
				<div class="col-md-3 form-group">
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
				<th>Picture</th>
				<!-- <th>Thumb</th> -->
				<th>Size</th>
				<th>Type</th>
				<th>Company</th>
				<th>Price</th>
				<th>Total View</th>
				<th>Total Add</th>
			</tr>
		</thead>
		<tbody>
			{foreach key=key item=item from=$items}
			<tr>
				<td>{$item.id}</td>
				<td>{$item.code}</td>
				<td>{$item.name}</td>
				<td><img src="upload/{$item.picture}" width="80" height="60"></td>
				<!-- <td><img src="upload/{$item.thumb}" width="80" height="60"></td> -->
				<td>{$item.size} (inch)</td>
				<td>{$item.type}</td>
				<td>{$item.company}</td>
				<td>{$item.price}</td>
				<td>{$item.total_view}</td>
				<td>{$item.total_add}</td>
			</tr>
			{/foreach}
		</tbody>
	</table>
	<ul class="pagination">
    {if $page gt 1}
    <li>
      <a href="{siteUrl url="/stat"}?{$form|@http_build_query:"_var1"}&page={$page-1}" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
      </a>
    </li>
    {/if}
    {for $i=1 to $maxPage}
    <li><a href="{siteUrl url="/stat"}?{$form|@http_build_query:"_var1"}&page={$i}">{$i}</a></li>
    {/for}
    {if $maxPage gt $page}
    <li>
      <a href="{siteUrl url="/stat"}?{$form|@http_build_query:"_var1"}&page={$page+1}" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
      </a>
    </li>
    {/if}
  </ul>
</div>
{/block}
