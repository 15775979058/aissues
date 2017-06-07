<?php
session_start();
//没有登录直接重定向
if(!$_SESSION['_admin_userid']){
  header('Location: /base/login.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Aissues</title>
  <meta name="keywords" content="index">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="renderer" content="webkit">
  <meta http-equiv="Cache-Control" content="no-siteapp" />
  <link rel="icon" type="image/png" href="assets/i/favicon.png">
  <script src="assets/js/echarts.min.js"></script>
  <link rel="stylesheet" href="assets/css/amazeui.min.css" />
  <link rel="stylesheet" href="assets/css/amazeui.datatables.min.css" />
  <link rel="stylesheet" href="assets/css/app.css">
  <script src="assets/js/jquery.min.js"></script>

</head>

<body data-type="widgets">
<script src="assets/js/theme.js"></script>
<div class="am-g tpl-g">
  <?php include_once('header.php');?>
  <?php include_once('menu.php');?>
  <!-- 内容区域 -->
  <div class="tpl-content-wrapper">
    <div class="row-content am-cf">
      <div class="row">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
          <div class="widget am-cf">
            <div class="widget-head am-cf">
              <div class="widget-title  am-cf">文章列表</div>


            </div>
            <div class="widget-body  am-fr">

              <div class="am-u-sm-12 am-u-md-6 am-u-lg-6">
                <div class="am-form-group">
                </div>
              </div>
              <div class="am-u-sm-12 am-u-md-6 am-u-lg-3">
                <div class="am-form-group tpl-table-list-select"></div>
              </div>
              <div class="am-u-sm-12 am-u-md-12 am-u-lg-3">
                <div class="am-input-group am-input-group-sm tpl-form-border-form cl-p">
                  <input id="newsid" type="text" class="am-form-field " placeholder="文章ID"/>
                  <span class="am-input-group-btn">
            <button id="search_btn" class="am-btn  am-btn-default am-btn-success tpl-table-list-field am-icon-search" type="button"></button>
          </span>
                </div>
              </div>

              <div class="am-u-sm-12">
                <table width="100%" class="am-table am-table-compact am-table-striped tpl-table-black " id="example-r">
                  <thead>
                  <tr>
                    <th>编号</th>
                    <th>文章ID</th>
                    <th>标题</th>
                    <th>作者</th>
                    <th>类型</th>
                    <th>时间</th>
                    <th>关键字</th>
                    <th>输入员</th>
                    <th>操作</th>
                  </tr>
                  </thead>
                  <tbody id="list_content"></tbody>
                  <script type="text/template" id="list">
                    <% _.each(objs, function (item, i) { %>
                    <tr class="gradeX">
                      <td><%=parseInt(i) + 1%></td>
                      <td><%=item.newsid%></td>
                      <td><%=item.title%></td>
                      <td><%=item.author%></td>
                      <td><%=item.type%></td>
                      <td><%=item.time%></td>
                      <td><%=item.keywords%></td>
                      <td><%=item.userid%></td>
                      <td>
                        <div class="tpl-table-black-operation">
                          <%if(parseInt(item.is_close)){%>
                          <a href="javascript:;" class="tpl-table-black-operation-del" news-id="<%=item.newsid%>" is-close="0">
                            <i class="am-icon-train"></i>已关
                          </a>
                          <%}else{%>
                          <a href="javascript:;" news-id="<%=item.newsid%>" is-close="1">
                            <i class="am-icon-close"></i>关闭
                          </a>
                          <%}%>
                          <a id="delete_btn" href="javascript:;" class="tpl-table-black-operation-del" news-id="<%=item.newsid%>">
                            <i class="am-icon-trash"></i>删除
                          </a>
                          <a id="update_btn" href="update_news.php?id=<%=item.newsid%>" class="tpl-table-black-operation-update">
                            <i class="am-icon-pencil"></i>修改
                          </a>
                        </div>
                      </td>
                    </tr>
                    <%});%>
                  </script>
                </table>
              </div>
              <div class="am-u-lg-12 am-cf">
                <div class="am-fr">
                  <ul id="page_nums" class="am-pagination tpl-pagination"></ul>
                  <span id="pages"></span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<style type="text/css">
  ._delete_view{
    position: fixed;
    z-index:10000000;
    top:50%;
    left:50%;
    width:500px;
    height:150px;
    margin-left:-250px;
    margin-top:-75px;
    background-color:#fff;
    border-radius: 2px;
    border:1px solid #ddd;
    display: none;
  }
  ._delete_mask{
    position: fixed;
    top:0;
    left:0;
    right: 0;
    bottom:0;
    background-color:#000;
    opacity: 0.6;
    z-index: 1000000;
    display: none;
  }
</style>
<div class="_delete_view">
  <div style="font-size:14px;margin-left:10px;margin-top:10px;">
    请输入文章ID
  </div>
  <div>
    <input id="news_id_delete" placeholder="文章ID" type="text" class="am-form-field"/>
  </div>
  <div style="margin-top:10px;margin-left:10px;">
    <button id="delete_btn_sure" class="am-btn am-btn-danger" type="button" style="margin-left:330px;">删除</button>
    <button id="close_btn_sure" class="am-btn am-btn-success" type="button">关闭</button>
  </div>
</div>
<div class="_delete_mask"></div>
<script src="assets/js/amazeui.min.js"></script>
<script src="assets/js/amazeui.datatables.min.js"></script>
<script src="assets/js/dataTables.responsive.min.js"></script>
<script src="assets/js/app.js"></script>
<script type="text/javascript" src="/js/underscore-min.js"></script>
<script type="text/javascript">
  var objs = [];
  var current_page = 1;
  var pages = 1;
  var url = '/base/api/get_news.php?page=';
  //更改表格数据
  function doshow() {
    $.get(url + current_page, function (data) {
      if(data.status){
        objs = data.data.rows;
        $('#list_content').html((_.template($('#list').html(), objs)()));
        //设置总页数、记录数
        pages = data.data.pages;
        var total = data.data.total;
        $('#pages').text('总共：' + pages + ' 页， ' +  total + '条记录');
        //设置页码块
        var page_nums = $('#page_nums');
        //先置空
        page_nums.html('');
        //前一页
        page_nums.append('<li><a>«</a></li>');
        //当前页
        page_nums.append('<li class="am-active"><a>' + current_page + '</a></li>');
        //后一页
        page_nums.append('<li><a>»</a></li>');

      }
    });
  }
  doshow();

  //绑定事件
  $('#page_nums').on('click', function (e) {
    if(e.target && e.target.nodeName.toLowerCase() == 'a'){
      var num = $(e.target).text();
      if(num == '«'){
        current_page = current_page - 1;
        if(current_page < 1){
          current_page = 1;
          (new Alert('提示', '已经是第一页了')).show();
        }else{
          doshow();
        }
      }else if(num == '»'){
        current_page = current_page + 1;
        if(current_page > pages){
          current_page = current_page - 1;
          (new Alert('提示', '已经是最后一页了')).show();
        }else{
          doshow();
        }
      }
    }
  });

  $('#search_btn').on('click', function () {
    var newsid = $('#newsid').val();
    if(!newsid)return;
    $.get('/base/api/get_news_id.php?newsid='+ newsid, function (data) {
      if(data.status){
        objs = data.data;
        $('#list_content').html((_.template($('#list').html(), objs)()));
        $('#page_nums').html('');
        $('#pages').html('');
      }else{
        (new Alert('提示', '没有查到相关用户')).show();
      }
    });
  });

  var delete_view = $('._delete_view');
  var delete_mask = $('._delete_mask');
  $('table').on('click', function (e) {
    if(e.target && e.target.nodeName.toLowerCase() == 'a' && (e.target.innerText == '关闭' || e.target.innerText == '已关')){
      var elm = $(e.target);
      var newsid = elm.attr('news-id');
      var is_close = elm.attr('is-close');
      var obj = {
        newsid: newsid,
        isclose: parseInt(is_close)
      };

      $.post('/base/api/close_news.php', obj, function (data) {
        console.log(data);
        if(data.status){
          return (new Alert('提示', data.info, function () {
            location.reload();
          })).show();
        }
        (new Alert('提示', data.info)).show();
      });
    }

    if(e.target && e.target.nodeName.toLowerCase() == 'a' && $(e.target).attr('id') == 'delete_btn'){
      delete_view.css('display', 'block');
      delete_mask.css('display', 'block');
    }
  });

  $('#close_btn_sure').on('click', function () {
    delete_view.css('display', 'none');
    delete_mask.css('display', 'none');
    $('#news_id_delete').val('');
  });

  $('#delete_btn_sure').on('click', function () {
    var news_id_delete = $('#news_id_delete').val();
    if(!news_id_delete){
      return (new Alert('提示', '请输入book id')).show();
    }
    var obj = {
      newsid: news_id_delete
    };
    $.post('/base/api/delete_news.php', obj, function (data) {
      if(data.status){
        (new Alert('提示', data.info, function () {
          location.reload();
        })).show();
      }else{
        (new Alert('提示',data.info)).show();
      }
    });
  });
</script>
</body>

</html>