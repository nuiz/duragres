{extends file="template.php"}
{block name=body}
<h4>{if isset($form->attr.id)}แก้ไขสินค้า{else}เพิ่มสินค้า{/if}</h4>
<div class="form-wrap">
	<small>{$form->error}</small>
	<form method="post" enctype="multipart/form-data" action="?submit={time()}">
		<div class="form-group">
			<label>Code</label>
			<input type="text" class="form-control" name="code" value="{$form->attr.code}" placeholder="" required>
		</div>
		<div class="form-group">
			<label>Name</label>
			<input type="text" class="form-control" name="name" value="{$form->attr.name}" placeholder="" required>
		</div>
		<div class="form-group">
			<label>Picture</label>
			<input type="file" class="form-control input-picture" name="picture" value="{$form->attr.picture}" {if $form->isNew()}required{/if}>
			<span class="help-block">รูปภาพควรมีขนาด 800x600 pixel</span>

			<div class="example-picture"></div>
		</div>
		<div class="form-group">
			<label>Thumbnail</label>
			<input type="file" class="form-control input-picture" name="thumb" value="{$form->attr.thumb}" {if $form->isNew()}required{/if}>
			<span class="help-block">รูปภาพควรมีขนาด 800x250 pixel</span>
			<div class="example-picture"></div>
		</div>
		<div class="form-group">
			<label>Type</label>
			<select class="form-control chain-master" name="type" data-chain-name="type-size" required="">
				<option value="">-All-</option>
				<option>Floor titles</option>
				<option>Wall titles</option>
				<option>Mosaic</option>
				<option>Porcelain</option>
			</select>
		</div>
		<div class="form-group">
			<label>Size</label>
			<select class="form-control chian-child" name="size" data-chain-name="type-size" required="">
				<option value="">-Please Select-</option>

				<option data-chain-value="Floor titles">8x8</option>
				<option data-chain-value="Floor titles">12x12</option>
				<option data-chain-value="Floor titles">13x13</option>
				<option data-chain-value="Floor titles">16x16</option>
				<option data-chain-value="Floor titles">50x50</option>
				<option data-chain-value="Floor titles">60x60</option>

				<option data-chain-value="Wall titles">8x10</option>
				<option data-chain-value="Wall titles">8x16</option>
				<option data-chain-value="Wall titles">10x16</option>
				<option data-chain-value="Wall titles">30x60</option>

				<option data-chain-value="Mosaic">8x8</option>
				<option data-chain-value="Mosaic">12x12</option>
				<option data-chain-value="Mosaic">13x13</option>
				<option data-chain-value="Mosaic">16x16</option>
				<option data-chain-value="Mosaic">50x50</option>
				<option data-chain-value="Mosaic">60x60</option>

				<option data-chain-value="Porcelain">8x8</option>
				<option data-chain-value="Porcelain">12x12</option>
				<option data-chain-value="Porcelain">13x13</option>
				<option data-chain-value="Porcelain">16x16</option>
				<option data-chain-value="Porcelain">50x50</option>
				<option data-chain-value="Porcelain">60x60</option>
			</select>
		</div>
		<div class="form-group">
			<label>Style</label>
			<select name="style" class="form-control">
				<option value="">-Please Select-</option>
				<option>1</option>
				<option>2</option>
				<option>3</option>
				<option>4</option>
			</select>
		</div>
		<div class="form-group">
			<label>Company</label>
			<select name="company" class="form-control">
				<option value="">-Please Select-</option>
				<option>Company 1</option>
				<option>Company 2</option>
			</select>
		</div>
		<div class="form-group">
			<label>Price</label>
			<input type="text" class="form-control" name="price" value="{$form->attr.price}" placeholder="">
		</div>
		<div class="form-group">
			<label><input type="checkbox" name="is_hot" value="1" {if $form->attr.is_hot eq 1}checked{/if}> Hot</label>

		</div>
		<button type="submit" class="btn btn-primary">ตกลง</button>
		<a href="{siteUrl url="/product"}" class="btn btn-warning">กลับไปยังรายการ</a>
	</form>
</div>
<script type="text/javascript">
$(function(){
	$('.datepicker').datepicker();

	function readURL(input) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();
	        reader.onload = function (e) {
	            $('#blah').attr('src', e.target.result);
	        }
	        reader.readAsDataURL(input.files[0]);
	    }
	}

	$(".input-picture").change(function(){
	    readURL(this);
	});
});

$(function(){
	$('.chain-master').change(function(e){
		var name = $(this).data('chain-name');
		var $childSelect = $('.chian-child[data-chain-name="'+name+'"]');
		var value = $(this).val();

		$childSelect.val('');
		$('option', $childSelect).hide()
			.filter('[data-chain-value="'+value+'"]').show();
	});

	// $('.chain-master').change();
});
</script>
{/block}
