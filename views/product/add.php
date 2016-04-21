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
		<div class="form-group picture">
			<label>Picture</label>
			<input type="file" class="form-control input-picture" name="picture" value="{$form->attr.picture}" accept="image/*" {if $form->isNew()}required{/if}>
			<span class="help-block">รูปภาพควรมีขนาดไม่เกิน 512x512 pixel</span>


			<div class="panel panel-info old-picture-block {if $form->attr.picture == ""}hidden{/if}">
				<div class="panel-heading">Old Picture</div>
				<div class="panel-body text-center">
					<img class="picture" src="../../upload/{$form->attr.picture}">
				</div>
			</div>

		</div>
		<div class="form-group picture">
			<label>ICON 1</label>
			<!-- <input type="file" class="form-control input-picture" name="icon_1" value="{$form->attr.icon_1}" accept="image/*"> -->
			<!-- <span class="help-block">รูปภาพควรมีขนาดไม่เกิน 150x150 pixel</span> -->
			<select class="form-control select-icon" name="icon_1" id="type" required="">
				<option value="">-None-</option>
				{foreach key=key item=item from=$icons}
				<option {if $form->attr.icon_1==$item}selected{/if}>{$item}</option>
				{/foreach}
			</select>

			<div class="panel panel-info old-picture-block icon {if $form->attr.icon_1}hidden{/if}">
				<div class="panel-heading">ICON 1</div>
				<div class="panel-body text-center">
					<img class="picture" src="../../icon/{$form->attr.icon_1 == ""}">
				</div>
			</div>
		</div>
		<div class="form-group picture">
			<label>ICON 2</label>
			<!-- <input type="file" class="form-control input-picture" name="icon_2" value="{$form->attr.icon_2}" accept="image/*"> -->
			<!-- <span class="help-block">รูปภาพควรมีขนาดไม่เกิน 150x150 pixel</span> -->
			<select class="form-control select-icon" name="icon_2" id="type" required="">
				<option value="">-None-</option>
				{foreach key=key item=item from=$icons}
				<option {if $form->attr.icon_2==$item}selected{/if}>{$item}</option>
				{/foreach}
			</select>

			{if $form->attr.icon_2}
			<div class="panel panel-info old-picture-block {if $form->attr.icon_2}hidden{/if}">
				<div class="panel-heading">Old ICON 2</div>
				<div class="panel-body text-center">
					<img class="picture" src="../../icon/{$form->attr.icon_2 == ""}">
				</div>
			</div>
			{/if}
		</div>
		<div class="form-group picture">
			<label>ICON 3</label>
			<!-- <input type="file" class="form-control input-picture" name="icon_3" value="{$form->attr.icon_3}" accept="image/*"> -->
			<!-- <span class="help-block">รูปภาพควรมีขนาดไม่เกิน 150x150 pixel</span> -->
			<select class="form-control select-icon {if $form->attr.icon_3 == ""}hidden{/if}" name="icon_3" id="type" required="">
				<option value="">-None-</option>
				{foreach key=key item=item from=$icons}
				<option {if $form->attr.icon_3==$item}selected{/if}>{$item}</option>
				{/foreach}
			</select>

			{if $form->attr.icon_3}
			<div class="panel panel-info old-picture-block">
				<div class="panel-heading">Old ICON 3</div>
				<div class="panel-body text-center">
					<img class="picture" src="../../icon/{$form->attr.icon_3}">
				</div>
			</div>
			{/if}
		</div>
		<div class="form-group picture">
			<label>ICON 4</label>
			<!-- <input type="file" class="form-control input-picture" name="icon_4" value="{$form->attr.icon_4}" accept="image/*"> -->
			<!-- <span class="help-block">รูปภาพควรมีขนาดไม่เกิน 150x150 pixel</span> -->
			<select class="form-control select-icon {if $form->attr.icon_4 == ""}hidden{/if}" name="icon_4" id="type" required="">
				<option value="">-None-</option>
				{foreach key=key item=item from=$icons}
				<option {if $form->attr.icon_4==$item}selected{/if}>{$item}</option>
				{/foreach}
			</select>

			{if $form->attr.icon_4}
			<div class="panel panel-info old-picture-block">
				<div class="panel-heading">Old ICON 4</div>
				<div class="panel-body text-center">
					<img class="picture" src="../../icon/{$form->attr.icon_4}">
				</div>
			</div>
			{/if}
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
				<option value="" class="hidden">-Please Select-</option>
				<option {if $form->attr.type=='Floor Tiles'}selected{/if}>Floor Tiles</option>
				<option {if $form->attr.type=='Wall Tiles'}selected{/if}>Wall Tiles</option>
				<option {if $form->attr.type=='Mosaic'}selected{/if}>Mosaic</option>
				<option {if $form->attr.type=='Porcelain'}selected{/if}>Porcelain</option>
			</select>
			<select class="form-control" name="porcelain_type" id="porcelain_type" required="" style="display: none;" disabled="">
				<option value="">-All-</option>
				<option {if $form->attr.porcelain_type=='Floor'}selected{/if}>Floor</option>
				<option {if $form->attr.porcelain_type=='Wall'}selected{/if}>Wall</option>
			</select>
		</div>
		<div class="form-group">
			<label>Size</label>
			<select class="form-control" id="size" name="size" required="">
				<option value="">-Please Select-</option>


				<option data-type-value="Floor Tiles" data-size_unit-value="inch" value="8x8" {if $form->attr.type=='Floor Tiles' && $form->attr.size=='8x8' && $form->attr.size_unit=='inch'}selected{/if}>8x8 inch</option>
				<option data-type-value="Floor Tiles" data-size_unit-value="inch" value="12x12" {if $form->attr.type=='Floor Tiles' && $form->attr.size=='12x12' && $form->attr.size_unit=='inch'}selected{/if}>12x12 inch</option>
				<option data-type-value="Floor Tiles" data-size_unit-value="inch" value="13x13" {if $form->attr.type=='Floor Tiles' && $form->attr.size=='13x13' && $form->attr.size_unit=='inch'}selected{/if}>13x13 inch</option>
				<option data-type-value="Floor Tiles" data-size_unit-value="inch" value="16x16" {if $form->attr.type=='Floor Tiles' && $form->attr.size=='16x16' && $form->attr.size_unit=='inch'}selected{/if}>16x16 inch</option>
				<option data-type-value="Floor Tiles" data-size_unit-value="cm" value="30x60" {if $form->attr.type=='Floor Tiles' && $form->attr.size=='30x60' && $form->attr.size_unit=='cm'}selected{/if}>30x60 cm</option>
				<option data-type-value="Floor Tiles" data-size_unit-value="cm" value="50x50" {if $form->attr.type=='Floor Tiles' && $form->attr.size=='50x50' && $form->attr.size_unit=='cm'}selected{/if}>50x50 cm</option>
				<option data-type-value="Floor Tiles" data-size_unit-value="cm" value="60x60" {if $form->attr.type=='Floor Tiles' && $form->attr.size=='60x60' && $form->attr.size_unit=='cm'}selected{/if}>60x60 cm</option>

				<option data-type-value="Wall Tiles" data-size_unit-value="inch" value="8x10" {if $form->attr.type=='Wall Tiles' && $form->attr.size=='8x10' && $form->attr.size_unit=='inch'}selected{/if}>8x10 inch</option>
				<option data-type-value="Wall Tiles" data-size_unit-value="inch" value="8x12" {if $form->attr.type=='Wall Tiles' && $form->attr.size=='8x12' && $form->attr.size_unit=='inch'}selected{/if}>8x12 inch</option>
				<option data-type-value="Wall Tiles" data-size_unit-value="inch" value="8x16" {if $form->attr.type=='Wall Tiles' && $form->attr.size=='8x16' && $form->attr.size_unit=='inch'}selected{/if}>8x16 inch</option>
				<option data-type-value="Wall Tiles" data-size_unit-value="inch" value="10x16" {if $form->attr.type=='Wall Tiles' && $form->attr.size=='10x16' && $form->attr.size_unit=='inch'}selected{/if}>10x16 inch</option>
				<option data-type-value="Wall Tiles" data-size_unit-value="cm" value="30x60" {if $form->attr.type=='Wall Tiles' && $form->attr.size=='30x60' && $form->attr.size_unit=='cm'}selected{/if}>30x60 cm</option>


				<option data-type-value="Porcelain" data-porcelain_type-value="Floor" data-size_unit-value="cm" value="15x60" {if $form->attr.type=='Porcelain' && $form->attr.porcelain_type=='Floor' && $form->attr.size=='15x60' && $form->attr.size_unit=='cm'}selected{/if}>15x60 cm</option>
				<option data-type-value="Porcelain" data-porcelain_type-value="Floor" data-size_unit-value="cm" value="20x60" {if $form->attr.type=='Porcelain' && $form->attr.porcelain_type=='Floor' && $form->attr.size=='20x60' && $form->attr.size_unit=='cm'}selected{/if}>20x60 cm</option>
				<option data-type-value="Porcelain" data-porcelain_type-value="Floor" data-size_unit-value="cm" value="30x60" {if $form->attr.type=='Porcelain' && $form->attr.porcelain_type=='Floor' && $form->attr.size=='30x60' && $form->attr.size_unit=='cm'}selected{/if}>30x60 cm</option>
				<option data-type-value="Porcelain" data-porcelain_type-value="Floor" data-size_unit-value="cm" value="40x60" {if $form->attr.type=='Porcelain' && $form->attr.porcelain_type=='Floor' && $form->attr.size=='40x60' && $form->attr.size_unit=='cm'}selected{/if}>40x60 cm</option>
				<option data-type-value="Porcelain" data-porcelain_type-value="Floor" data-size_unit-value="cm" value="60x60" {if $form->attr.type=='Porcelain' && $form->attr.porcelain_type=='Floor' && $form->attr.size=='60x60' && $form->attr.size_unit=='cm'}selected{/if}>60x60 cm</option>

				<option data-type-value="Porcelain" data-porcelain_type-value="Wall" data-size_unit-value="cm" value="30x60" {if $form->attr.type=='Porcelain' && $form->attr.porcelain_type=='Wall' && $form->attr.size=='30x60' && $form->attr.size_unit=='cm'}selected{/if}>30x60 cm</option>

				<option data-type-value="Mosaic" data-size_unit-value="cm" value="30x30" {if $form->attr.type=='Mosaic' && $form->attr.size=='30x30' && $form->attr.size_unit=='cm'}selected{/if}>30x30 cm</option>
			</select>
			<input type="hidden" id="size_unit" name="size_unit" readonly="" value="{$form->attr.size_unit}">
		</div>
		<div class="form-group">
			<label>Style</label>
			<input type="text" class="form-control" name="style" value="{$form->attr.style}" placeholder="">
		</div>
		<div class="form-group">
			<label>Company</label>
			<select name="company" id="company" class="form-control">
				<option value="" class="hidden">-Please Select-</option>
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
		<div class="form-group">
			<label><input type="checkbox" name="is_group" value="1" {if $form->attr.is_group eq 1}checked{/if}> Group</label>
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
	var $elCompany = $("#company");

	function changeType() {
		var type = $elType.val();
		var porcelainType = $elPorcelainType.val();

		if(type == "Porcelain")
			$elPorcelainType.prop("disabled", false).show();
		else
			$elPorcelainType.prop("disabled", true).hide();

		// size chain
		var optionQuery = ["option"];
		optionQuery.push("[data-type-value='"+type+"']");
		if(type == "Porcelain")
			optionQuery.push("[data-porcelain_type-value='"+porcelainType+"']");
		$("option", $elSize).hide();
		$(optionQuery.join(""), $elSize).show();

		// company chain
		var $cergresOption = $("option[value='Cergres']", $elCompany);
		if(type == "Mosaic"){
			$cergresOption.hide();
			if($elCompany.val() == "Cergres")
				$elCompany.val("");
		}
		else
			$cergresOption.show();
	}

	$('#porcelain_type, #type').change(function(){
		changeType();
		$elSize.val(""); $elSizeUnit.val("");
		if($elType.val() != "Porcelain") $elPorcelainType.val("");
	});
	$elSize.change(function(e){
		var sizeUnit = $("option:selected", $elSize).data("size_unit-value");
		// console.log($("option:selected", $elSize));
		$elSizeUnit.val(sizeUnit);
	});
	changeType();

	$('.form-group.picture').each(function(i, el) {
		var $el = $(el);
		var $picture = $('.picture', $el);
		var $pictureBlock = $('.old-picture-block', $el);
		var $select = $('.select-icon', $el).change(function(e) {
			$picture.attr('src', '../../icon/'+$select.val());
			if($select.val() == "") $pictureBlock.addClass('hidden');
			else $pictureBlock.removeClass('hidden');
		});
	});
});
</script>
{/block}
