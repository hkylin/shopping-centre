<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>乐蜂网</title> 
    <link href="/newlefeng/Public/home/css/mylefeng.css" rel="stylesheet" type="text/css">
    <link href="/newlefeng/Public/home/css/common.css" rel="stylesheet" type="text/css">
    <link href="/newlefeng/Public/home/css/cart.css" rel="stylesheet" type="text/css">
    
    <link href="/newlefeng/Public/home/css/bus.css" rel="stylesheet" type="text/css" class="lefeng-lazy" charset="utf-8">
    <script src="/newlefeng/Public/home/js/jquery.min.js"></script>
     <script src="/newlefeng/Public/layer/layer.min.js"></script>

    

</head>
<body class="Wmin new">
    
        <!-- header 开始 -->
<div class="Chead">
    <div class="Chead-main" id="Chead-main">
        <div class="Chead-logo"><a href="/newlefeng/index.php/Home/Index/index"></a></div>
        
        <div class="Chead-info">
            <a id="Chead_app" class="Chead-app" href="/newlefeng/index.php/Home/Article/articleList" target="_blank" rel="nofollow">手机乐蜂</a>
            <div class="Chead-appDown"><a href="" target="_blank" rel="nofollow"></a></div>
            
            <span id="Chead_save" class="Chead-save">收藏乐蜂</span>
            <span id="Chead_fastnav" class="fast-nav turl">快速导航<i></i></span>
            <div class="Chead-floatmenu">
                <a href="/newlefeng/index.php/Home/Article/articleList" rel="nofollow">礼品卡</a>
                <a href="/newlefeng/index.php/Home/Article/articleList" rel="nofollow">帮助中心</a>
                <a href="/newlefeng/index.php/Home/Article/articleList" rel="nofollow">乐蜂校园</a>
                <a href="/newlefeng/index.php/Home/Article/articleList" rel="nofollow">推荐好友</a>
                <a href="/newlefeng/index.php/Home/Article/articleList" rel="nofollow">猜你喜欢</a>
                <a href="/newlefeng/index.php/Home/Article/articleList" rel="nofollow">合作专区</a>
            </div>
            <a class="turl" href="/newlefeng/index.php/Home/Article/articleList" id="Chuafen">花粉商城</a>
            <a class="turl" id="Chead_myhome_btn" href="/newlefeng/index.php/Home/Center/index">我的蜂巢<i></i></a>
            <div class="Chead-myhome">
                <i>#&amp;160;</i>
        
                <a href="/newlefeng/index.php/Home/Center/mycoin" rel="nofollow">我的花粉</a>
                <a href="/newlefeng/index.php/Home/Center/like" rel="nofollow">我的收藏</a>
                <a href="/newlefeng/index.php/Home/Center/comment" rel="nofollow">我的评价</a>
                <!--<a href="" rel="nofollow">我的空间</a>-->
            </div>
            
            <a class="turl" href="/newlefeng/index.php/Home/MyOrder/order" rel="nofollow">我的订单</a>
            <span class="Chead-welcome" id="Cheadlogin">嗡，欢迎来乐蜂，<a href="/newlefeng/index.php/Home/Center"><?php echo ($_SESSION['user']['user_email']); ?></a>&nbsp;&nbsp;&nbsp;&nbsp;<!-- <a href="/newlefeng/index.php/Home/User/loginout">退出</a> --></span>
        </div>
        
        <p class="jd1"><b class="d">我的购物车</b><b>确认订单信息</b><b>成功提交订单</b></p>
    </div>
</div>
    <!-- header 结束 -->


       <link rel="stylesheet" href="/newlefeng/Public/home/css/cart_confirm.css">

       <div class="main">
              <!-- 收货地址 -->
              <div class="path" id="path">
                     <h3> <i>1</i>
                            收货地址
                            <span id="path_msg"></span>
                     </h3>
                     <div id="path_list">
                            <div id="path_list">
                                   <?php if(is_array($addr)): foreach($addr as $key=>$vo): ?><dl class="cli">
                                                 <dt>
                                                        <span class="tit"><?php echo ($vo["true_name"]); ?></span>
                                                        <span class="tel"><?php echo ($vo["address_phone"]); ?></span>
                                                        <span class="def"></span>
                                                 </dt>
                                                 <dd>
                                                        <?php echo ($vo["address_province"]); ?>-<?php echo ($vo["address_city"]); ?>-<?php echo ($vo["address_county"]); ?>
                                                        <br><?php echo ($vo["address_info"]); ?></dd>
                                                 <dd class="ubtn"> <b class="update" edit="<?php echo ($vo["id"]); ?>">修改</b> <b class="del" del="<?php echo ($vo["id"]); ?>">删除</b>
                                                 </dd>
                                                 <span style="display:none" name="ship_info" id="<?php echo ($vo["id"]); ?>" receiver="<?php echo ($vo["true_name"]); ?>" province="<?php echo ($vo["address_province"]); ?>" city="<?php echo ($vo["address_city"]); ?>" county="<?php echo ($vo["address_county"]); ?>" address="<?php echo ($vo["address_info"]); ?>" zipcode="<?php echo ($vo["address_zip"]); ?>" phone="<?php echo ($vo["address_phone"]); ?>" email="<?php echo ($vo["address_email"]); ?>"></span>
                                          </dl><?php endforeach; endif; ?>
                                   <dl class="add">
                                          <dd>
                                                 <b></b>
                                                 使用新地址
                                          </dd>
                                   </dl>
                                   <p>
                                          <b style="display: none;" class="more-path" id="adshow">查看更多地址 <i></i></b> 
                                          <b style="display:none ;" class="more-path" id="hid">收起
                                                 <i class="up"></i></b> 
                                          <b style="display:none ;" class="addBtn" id="allshow">
                                                 使用新地址
                                                 <i>+</i>
                                          </b>
                                   </p>
                            </div>
                            <p></p>
                     </div>
              </div>
              <!-- 支付方式 -->
              <div class="pay" id="pay">
                     <h3>
                            <i>2</i>
                            支付方式
                            <b style="display: none;" class="update" >修改</b>
                            <span id="pay_msg"></span>
                     </h3>
                     <div style="display: none;" id="pay_closed">
                            <p>default</p>
                     </div>
                     <div id="pay_opened">
                            <ul>
                                   <?php if(is_array($paytype)): foreach($paytype as $key=>$vo): ?><li>
                                                 <span style="cursor:pointer;">
                                                        <input       name="pay_id" value="<?php echo ($vo["id"]); ?>" type="radio"><?php echo ($vo["pay_name"]); ?></span>
                                                 <?php echo ($vo["pay_desc"]); ?>
                                          </li><?php endforeach; endif; ?>

                            </ul>
                     </div>
              </div>

              <!-- 配送方式 -->
              <div class="pay">
                     <h3>
                            <i>3</i>
                            配送方式
                            <b style="display: none;" class="update" >修改</b>
                            <span id="pay_msg"></span>
                     </h3>
                     <div style="display: none;" id="pay_closed">
                            <p>default</p>
                     </div>
                     <div>
                            <ul id="shiptype">
                                   <?php if(is_array($ships)): foreach($ships as $key=>$vo): ?><li>
                                                 <span style="cursor:pointer;">
                                                        <input name="shipid" value="<?php echo ($vo["id"]); ?>" type="radio" pri="<?php echo ($vo["shipping_money"]); ?>" id="<?php echo ($key); ?>">
                                                        <label for="<?php echo ($key); ?>"><?php echo ($vo["shipping_name"]); ?></span>
                                                        <?php echo ($vo["shipping_desc"]); ?>（配送价格 <?php echo ($vo["shipping_money"]); ?>）
                                                 </label>
                                          </li><?php endforeach; endif; ?>

                            </ul>
                     </div>

              </div>
              <!-- 配送时间 -->
              <div class="time" id="time">
                     <h3>
                            <i>4</i>
                            快递配送时间
                     </h3>
                     <div style="display: none;" id="time_closed">
                            <p>default</p>
                     </div>
                     <div id="time_opened">
                            <dl class="on"       value="1">
                                   <dt>不限时间</dt>
                            </dl>
                            <dl       value="2">
                                   <dt>周一至周五</dt>
                            </dl>
                            <dl       value="3">
                                   <dt>周六日/节假日</dt>
                            </dl>
                     </div>
                     <div style="display: none;" id="time_mandi">
                            <p class="showpirce">
                                   <input type="checkbox">
                                   <b class="checkbox" ></b>
                                   <span id="time_mandi_msg" style="margin:0"></span>
                            </p>
                     </div>
              </div>
              <!-- 商品清单 -->
              <div class="pro-list">
                     <h3>
                            <i>5</i>
                            商品清单
                     </h3>
                     <div id="shoppinglistDiv">
                            <h2>
                                   <a href="/newlefeng/index.php/Home/Cart/index">
                                          返回购物车
                                          <b></b>
                                   </a>
                                   以下商品由
                                   <span>乐蜂网</span>
                                   发出
                            </h2>
                            <table name="productList" border="0" cellpadding="0" cellspacing="0">
                                   <tbody>

                                          <tr>
                                                 <th class="t1">商品名称</th>
                                                 <th style="width:140px;">单价</th>
                                                 <th style="width:110px;">数量</th>
                                                 <th style="width:124px;">赠送花粉</th>
                                                 <th style="width:110px;">库存情况</th>
                                          </tr>
                                          <?php if(is_array($_SESSION['cart'])): foreach($_SESSION['cart'] as $key=>$vo): ?><tr class="noshop">
                                                        <td class="t1">
                                                               <a target="_blank" href="/newlefeng/index.php/Home/Product/index/id/<?php echo ($vo["id"]); ?>"><?php echo ($vo["goods_name"]); ?></a>
                                                        </td>
                                                        <td class="t2">
                                                               <b>￥</b>
                                                               <span pri="<?php echo ($vo["goods_price"]); ?>"><?php echo ($vo["goods_price"]); ?></span>
                                                        </td>
                                                        <td><?php echo ($vo["num"]); ?></td>
                                                        <td coi="coin"><?php echo ($vo['goods_coin']*$vo['num']); ?></td>
                                                        <td>有货</td>
                                                 </tr><?php endforeach; endif; ?>
                                   </tbody>
                            </table>

                            <div class="price">
                                   <p>
                                          总价：
                                          <span>
                                                 <b>￥</b>
                                                 <b class="moneys">0.00</b>
                                          </span>
                                   </p>
                                   <p>
                                          运费：
                                          <span>
                                                 <b>￥</b>
                                                 <b id="freight">0.00</b>
                                          </span>
                                   </p>
                                   <p>
                                        （满99元可免运费）  运费优惠：
                                          <span>
                                                 <b>-￥</b>
                                                 <b id="freightmin">0.00</b>
                                          </span>
                                   </p>
                                   <p>
                                          需支付总额：
                                          <span class="red">
                                                 <b>￥</b> <strong class="pmoneys"></strong>
                                          </span>
                                   </p>
                            </div>
                            <!-- 买家留言 -->
                            <div class="price">
                                   <div style="float:left">
                                          <span>买家留言</span>
                                   </div>
                                   <div>
                                          <textarea name="order_message" style="float:left;width:600px;resize:none;height:70px"></textarea>
                                   </div>
                                   <div style="clear:both"></div>
                            </div>
                     </div>

                     <!-- 积分显示区域 -->
                     <div id="point">
                            <p>
                                   ● 您有
                                   <span id="point_display"><?php echo ($_SESSION['user']['user_coin']); ?></span>
                                   花粉，使用 (提示：最多可抵本订单20%的金额)
                                   <input       id="ucoin" type="text" name="coin" style="height:20px;width:100px;box-shadow:1px 1px 1px 1px inset #ccc;border:1px solid #ccc" >
                                   等价于
                                   <span id="coinmo">0</span>
                                   元
                            </p>
                     </div>
              </div>
              <!-- 确认订单按钮 -->
              <div id="confirm" class="confirm">

                     <span id="confirm_totalPrice"></span> <strong class="on">确认订单</strong>
                     <!--       <strong disabled="disabled"       class="">确认订单</strong>
              <p style="display: block;" id="confirm_bottom_notice" class="notice">
                     <a href="#path">
                            请先选择收货地址
                            <b></b>
                     </a>
              </p>
              -->
       </div>
</div>

<!-- 收货地址弹出框(创建和编辑公用) -->
<div style="display:<?php if(empty($addr)): ?>block
       <?php else: ?>
       none<?php endif; ?>
; top: 200px; height: 531px;" id="path_window" class="pathadd">
<h3>创建收货地址</h3>
<i class="close"></i>

<p>
       <span>
              <i>*</i>收货人姓名 ：</span><input id="shipwindow_receiver" style="width:298px;" name="true_name">
       <b></b> <em></em>
</p>

<p id="pcc">
       <span>
              <i>*</i>
              所在地区 ：
       </span>
       <?php echo ($address); ?>
       <b>注：标“*”的为支持货到付款的地区</b> <em></em>
</p>
<p>
       <span>
              <i>*</i>
              详细地址 ：
       </span>
       <input id="shipwindow_address" style="width:418px;" name="address_info" maxlength="50">
       <b>请直接填写街道等详细地址，省/市/区不用填写</b>
       <em></em>
</p>
<p>
       <span>
              <i>*</i>
              邮政编码 ：
       </span>
       <input id="shipwindow_postcode" style="width:93px;" name="address_zip">
       <span id="refer_postcode_span" style="width: 180px; margin: 0px; display:;" align="left">
              邮编格式：
              <strong id="refer_postcode" style="margin:0">100000</strong>
       </span>
       <b></b>
       <em></em>
</p>
<p>
       <span>
              <i>*</i>
              手机号码 ：
       </span>
       <input id="shipwindow_mobile" style="width:200px;" name="address_phone">

       <b>用于接受订单短信或送货前确认</b>
       <em></em>
</p>
<p>
       <span>
              <i></i>
              邮箱 ：
       </span>
       <input id="shipwindow_email" style="width:298px;" name="address_email">
       <b>用于接收订单状态提醒邮件,便于您及时了解订单状态</b>
       <em></em>
</p>
<input id="shipwindow_shipId" value="" style="width:298px;" type="hidden">
<input id="shipwindow_defaultAddrState" value="false" style="width:298px;" type="hidden">
<span id="shipwindow_optbutton" opt="add" class="save">保存并使用</span>
<i></i>
</div>
<!-- 收货地址弹出框的遮罩 -->
<div style="display: <?php if(empty($addr)): ?>block
<?php else: ?>
none<?php endif; ?>
;" id="lock">
</div>

<script>
      $(function() {
             //地址框选择，默认使用第一个地址
             $('.cli').eq(0).addClass('default cli');

             //改变头部确认订单信息
             $('.jd1').children('b').eq(1).addClass('d');

             //默认使用第一个配送方式
             $('#shiptype').children('li').eq(0).children('span').children('input').prop('checked',true);

             //默认使用第一个支付方式
             $('input[name="pay_id"]').eq(0).prop('checked',true);

             //计算总价
             cmoney();
             //填入运费
             freight();

             //配送方式选择
             $('input[name="shipid"]').bind('click',function() {
                    freight();
                    cmoney();
             })

             //正则判断地址输入
             var name = false;
             var addr = false;
             var phone = false;
             $('#shipwindow_receiver').bind('blur',function() {
                     if(!$(this).val()){
                            $(this).next('b').html('真实姓名不能为空').css('color','red');
                            name = false;
                     }else{
                            $(this).next('b').html('');
                            name = true;
                     }
             })

             $('#shipwindow_address').bind('blur',function() {
                    if(!$(this).val()){
                            $(this).next('').html('地址不能为空').css('color','red');
                            addr = false;
                     }else{
                           $(this).next().html('请直接填写街道等详细地址，省/市/区不用填写').css('color','#999999');
                           addr = true;
                     }
             })
             $('#shipwindow_postcode').bind('blur',function() {
                     var reg = /^[0-9]{6}$/;
                     if(!reg.test($(this).val())){
                            $(this).next().html('邮编格式不正确').css('color','red');
                     }else{
                            $(this).next().html('邮编格式：100000').css('color','#999999');
                     }
             })

             $('#shipwindow_mobile').bind('blur',function() {
                     var reg = /^[0-9]{6,11}$/;
                     if(!reg.test($(this).val())){
                           $(this).next().html('手机号格式不正确').css('color','red');
                           phone = false;
                     }else{
                            $(this).next().html('用于接受订单短信或送货前确认').css('color','#999999');
                            phone = true;
                     }
             })

             $('#shipwindow_email').bind('blur',function() {
                           var reg = /^\w+@\w+\.\w+$/;
                           if(!reg.test($(this).val())){
                                   $(this).next().html('邮箱格式不正确').css('color','red');
                           }else{
                                  $(this).next().html('用于接收订单状态提醒邮件,便于您及时了解订单状态').css('color','#999999');
                           }
             })

              //花粉输入
             $('#ucoin').bind('blur',function() {
                    var reg = /^[0-9]+$/;
                    if(!reg.test($(this).val())){
                           return;
                    }
                    if($(this).val() > <?php echo ($_SESSION['user']['user_coin']); ?>) {
                            $(this).val(<?php echo ($_SESSION['user']['user_coin']); ?>);
                    }

                    //最多可抵本订单百分之二十的金额
                    if($(this).val() >= parseInt($('.moneys').html() * 20)) {
                           $(this).val(parseInt($('.moneys').html() * 20));
                    }

                    if($(this).val() <0) {
                           $(this).val(0);
                    }
                    $(this).next('span').html($(this).val() / 100);
                    cmoney();
             })

             //获取运费 
             function freight() {
                    $('#freight').html($('input[name="shipid"]:checked').attr('pri'));
             }                                           
             

             //计算总价
             function cmoney() {
                     var money = 0;
                     $.each($('span[pri]'),function(i,v) {
                            var num = parseInt($(v).parent().next().html());
                            money += parseFloat($(v).html()) * num;
                     })
                     money = money.toFixed(2);
              
              $('.moneys').html(money);

              //减花粉抵消
                     if($('#coinmo').html()){
                           money -= $('#coinmo').html();
                     }

                     //加上运费
                     if($('input[name="shipid"]:checked').attr('pri')) {
                     money = parseFloat(money);
                            var ship = parseFloat($('input[name="shipid"]:checked').attr('pri'));
                            money += ship;

                             //运费减免
                            if(money>99) {
                                  $('#freightmin').html($('input[name="shipid"]:checked').attr('pri'));
                                  money -= parseFloat($('input[name="shipid"]:checked').attr('pri'));
                            }
                     }

                     money = money.toFixed(2);
              
              $('.pmoneys').html(money);
              }


      $('.close').bind('click',function() {
             $(this).parent().attr('style','display:none');
             $('#lock').attr('style','display:none');
       })

      //单击添加地址事件
      $('.add,.addBtn').bind('click',function() {
              $('#path_window :input').val('');
             $('#path_window').attr('style','display: block; top: 200px; height: 531px;');
             $('#lock').attr('style','display:block');
                    $.post('/newlefeng/index.php/Home/Order/addredit',{id:0},function(data) {
                           if(data) {
                                         $('#pcc').html('<span><i>*</i>所在地区 ：</span>'+data+'<b>注：标“*”的为支持货到付款的地区</b><em></em>');
                           }
                    });
})

      $('span[opt="add"]').bind('click',function() {
             if(!name){
                    $(this).next().html('请输入合法的用户名').css('color','red');
                    return;
             }

             if(!addr) {
                    $(this).next().html('请输入合法的地址').css('color','red');
                    return;
             }
             if(!phone) {
                    $(this).next().html('请输入合法的手机号').css('color','red');
                    return;
             }
                     var info = $('#path_window :input').serialize();

                     $.post('/newlefeng/index.php/Home/Order/address',info,function(data){
                           if(data){ 
                                   location.reload(true);
                           }
                     })
             })

              //鼠标移上地址栏样式
              $('.cli').hover(
                    function() {
                            $(this).children().show();
                            $(this).children().children().show();
                    },
                    function() {
                           $(this).children('.ubtn').hide();
                           $(this).children().children('.def').hide();
                    }
             )

      
       //鼠标点击地址栏样式
             $('.cli').bind('click',function() {
                    $('.cli').removeClass('default');
                    $(this).addClass('default');
             })

      //修改地址
      $('b[edit]').bind('click',function() {

              name = true;
              addr = true;
              phone = true;
              var va = $(this).attr('edit');
              $('#path_window').attr('style','display: block; top: 200px; height: 531px;');
              $('#path_window').append('<input type="hidden" name="id" value="'+va+'">');
              $('#lock').attr('style','display:block');

              var inf = $('span[id="'+va+'"]');
              $('#shipwindow_receiver').val(inf.attr('receiver'));

              //省市区
              $.post('/newlefeng/index.php/Home/Order/addredit',{id:va},function(data) {
                     if(data) {
                            $('#pcc').html('<span><i>*</i>所在地区 ：</span>'+data+'<b>注：标“*”的为支持货到付款的地区</b><em></em>');
                     }
              });
                                   
             //详细地址
             $('#shipwindow_address').val(inf.attr('address'));

             //邮编
             $('#shipwindow_postcode').val(inf.attr('zipcode'));

             //手机
             $('#shipwindow_mobile').val(inf.attr('phone'))                                                                                           

            //邮箱
            $('#shipwindow_email').val(inf.attr('email'))

      })

      //删除地址
      $('b[del]').bind('click',function() {
             if(confirm('确定删除么')) {
                    var id = $(this).attr('del');
                   $.post('/newlefeng/index.php/Home/Order/delete',{id:id},function(data) {
                          if(data) {
                                  location.reload(true);
                          }
                   })
             }
      })

     //地址收起展示
      if(<?php echo ($num); ?>>3){
            for(var i=2; i<<?php echo ($num); ?>;i++){
                   $('dl[class="cli"]').eq(i).attr('style','display:none')
            }
            $('.add').attr('style','display:none');
                   $('#adshow').attr('style','display:block-line');
                   $('#allshow').attr('style','display:block-line')
      }

      $('#adshow').bind('click',function() {
             $('dl[class="cli"]').attr('style','display:block-line');
             $('.add').attr('style','display:block-line');
             $(this).hide();
             $('#hid').attr('style','display:block-line');
      })

      $('#hid').click(function() {
              for(var i=2; i<<?php echo ($num); ?>;i++){
                     $('dl[class="cli"]').eq(i).attr('style','display:none')
              }
              $('.add').attr('style','display:none');
              $(this).hide();
              $('#adshow').attr('style','display:block-line');
              $('#allshow').attr('style','display:block-line')
                })
      
      //配送时间选定
      $('#time_opened>dl').bind('click',function() {
           $('#time_opened>dl').removeClass('on');
           $(this).addClass('on');
      })


      //提交本页信息
      $('strong[class="on"]').bind('click',function() {

              //获取配送方式
              var ship = $('input[name="shipid"]:checked').val();

              //计算赠送花粉总计
              var coin = 0 ;
              $('td[coi]').each(function() {
                     coin += parseInt($(this).html());
              })
              //共消费花粉
              var pcoin = $('#ucoin').val();
              //买家留言
              var mes = $('textarea[name="order_message"]').val();
              var addrid = $('.default').children('span').attr('id');//地址
              var addtime = $('dl[class="on"]').attr('value');//配送时间段
              var count = $('.pmoneys').html();//总金额                      
              var pay = $('input[name="pay_id"]').val();//支付方式

              $.post('/newlefeng/index.php/Home/Order/info',{address_id:addrid,delivery:addtime,action_count:count,pay_id:pay,pay_coin:coin,order_message:mes,pcoin:pcoin,shipping_id:ship},function(data) {
                            if(data){
                                   location.href='/newlefeng/index.php/Home/Order/confirm/id/'+data;
                            }
              })

       })

    })
</script>




    <!-- footer -->
    <div id="Cfooter" class="Cfooter">
        <div class="Cfooter">
            <div class="Cfooter-copyright">
                <a rel="nofollow" target="_blank" href="/newlefeng/index.php/Home/Article/articleList">关于lefeng　</a>
                <a rel="nofollow" target="_blank" href="/newlefeng/index.php/Home/Article/articleList">免责声明　</a>
                <a rel="nofollow" target="_blank" href="/newlefeng/index.php/Home/Article/articleList">隐私声明　</a>
                <a rel="nofollow" target="_blank" href="/newlefeng/index.php/Home/Article/articleList">版权声明　</a>
                <a rel="nofollow" target="_blank" href="/newlefeng/index.php/Home/Article/articleList">招聘信息　</a>
                <!--<a rel="nofollow" target="_blank" href="">网站地图</a>
            -->
            <a rel="nofollow" target="_blank" href="/newlefeng/index.php/Home/Article/articleList">联系我们　</a>
            <a rel="nofollow" target="_blank" href="/newlefeng/index.php/Home/Article/articleList">帮助中心　</a>
            <a rel="nofollow" target="_blank" href="/newlefeng/index.php/Home/Article/articleList">网站联盟　</a>
            <a target="_blank" href="/newlefeng/index.php/Home/Article/articleList">友情链接　</a>
            <a href="/newlefeng/index.php/Home/Article/articleList" target="_blank" rel="nofollow">商务合作　</a>
            <br>
            <span class="carial">
                Copyright　
                <b>©</b>
                2008-2014 Lefeng.com All Rights Reserved.　
            </span>
            <a rel="nofollow" target="_blank" href="/newlefeng/index.php/Home/Article/articleList">京ICP证080382号　</a>
            <a rel="nofollow" target="_blank" href="/newlefeng/index.php/Home/Article/articleList">京ICP备10006831号-1　</a>
            <span>京公网安备11010502014183　</span>
            <a rel="nofollow" target="_blank" href="/newlefeng/index.php/Home/Article/articleList">营业执照　</a>
        </div>

    </div>


<!-- 滚到顶部按钮 -->
<div class="topdown" id="top_down" title="回到顶部">&nbsp;</div>
</body>

</html>