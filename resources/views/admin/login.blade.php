<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>系统登录</title>
<link href="css/login.css" rel="stylesheet" rev="stylesheet" type="text/css" media="all" />
<link href="css/demo.css" rel="stylesheet" rev="stylesheet" type="text/css" media="all" />
<script src="js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="js/jquery.SuperSlide.js"></script>
<script type="text/javascript" src="js/Validform_v5.3.2_min.js"></script>
<script type="text/javascript" src="js/sha1.js"></script>
<link href="css/freeue.css" rel="stylesheet" type="text/css">
<link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">

<script>
$(function(){

$(".i-text").focus(function(){
$(this).addClass('h-light');
});

$(".i-text").focusout(function(){
$(this).removeClass('h-light');
});

$("#username").focus(function(){
 var username = $(this).val();
 if(username=='输入账号'){
 $(this).val('');
 }
});

$("#username").focusout(function(){
 var username = $(this).val();
 if(username==''){
 $(this).val('输入账号');
 }
});


$("#password").focus(function(){
 var username = $(this).val();
 if(username=='输入密码'){
 $(this).val('');
 }
});


$("#yzm").focus(function(){
 var username = $(this).val();
 if(username=='输入验证码'){
 $(this).val('');
 }
});

$("#yzm").focusout(function(){
 var username = $(this).val();
 if(username==''){
 $(this).val('输入验证码');
 }
});



$(".registerform").Validform({
	tiptype:function(msg,o,cssctl){
		var objtip=$(".error-box");
		cssctl(objtip,o.type);
		objtip.text(msg);
	},
		ajaxPost:true,
		beforeSubmit:function(curform){
			var newpass = "{{Session::get('tk')}}";
			var pass = hex_sha1(hex_sha1($('#password').val()) + newpass);
			$('#password').val(pass);
		},
	callback:function(data){
		if(data.status != 0){
			alert(data.errorMsg);
			location.reload();
		}else{
			window.location='./console';
		}
	}
});

});




</script>


</head>

<body>

<!--=============================导航栏================================-->
        <header id="js-header" class="mala-header mala-header-fix">
        <div class="mala-clearfix">
            <a href="index" class="mala-logo mala-fl"></a>
            <div class="mala-user-info mala-fr js-header-dropmenu">
                <span class="mala-username">欢迎使用管理后台<!--<i class="mala-arrow mala-arrow-down  mala-ml"></i>--></span>
            </div>
            <nav class="mala-fr">
                <ul class="mala-nav-list mala-clearfix">
                    <li class="mala-nav-item mala-fl"> <a href="index" class="mala-nav-link">首页</a> 
					</li>
					<!--
                    <li class="mala-nav-item mala-fl"> <a href="register.php" class="mala-nav-link">注册账号</a> 
                    </li>-->
                </ul>
            </nav>
        </div>
    </header>

<div class="banner">

<div class="login-aside">
  <div id="o-box-up"></div>
  <div id="o-box-down"  style="table-layout:fixed;">
   <div class="error-box"></div>
   
   <form class="registerform" action="../api/login">
   <div class="fm-item">
	   <label for="logonId" class="form-label">登录帐号：</label>
	   <input type="text" value="输入账号" name='username' maxlength="100" id="username" class="i-text"  datatype="s6-12" errormsg="用户名至少6个字符,最多12个字符！"  >    
       <div class="ui-form-explain"></div>
  </div>
  
  <div class="fm-item">
	   <label for="logonId" class="form-label">登陆密码：</label>
	   <input type="password" value="" maxlength="100" name='password' id="password" class="i-text" datatype="*6-16" nullmsg="请设置密码！" errormsg="密码范围在6~16位之间！">    
       <div class="ui-form-explain"></div>
  </div>
  
  
  <div class="fm-item">
	   <label for="logonId" class="form-label"></label>
	   <input type="submit" value="" tabindex="4" id="send-btn" class="btn-login"> 
       <div class="ui-form-explain"></div>
  </div>
  
  </form>
  
  </div>

</div>

	<div class="bd">
		<ul>
			<li style="background:url(./images/slide3.jpg) #CCE1F3 center 0 no-repeat;"></li>
		</ul>
	</div>

	<div class="hd"><ul></ul></div>
</div>
<script type="text/javascript">jQuery(".banner").slide({ titCell:".hd ul", mainCell:".bd ul", effect:"fold",  autoPlay:true, autoPage:true, trigger:"click" });</script>


<div class="banner-shadow"></div>
<div class="footer">
   <p>Copyright &copy; 2015.  {{Config::get('nanhai.Company_Name')}} All rights reserved.</p>
</div>
</body>
<script src="js/common.js"></script>
<script src="js/jquery.glide.js"></script>
</html>
