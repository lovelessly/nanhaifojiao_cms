function upload_pic(params){
	//alert('upload_pic_func()');	
}


function previewImage(file)
 {
    var MAXWIDTH = 260;
    var MAXHEIGHT = 180;
    var div = document.getElementById('preview');
    if (file.files && file.files[0])
    {
        div.innerHTML = '<img id=imghead>';
        var img = document.getElementById('imghead');
        img.onload = function() {
            var rect = clacImgZoomParam(MAXWIDTH, MAXHEIGHT, img.offsetWidth, img.offsetHeight);
            img.width = rect.width;
            img.height = rect.height;
            //                 img.style.marginLeft = rect.left+'px';
            img.style.marginTop = rect.top + 'px';

        }
        var reader = new FileReader();
        reader.onload = function(evt) {
            img.src = evt.target.result;
        }
        reader.readAsDataURL(file.files[0]);

    }
    else
    {
        var sFilter = 'filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale,src="';
        file.select();
        var src = document.selection.createRange().text;
        div.innerHTML = '<img id=imghead>';
        var img = document.getElementById('imghead');
        img.filters.item('DXImageTransform.Microsoft.AlphaImageLoader').src = src;
        var rect = clacImgZoomParam(MAXWIDTH, MAXHEIGHT, img.offsetWidth, img.offsetHeight);
        status = ('rect:' + rect.top + ',' + rect.left + ',' + rect.width + ',' + rect.height);
        div.innerHTML = "<div id=divhead style='width:" + rect.width + "px;height:" + rect.height + "px;margin-top:" + rect.top + "px;" + sFilter + src + "\"'></div>";

    }

}
function clacImgZoomParam(maxWidth, maxHeight, width, height) {
    var param = {
        top: 0,
        left: 0,
        width: width,
        height: height
    };
    if (width > maxWidth || height > maxHeight)
    {
        rateWidth = width / maxWidth;
        rateHeight = height / maxHeight;

        if (rateWidth > rateHeight)
        {
            param.width = maxWidth;
            param.height = Math.round(height / rateWidth);

        } else
        {
            param.width = Math.round(width / rateHeight);
            param.height = maxHeight;

        }

    }

    param.left = Math.round((maxWidth - param.width) / 2);
    param.top = Math.round((maxHeight - param.height) / 2);
    return param;

}

function test(page){
var str = '';
var per_page = 20;
var pageint = parseInt(page)-1;
var limit_1 = String(pageint * per_page);
var limit_2 = String(per_page * (pageint + 1));
$.getJSON('../API/get_all_style.php',
	{'id':0,'limit':limit_1 + ',' + limit_2, 'method':'backend_all', 'ele_per_page':per_page},
	function(data){
		if(data.page == undefined){
			window.history.back(-1);
		}
		for (var i=0;i<data.data.length;i++){
			var str1 = '<tr class="mala-tr"><td class="mala-td">';
			var str2 = '<input type="checkbox" class="mala-ml-small">';
			var str3 = '<td class="mala-td">' + data.data[i].id + '</td>';
			var str4 = '</td><td class="mala-td mala-td-title"><a href="./detail.php?id=' + data.data[i].id + '">' + data.data[i].title + '</a></td>';
			var str5 = '<td class="mala-td">' + data.data[i].belong + '</td>';
			if(data.data[i].type == '0'){
				var type = 'PC';
			}
			else if(data.data[i].type == '1'){
				var type = 'Mobile';
			}
			else{
				var type = 'Null'
			};
			var str6 = '<td class="mala-td">' + type + '</td>';
			if(data.data[i].ishot == '0'){
				var hot = '否';
			}
			else if (data.data[i].ishot == '1'){
				var hot = '是';
			}
			else{
				var hot = '数据错误';
			}
			var str7 = '<td class="mala-td">' + hot + '</td>';
			var str8 = '<td class="mala-td">' + data.data[i].mod_time + '</td>';
			var str9 = '<td class="mala-td"><a href="./detail.php?id=' + data.data[i].id + '" class="mala-mr js-edit">编辑</a> <a href="#" id=' + data.data[i].id + ' onclick="delete_style(this.id)">删除</a></td></tr>';
			str = str + str1 + str2 + str3 + str4 + str5 + str6 + str7 + str8 + str9;
		}
		$('#element_list').html(str);
		$('.mala-pager').html(mod_tab_page(data.page,Request('page')));
	}
	)
}

function mod_tab_page(page,curPage){
		var str = '';
		if(curPage > 1){
                	str += '<span class="mala-paginate-link" onclick="prepage();"><span class="mala-caret mala-caret-prev"></span></span>'
		}
		for (var i=0;i < page;i++){
			var id = String(i+1);
			if(curPage == i+1){
				str += '<a href="?page=' + id +'" class="mala-paginate-link active">' + id +'</a>';
			}
			else{
				str += '<a href="?page=' + id +'" class="mala-paginate-link">' + id +'</a>';	
			}
		}
		if(page > curPage){
                	str += '<span class="mala-paginate-link" onclick="nextpage();"><span class="mala-caret mala-caret-next"></span></span>'
		}
		return str;
}

function Request(strName){
	var strHref = document.location.href;
	var intPos = strHref.indexOf("?");
	var strRight = strHref.substr(intPos + 1);
	var arrTmp = strRight.split("&");
	for(var i = 0; i < arrTmp.length; i++ ) {
	var arrTemp = arrTmp[i].split("=");
	if(arrTemp[0].toUpperCase() == strName.toUpperCase()) return arrTemp[1];
	}
	return 0;
}

function nextpage(){
	var curPage = parseInt(Request('page'));
	var nexPage = curPage + 1;
	window.location = './stylelist.php?page=' + nexPage;
}

function prepage(){
	var curPage = parseInt(Request('page'));
	var nexPage = curPage - 1;
	window.location = './stylelist.php?page=' + nexPage;
}

function getdetail(id){
	$.getJSON('../API/get_one_info.php',
		{'id':id},
		function(data){
			$('#ad_name').attr('value',data.data[0].title);
			$('#short_desc').attr('value',data.data[0].short_des);
			$('#belong').attr('value',data.data[0].belong);
			$('#toufang_url').attr('value',data.data[0].toufang_url);
			$('#detail_url').attr('value',data.data[0].detail_url);
			$('#charging_type').html(data.data[0].charging_type);
			$('#desc').html(data.data[0].desc);
			$('#s_keyword').html(data.data[0].s_keyword);
			$('#style_img').attr('src',data.data[0].image_url);
			$('#type_'+data.data[0].type).attr('selected','selected');
			$('#hot_'+data.data[0].ishot).attr('selected','selected');
			
		})
}

function delete_style(id){
	$.getJSON('../API/del_one_style.php',
		{'id':id},
		function(data){
			if(data.status == 0){
				location.reload();
			}
		})
}

function check2menu(obj){
	var id = obj.value;
	$.ajax({
                type: "GET",
                async: true, //同步执行
                url: '../api/submenu',
                data: {'ParentsID':id},
                dataType: "jsonp", //返回数据形式为json
                callback: "callback",
                success: function (result) {
					if(result.data.length > 0){
						$('#secondmenu').html('');
						for(var i = 0; i < result.data.length; i++){
							$('#secondmenu').append('<option value="'+result.data[i].Menu_ID+'">'+result.data[i].Menu_Name+'</option>');
						}
					}else{
						$('#secondmenu').html('<option value="0">无需选择二级类目</option>');						
					}
				},
                error: function (errorMsg) {
                }
    });

}

function fsubmit(){
	var data = new FormData($('#form')[0]);
	$.ajax({
		url: '../file/mediaupload',
		type: 'POST',
		data: data,
		dataType: 'JSON',
		cache: false,
		processData: false,
		contentType: false,
		success: function (result) {
			if(result.status == 0){
				alert('上传成功');
				location.reload();
			}else{
				alert(result.errorMsg);
			}
		},
		error:function(errorMsg){
			alert('上传过程出现错误，请刷新后再试');
		}
	});

}

function fupdate(obj){
	var data = new FormData($('#form')[0]);
	$.ajax({
		url: '../file/mediaupdate',
		type: 'POST',
		data: data,
		dataType: 'JSON',
		cache: false,
		processData: false,
		contentType: false,
		success: function (result) {
			if(result.status == 0){
				alert('上传成功');
				//history.back();
				window.location.href = './'+obj.id+'?Page=1';
			}else{
				alert(result.errorMsg);
			}
		},
		error:function(errorMsg){
			alert('上传过程出现错误，请刷新后再试');
		}
	});

}

function newspost(){
	var html = UE.getEditor('editor').getContent();
	var first = $('#firstmenu').val();
	var second = $('#secondmenu').val();
	var title = $('#title').val();
	$.ajax({
        type: "POST",
        async: true, //同步执行
        url: '../api/newsinsert',
        data: {'Title':title, 'FirstLevel':first,'SecondLevel':second,'Content':html},
        dataType: "jsonp", //返回数据形式为json
        callback: "callback",
        success: function (result) {
			if(result.status == 0){
				alert(result.Msg);
				window.location.href = './news?Page=1';
			}else{
				alert(result.errorMsg);
			}
		},
        error: function (errorMsg) {
			alert('后端服务异常');
        }
    });
}

function newsupdate(){
	var ContentID = parseInt(Request('Content_ID'));
	var html = UE.getEditor('editor').getContent();
	var first = $('#firstmenu').val();
	var second = $('#secondmenu').val();
	var title = $('#title').val();
	$.ajax({
        type: "POST",
        async: true, //同步执行
        url: '../api/newsupdate',
        data: {'ContentID':ContentID, 'Title':title, 'FirstLevel':first,'SecondLevel':second,'Content':html},
        dataType: "jsonp", //返回数据形式为json
        callback: "callback",
        success: function (result) {
			if(result.status == 0){
				alert(result.Msg);
				window.location.href = './news?Page=1';
			}else{
				alert(result.errorMsg);
			}
		},
        error: function (errorMsg) {
			alert('后端服务异常');
        }
    });
}

