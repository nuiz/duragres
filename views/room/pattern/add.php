{extends file="template.php"}
{block name=body}
<h4>{if isset($form->attr.id)}แก้ไขห้อง{else}เพิ่มห้อง{/if}</h4>
<div class="form-wrap">
	<small>{$form->error}</small>
	<form method="post" enctype="multipart/form-data" action="?submit={time()}">
		<div class="form-group">
			<label>Name</label>
			<input type="text" class="form-control" name="name" value="{$form->attr.name}" placeholder="" required>
		</div>
		<div class="form-group">
			<label>Width</label>
			<input type="text" name="width" id="input-width" class="form-control" value="{$form->attr.width}" placeholder="" autocomplete="off" required>
		</div>
		<div class="form-group">
			<label>Height</label>
			<input type="text" name="height" id="input-height" class="form-control" value="{$form->attr.height}" placeholder="" autocomplete="off" required>
		</div>
		<div class="form-group">
			<label>Size unit</label>
			<select name="size_unit" id="size_unit" class="form-control" required>
				<option {if $form->attr.size_unit=='inch'}selected{/if}>inch</option>
				<option {if $form->attr.size_unit=='cm'}selected{/if}>cm</option>
			</select>
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
		<div class="form-group">
			<label>Product Use</label>
			<select class="form-control" name="product_use[]" multiple>
				{foreach key=key item=item from=$products}
				<option value="{$item.id}" {if in_array($item.id, $form->attr.product_use) !== false }selected{/if}>{$item.name}</option>
				{/foreach}
			</select>
		</div>
		<button type="submit" class="btn btn-primary">ตกลง</button>
		<a href="{siteUrl url="/room/{$room.id}/pattern"}" class="btn btn-warning">กลับไปยังรายการ</a>
	</form>
</div>
<script type="text/javascript">
$(function(){
	$('.datepicker').datepicker();

	var room = {$room|@json_encode};

	var $inputSizUnit = $('#size_unit');
	var $inputWidth = $('#input-width');
	var $inputHeight = $('#input-height');
	var $outputTexture = $('#texture-size');
	var $outputTile = $('#tile-size');

	function calculateSize(){
		var textureX = parseInt(room.width) * 256;
		var textureY = parseInt(room.height) * 256;

		var unitMulti = $inputSizUnit.val() == 'inch'? 40: 0.001;
		var tileX = parseInt($inputWidth.val() || 0) * unitMulti;
		var tileY = parseInt($inputHeight.val() || 0) * unitMulti;

		$outputTexture.text(textureX+'x'+textureY);
		$outputTile.text(tileX+'x'+tileY);
	}

	calculateSize();
	$inputWidth.on('change keydown paste input', calculateSize);
	$inputHeight.on('change keydown paste input', calculateSize);
	$inputSizUnit.change(calculateSize);
});
</script>
{/block}
