@extends('admin.leftbarbase')
@section('main')
<style>
img{
	max-width: 100%;
}
</style>
<section class="mala-content" style="margin:0px;">
<div style="text-align:center;">
<h1 class="mala-title-bar">{{$materialsdata['Title']}}</h1>
<br>
<span>上传日期：{{$materialsdata['Create_Time']}} &nbsp;&nbsp;&nbsp;修改日期：{{$materialsdata['Update_Time']}}</span>
</div>
<br>
<div style="margin:20px">
{!!$materialsdata['Content']!!}
</div>
</section>
@endsection
