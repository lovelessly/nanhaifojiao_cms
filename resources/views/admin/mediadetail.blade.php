@extends('admin.leftbarbase')
@section('main')
<section class="mala-content">
        <h1 class="mala-title-bar">详情编辑</h1>
        <div class="mala-flow-bar">
        </div>
        <form id='form' enctype="multipart/form-data">
			<div class="mala-container-fluid">
				<input type="text" style='display:none' name='ContentID' value="{{$materialsdata['Content_ID']}}">
                            <div class="mala-form">
                                <div class="mala-form-item mala-row">
                                    <div class="mala-col-md-3">
                                        <label for="" class="mala-label mala-form-fix">
                                        @if ($materialsdata['Content_type'] == 1)
                                            <span class="mala-required">*</span>图片名称</label>
                                        @elseif ($materialsdata['Content_type'] == 2)
                                            <span class="mala-required">*</span>视频名称</label>
                                        @endif
                                    </div>
                                    <div class="mala-col-md-6">
                                        <input type="text" class="mala-input mala-form-control" value="{{$materialsdata['Title']}}" name='Title'>
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
                                            @if($menu['Menu_ID'] == $materialsdata['FirstLevel'])
                                            <option value="{{$menu['Menu_ID']}}" selected="selected">{{$menu['Menu_Name']}}</option>
                                            @else
                                            <option value="{{$menu['Menu_ID']}}">{{$menu['Menu_Name']}}</option>
                                            @endif
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
                                            @if($menu['Menu_ID'] == $materialsdata['SecondLevel'])
                                            <option value="{{$menu['Menu_ID']}}" selected="selected">{{$menu['Menu_Name']}}</option>
                                            @else
                                            <option value="{{$menu['Menu_ID']}}">{{$menu['Menu_Name']}}</option>
                                            @endif
                                        @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="mala-form-item mala-row">
                                    <div class="mala-col-md-3">
                                        <label for="" class="mala-label mala-form-fix">
                                        @if ($materialsdata['Content_type'] == 1)
                                            <span class="mala-required">*</span>图片描述</label>
                                        @elseif ($materialsdata['Content_type'] == 2)
                                            <span class="mala-required">*</span>视频描述</label>
                                        @endif
                                    </div>
                                    <div class="mala-col-md-6">
                                        <textarea name="Content" class="mala-textarea mala-form-control" rows="4" id='desc'>{{$materialsdata['Content']}}</textarea>
                                    </div>
                                </div>
                                <div class="mala-form-item mala-row">
                                    <div class="mala-col-md-3">
                                        <label for="" class="mala-label mala-form-fix">
                                        @if ($materialsdata['Content_type'] == 1)
                                            <span class="mala-required">*</span>图片素材</label>
                                        @elseif ($materialsdata['Content_type'] == 2)
                                            <span class="mala-required">*</span>视频素材</label>
                                        @endif
                                    </div>
                                    @if ($materialsdata['Content_type'] == 1)
                                    <input onchange="previewImage(this)" style='display:none' type="file" name="file" id="upload_file" />
                                    <div class="mala-col-md-3"><span class="mala-btn mala-btn-default mala-btn-block" onclick='upload_pic(this.className);$("#upload_file").click();'>点击上传图片</span>
                                    @elseif ($materialsdata['Content_type'] == 2)
                                    <input onchange="$('#video_download_link').html('已完成视频预上传');$('#video_download_link').removeattr('href');" style='display:none' type="file" name="file" id="upload_file" />
                                    <div class="mala-col-md-3"><span class="mala-btn mala-btn-default mala-btn-block" onclick='upload_pic(this.className);$("#upload_file").click();'>点击上传视频</span>
                                    @endif
                                        <br>
                                        <div id='preview'>
                                        @if ($materialsdata['Content_type'] == 1)
                                        <img  src="{{$materialsdata['Materials_Url']}}" class="mala-form-photo" id='style_img'>
										@elseif ($materialsdata['Content_type'] == 2)
										<div id='video_download_link'><a href="{{$materialsdata['Materials_Url']}}" id='video_download_link'>点击下载视频</a></div>
                                        @endif
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
            <div class=" mala-form-opt">
				<button type="button" onclick="history.back()" class="mala-btn mala-btn-default mala-btn-wie mala-mr">取消</button>
				@if ($materialsdata['Content_type'] == 1)
				<button onclick="fupdate(this);" id="image" type="button" class="mala-btn mala-btn-primary mala-btn-wide">保存</button>
				@else
				<button onclick="fupdate(this);" id="video" type="button" class="mala-btn mala-btn-primary mala-btn-wide">保存</button>
				@endif
            </div>
        </form>
    </section>

@endsection
