{extends file="template.php"}
{block name=body}
<h3>User</h3>
<div>
	<div>
		<a href="{siteUrl url="/user/sheet"}" class="btn btn-info">
			Download Sheet
		</a>
	<div>
	<table class="table">
		<thead>
			<tr>
				<th>#</th>
				<th>Created At</th>
				<th>Email</th>
				<th>Product Count</th>
				<th>Personal</th>
			</tr>
		</thead>
		<tbody>
			{foreach key=key item=item from=$items}
			<tr>
				<td>{$item.id}</td>
				<td>{$item.created_at|date_format:"%e %B, %Y"}</td>
				<td>{$item.email}</td>
				<td>{$item.product_count}</td>
						<td><a href="{siteUrl url="/user/sheet/{$item.id}"}" class ="btn btn-primary">User Data<a></td>
			</tr>
			{/foreach}
		</tbody>
	</table>
	<ul class="pagination">
    {if $page gt 1}
    <li>
      <a href="{siteUrl url="/user?page={$page-1}"}" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
      </a>
    </li>
    {/if}
    {for $i=1 to $maxPage}
    <li><a href="{siteUrl url="/user?page=$i"}">{$i}</a></li>
    {/for}
    {if $maxPage gt $page}
    <li>
      <a href="{siteUrl url="/user?page={$page+1}"}" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
      </a>
    </li>
    {/if}
  </ul>
</div>
<script>

</script>
{/block}
