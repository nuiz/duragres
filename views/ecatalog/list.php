{extends file="template.php"}
{block name=body}
<h3>E-Catalog</h3>
<div>
	<div>
		<a href="{siteUrl url="/ecatalog/add"}" class="btn btn-info">
			<i class="glyphicon glyphicon-plus-sign"></i> เพิ่ม
		</a>
	<div>
	<table class="table">
		<thead>
			<tr>
				<th>#</th>
				<th>Name</th>
				<th>Cover</th>
				<th>PDF File</th>
				<th>New</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			{foreach key=key item=item from=$items}
			<tr>
				<td>{$item.id}</td>
				<td>{$item.name}</td>
				<td><img src="{siteUrl url="/upload/{$item.cover_path}"}" width="64"></td>
				<td><a href="{siteUrl url="/upload/{$item.pdf_path}"}" download>Download</a></td>
				<td>{if $item.is_new}<span class="badge" style="background: rgb(240, 77, 25);">New</span>{/if}</td>
				<td>
					<a href="{siteUrl url="/ecatalog/edit/{$item.id}"}"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
					<a class="confirm-beforeclick" href="{siteUrl url="/ecatalog/delete/{$item.id}"}"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
				</td>
			</tr>
			{/foreach}
		</tbody>
	</table>
	<ul class="pagination">
    {if $page gt 1}
    <li>
      <a href="{siteUrl url="/ecatalog?page={$page-1}"}" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
      </a>
    </li>
    {/if}
    {for $i=1 to $maxPage}
    <li><a href="{siteUrl url="/ecatalog?page=$i"}">{$i}</a></li>
    {/for}
    {if $maxPage gt $page}
    <li>
      <a href="{siteUrl url="/ecatalog?page={$page+1}"}" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
      </a>
    </li>
    {/if}
  </ul>
</div>
<script>

</script>
{/block}
