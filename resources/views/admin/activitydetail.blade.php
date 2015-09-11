@extends('admin.leftbarbase')
@section('main')
<script type="text/javascript" charset="utf-8" src="ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="ueditor.all.min.js"> </script>
<script type="text/javascript" charset="utf-8" src="lang/zh-cn/zh-cn.js"></script>

<section class="mala-content">
        <h1 class="mala-title-bar">活动管理</h1>
        <ul class="mala-tab-navi-bar mala-clearfix">
        </ul>
        <div class="mala-container-fluid">
            <div class="mala-opt-bar mala-clearfix">
                <div class="mala-btn-group mala-mr"><a class="mala-btn mala-btn-primary mala-btn" onclick="activityupdate()">保存</a>
                </div>
                <div class="mala-btn-group "><a class="mala-btn mala-btn-danger" onclick="history.back();">返回</a>
				</div>
				<div class="mala-btn-group" style='margin:10px'>活动标题</div>
				<div class="mala-btn-group" style='margin:10px'><input id='title' value="{{$materialsdata['Title']}}" /></div>
				<div class="mala-btn-group" style='margin:10px'>*选择一级类目:</div>
                <div class="mala-btn-group">
                    <select name="FirstLevel" id="firstmenu" class="mala-select mala-form-control" onchange='check2menu(this);'>
                    @foreach ($menulist as $menu)
                        @if($menu['Menu_ID'] == $materialsdata['FirstLevel'])
                            <option value="{{$menu['Menu_ID']}}" selected="selected">{{$menu['Menu_Name']}}</option>
                        @else
                            <option value="{{$menu['Menu_ID']}}">{{$menu['Menu_Name']}}</option>
                        @endif
                    @endforeach
    				</select>
                </div>
                <div class="mala-btn-group" style='margin:10px'>*选择二级类目:</div>
                <div class="mala-btn-group" style='width=20px'>
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
   		</div>
<div id='entity' style='display:none'>
    <script id="editor" type="text/plain" style="width:97%;height:500px;margin:20px;"></script>
</div>

<script type="text/javascript">

	var ue = UE.getEditor('editor');
	setTimeout(function(){UE.getEditor('editor').execCommand('insertHtml', '{!!$materialsdata["Content"] !!}');$('#entity').attr('style','display:block')}, 1500);

</script>
</section>
@endsection
