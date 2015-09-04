@extends('admin.leftbarbase')
@section('main')
<section class="mala-content">
        <h1 class="mala-title-bar">视频内容管理</h1>
        <ul class="mala-tab-navi-bar mala-clearfix">
            <li class="mala-tab-navi-item mala-fl mala-mr active">所有视频</li>
        </ul>
        <div class="mala-container-fluid">
            <div class="mala-opt-bar mala-clearfix">
                <div class="mala-btn-group mala-mr"><a class="mala-btn mala-btn-primary mala-btn" data-toggle="modal" data-target="#malaModal">新建内容</a>
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
						@foreach($imagelist as $image)
                         <tr class="mala-tr">
                            <td class="mala-td">{{$image['Content_ID']}}</td>
                            <td class="mala-td mala-td-title">{{$image['Title']}}</td>
                            <td class="mala-td">{{$image['Poster']}}</td>
							<td class="mala-td">{{$image['FirstLevelName']}}</td>
							<td class="mala-td">{{$image['SecondLevelName']}}</td>
							<td class="mala-td">{{$image['Create_Time']}}</td>
                            <td class="mala-td">{{$image['Update_Time']}}</td>
                            <td class="mala-td"><a href="./mediadetail?Content_ID={{$image['Content_ID']}}" class="mala-mr js-edit">编辑</a> <a href="/api/delmaterials?Content_ID={{$image['Content_ID']}}" class="mala-mr js-edit">删除</a>  <a class="mala-mr js-edit" href="/admin/videopreview?ContentID={{$image['Content_ID']}}">查看视频</a>
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
                    <a href="video?Page={{$currentpage-1}}"><span class="mala-caret mala-caret-prev"></span></a>
                </span>
                @endif

                @for ($i = 1; $i < $totalpage+1; $i++)
                	@if($i == $currentpage)
                	<a href="video?Page={{$i}}" class="mala-paginate-link active">{{$i}}</a>
                	@else
                	<a href="video?Page={{$i}}" class="mala-paginate-link">{{$i}}</a>
                	@endif
                @endfor
                 
                @if ($currentpage < $totalpage)  
                <span class="mala-paginate-link">
                    <a href="video?Page={{$currentpage+1}}"><span class="mala-caret mala-caret-next"></span></a>
                </span>
                @endif
            </div>
        </div>
	</section>

<!-- =====================模拟弹窗================= -->	
	<div class="mala-modal fade" id="malaModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="mala-modal-dialog">
            <div class="mala-modal-content">
                <div class="mala-modal-header">
                    <button type="button" class="close" id='new_style_close' data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="mala-modal-title" id="myModalLabel">新增视频</h4>
                </div>
                <div class="mala-modal-body">
                <!-- =============================在mala-modal-body中写上弹窗中内容的html=================== -->
					<form id='form'  enctype="multipart/form-data" method='POST' target='#'>
						<div class="mala-container-fluid">
							<div class="mala-form">
								<div class="mala-form-item mala-row">
									<div class="mala-col-md-3">
										<label for="" class="mala-label mala-form-fix">
											<span class="mala-required">*</span>视频名称</label>
									</div>
									<div class="mala-col-md-6">
										<input type="text" class="mala-input mala-form-control" name='Title'>
									</div>
								</div>
								 <div class="mala-form-item mala-row">
									<div class="mala-col-md-3">
										<label for="" class="mala-label mala-form-fix">
											<span class="mala-required">*</span>所属一级类目</label>
									</div>
									<div class="mala-col-md-3">
										<select name="FirstLevel" id="firstlevel" class="mala-select mala-form-control" onchange='check2menu(this);'>
										@foreach ($menulist as $menu)
											<option value="{{$menu['Menu_ID']}}">{{$menu['Menu_Name']}}</option>
										@endforeach
										</select>
									</div>
								</div>
								<div class="mala-form-item mala-row">
									<div class="mala-col-md-3">
										<label for="" class="mala-label mala-form-fix">
											<span class="mala-required">*</span>所属二级类目</label>
									</div>
									<div class="mala-col-md-3">
										<select name="SecondLevel" id="secondmenu" class="mala-select mala-form-control">
										@foreach ($submenulist as $menu)
											<option value="{{$menu['Menu_ID']}}">{{$menu['Menu_Name']}}</option>
										@endforeach
										</select>
									</div>
								</div>
								<div class="mala-form-item mala-row">
									<div class="mala-col-md-3">
										<label for="" class="mala-label mala-form-fix">
											<span class="mala-required">*</span>视频描述</label>
									</div>
									<div class="mala-col-md-6">
										<textarea name="Content" class="mala-textarea mala-form-control" rows="4"></textarea>
									</div>
								</div>
								<div class="mala-form-item mala-row">
									<div class="mala-col-md-3">
										<label for="" class="mala-label mala-form-fix">
											<span class="mala-required">*</span>上传视频</label>
									</div>
									<input onchange="" style='display:none' type="file" name="file" id="upload_file" />
									<div class="mala-col-md-3"><span class="mala-btn mala-btn-default mala-btn-block" onclick='upload_pic(this.className);$("#upload_file").click();'>点击上传</span>
										<br>
										<div id='preview'>
										<!-- <img src="images/slide1.jpg" class="mala-form-photo"> -->
										</div>
									</div>
								</div>
								<div class="mala-form-item mala-row">
									<div class="mala-col-md-3">
										<label for="" class="mala-label mala-form-fix">&nbsp;</label>
									</div>
									<div class="mala-col-md-3">&nbsp;</div>
								</div>
							</div>
						</div>
					</form>
				</div>
                <div class="mala-modal-footer">
                    <button type="button" class="mala-btn mala-btn-default mala-btn-wie mala-mr" data-dismiss="modal">取消</button>
                    <button onclick="fsubmit();$('#new_style_close').click();" type="button" class="mala-btn mala-btn-primary mala-btn-wide">保存</button>
                </div>
            </div>
        </div>
    </div>

@endsection
