{extends file="template.php"}
{block name=body}
<h3>Stat</h3>
<div>
	<div>
		<form>
			<div class="row">

				<div class="col-md-3 form-group">
					<label>Room</label>
					<select class="form-control" name="room">
						<option value="">-All-</option>
						<option value="room1" {if $form.room=="room1"}selected{/if}>Room1</option>
						<option value="room2" {if $form.room=="room2"}selected{/if}>Room2</option>
						<option value="room3" {if $form.room=="room3"}selected{/if}>Room3</option>
						<option value="room4" {if $form.room=="room4"}selected{/if}>Room4</option>
						<option value="room5" {if $form.room=="room5"}selected{/if}>Room5</option>
						<option value="room6" {if $form.room=="room6"}selected{/if}>Room6</option>
						<option value="room7" {if $form.room=="room7"}selected{/if}>Room7</option>
						<option value="room8" {if $form.room=="room8"}selected{/if}>Room8</option>
						<option value="room9" {if $form.room=="room9"}selected{/if}>Room9</option>
						<option value="room10" {if $form.room=="room10"}selected{/if}>Room10</option>
					</select>
				</div>
	</div>


		<div class="col-md-12 form-group">
			<label style="opacity: 0;">submit</label>
			<button type="submit" class="form-control btn btn-info">Filter</button>
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

				<th>Total Room Use</th>
			</tr>
		</thead>
		<tbody>
			{foreach key=key item=item from=$items}
			<tr>
				<td>{$item.id}</td>
				<td>{$item.code}</td>
				<td>{$item.name}</td>
				<td><img src="/upload/{$item.picture}" width="80" height="60"></td>
				<!-- <td><img src="upload/{$item.thumb}" width="80" height="60"></td> -->
				<td>{$item.size} (inch)</td>
				<td>{$item.type}</td>
				<td>{$item.company}</td>

				<td>{$item.total_room}</td>
			</tr>
			{/foreach}
		</tbody>
	</table>
	<ul class="pagination">
    {if $page gt 1}
    <li>
      <a href="{siteUrl url="/room/stat/$"}?{$form|@http_build_query:"_var1"}&page={$page-1}" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
      </a>
    </li>
    {/if}
    {for $i=1 to $maxPage}
    <li><a href="{siteUrl url="/room/stat"}?{$form|@http_build_query:"_var1"}&page={$i}">{$i}</a></li>
    {/for}
    {if $maxPage gt $page}
    <li>
      <a href="{siteUrl url="/room/stat"}?{$form|@http_build_query:"_var1"}&page={$page+1}" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
      </a>
    </li>
    {/if}
  </ul>
</div>

{/block}
