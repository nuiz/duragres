<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Duragres</title>

	<link rel="stylesheet" type="text/css" href="{siteUrl url='/asset/bootstrap/css/bootstrap.min.css'}">
	<link rel="stylesheet" type="text/css" href="{siteUrl url='/asset/bootstrap/css/bootstrap-theme.min.css'}">
	<link rel="stylesheet" type="text/css" href="{siteUrl url='/asset/datepicker/css/datepicker.css'}">
	<link rel="stylesheet" type="text/css" href="{siteUrl url='/asset/css/style.css'}">

	<script src="{siteUrl url='/asset/jquery/jquery-1.11.3.min.js'}"></script>
	<script src="{siteUrl url='/asset/bootstrap/js/bootstrap.min.js'}"></script>
	<script src="{siteUrl url='/asset/datepicker/js/bootstrap-datepicker.js'}"></script>
	<!-- <script src="{siteUrl url=''}"></script> -->
</head>
<body>
<nav class="navbar navbar-default">
	<div class="container">
		<ul class="nav navbar-nav">
  		<li {if strpos({currentUrl}, {siteUrl url="/news"}) !== false}  class="active" {/if}><a href="{siteUrl url="/news"}">News & Promotion</a></li>
  		<li {if strpos({currentUrl}, {siteUrl url="/product"}) !== false} class="active" {/if}><a href="{siteUrl url="/product"}">Product</a></li>
  		<li {if strpos({currentUrl}, {siteUrl url="/contactdealer"}) !== false} class="active" {/if}><a href="{siteUrl url="/contactdealer"}">Contact Dealer</a></li>
  		<li {if strpos({currentUrl}, {siteUrl url="/ecatalog"}) !== false} class="active" {/if}><a href="{siteUrl url="/ecatalog"}">E-Catalog</a></li>
		<!--
			<li {if strpos({currentUrl}, {siteUrl url="/user"}) !== false} class="active" {/if}><a href="{siteUrl url="/user"}">User</a></li>
		-->
			<li {if strpos({currentUrl}, {siteUrl url="/menu"}) !== false} class="active" {/if}><a href="{siteUrl url="/menu"}">Menu</a></li>
			<li {if strpos({currentUrl}, {siteUrl url="/room"}) !== false} class="active" {/if}><a href="{siteUrl url="/room"}">Room</a></li>
			<li {if strpos({currentUrl}, {siteUrl url="/stat"}) !== false} class="active" {/if}><a href="{siteUrl url="/stat"}">Stat</a></li>
  		<li><a href="{siteUrl url="/logout"}">Logout</a></li>
		</ul>
	</div>
</nav>
<div class="container">
	{block name=body}{/block}
</div>
<div class="footer"></div>
<script>
$('.confirm-beforeclick').click(function(e){
	if(!window.confirm('คุณแน่ใจหรือไม่?')){
		e.preventDefault();
		return false;
	}
});
</script>
</body>
</html>
