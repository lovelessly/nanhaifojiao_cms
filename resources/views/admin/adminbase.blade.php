<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <title>后台管理页面</title>
    <base href="{{Config::get('app.admin_domain')}}">
    <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<link href="css/freeue.css" rel="stylesheet" type="text/css">
	<script src="js/jquery.min.js"></script>
</head>

<body>
    <!--=============================导航栏================================-->
    <header id="js-header" class="mala-header mala-header-fix">
        <div class="mala-clearfix">
            <!--=============================右侧的个人中心================-->
            <a href="./index" class="mala-logo mala-fl"></a>
            <div class="mala-user-info mala-fr js-header-dropmenu">
                <span class="mala-username">欢迎使用管理后台, {{$username}}<i class="mala-arrow mala-arrow-down  mala-ml"></i>
                </span>
                <!--=====================js/common.js中控制下拉菜单========-->
                <ul class="mala-header-dropdown-list js-header-list">
                    <li class="mala-header-dropdown-item"><a href="./console" class="mala-link">后台管理中心</a>  <i class="mala-arrow mala-arrow-up" style="right:10px;"></i>
                    </li>
                    <li class="mala-header-dropdown-item"><a href="./logout" class="mala-link">退出</a>
                    </li>
                </ul>
            </div>
			<!--=====================mala-avatar控制头像=============-->
			<!--
            <span class="mala-avatar mala-fr">
                <img src="images/demo-photo.jpg">
			</span>
			-->
            @yield('top-bar')
        </div>
    </header>
    <!--=====================左侧栏,js代码在/js/navi.js=============-->
    @yield('left-bar')
    <!--=========主内容区======-->
    @yield('main')
    
    <div class="mala-aside-opt">
        <a href="{{Request::getRequestUri()}}#" class="" id="mala-aside-hide">
            <i class="fa fa-arrow-left"></i>
        </a>
        <a href="{{Request::getRequestUri()}}#" class="" id="mala-aside-show" style="display:none">
            <i class="fa fa-arrow-right"></i>
        </a>
	</div>
	<script src="js/function.js"></script>
	<!-- 主要用户左侧栏的下拉效果和导航栏的下拉 -->
	<script src="js/modal.js"></script>
    <script src="js/common.js"></script>
    <script src="js/echarts-plain-map.js"></script>
    <!--=======访问量统计表===========-->
    <script src="js/echarts-sample.js"></script>


</body>

</html>
