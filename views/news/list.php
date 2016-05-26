{extends file="template.php"}
{block name=body}
<h3>News</h3>
<div>
	<div>
		<a href="{siteUrl url="/news/add"}" class="btn btn-info">
			<i class="glyphicon glyphicon-plus-sign"></i> เพิ่ม
		</a>
	<div>
	<table class="table">
		<thead>
			<tr>
				<th>#</th>
				<th>Thumb</th>
				<th>Picture</th>
				<th>Name</th>
				<th></th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			{foreach key=key item=item from=$items}
			<tr>
				<td>{$item->id}</td>
				<td><img src="upload/{$item->thumb}" width="80" height="60"></td>
				<td><img src="upload/{$item->picture}" width="80" height="60"></td>
				<td>{$item->name}</td>
				<td>
					<button class="btn btn-move">Move</button>
					<form class="form-move" action="{siteUrl url="/news/sort_move/{$item.id}"}" style="display: none;">
						<select class="form-control" name="position" required="">
							<option value="">--Where--</option>
							<option value="before">Before</option>
							<option value="after">After</option>
						</select>
						<select class="form-control" name="id" required="">
							<option value="">--Chose News--</option>
							{foreach key=key2 item=item2 from=$itemsAll}
							<option value="{$item2.id}">{$item2.name}</option>
							{/foreach}
						</select>
						<button type="submit" class="btn btn-info form-control">Move</button>
					</form>
				</td>
				<td>
					<a href="{siteUrl url="/news/edit/{$item->id}"}"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
					<a class="confirm-beforeclick" href="{siteUrl url="/news/delete/{$item->id}"}"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
				</td>
			</tr>
			{/foreach}
		</tbody>
	</table>
	<ul class="pagination">
    {if $page gt 1}
    <li>
      <a href="{siteUrl url="/news?page={$page-1}"}" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
      </a>
    </li>
    {/if}
    {for $i=1 to $maxPage}
    <li><a href="{siteUrl url="/news?page=$i"}">{$i}</a></li>
    {/for}
    {if $maxPage gt $page}
    <li>
      <a href="{siteUrl url="/news?page={$page+1}"}" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
      </a>
    </li>
    {/if}
  </ul>
</div>
<script>
$(function(){
	$(".btn-move").click(function(e){
		$(this).next().toggle();
	});
});
</script>
{/block}
