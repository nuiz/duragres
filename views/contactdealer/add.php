{extends file="template.php"}
{block name=body}
<h4>{if isset($form->attr.id)}แก้ไขตัวแทนจำหน่าย{else}เพิ่มตัวแทนจำหน่าย{/if}</h4>
<div class="form-wrap">
	<small>{$form->error}</small>
	<form method="post" enctype="multipart/form-data" action="?submit={time()}">
		<div class="form-group">
			<label>ชื่อ</label>
			<input type="text" class="form-control" name="name" value="{$form->attr.name}" placeholder="" required>
		</div>
		<div class="form-group">
			<label>ที่อยู่</label>
			<textarea type="text" class="form-control" name="address">{$form->attr.address}</textarea>
		</div>
		<div class="form-group">
			<label>เบอร์โทรศัพท์</label>
			<input type="text" class="form-control" name="phone" value="{$form->attr.phone}" placeholder="">
		</div>
		<div class="form-group">
			<label>จังหวัด</label>
			<select class="form-control" name="province_id">
				{foreach key=key item=province from=$provinces}
				<option value="{$province.province_id}" {if $province.province_id==$form->attr.province_id}selected{/if}>{$province.province_name}</option>
				{/foreach}
			</select>
		</div>
		<div class="form-group">
			<label>ตำแหน่งละติจูด</label>
			<input type="text" class="form-control" name="lat" value="{$form->attr.lat}" placeholder="">
		</div>
		<div class="form-group">
			<label>ตำแหน่งลองติจูด</label>
			<input type="text" class="form-control" name="lng" value="{$form->attr.lng}" placeholder="">
		</div>
		<button type="submit" class="btn btn-primary">ตกลง</button>
		<a href="{siteUrl url="/contactdealer"}" class="btn btn-warning">กลับไปยังรายการ</a>
	</form>
</div>
<script>
$(function(){
	// $('.datepicker').datepicker()
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
</script>
{/block}
