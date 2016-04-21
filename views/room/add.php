{extends file="template.php"}
{block name=body}
<h4>{if isset($form->attr.id)}แก้ไขห้อง{else}เพิ่มห้อง{/if}</h4>
<div class="form-wrap">
	{if $form->error}
	<div class="alert alert-danger" role="alert">
		<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
		<span class="sr-only">Error:</span>
		{$form->error}
	</div>
	{/if}
	<form method="post" enctype="multipart/form-data" action="?submit={time()}">
		<div class="form-group">
			<label>Name</label>
			<input type="text" class="form-control" name="name" value="{$form->attr.name}" placeholder="" required>
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
