<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <title>后台管理页面</title>
    <link href="css/freeue.css" rel="stylesheet" type="text/css">
    <base href="{{Config::get('app.admin_domain')}}">
    <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">
</head>

<body>
    <!--=============================导航栏================================-->
    <header id="js-header" class="mala-header">
        <div class="mala-clearfix mala-container">
        <!--=============================右侧的个人中心================-->
            <a href="./index" class="mala-logo mala-fl"></a>
            <div class="mala-user-info mala-fr js-header-dropmenu">
                @if (Session::get('isLogin') === true)
                <span class="mala-username">欢迎使用管理后台, {{$username}}<i class="mala-arrow mala-arrow-down  mala-ml"></i>
                </span>
                <!--=====================js/common.js中控制下拉菜单========-->
                <ul class="mala-header-dropdown-list js-header-list">
                    <li class="mala-header-dropdown-item"><a href="./console" class="mala-link">后台管理中心</a>  <i class="mala-arrow mala-arrow-up" style="right:10px;"></i>
                    </li>
                    <li class="mala-header-dropdown-item"><a href="./logout" class="mala-link">退出</a>
                    </li>
                </ul>
                @else
                <span class="mala-username">欢迎使用管理后台<i class="mala-arrow mala-arrow-down  mala-ml"></i>
                </span>
                <!--=====================js/common.js中控制下拉菜单========-->
                <ul class="mala-header-dropdown-list js-header-list">
                    <li class="mala-header-dropdown-item"><a href="./login" class="mala-link">登入</a>  <i class="mala-arrow mala-arrow-up" style="right:10px;"></i>
                    </li>
                </ul>
                @endif
            </div>
			<!--=====================mala-avatar控制头像=============-->
			<!--
            <span class="mala-avatar mala-fr">
                <img src="images/demo-photo.jpg">
			</span>
		-->
        </div>
    </header>
    <!--=====================图片轮播=============-->
    <!--=====================js_slider控制图片轮播,具体代码在文件尾部=============-->
    <div class="mala-slider" id="js-slider">
        <ul class="mala-slide-list">
            <!--=====================背景图片由mala-slider-item控制=============-->
            <li class="mala-slide-item mala-fl" style="background-image: url(images/slide1.jpg);">
                <div class="mala-container">
                    <h3 class="mala-slide-title">一站式信息发布平台</h3>
                    <h4 class="mala-slide-subtitle">简单，易用，全能</h4>
                    <p class="mala-slide-cont"><br></p>
                    <a href="./login" class="mala-btn mala-btn-primary mala-btn-larger">登陆后台</a>
                </div>
            </li>
            <li class="mala-slide-item mala-fl" style="background-image: url(images/slide2.jpg);">
                <div class="mala-container">
                    <h3 class="mala-slide-title">集成化数据整合平台</h3>
					<h4 class="mala-slide-subtitle">直观，完整，专业</h4>
					<p class="mala-slide-cont"><br></p> 
                    <a href="./login" class="mala-btn mala-btn-primary mala-btn-larger">登陆后台</a> 
                </div>
            </li>
        </ul>
    </div>
    <!--===========通知栏=============-->
    <div class="mala-notice">
        <div class="mala-container mala-clearfix">
            <div class="mala-fl"> <i class="fa fa-volume-up"></i>一站式通用内容管理系统</div>
            <div class="mala-fr"> <i class="fa fa-envelope-o"></i> {{Config::get('nanhai.Contact_Email')}} <!--<i class="fa fa-paw" style="margin-left:10px;"></i>--> ★ {{Config::get('nanhai.Website_Name')}}</div>
        </div>
    </div>
    <!--==============主体内容========-->
    <div class="mala-main">
        <div class="mala-container mala-clearfix">
            <figure class="mala-figure">
                <!--产品特点-->
                <div class="mala-service-list">
                    <div class="mala-row">
                        <div class="mala-col-md-4">
                            <div class="mala-service-item">
                                <span class="mala-service-img"><i class="fa fa-plane"></i>
                                </span>
                                <h4 class="mala-service-title">内容管理</h4>
                                <span class="mala-service-desc">一站式CMS管理系统</span>
                            </div>
                        </div>
                        <div class="mala-col-md-4">
                            <div class="mala-service-item">
                                <span class="mala-service-img"><i class="fa fa-shield"></i>
                                </span>
                                <h4 class="mala-service-title">账号管理</h4>
                                <span class="mala-service-desc">一站式用户中心</span>
                            </div>
                        </div>
                        <div class="mala-col-md-4">
                            <div class="mala-service-item">
                                <span class="mala-service-img"><i class="fa fa-tasks"></i>
                                </span>
                                <h4 class="mala-service-title">大数据信息整合</h4>
                                <span class="mala-service-desc">后台运营数据收集处理</span>
                            </div>
                        </div>
                    </div>
                </div>
            </figure>
        </div>
    </div>
    <!--==============页尾==============-->
    <footer class="mala-footer">
        <div class="mala-container mala-clearfix">
            <div class="mala-footer-links"></div>
            <div class="mala-row">
                <div class="mala-col-md-2">
                    <dl class="mala-footer-dl">
                        <dt class="mala-footer-dt">关于</dt>
                        <dd class="mala-footer-dd"> <a href="./index" class="mala-link">帮助</a> 
                        </dd>
                    </dl>
                </div>
                <div class="mala-col-md-2">
                    <dl class="mala-footer-dl">
                        <dt class="mala-footer-dt">友情链接</dt>
                        <dd class="mala-footer-dd"> <a href="./index" class="mala-link">联系</a> 
                        </dd>
                    </dl>
                </div>
                <div class="mala-col-md-2">
                    <dl class="mala-footer-dl">
                        <dt class="mala-footer-dt">反馈</dt>
                        <dd class="mala-footer-dd"> <a href="./index" class="mala-link">QQ：{{Config::get('nanhai.Contact_QQ')}}</a> 
                        </dd>
                    </dl>
                </div>
                <div class="mala-col-md-2">
                </div>
                <div class="mala-col-md-4">
                    <div class="mala-footer-copyright mala-fr">©2015 {{Config::get('nanhai.Company_Name')}}</div>
                </div>
            </div>
        </div>
    </footer>
    <script src="js/jquery.min.js"></script>
    <!--======主要用于header的控制===-->
    <script src="js/common.js"></script>
    <script src="js/jquery.glide.js"></script>
    <!--控制轮播图片切换代码，引用的js为jquery.glide.js-->
    <script>
    $('#js-slider').glide();                    
    </script>
</body>

</html>
