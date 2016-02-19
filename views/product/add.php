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
			<label>Name Eng</label>
			<input type="text" class="form-control" name="name_eng" value="{$form->attr.name_eng}" placeholder="" required>
		</div>
		<div class="form-group">
			<label>Picture</label>
			<input type="file" class="form-control input-picture" name="picture" value="{$form->attr.picture}" accept="image/*" {if $form->isNew()}required{/if}>
			<span class="help-block">รูปภาพควรมีขนาดไม่เกิน 512x512 pixel</span>

			<div class="example-picture"></div>
		</div>
		<!-- <div class="form-group">
			<label>Thumbnail</label>
			<input type="file" class="form-control input-picture" name="thumb" value="{$form->attr.thumb}" accept="image/*" {if $form->isNew()}required{/if}>
			<span class="help-block">รูปภาพควรมีขนาด 800x250 pixel</span>
			<div class="example-picture"></div>
		</div> -->
		<div class="form-group">
			<label>Type</label>
			<select class="form-control chain-master" name="type" data-chain-name="type-size" required="">
				<option value="">-All-</option>
				<option {if $form->attr.type=='Floor Tiles'}selected{/if}>Floor Tiles</option>
				<option {if $form->attr.type=='Wall Tiles'}selected{/if}>Wall Tiles</option>
				<option {if $form->attr.type=='Mosaic'}selected{/if}>Mosaic</option>
				<option {if $form->attr.type=='Porcelain'}selected{/if}>Porcelain</option>
			</select>
		</div>
		<div class="form-group">
			<label>Size</label>
			<select class="form-control chian-child" name="size" data-chain-name="type-size" required="">
				<option value="">-Please Select-</option>

				<option data-chain-value="Floor Tiles" value="8x8">8x8</option>
				<option data-chain-value="Floor Tiles" value="12x12">12x12</option>
				<option data-chain-value="Floor Tiles" value="12x24">12x24</option>
				<option data-chain-value="Floor Tiles" value="13x13">13x13</option>
				<option data-chain-value="Floor Tiles" value="16x16">16x16</option>
				<option data-chain-value="Floor Tiles" value="20x20">20x20</option>

				<option data-chain-value="Wall Tiles" value="8x10">8x10</option>
				<option data-chain-value="Wall Tiles" value="8x12">8x12</option>
				<option data-chain-value="Wall Tiles" value="8x16">8x16</option>
				<option data-chain-value="Wall Tiles" value="10x16">10x16</option>
				<option data-chain-value="Wall Tiles" value="12x24">12x24</option>

				<option data-chain-value="Mosaic" value="8x8">8x8</option>
				<option data-chain-value="Mosaic" value="12x12">12x12</option>
				<option data-chain-value="Mosaic" value="12x24">12x24</option>
				<option data-chain-value="Mosaic" value="13x13">13x13</option>
				<option data-chain-value="Mosaic" value="16x16">16x16</option>
				<option data-chain-value="Mosaic" value="20x20">20x20</option>

				<option data-chain-value="Porcelain" value="8x8">8x8</option>
				<option data-chain-value="Porcelain" value="12x12">12x12</option>
				<option data-chain-value="Porcelain" value="12x24">12x24</option>
				<option data-chain-value="Porcelain" value="13x13">13x13</option>
				<option data-chain-value="Porcelain" value="16x16">16x16</option>
				<option data-chain-value="Porcelain" value="20x20">20x20</option>
			</select>
		</div>
		<div class="form-group hidden">
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
				<option {if $form->attr.company=='Duragres'}selected{/if}>Duragres</option>
				<option {if $form->attr.company=='Cergres'}selected{/if}>Cergres</option>
			</select>
		</div>
		<div class="form-group">
			<label>Price</label>
			<input type="text" class="form-control" name="price" value="{$form->attr.price}" placeholder="">
		</div>
		<div class="form-group">
			<label>Color</label>
			<input type="text" class="form-control" name="color" value="{$form->attr.color}" placeholder="">
		</div>
		<div class="form-group">
			<label>Surface</label>
			<input type="text" class="form-control" name="surface" value="{$form->attr.surface}" placeholder="">
		</div>
		<div class="form-group">
			<label>PCS./CTN</label>
			<input type="text" class="form-control" name="pcs_ctn" value="{$form->attr.pcs_ctn}" placeholder="">
		</div>
		<div class="form-group">
			<label>SQ.M/CTN</label>
			<input type="text" class="form-control" name="sqm_ctn" value="{$form->attr.sqm_ctn}" placeholder="">
		</div>
		<div class="form-group">
			<label><input type="checkbox" name="is_hot" value="1" {if $form->attr.is_hot eq 1}checked{/if}> Hot</label>
		</div>
		<div class="form-group">
			<label><input type="checkbox" name="is_new" value="1" {if $form->attr.is_new eq 1}checked{/if}> New</label>
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
	var formType = "{$form->attr.type}";
	var formSize = "{$form->attr.size}";

	$('.chain-master').change(function(e){
		var name = $(this).data('chain-name');
		var $childSelect = $('.chian-child[data-chain-name="'+name+'"]');
		var value = $(this).val();

		$childSelect.val("");
		$('option', $childSelect).hide()
			.filter('[data-chain-value="'+value+'"]').show();
	});

	 $('.chain-master').change();
	 $('option[data-chain-value="'+formType+'"][value="'+formSize+'"]').prop("selected", true);
});
</script>
{/block}
