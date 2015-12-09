{extends file="template.php"}
{block name=body}
<h4>{if isset($form->attr.id)}แก้ไขข่าว{else}เพิ่มข่าว{/if}</h4>
<div class="form-wrap">
	<small>{$form->error}</small>
	<form method="post" enctype="multipart/form-data" action="?submit={time()}">
		<div class="form-group">
			<label>Name</label>
			<input type="text" class="form-control" name="name" value="{$form->attr.name}" placeholder="" required>
		</div>
		<div class="form-group">
			<label>รูปภาพ</label>
			<input type="file" class="form-control input-picture" name="picture" value="{$form->attr.picture}" {if $form->isNew()}required{/if}>

			<div class="example-picture"></div>
		</div>
		<div class="form-group">
			<label>รูป thumbnail</label>
			<input type="file" class="form-control input-picture" name="thumb" value="{$form->attr.thumb}" {if $form->isNew()}required{/if}>
			<span class="help-block">รูปภาพควรมีขนาด 800x250 pixel</span>
			<div class="example-picture"></div>
		</div>
		<div class="form-group">
			<label>Content</label>
			<input type="text" class="form-control" name="content" value="{$form->attr.content}" placeholder="">
		</div>
		<div class="form-group">
			<label>Link</label>
			<input type="text" class="form-control" name="link" value="{$form->attr.link}" placeholder="">
		</div>
		<button type="submit" class="btn btn-primary">ตกลง</button>
		<a href="{siteUrl url="/news"}" class="btn btn-warning">กลับไปยังรายการ</a>
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
