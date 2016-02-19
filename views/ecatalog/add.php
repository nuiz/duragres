{extends file="template.php"}
{block name=body}
<h4>{if isset($form->attr.id)}แก้ไข E-Catalog{else}เพิ่ม E-Catalog{/if}</h4>
<div class="form-wrap">
	<small>{$form->error}</small>
	<form method="post" enctype="multipart/form-data" action="?submit={time()}">
		<div class="form-group">
			<label>Name</label>
			<input type="text" class="form-control" name="name" value="{$form->attr.name}" placeholder="" required>
		</div>
		<div class="form-group">
			<label>PDF</label>
			<input type="file" class="form-control" name="pdf" value="{$form->attr.pdf_path}" accept="application/pdf" {if $form->isNew()}required{/if}>
		</div>
		<div class="form-group">
			<label><input type="checkbox" name="is_new" value="1" {if $form->attr.is_new eq 1}checked{/if}> New</label>
		</div>
		<button type="submit" class="btn btn-primary">ตกลง</button>
		<a href="{siteUrl url="/ecatalog"}" class="btn btn-warning">กลับไปยังรายการ</a>
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
