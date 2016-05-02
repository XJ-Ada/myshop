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
<script type="text/javascript">
//声明一个全局变量，把ajax已经请求回来的属性信息给予缓存
var attrinfo_cache = new Array();

//根据类型显示对应的属性列表信息
function show_attr(){
  //当前选中的类型id
  var typeid = $('[name=type_id]').val();

  //判断缓存是否存在当前类型对应的属性信息
  if(typeof attrinfo_cache[typeid] === 'undefined'){
    //带着typeid去服务器端请求对应的属性列表信息回来
    $.ajax({
      url:"/index.php/Admin/Attribute/getAttributeByType",
      data:{'typeid':typeid},
      dataType:'json',
      type:'get',
      async:false,
      success:function(msg){
        //console.log(msg);
        //遍历msg，并与具体的html代码结合同时追加给页面
        var s = "";
        $.each(msg,function(){
          var sel = this.attr_sel=='0'?'单选':'多选';
          var write = this.attr_write=='0'?'手工录入':'列表选择';
          //this:代表一个一个遍历出来小的json对象
          s += '<tr><td bgcolor="#FFFFFF"><div align="center"><input type="checkbox" id="checkbox2" name="checkbox2"></div></td><td bgcolor="#FFFFFF" class="STYLE6"><div align="center"><span class="STYLE19">'+this.attr_id+'</span></div></td><td bgcolor="#FFFFFF" class="STYLE19"><div align="left">'+this.attr_name+'</div></td><td bgcolor="#FFFFFF" class="STYLE19"><div align="center">'+this.type_name+'</div></td><td bgcolor="#FFFFFF" class="STYLE19"><div align="center">'+sel+'</div></td><td bgcolor="#FFFFFF" class="STYLE19"><div align="left">'+write+'</div></td><td bgcolor="#FFFFFF" class="STYLE19"><div align="center">'+this.attr_vals+'</div></td><td bgcolor="#FFFFFF"><div align="center" class="STYLE21"><img width="10" height="10" src="http://web.shop44.com/Public/Admin/images/del.gif"> 删除 | 查看 | <img width="10" height="10" src="http://web.shop44.com/Public/Admin/images/edit.gif"> 编辑</div></td></tr>';
        });

        //把请求好的属性信息给缓存起来
        attrinfo_cache[typeid] = s;
        }
      });
    }


    //去除旧的属性信息
    $('#attrinfo_table tr:gt(1)').remove();
    //追加s到页面上
    $('#attrinfo_table').append(attrinfo_cache[typeid]);
}

//页面加载完毕就根据类型 获得对象的属性信息并显示
$(function(){
  show_attr();
});
</script>
<tr>
  <td><table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#a8c7ce" id='attrinfo_table'>
    <tr><td colspan='100' bgcolor="#fff" height='30'>按商品类型显示：
      <select name='type_id' onchange='show_attr()'>
        <option value='0'>-请选择-</option>
        <?php if(is_array($typeinfo)): foreach($typeinfo as $key=>$v): ?><option value='<?php echo ($v["type_id"]); ?>'
          <?php if(($v["type_id"]) == $_GET['type_id']): ?>selected='selected'<?php endif; ?>
          ><?php echo ($v["type_name"]); ?></option><?php endforeach; endif; ?>
      </select>
      </td>
    </tr>
    <tr>
      <td width="4%" height="20" bgcolor="d3eaef" class="STYLE10"><div align="center">
        <input type="checkbox" name="checkbox" id="checkbox" />
      </div></td>

      <td width="10%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">属性id</span></div></td>
      <td width="" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">属性名称</span></div></td>
      <td width="" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">类型</span></div></td>
      <td width="" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">单选多选</span></div></td>
      <td width="" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">录入方式</span></div></td>
      <td width="" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">可选值</span></div></td>
      <td width="" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">基本操作</span></div></td>
    </tr>

  </table></td>
</tr>
<tr>
  <td height="30"><table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="33%"><div align="left"><span class="STYLE22">&nbsp;&nbsp;&nbsp;&nbsp;共有<strong> 243</strong> 条记录，当前第<strong> 1</strong> 页，共 <strong>10</strong> 页</span></div></td>
      <td width="67%"><table width="312" border="0" align="right" cellpadding="0" cellspacing="0">
        <tr>
          <td width="49"><div align="center"><img src="<?php echo (AD_IMG_URL); ?>main_54.gif" width="40" height="15" /></div></td>
          <td width="49"><div align="center"><img src="<?php echo (AD_IMG_URL); ?>main_56.gif" width="45" height="15" /></div></td>
          <td width="49"><div align="center"><img src="<?php echo (AD_IMG_URL); ?>main_58.gif" width="45" height="15" /></div></td>
          <td width="49"><div align="center"><img src="<?php echo (AD_IMG_URL); ?>main_60.gif" width="40" height="15" /></div></td>
          <td width="37" class="STYLE22"><div align="center">转到</div></td>
          <td width="22"><div align="center">
            <input type="text" name="textfield" id="textfield"  style="width:20px; height:12px; font-size:12px; border:solid 1px #7aaebd;"/>
          </div></td>
          <td width="22" class="STYLE22"><div align="center">页</div></td>
          <td width="35"><img src="<?php echo (AD_IMG_URL); ?>main_62.gif" width="26" height="15" /></td>
        </tr>
      </table></td>
    </tr>
  </table></td>
</tr>




</table>
</body>
</html>