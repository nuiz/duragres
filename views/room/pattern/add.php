{extends file="template.php"}
{block name=body}
<h4>{if isset($form->attr.id)}แก้ไขแพทเทิร์น{else}เพิ่มแพทเทิร์น{/if}</h4>
<div class="form-wrap">
	{if $form->error}
	<div class="alert alert-danger" role="alert">
		<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
		<span class="sr-only">Error:</span>
		{$form->error}
	</div>
	{/if}
	<form method="post" enctype="multipart/form-data" action="?submit={time()}">
		<div class="form-group">
			<label>Name</label>
			<input type="text" class="form-control" name="name" value="{$form->attr.name}" placeholder="" required>
		</div>
		<div class="form-group">
			<label>Size (Width, Height)</label>
			<div class="row">
				<div class="col-md-4">
					<input type="text" id="width" name="width" class="form-control" value="{$form->attr.width}" placeholder="width" required>
				</div>
				<div class="col-md-4">
					<input type="text" id="height" name="height" class="form-control" value="{$form->attr.height}" placeholder="height" required>
				</div>
				<div class="col-md-4" style="padding-top: 4px;">
					Meter
				</div>
			</div>
		</div>
		<div class="form-group">
			<label>Tile Size (Width, Height, Type)</label>
			<div class="row">
				<div class="col-md-4">
					<input type="text" id="tile_width" name="tile_width" class="form-control" value="{$form->attr.tile_width}" placeholder="" required>
				</div>
				<div class="col-md-4">
					<input type="text" id="tile_height" name="tile_height" class="form-control" value="{$form->attr.tile_height}" placeholder="" required>
				</div>
				<div class="col-md-4">
					<select name="tile_size_unit" id="tile_size_unit" class="form-control" required>
						<option {if $form->attr.tile_size_unit=='inch'}selected{/if}>inch</option>
						<option {if $form->attr.tile_size_unit=='cm'}selected{/if}>cm</option>
					</select>
				</div>
			</div>
		</div>
		<div class="form-group picture">
			<label>Picture</label>
			<input type="file" class="form-control input-picture" name="picture" value="{$form->attr.picture}" accept="image/*" {if $form->isNew()}required{/if}>
			<span class="help-block">Texture size <span id="texture-size"></span> pixel / Tile size <span id="tile-size"></span> pixel</span>

			{if $form->attr.picture}
			<div class="panel panel-info old-picture-block">
				<div class="panel-heading">Old Picture</div>
				<div class="panel-body text-center">
					<img class="picture" src="../../../../upload/{$form->attr.picture}">
				</div>
			</div>
			{/if}
		</div>
		<div class="form-group picture">
			<label>Thumb</label>
			<input type="file" class="form-control input-picture" name="thumb" value="{$form->attr.thumb}" accept="image/*" {if $form->isNew()}required{/if}>
			<span class="help-block">ควรมีขนาด 150x150 pixel</span>

			{if $form->attr.thumb}
			<div class="panel panel-info old-picture-block">
				<div class="panel-heading">Old Thumb</div>
				<div class="panel-body text-center">
					<img class="picture" src="../../../../upload/{$form->attr.thumb}">
				</div>
			</div>
			{/if}
		</div>
		<div class="form-group">
			<label>Product Use</label>
			<select class="form-control" id="product_use" name="product_use[]" multiple>
				{foreach key=key item=item from=$products}
				<option value="{$item.id}" picture_url="../../../../upload/{$item.picture}" {if in_array($item.id, $form->attr.product_use) !== false }selected{/if}>{$item.name}</option>
				{/foreach}
			</select>
		</div>
		<button type="submit" class="btn btn-primary">ตกลง</button>
		<a href="{siteUrl url="/room/{$room.id}/pattern"}" class="btn btn-warning">กลับไปยังรายการ</a>
	</form>
</div>
<style>
.img-product {
	height: 30px;
}
</style>
<link rel="stylesheet" href="{siteUrl url="/asset/select2/css/select2.min.css"}">
<script type="text/javascript" src="{siteUrl url="/asset/select2/js/select2.min.js"}"></script>
<script type="text/javascript">
$(function(){
	$('.datepicker').datepicker();

	var $tileSizUnit = $('#tile_size_unit');
	var $tileWidth = $('#tile_width');
	var $tileHeight = $('#tile_height');
	var $width = $('#width');
	var $height = $('#height');

	var $outputTexture = $('#texture-size');
	var $outputTile = $('#tile-size');

	function calculateSize(){
		var textureX = parseInt($width.val()) * 256;
		var textureY = parseInt($height.val()) * 256;

		var unitMulti = $tileSizUnit.val() == 'inch'? 0.0254: 0.01;
		var tileX = parseInt($tileWidth.val() || 0) * unitMulti * 256;
		var tileY = parseInt($tileHeight.val() || 0) * unitMulti * 256;

		$outputTexture.text(textureX+'x'+textureY);
		$outputTile.text(tileX+'x'+tileY);
	}

	calculateSize();
	$tileWidth.on('change keydown paste input', calculateSize);
	$tileHeight.on('change keydown paste input', calculateSize);
	$width.on('change keydown paste input', calculateSize);
	$height.on('change keydown paste input', calculateSize);
	$tileSizUnit.change(calculateSize);

	(function(){
		function formatProduct(item){
			var picture = $(item.element).attr("picture_url");
			$product = $('<span><img src="'+picture+'" class="img-product"> '+item.text+'</span>');
			return $product;
		}

		$("#product_use").select2({
		  templateResult: formatProduct
		});
	})();
});
</script>
{/block}
