@extends('admin.adminbase')
@section('left-bar')
<nav id="js-aside" class="mala-aside">
        <h3 class="mala-subnavi-title">后台管理</h3>
		<ul class="mala-subnavi-list">
            <li class="mala-subnavi-item">
                <a href="./console" class="mala-subnavi-link"> <i class="fa fa-taxi fa-fw"></i> </i>总体概况</a>
			</li>
            <li class="mala-subnavi-item">
                <a href="./image" class="mala-subnavi-link"> <i class="fa fa-taxi fa-fw"></i> </i>图片管理</a>
            </li>
            <li class="mala-subnavi-item">
                <a href="./video" class="mala-subnavi-link"> <i class="fa fa-taxi fa-fw"></i> </i>视频管理</a>
            </li>
            <li class="mala-subnavi-item">
                <a href="./news" class="mala-subnavi-link"> <i class="fa fa-taxi fa-fw"></i> </i>新闻管理</a>
            </li>
        </ul>
        <h3 class="mala-subnavi-title">用户管理</h3>
        <ul class="mala-subnavi-list">
            <li class="mala-subnavi-item">
                <a href="./account" class="mala-subnavi-link"> <i class="fa fa-cube fa-fw"></i>会员账号管理</a>
            </li>
        </ul>
</nav>
@endsection
