{extends file="template.php"}
{block name=body}
<h3>Menu</h3>
<div>
	<table class="table">
		<thead>
			<tr>
				<th>#</th>
				<th>Menu</th>
				<th>Name</th>
				<th>Picture</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			{foreach key=key item=item from=$items}
			<tr>
				<td>{$item->id}</td>
				<td>{$item->menu}</td>
				<td>{$item->name}</td>
				<td><img src="upload/{$item->picture}" width="80" height="60"></td>
				<td>
					<a href="{siteUrl url="/menu/edit/{$item->id}"}"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
				</td>
			</tr>
			{/foreach}
		</tbody>
	</table>
	<ul class="pagination">
    {if $page gt 1}
    <li>
      <a href="{siteUrl url="/menu?page={$page-1}"}" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
      </a>
    </li>
    {/if}
    {for $i=1 to $maxPage}
    <li><a href="{siteUrl url="/menu?page=$i"}">{$i}</a></li>
    {/for}
    {if $maxPage gt $page}
    <li>
      <a href="{siteUrl url="/menu?page={$page+1}"}" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
      </a>
    </li>
    {/if}
  </ul>
</div>
<script>

</script>
{/block}
