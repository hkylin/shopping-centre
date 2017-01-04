// 顶部的下拉
$(function(){
        $('#Chead-myhome').hover(function() {
        $(this).addClass('Chead-myhome-on');
        $(this).find('a').stop().slideDown(200).css('display', 'block');
    }, function() {
        $(this).find('a').stop().slideUp(200, function() {
            $(this).removeAttr('style').parent().removeClass('Chead-myhome-on')
        });
    });
    var menuUpTime;
    $('#Cnav_starp dt,#Chead_myhome_btn,#Chead_app,#Chead_fastnav,#fxbmain').mouseenter(function(){
            $(this).next().show();
    }).mouseleave(function() {
                if ($(this).next().is('hidden')) {
                    $(this).next().slideUp(100);
                }
            });
    $(".turl,.Chead-save").hover(function(){
        $(this).css('color',"#f52648")
    },function(){
        $(this).css('color',"#666666");
    })
    $('#Cnav_starp dt,#Chead_myhome_btn,#Chead_fastnav,#Chead_app,#fxbmain').next().mouseleave(function(){
        $(this).slideUp(100);
    });

    $('#Cnav_starp').hover(function(){$(this).addClass('Cnav-starp-on')},function(){$(this).removeClass('Cnav-starp-on')});

    $('a:eq(1)', '#Cnav-one', '#Cnav_main').hover(function () {
        $("#float-list").stop(true, true).slideDown(100)
    }, function () {
        menuUpTime = setTimeout(function () {
            $("#float-list").slideUp(100)
        }, 400)
    });
    $('#float-list').hover(function () {
        clearTimeout(menuUpTime);
    }, function () {
        $(this).stop(true, true).slideUp(100);
    })
    //购物车
    $('#Chead-shopping').delegate('.shopping-btn','mouseenter',function(){
        $(this).next().show();
    })
    $('#Chead-shopping').delegate('.shopping-btn','mouseleave',function() {
        // alert('asd');
        if ($(this).next().is('hidden')) {
            $(this).next().slideUp(100);
        }
    })
    $('#Chead-shopping').delegate('#shopping_list','mouseleave',function(){
        $(this).slideUp(100);
    });
})
// 回到顶部
$(function(){
    var hdt = $(document).scrollTop();
    $('#top_down').bind('click',function(){
        var uptime = null;
        uptime = setInterval(function(){
            var top = $(document).scrollTop();
            $(document).scrollTop(top - top/5);
            if(top == 0){
                clearInterval(uptime);
            }
        },10)
    })
    $(window).scroll(function(){
        if($(document).scrollTop() > 0){
            $('#top_down').slideDown();
        }else{
            $('#top_down').slideUp();
        }
    })
})
// 回到顶部结束

$(function(){
    // 搜索开始
    $('#search-t').focus(function(){
        $('#auto-t').slideDown('fast');
        $(this).val('');
    })
    $('#search-t').blur(function(){
        $('#auto-t').slideUp('fast');
        // $(this).val('输入商品名');
    })
    // 搜索结束
    $('#search').focus(function(){
        $('#auto').show();
    })
    

    //list页面的左侧导航栏
    $('#categorySearch').find('p').each(function(){
        $(this).css({'cursor':'pointer'});
        var othis = $(this);
        othis.click(function(){
            othis.toggleClass('show');
            othis.next().slideToggle();
        })
    })
})

