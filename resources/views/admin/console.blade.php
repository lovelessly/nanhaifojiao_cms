@extends('admin.leftbarbase')
@section('main')
<section class="mala-content">
        <h1 class="mala-title-bar">系统概况</h1>
        <div class="mala-overview-bar">
            <div class="mala-welcome">你好！欢迎登陆后台管理平台。</div>
            <div class="mala-login-time">本次登录时间：
                <time>{{Session::get('LoginTime')}}</time>
            </div>
            <div class="mala-statistic-list">
                <div class="mala-row">
                    <div class="mala-col-md-2">
                        <div class="mala-statistic-item">
                            <span class="mala-circle-title" style="font-size:22px;margin-top:25px">{{$data['AllImageCount']}}</span>
                            <br>
                            <span class="mala-circle-desc">图片素材</span>
                        </div>
                    </div>
                    <div class="mala-col-md-2">
                        <div class="mala-statistic-item">
                            <span class="mala-circle-title" style="font-size:22px;margin-top:25px">{{$data['AllVideoCount']}}</span>
                            <br>
                            <span class="mala-circle-desc">视频素材</span>
                        </div>
                    </div>
                    <div class="mala-col-md-2">
                        <div class="mala-statistic-item">
                            <span class="mala-circle-title" style="font-size:22px;margin-top:25px">{{$data['AllNewsCount']}}</span>
                            <br>
                            <span class="mala-circle-desc">新闻素材</span>
                        </div>
                    </div>
                    <div class="mala-col-md-2">
                        <div class="mala-statistic-item">
                            <span class="mala-circle-title" style="font-size:22px;margin-top:25px">{{$data['AllUserCount']}}</span>
                            <br>
                            <span class="mala-circle-desc">注册用户数</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mala-container-fluid">
            <div class="mala-row">
                <div class="mala-col-md-6">
                    <div class="mala-panel">
                        <div class="mala-panel-heading mala-clearfix">
                            <h3 class="mala-panel-title">最新新闻</h3>
                        </div>
                        <div class="mala-panel-body">
							<ul class="mala-list">
								@foreach($neweditlist as $element)
                                <li class="mala-list-item">
                                    <span class="mala-list-time mala-fr">{{$element['Create_Time']}}</span>
                                    <span class="mala-list-title"><a href="./newspreview?Content_ID={{$element['Content_ID']}}">{{$element['Title']}}</a>
                                    </span>
								</li>
								@endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="mala-col-md-6">
                    <div class="mala-panel">
                        <div class="mala-panel-heading mala-clearfix">
                            <h3 class="mala-panel-title">最新图片</h3>
                        </div>
                        <div class="mala-panel-body">
                            <ul class="mala-list">
                                @foreach($imagelist as $element)
                                <li class="mala-list-item">
                                    <span class="mala-list-time mala-fr">{{$element['Create_Time']}}</span>
                                    <span class="mala-list-title"><a href="./imagepreview?ContentID={{$element['Content_ID']}}">{{$element['Title']}}</a>
                                    </span>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <!--=====================访问统计表格使用echarts,具体看js/echarts.js=============-->
 <!--
                <div class="mala-col-md-6">
                    <div class="mala-panel">
						<div class="mala-panel-heading mala-clearfix">

                            <span class="mala-fr mala-panel-filter">
                                <div class="mala-fake-select mala-fr">
                                    <span class="mala-select-title js-fake-select">筛选项目</span> <i class="mala-arrow mala-arrow-down"></i>
                                    <ul class="mala-select-list js-list">
                                        <li class="mala-select-item js-select-item active">筛选项目</li>
                                        <li class="mala-select-item js-select-item">发生的发生</li>
                                        <li class="mala-select-item js-select-item">发生的发生</li>
                                    </ul>
                                    <ul class="mala-select-list-fix">
                                        <li class="mala-select-item">筛选项目</li>
                                        <li class="mala-select-item">发生的发生</li>
                                        <li class="mala-select-item">发生的发生</li>
                                    </ul>
                                </div>
							</span>
                            <h3 class="mala-panel-title">统计数据（未开发）</h3>
                        </div>
                        <div class="mala-panel-body">
                            <div id="js-visit-graph" class="mala-echarts-normal "></div>
                        </div>
                    </div>
                </div>
-->
            </div>
        </div>
    </section>
@endsection
