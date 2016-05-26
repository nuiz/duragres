{extends file="template.php"}
{block name=body}
<h3>Stat</h3>
<div>
	<div>
		<form id="list-search">
			<div class="row">
				<div class="col-md-3 form-group">
					<label>Order By</label>
					<select class="form-control" name="order">
						<option value="">-All-</option>
						<option value="total_view" {if $form.order=="total_view"}selected{/if}>Total View</option>
						<option value="total_add" {if $form.order=="total_add"}selected{/if}>Total Add</option>
						<option value="total_room" {if $form.order=="total_room"}selected{/if}>Total Room</option>
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
				<!-- <div class="col-md-3 form-group">
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
				</div> -->
	</div>
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
			<label style="opacity: 0;">Filter</label>
			<button type="submit" class="form-control btn btn-info">Filter</button>
		</div>
	</div>



		</form>
		<form id="download-sheet" action="{siteUrl url="/stat/sheet"}" target="_blank" style="border: 1px solid; padding: 10px;">
			<label>Dowload Sheet</label>
			<fieldset>
				<input type="text" class="form-control" name="limit" placeholder="Limit" style="width: 80px; display: inline-block;">
				<button class="btn btn-info">Download Sheet</button>
			</fieldset>
		</form>

	</div>
	<hr>
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
				<th>Total Room Use</th>
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
				<td>{$item.total_room}</td>
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
$(function(){
	$('select[name="year"]').change(function(){
		if(!$(this).val()) {
			$('select[name="month"]').val('').parent().hide();
		}
		else {
			$('select[name="month"]').parent().show();
		}
	})
	.change();
});
$(function(){
	// $('form#list-search').submit(function(e){
	// 	$('input[name="limit"]', this).prop('disable', true);
	// });
	$('form#download-sheet').submit(function(e){
		e.preventDefault();
		var $form = $(this).clone(true).unbind('submit');
		$('form#list-search input, form#list-search select').each(function(i, el){
			var $el = $(el);
			var $clone = $el.clone();
			$clone.val($el.val());
			$form.append($clone);
			console.log($clone.val());
		});
		$form.submit();
		// console.log($form.html());
	});
});
</script>
{/block}
