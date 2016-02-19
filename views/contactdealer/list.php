{extends file="template.php"}
{block name=body}
<h3>Contact Dealer</h3>
<div>
	<div>
		<a href="{siteUrl url="/contactdealer/add"}" class="btn btn-info">
			<i class="glyphicon glyphicon-plus-sign"></i> เพิ่ม
		</a>
	<div>
	<table class="table">
		<thead>
			<tr>
				<th>#</th>
				<th>Name</th>
				<th>Phone</th>
				<th>Province</th>
				<th>Geography</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			{foreach key=key item=item from=$items}
			<tr>
				<td>{$item->id}</td>
				<td>{$item->name}</td>
				<td>{$item->phone}</td>
				<td>{$item->ownProvince.province_name}</td>
				<td>{$item->ownGeography.geo_name}</td>
				<td>
					<a href="{siteUrl url="/contactdealer/edit/{$item->id}"}"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
					<a class="confirm-beforeclick" href="{siteUrl url="/contactdealer/delete/{$item->id}"}"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
				</td>
			</tr>
			{/foreach}
		</tbody>
	</table>
	<ul class="pagination">
    {if $page gt 1}
    <li>
      <a href="{siteUrl url="/contactdealer?page={$page-1}"}" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
      </a>
    </li>
    {/if}
    {for $i=1 to $maxPage}
    <li><a href="{siteUrl url="/contactdealer?page=$i"}">{$i}</a></li>
    {/for}
    {if $maxPage gt $page}
    <li>
      <a href="{siteUrl url="/contactdealer?page={$page+1}"}" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
      </a>
    </li>
    {/if}
  </ul>
</div>
<script>

</script>
{/block}
