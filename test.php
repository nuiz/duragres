<?php
if(@$_POST['submit']) {
  echo "submit";
}
else {
  echo "cancle";
}
?>
<form method="post">
  <!-- code input -->
  <input type="submit" name="submit" value="ok">
  <input type="submit" name="cancle" value="no">
</form>
