{extends file="template.php"}
{block name=body}
<h4>{if isset($form->attr.id)}แก้ไขแม่บ้าน{else}เพิ่มแม่บ้าน{/if}</h4>
<div class="form-wrap">
	<small>{$form->error}</small>
	<form method="post">
		<div class="form-group">
			<label>ชื่อ</label>
			<input type="text" class="form-control" name="first_name" value="{$form->attr.first_name}" placeholder="">
		</div>
		<div class="form-group">
			<label>นามสกุล</label>
			<input type="text" class="form-control" name="last_name" value="{$form->attr.last_name}" placeholder="">
		</div>
		<div class="form-group">
			<label>เบอร์โทรศัพท์</label>
			<input type="text" class="form-control" name="tel_number" value="{$form->attr.tel_number}" placeholder="">
		</div>
		<div class="form-group">
			<label>รหัส passport</label>
			<input type="text" class="form-control" name="passport_id" value="{$form->attr.passport_id}" placeholder="">
		</div>
		<div class="form-group">
			<label>วันหมดอายุ passport</label>
			<input type="text" class="form-control datepicker" name="passport_expiry" value="{$form->attr.passport_expiry}" data-date-format="yyyy-mm-dd" placeholder="">
		</div>
		<div class="form-group">
			<label>วันหมดอายุ visa</label>
			<input type="text" class="form-control datepicker" name="visa_expiry" value="{$form->attr.visa_expiry}" data-date-format="yyyy-mm-dd" placeholder="">
		</div>
		<div class="form-group">
			<label>วันหมดอายุรายงานตัว</label>
			<input type="text" class="form-control datepicker" name="report_expiry" value="{$form->attr.report_expiry}" data-date-format="yyyy-mm-dd" placeholder="">
		</div>
		<button type="submit" class="btn btn-primary">ตกลง</button>
		<a href="{siteUrl url="/employee"}" class="btn btn-warning">กลับไปยังรายการ</a>
	</form>
</div>
<script>
$(function(){
	$('.datepicker').datepicker()
});
</script>
{/block}
