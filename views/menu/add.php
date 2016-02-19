{extends file="template.php"}
{block name=body}
<h4>{if isset($form->attr.id)}แก้ไขเมนู {$form->attr.menu}{else}เพิ่มข่าว{/if}</h4>
<div class="form-wrap">
	<small>{$form->error}</small>
	<form method="post" enctype="multipart/form-data" action="?submit={time()}">
		<div class="form-group">
			<label>Name</label>
			<input type="text" class="form-control" name="name" value="{$form->attr.name}" placeholder="" required>
		</div>
		<div class="form-group">
			<label>รูปภาพ</label>
			<input type="file" class="form-control input-picture" name="picture" accept="image/*" {if $form->isNew()}required{/if}>
			<span class="help-block">รูปภาพควรมีขนาด 964x1024 pixel</span>
			<div class="example-picture"></div>
		</div>
		<button type="submit" class="btn btn-primary">ตกลง</button>
		<a href="{siteUrl url="/home"}" class="btn btn-warning">กลับไปยังรายการ</a>
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
