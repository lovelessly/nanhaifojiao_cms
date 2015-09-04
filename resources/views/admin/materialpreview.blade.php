@extends('admin.leftbarbase')
@section('main')
	<section class="mala-content" style="margin:0px;text-align:center;">
	<h1 class="mala-title-bar">{{$materialsdata['Title']}}</h1>
	<br>
	<span>上传日期：{{$materialsdata['Create_Time']}} &nbsp;&nbsp;&nbsp;修改日期：{{$materialsdata['Update_Time']}}</span>
	<br>
	<br>
	@if($materialsdata['Content_type'] == 1)
	<img src="{!!$materialsdata['Materials_Url']!!}" style='max-width:100%;'/>
	@elseif($materialsdata['Content_type'] == 2)
	<video controls="controls" src="{!!$materialsdata['Materials_Url']!!}" style='max-width:100%;'/>
	@endif
	</section>
@endsection
