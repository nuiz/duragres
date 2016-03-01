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
			<select class="form-control" name="type" id="type" required="">
				<option value="">-All-</option>
				<option {if $form->attr.type=='Floor Tiles'}selected{/if}>Floor Tiles</option>
				<option {if $form->attr.type=='Wall Tiles'}selected{/if}>Wall Tiles</option>
				<option {if $form->attr.type=='Mosaic'}selected{/if}>Mosaic</option>
				<option {if $form->attr.type=='Porcelain'}selected{/if}>Porcelain</option>
			</select>
			<select class="form-control" name="porcelain_type" id="porcelain_type" required="" style="display: none;" disabled="">
				<option value="">-All-</option>
				<option {if $form->attr.type=='Floor'}selected{/if}>Floor</option>
				<option {if $form->attr.type=='Wall'}selected{/if}>Wall</option>
			</select>
		</div>
		<div class="form-group">
			<label>Size</label>
			<select class="form-control" id="size" name="size" required="">
				<option value="">-Please Select-</option>

				<option data-type-value="Floor Tiles" data-size-unit="cm" value="50x50">50x50 cm</option>
				<option data-type-value="Floor Tiles" data-size-unit="cm" value="30x60">30x60 cm</option>
				<option data-type-value="Floor Tiles" data-size-unit="inch" value="16x16">16x16 inch</option>
				<option data-type-value="Floor Tiles" data-size-unit="inch" value="13x13">13x13 inch</option>
				<option data-type-value="Floor Tiles" data-size-unit="inch" value="12x12">12x12 inch</option>
				<option data-type-value="Floor Tiles" data-size-unit="inch" value="8x8">8x8 inch</option>

				<option data-type-value="Wall Tiles" data-size-unit="cm" value="30x60">30x60 cm</option>
				<option data-type-value="Wall Tiles" data-size-unit="inch" value="10x16">10x16 inch</option>
				<option data-type-value="Wall Tiles" data-size-unit="inch" value="8x16">8x16 inch</option>
				<option data-type-value="Wall Tiles" data-size-unit="inch" value="8x12">8x12 inch</option>
				<option data-type-value="Wall Tiles" data-size-unit="inch" value="8x10">8x10 inch</option>

				<option data-type-value="Porcelain" data-porcelain_type-value="Floor" data-size-unit="cm" value="60x60">60x60 cm</option>
				<option data-type-value="Porcelain" data-porcelain_type-value="Floor" data-size-unit="cm" value="30x60">30x60 cm</option>
				<option data-type-value="Porcelain" data-porcelain_type-value="Floor" data-size-unit="cm" value="30x30">30x30 cm</option>
				<option data-type-value="Porcelain" data-porcelain_type-value="Floor" data-size-unit="cm" value="15x60">15x60 cm</option>

				<option data-type-value="Porcelain" data-porcelain_type-value="Wall" data-size-unit="cm" value="60x60">60x60 cm</option>
				<option data-type-value="Porcelain" data-porcelain_type-value="Wall" data-size-unit="cm" value="30x30">30x30 cm</option>
				<option data-type-value="Porcelain" data-porcelain_type-value="Wall" data-size-unit="cm" value="15x60">15x60 cm</option>

				<option data-type-value="Mosaic" data-size-unit="cm" value="30x30">30x30 cm</option>
			</select>
			<input type="hidden" id="size_unit" name="size_unit" readonly="" value="{$form->attr.size_unit}">
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
			<select name="company" id="company" class="form-control">
				<option value="">-Please Select-</option>
				<option value="Duragres" {if $form->attr.company=='Duragres'}selected{/if}>Duragres</option>
				<option value="Cergres" {if $form->attr.company=='Cergres'}selected{/if}>Cergres</option>
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
	var formPorcelainType = "{$form->attr.porcelain_type}";
	var formSize = "{$form->attr.size}";

	var $elType = $('#type');
	var $elPorcelainType = $('#porcelain_type');
	var $elSize = $('#size');
	var $elSizeUnit = $('#size_unit');

	$('#porcelain_type, #type').change(function(e){
		var type = $elType.val();
		var porcelainType = $elPorcelainType.val();
		var sizeUnit = $elSizeUnit.data("size_unit-value");

		// size_unit chain
		$elSizeUnit.val(sizeUnit);

		// size chain
		var optionQuery = ["option"];
		optionQuery.push("[data-type-value='"+type+"']");
		if(type == "Porcelain") optionQuery.push("[data-porcelain_type-value='"+porcelainType+"']");

		// company chain
		var $companyOptions = $("#company option");
		$companyOptions.show();
		if(type == "Mosaic")
			$companyOptions.filter("[value='Cergres']").hide();

		$("option", $elSize).hide();
		$(optionQuery.join(""), $elSize).show();
	});
});
</script>
{/block}
