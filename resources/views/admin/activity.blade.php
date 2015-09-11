@extends('admin.leftbarbase')
@section('main')
<section class="mala-content">
        <h1 class="mala-title-bar">活动内容管理</h1>
        <ul class="mala-tab-navi-bar mala-clearfix">
            <li class="mala-tab-navi-item mala-fl mala-mr active">所有活动</li>
        </ul>
        <div class="mala-container-fluid">
            <div class="mala-opt-bar mala-clearfix">
                <div class="mala-btn-group mala-mr"><a class="mala-btn mala-btn-primary mala-btn" href='./editactivity'>新建内容</a>
                </div>
               <!-- <div class="mala-btn-group "><a class="mala-btn mala-btn-danger" data-toggle="modal" data-target="#malaModal2">批量删除</a>
				</div>-->
				<!--=====================筛选项目,具体看js/common.js=============-->
				<!--
				<div class="mala-fake-select mala-fr">
                    <span class="mala-select-title js-fake-select">筛选项目</span> <i class="mala-arrow mala-arrow-down"></i>
                    <ul class="mala-select-list js-list">
                        <li class="mala-select-item js-select-item active">筛选项目</li>
                        <li class="mala-select-item js-select-item">发生的发生</li>
                        <li class="mala-select-item js-select-item">发生的发生</li>
                    </ul>
				</div>
				-->
            </div>
            <div class="mala-list-bar">
                <table id="js-mytable" class="mala-table">
                    <thead>
                        <tr>
                            <th class="mala-th" width="5%">ID</th>
                            <th class="mala-th" width='20%'>标题</th>
                            <th class="mala-th" width="10%">上传者</th>
                            <th class="mala-th" width="10%">从属一级类目</th>
                            <th class="mala-th" width="10%">从属二级类目</th>
                            <th class="mala-th" width="15%">创建时间</th>
                            <th class="mala-th" width="15%">修改时间</th>
                            <th class="mala-th" width="15%">操作</th>
                        </tr>
                    </thead>
					<tbody id='element_list'>
						@foreach($activitylist as $activity)
                         <tr class="mala-tr">
                            <td class="mala-td">{{$activity['Content_ID']}}</td>
                            <td class="mala-td mala-td-title">{{$activity['Title']}}</td>
                            <td class="mala-td">{{$activity['Poster']}}</td>
							<td class="mala-td">{{$activity['FirstLevelName']}}</td>
							<td class="mala-td">{{$activity['SecondLevelName']}}</td>
                            <td class="mala-td">{{$activity['Create_Time']}}</td>
                            <td class="mala-td">{{$activity['Update_Time']}}</td>
                            <td class="mala-td"><a href="./activitydetail?Content_ID={{$activity['Content_ID']}}" class="mala-mr js-edit">编辑</a> <a href="../api/delmaterials?Content_ID={{$activity['Content_ID']}}" class="mala-mr js-edit">删除</a>  <a class="mala-mr js-edit" href="../admin/activitypreview?Content_ID={{$activity['Content_ID']}}">预览活动</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!--==============换页=================-->
            <div class="mala-pager">
            	@if ($currentpage > 1)
                <span class="mala-paginate-link">
                    <a href="news?Page={{$currentpage-1}}"><span class="mala-caret mala-caret-prev" href="?Page={{$currentpage-1}}"></span></a>
                </span>
                @endif

                @for ($i = 1; $i < $totalpage+1; $i++)
                	@if($i == $currentpage)
                	<a href="news?Page={{$i}}" class="mala-paginate-link active">{{$i}}</a>
                	@else
                	<a href="news?Page={{$i}}" class="mala-paginate-link">{{$i}}</a>
                	@endif
                @endfor
                 
                @if ($currentpage < $totalpage)  
                <span class="mala-paginate-link">
                    <a href="news?Page={{$currentpage+1}}"><span class="mala-caret mala-caret-next"></span></a>
                </span>
                @endif
            </div>
        </div>
	</section>

@endsection
