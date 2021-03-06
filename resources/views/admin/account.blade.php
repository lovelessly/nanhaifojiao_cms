@extends('admin.leftbarbase')
@section('main')
<section class="mala-content">
        <h1 class="mala-title-bar">用户管理</h1>
        <ul class="mala-tab-navi-bar mala-clearfix">
            <li class="mala-tab-navi-item mala-fl mala-mr active">所有用户</li>
        </ul>
        <div class="mala-container-fluid">
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
                            <th class="mala-th" width="15%">用户名</th>
                            <th class="mala-th" width='25%'>邮箱</th>
                            <th class="mala-th" width="10%">是否管理员</th>
                            <th class="mala-th" width="5%">积分</th>
                            <th class="mala-th" width="20%">手机号</th>
                            <th class="mala-th" width="10%">操作</th>
                        </tr>
                    </thead>
					<tbody id='element_list'>
						@foreach($userlist as $user)
                         <tr class="mala-tr">
                            <td class="mala-td mala-td-title">{{$user['User_Name']}}</td>
                            <td class="mala-td">未开通服务</td>
                            @if($user['isAdmin'] == 1)
							<td class="mala-td">是</td>
                            @elseif($user['isAdmin'] == 0)
                            <td class="mala-td">否</td>
                            @endif
							<td class="mala-td">0</td>
                            <td class="mala-td">未开通服务</td>
                            <td class="mala-td"><!--<a href="./mediadetail?Content_ID=" class="mala-mr js-edit">编辑</a>--> <a href="../api/deluser?User_ID={{$user['User_ID']}}" class="mala-mr js-edit">删除</a> 
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
                    <a href="account?Page={{$currentpage-1}}"><span class="mala-caret mala-caret-prev"></span></a>
                </span>
                @endif

                @for ($i = 1; $i < $totalpage+1; $i++)
                	@if($i == $currentpage)
                	<a href="account?Page={{$i}}" class="mala-paginate-link active">{{$i}}</a>
                	@else
                	<a href="account?Page={{$i}}" class="mala-paginate-link">{{$i}}</a>
                	@endif
                @endfor
                 
                @if ($currentpage < $totalpage)  
                <span class="mala-paginate-link">
                    <a href="account?Page={{$currentpage+1}}"><span class="mala-caret mala-caret-next"></span></a>
                </span>
                @endif
            </div>
        </div>
	</section>

@endsection
