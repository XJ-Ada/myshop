<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<script type="text/javascript" src='<?php echo (AD_JS_URL); ?>jquery-1.8.3.min.js' ></script>
<style type="text/css">
<!--
body { 
    margin-left: 3px;
    margin-top: 0px;
    margin-right: 3px;
    margin-bottom: 0px;
}
.STYLE1 {
    color: #e1e2e3;
    font-size: 12px;
}
.STYLE6 {color: #000000; font-size: 12; }
.STYLE10 {color: #000000; font-size: 12px; }
.STYLE19 {
    color: #344b50;
    font-size: 12px;
}
.STYLE21 {
    font-size: 12px;
    color: #3b6375;
}
.STYLE22 {
    font-size: 12px;
    color: #295568;
}
a:link{
    color:#e1e2e3; text-decoration:none;
}
a:visited{
    color:#e1e2e3; text-decoration:none;
}

-->
</style>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="30"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="24" bgcolor="#353c44"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="6%" height="19" valign="bottom"><div align="center"><img src="<?php echo (AD_IMG_URL); ?>tb.gif" width="14" height="14" /></div></td>
                <td width="94%" valign="bottom"><span class="STYLE1"> <?php echo ($daohang["first"]); ?> -> <?php echo ($daohang["second"]); ?></span></td>
              </tr>
            </table></td>
            <td><div align="right"><span class="STYLE1">
              <a href="<?php echo ($daohang["third_url"]); ?>"><img src="<?php echo (AD_IMG_URL); ?>add.gif" width="10" height="10" /> <?php echo ($daohang["third"]); ?></a>   &nbsp; 
              </span>
              <span class="STYLE1"> &nbsp;</span></div></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>

<!--中间体现不同页面的具体内容，并且每个页面内容不一样
通过content代表不同具体业务模板内容
-->
<script type="text/javascript" src='<?php echo (PLUGIN_URL); ?>ueditor/ueditor.config.js' ></script>
<script type="text/javascript" src='<?php echo (PLUGIN_URL); ?>ueditor/ueditor.all.min.js' ></script>
<script type="text/javascript" src='<?php echo (PLUGIN_URL); ?>ueditor/lang/zh-cn/zh-cn.js' ></script>
<tr>
<td>
<style type="text/css">
#tabbar-div {
    font-size:12px;
    background: none repeat scroll 0 0 #80BDCB;
    height: 22px;
    padding-left: 10px;
    padding-top: 1px;
}
#tabbar-div p {
    margin: 2px 0 0;
}
.tab-back {
    border-right: 1px solid #FFFFFF;
    color: #FFFFFF;
    cursor: pointer;
    line-height: 20px;
    padding: 4px 15px 4px 18px;
}
.tab-front {
    background: none repeat scroll 0 0 #BBDDE5;
    border-right: 2px solid #278296;
    cursor: pointer;
    font-weight: bold;
    line-height: 20px;
    padding: 4px 15px 4px 18px;
}
</style>
<div id="tabbar-div">
<p>
<span id="general-tab" class="tab-front">通用信息</span>
<span id="detail-tab" class="tab-back">详细描述</span>
<span id="mix-tab" class="tab-back">其他信息</span>
<span id="properties-tab" class="tab-back">商品属性</span>
<span id="gallery-tab" class="tab-back">商品相册</span>
<span id="linkgoods-tab" class="tab-back">关联商品</span>
<span id="groupgoods-tab" class="tab-back">配件</span>
<span id="article-tab" class="tab-back">关联文章</span>
</p>
</div>
<script type='text/javascript'>
//给全部的“标签”设置“click点击”事件
//页面加载完毕后，设置事件
//click()内部有遍历机制，会给每个span设置onclick事件
$(function(){
  $('#tabbar-div span').click(function(){
    $('#tabbar-div span').attr('class','tab-back')//全部标签变暗
    //this：当前点击span的dom对象
    //$(this): 把dom对象变成jquery对象
    $(this).attr('class','tab-front');//当前点击的标签高亮

    //标签对应的内容显示
    $('table[id$=-show]').hide();//全部的table隐藏
    //当前标签对应的table显示
    var idflag = $(this).attr('id');
    $('#'+idflag+'-show').show();
  });
});
</script>
<script type='text/javascript'>
//主分类切换显示第一个扩展分类
function show_cat1(){
  //获得当前选取的主分类id信息
  var cat_id = $('#main_cat0').val();

  //不显示分类信息处理
  if(cat_id==0){
      $('#ext_cat1 option:gt(0)').remove();//清除旧数据标签
      $('#ext_cat2 option:gt(0)').remove();//清除第二个扩展分类信息
  }else{
      //让ajax带着cat_id信息，去服务器端获得子级分类信息
      $.ajax({
        url:"/index.php/Admin/Category/getCatByPid",
        data:{'cat_id':cat_id},
        dataType:'json',
        type:'get',
        success:function(msg){
          var s = "";
          //遍历msg并与html标签(option)结合，最后追加给页面
          $.each(msg,function(){
            s += "<option value='"+this.cat_id+"'>--/"+this.cat_name+"</option>";
          });
          $('#ext_cat1 option:gt(0)').remove();//清除旧数据标签
          $('#ext_cat2 option:gt(0)').remove();//清除第二个扩展分类信息
          $('#ext_cat1').append(s);//追加新标签
        }
      });
    }
}
//第一个扩展分类切换显示第二个扩展分类
function show_cat2(){
  //获得当前选取的第一级别扩展分类id信息
  var cat_id = $('#ext_cat1').val();

  //不显示分类信息处理
  if(cat_id==0){
    $('#ext_cat2 option:gt(0)').remove();//清除旧数据标签
  }else{
    //让ajax带着cat_id信息，去服务器端获得子级分类信息
    $.ajax({
      url:"/index.php/Admin/Category/getCatByPid",
      data:{'cat_id':cat_id},
      dataType:'json',
      type:'get',
      success:function(msg){
        var s = "";
        //遍历msg并与html标签(option)结合，最后追加给页面
        $.each(msg,function(){
          s += "<option value='"+this.cat_id+"'>--/--/"+this.cat_name+"</option>";
        });
        $('#ext_cat2 option:gt(0)').remove();//清除旧数据标签
        $('#ext_cat2').append(s);//追加新标签
      }
    });
  }
}
</script>


<form action="/index.php/Admin/Goods/tianjia.html" method="post" enctype='multipart/form-data'>
<table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#a8c7ce" id='general-tab-show'>
  <tr>
    <td height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="right"><span class="STYLE19">商品名称：</span></div></td>
    <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="left">
    <input type="text" name="goods_name" />
    </div></td>
  </tr>
  <tr>
    <td height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="right"><span class="STYLE19">价格：</span></div></td>
    <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="left"><input type="text" name="goods_price" /></div></td>
  </tr>
  <tr>
    <td height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="right"><span class="STYLE19">数量：</span></div></td>
    <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="left"><input type="text" name="goods_number" /></div></td>
  </tr>
  <tr>
    <td height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="right"><span class="STYLE19">重量：</span></div></td>
    <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="left"><input type="text" name="goods_weight" /></div></td>
  </tr>
  <tr>
    <td height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="right"><span class="STYLE19">商品主分类：</span></div></td>
    <td height="20" bgcolor="#FFFFFF" class="STYLE19">
    <div align="left">
    <select id='main_cat0' name='cat_id' onchange='show_cat1()'>
      <option value='0'>-请选择-</option>
      <?php if(is_array($catinfoA)): foreach($catinfoA as $key=>$v): ?><option value="<?php echo ($v["cat_id"]); ?>"><?php echo ($v["cat_name"]); ?></option><?php endforeach; endif; ?>
    </select>
    </div></td>
  </tr>  
  <tr>
    <td height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="right"><span class="STYLE19">扩展分类：</span></div></td>
    <td height="20" bgcolor="#FFFFFF" class="STYLE19">
    <div align="left">
    <select id='ext_cat1' name='ext_cat[]' onchange='show_cat2()'>
    <option value='0'>-请选择-</option></select>
    <select id='ext_cat2' name='ext_cat[]'>
    <option value='0'>-请选择-</option></select>
    </div></td>
  </tr>
  <tr>
    <td height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="right"><span class="STYLE19">商品logo图片：</span></div></td>
    <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="left">
    <input type="file" name="goods_logo" /></div></td>
  </tr>

</table>

<table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#a8c7ce" style='display:none;' id='detail-tab-show'>
      <tr>
    <td height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="right"><span class="STYLE19">详情描述：</span></div></td>
    <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="left">
    <textarea rows="5" cols="30" id='goods_introduce' name='goods_introduce' style='width:550px;height:260px;'></textarea>
    </div></td>
  </tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#a8c7ce" style='display:none;' id='mix-tab-show'>
      <tr>
    <td height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="left"><span class="STYLE19">其他信息</span></div></td>
    <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="left">
    </div></td>
  </tr>
</table>
<script type='text/javascript'>
//根据类型显示对应的属性列表信息
function show_attr2(){
  //当前选中的类型id
  var typeid = $('[name=type_id]').val();

  //带着typeid去服务器端请求对应的属性列表信息回来
  $.ajax({
    url:"/index.php/Admin/Attribute/getAttributeByType2",
    data:{'typeid':typeid},
    dataType:'json',
    type:'get',
    success:function(msg){
      //console.log(msg);
      //遍历msg，并与具体的html代码结合同时追加给页面
      var s = "";
      $.each(msg,function(){
        //展示的信息：属性名称、输入框/下拉列表
        if(this.attr_sel=='0'){
          //单选属性
          s += '<tr><td align="right"  bgcolor="#FFFFFF"><span class="STYLE19"><em>'+this.attr_name+'：</em></span></td><td bgcolor="#FFFFFF">';
          s += '<input type="text" size="40" value="" name="attrid['+this.attr_id+'][]">';
        }else{
          //多选属性
          s += '<tr><td align="right"  bgcolor="#FFFFFF"><span class="STYLE19"><span onclick="add_attr(this)">[+]</span><em>'+this.attr_name+'：</em></span></td><td bgcolor="#FFFFFF">';
          //拆分attr_vals供选择的信息，并追加给下拉列表
          var vals = this.attr_vals.split(',');
          s += '<select name="attrid['+this.attr_id+'][]"><option value="0">-请选择-</option>';
          for(var i=0; i<vals.length; i++){
            s += '<option value="'+vals[i]+'">'+vals[i]+'</option>';
          }
          s += '</select>';
        }
        s += '</td></tr>';
      });
      //去除旧的属性信息
      $('#properties-tab-show tr:gt(0)').remove();
      //追加s到页面上
      $('#properties-tab-show').append(s);
    }
  });
}

//点击[+]增加多选属性tr
//@param obj: 代表[+]外边的span的dom对象
function add_attr(obj){
  //“复制”obj对应的tr节点
  var fu_tr = $(obj).parent().parent().parent().clone();

  //把fu_tr内部的[+]号变为[-]，并给[-]号设置触发事件
  fu_tr.find('.STYLE19 span').remove(); //删除fu_tr内部的[+]号span
  fu_tr.find('em').before('<span onclick="$(this).parent().parent().parent().remove()">[-]</span>')//给fu_tr再追加一个[-]号span

  //追加fu_tr 称为obj对应tr的后续兄弟节点
  $(obj).parent().parent().parent().after(fu_tr); //兄弟关系节点追加
}
</script>
<table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#a8c7ce" style='display:none;' id='properties-tab-show'>
  <tr>
    <td width='40%' height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="right"><span class="STYLE19">商品类型：</span></div></td>
    <td height="20" bgcolor="#FFFFFF" class="STYLE19">
    <div align="left">
      <select name='type_id' onchange='show_attr2()'>
        <option value='0'>-请选择-</option>
        <?php if(is_array($typeinfo)): foreach($typeinfo as $key=>$v): ?><option value='<?php echo ($v["type_id"]); ?>'><?php echo ($v["type_name"]); ?></option><?php endforeach; endif; ?>
      </select>
    </div></td>
  </tr>
</table>
<script type="text/javascript">
function add_pics(){
//增加相册
//就是给table增加tr节点而已
$('#gallery-tab-show').append('<tr><td height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="right"><span onclick="$(this).parent().parent().parent().remove()" class="STYLE19">[-]商品相册：</span></div></td><td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="left"><input type="file" name="goods_pics[]"></div></td></tr>');
}
</script>
<table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#a8c7ce" style='display:none;' id='gallery-tab-show'>
  <tr>
    <td height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="right"><span class="STYLE19" onclick="add_pics()">[+]商品相册：</span></div></td>
    <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="left">
    <input type='file' name='goods_pics[]' />
    </div></td>
  </tr>      

</table>
<table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#a8c7ce">
  <tr>
    <td height="20" bgcolor="#FFFFFF" class="STYLE6" colspan='2'><div align="center"><input type="submit" value='添加商品' /></div></td>
  </tr>
</table>
</form>
</td>
</tr>

<script type="text/javascript">
var ue = UE.getEditor('goods_introduce',{toolbars: [[
        'fullscreen', 'source', '|', 'undo', 'redo', '|',
        'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall', 'cleardoc', '|',
        'rowspacingtop', 'rowspacingbottom', 'lineheight', '|',
        'customstyle', 'paragraph', 'fontfamily', 'fontsize', '|',
        'directionalityltr', 'directionalityrtl', 'indent', '|',
        'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|', 'touppercase', 'tolowercase', '|',
        'link', 'unlink', 'anchor', '|', 'imagenone', 'imageleft', 'imageright', 'imagecenter', '|',
        'simpleupload', 'insertimage'
    ]]});
</script>



</table>
</body>
</html>