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
			<div class="row">
				<div class="col-md-10">
					<input type="text" name="width" class="form-control" value="{$form->attr.width}" placeholder="" required>
				</div>
				<div class="col-md-2" style="padding-top: 4px;">
					Meter
				</div>
			</div>
		</div>
		<div class="form-group">
			<label>Height</label>
			<div class="row">
				<div class="col-md-10">
					<input type="text" name="height" class="form-control" value="{$form->attr.height}" placeholder="" required>
				</div>
				<div class="col-md-2" style="padding-top: 4px;">
					Meter
				</div>
			</div>
		</div>
		<button type="submit" class="btn btn-primary">ตกลง</button>
		<a href="{siteUrl url="/room"}" class="btn btn-warning">กลับไปยังรายการ</a>
	</form>
</div>
<script type="text/javascript">
$(function(){
	$('.datepicker').datepicker();
});
</script>
{/block}
