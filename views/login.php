<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>UM</title>

	<link rel="stylesheet" type="text/css" href="{siteUrl url='/asset/bootstrap/css/bootstrap.min.css'}">
	<link rel="stylesheet" type="text/css" href="{siteUrl url='/asset/bootstrap/css/bootstrap-theme.min.css'}">

	<script src="{siteUrl url='/asset/jquery/jquery-1.11.3.min.js'}"></script>
	<script src="{siteUrl url='/asset/bootstrap/js/bootstrap.min.js'}"></script>
</head>
<body>
<style>
    body {
        background: url(http://localhost/um_old/public/images/bg_login.jpg);
    }

    .jumbotron {
        text-align: center;
        width: 30rem;
        border-radius: 0.5rem;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        position: absolute;
        margin: 4rem auto;
        background-color: #fff;
        padding: 2rem;
        height: 430px;
    }

    .container .glyphicon-list-alt {
        font-size: 10rem;
        margin-top: 3rem;
        color: #f96145;
    }

    input {
        width: 100%;
        margin-bottom: 1.4rem;
        padding: 1rem;
        background-color: #ecf2f4;
        border-radius: 0.2rem;
        border: none;
    }

    h2 {
        margin-bottom: 3rem;
        font-weight: bold;
        color: #ababab;
    }

    .btn {
        border-radius: 0.2rem;
    }

    .btn .glyphicon {
        font-size: 3rem;
        color: #fff;
    }

    .full-width {
        background-color: #8eb5e2;
        width: 100%;
        -webkit-border-top-right-radius: 0;
        -webkit-border-bottom-right-radius: 0;
        -moz-border-radius-topright: 0;
        -moz-border-radius-bottomright: 0;
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
    }

    .box {
        position: absolute;
        bottom: 0;
        left: 0;
        margin-bottom: 3rem;
        margin-left: 3rem;
        margin-right: 3rem;
    }
</style>
<div class="jumbotron">
    <div class="container">
        <span class="glyphicon glyphicon-list-alt"></span>

        <h2>Login</h2>

        <div class="box">
            <form data-toggle="validator" role="form" name="loginForm" id="loginForm" method="post">
                <input type="username" placeholder="username" required name="username"
                    {if isset($loginForm)} value="{$loginForm->attr.username}"{/if}>
                <input type="password" placeholder="password" required name="password">
                <button class="btn btn-primary full-width"><span class="glyphicon glyphicon-ok"></span></button>
            </form>
            {if isset($loginForm)}<small>{$loginForm->error}</small>{/if}
        </div>
    </div>
</div>
</body>
</html>