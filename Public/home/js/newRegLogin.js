if($('.partners')){$('.partners').append('<span style="display:none;">hidden</span><span style="display:none;">hidden</span>')};
var ta = window.location.href.split('?')[0].split('/');
if(ta[ta.length-1]=='reg_success.jsp'){
    $('body').removeClass('register').addClass('un_login');
}
if(GLOBAL.visableLoginAndRegister){
	loadUser('Cheadlogin');
}
if(GLOBAL.hiddenMyOrderAndMyHive){
	$(".Chead-info-r>a").slice(3).hide();
}
if(GLOBAL.pagename == "register"){
	$(".mailwrap").addClass('regwarp');
}
function loadUser(obj){
	var islogin=getLogin();
	var str = "";
	if(islogin != null && islogin != "__TRANSIENT" && islogin != ""){
		str = "小蜜蜂欢迎您，<b>" + islogin + "</b>！<a href=\"###\" onclick=\"logout();return false;\">退出登录</a>";
	}else{
		str = "欢迎来乐蜂，请&nbsp;<a href=\"###\" onclick=\"loginreg('login')\">登录</a>&nbsp;<a href=\"###\" onclick=\"loginreg('reg')\">注册</a>";
	}
	$("#"+obj).html(str);
}
function loginreg(str){
	var returnback=encodeURIComponent(window.location.href);
	if("login"==str){
		var nowhref=window.location.href;
		if(nowhref.indexOf("login.jsp")!=-1){
			window.location.href='https://passport.lefeng.com/login.jsp';
		}else{
			window.location.href='https://passport.lefeng.com/login.jsp?returnback='+returnback.replace('###','');
		}
	}
	if("reg"==str){
		window.location.href='https://passport.lefeng.com/register.jsp?returnback='+returnback.replace('###','');
	}
}
function getlogCookie(name) {
	var start = document.cookie.indexOf( name + "=" );
	var len = start + name.length + 1;
	if ( ( !start ) && ( name != document.cookie.substring( 0, name.length ) ) ) {
		return null;
	}
	if ( start == -1 ) return null;
	var end = document.cookie.indexOf( ';', len );
	if ( end == -1 ) end = document.cookie.length;
	return decodeURIComponent( document.cookie.substring( len, end ) );
}
function logout(){
$.getJSON("http://shopping.lefeng.com/cart/destroy_cloud_cart.jsp?callback=?"); //云端购物车增加
	var today = new Date();
	today.setTime( today.getTime() );
	var expires = 1000 * 60;
	var expires_date = new Date( today.getTime() - (expires) );
	document.cookie = 'LongTimeValuesCookies=;expires='+expires_date.toGMTString()+';path=/'+
		';domain=lefeng.com;secure';	
	$("#Cheadlogin").html("欢迎来到乐蜂，请&nbsp;<a href=\"###\" onclick=\"loginreg('login')\">登录</a>&nbsp;<a href=\"###\" onclick=\"loginreg('reg')\">注册</a>");
	$('#Chead-tip').remove();
	try{NTKF.onLoginResult(3)
	}catch(e){};
}
function getLogin(){
	var login="__TRANSIENT";
	var LongTimeValuesCookies=getlogCookie("LongTimeValuesCookies");
	if(LongTimeValuesCookies!=null && LongTimeValuesCookies!=""){
		var arrStr = LongTimeValuesCookies.split("#");
		for(var i=0;i<arrStr.length;i++){
			var co = arrStr[i].split("$");
			if(co[0]=="__LOGIN__VIEWINFO__"){
				if("invalid"!=co[1]){
					login=co[1];
					break;
				}
			}
			if(co[0]=="__LOGIN")
			{
				login=co[1];
				break;
			}
		}
	}
	return login; 
}
	var menuUpTime;
	$('#Cnav_starp dt,#Chead_myhome_btn,#Chead_fastnav,#Chead_app').hover(function(){
		$(this).next().removeAttr('style').stop().slideDown(100);
	},function(e){
		var _s = this;
		menuUpTime = setTimeout(function(){$(_s).next().slideUp(100)},200)
	});
	$('#Cnav_starp dt,#Chead_myhome_btn,#Chead_fastnav,#Chead_app').next().hover(function(){
		clearTimeout(menuUpTime);
	},function(){
		$(this).stop().slideUp(100);
	});
	$('#Cnav_starp').hover(function(){$(this).addClass('Cnav-starp-on')},function(){$(this).removeClass('Cnav-starp-on')});
	
function throttleV2(e,t,n){var r=null,i;return function(){var s=this,o=arguments,u=+(new Date);clearTimeout(r),i||(i=u),u-i>=n?(e.apply(s,o),i=u):r=setTimeout(function(){e.apply(s,o)},t)}}
var ua = navigator.userAgent.toLowerCase();
var fH = $(".loginfooter").outerHeight();
var rH = $(".Chead-r").outerHeight();
var lH = $(".Logo-r").outerHeight();
var bH = $(".loginBk").outerHeight();	
if(!(ua.match(/iPad/i)=="ipad")) {  
	if ($(window).height() > 768) {
		$(".loginfooter").height(($(window).height()-rH-lH-bH-fH-160)+'px')
	}
}	
$(".loginfooter").css('width',$(document).width()+'px');
$(window).resize(throttleV2(function() {
	$(".loginfooter").removeAttr('style');
	var dh = $(window).height(); 
	var dw = $(window).width();  
    if(dh>768){
	   $(".loginfooter").height((dh-rH-lH-bH-fH-160)+'px')
    }
	if(dw>768){
		$('body').css('overflow-x','hidden');
	}else{
		$('body').css('overflow-x','scroll');		
	}
	$(".loginfooter").css('width',$(document).width()+'px');
},100,500));
String.prototype.trim = function() {
    return this.replace(/(^\s*)|(\s*$)/g, '');
}
function regedit() {

}
regedit.prototype = {
    holderText:['用户名/邮箱/已验证手机','验证码'],
    tipsText:{
        'mail':[
            ['正在验证邮箱......'],
            ['邮箱格式有误，请重新输入','该邮箱已注册，请重新输入']
        ],
        'mobile':[
            ['正在验证手机号码......'],
            ['手机格式有误，请重新输入','该手机号已注册，请重新输入','账号信息有误']
        ],
        'SMS':[
            ['已发送，$TIME$秒后可重新获取'],
            ['，今天还可发送$NUM$次','您的短信发送次数已达到3次，请明天再发','短信发送次数过于频繁，请于1小时后重试','此手机正在验证当中，请稍后重试','验证码或手机号码不能为空']
        ],
        'password':[
            ['正在验证密码......'],
            ['密码长度需6-16位字符','两次输入密码不一致','密码不能与手机号相同','密码不能与邮箱相同','请确认密码']
        ],
        'verion':[
            ['检测验证码......'],
            ['请输入验证码']
        ],
        'public':['请输入账号','邮箱/手机格式输入有误，请重新输入','您输入的账号和密码不匹配，请重新输入']
    },
    userName:'',
    passWord:'',
    SMSNum:0,
    ajaxFlag:true,
    init:function(dom) {
        /*
         * stu的状态 1:账号 2:密码 3:确认密码 4:验证码 5:发送短信息
         * */
        $(document).bind("click",function(e){
            var src = e.target || window.event.srcElement;
            if(src.className=="no"){
                return;
            }
            if(!$("#mailtips").is(":hidden")){
                $("#mailtips").hide();
            }
        });
        $(document).bind("keyup",function(e){
            if (e.which == 13) {
                if (!$('input[name=login]').is(":focus")) {
                    if ($('input[name=login]').val() != "") {
                        $(".buttonwrap a").click();
                    }
                }
            }
        });

         var _s = this;
        $(dom).each(function() {
            var stu = $(this).attr('stu');
            if(stu==1){
                if ($(this).val() != "") {
                    $(this).parent().addClass('nobk')
                }
            }
            if (stu == 5) {
                _s.SMSBind(_s, $(this));
                return true;
            }
            _s.nameKeypress(_s, $(this), stu);          //用户类型输入监听事件  dom,类型
            //绑定键盘监听事件
            _s.focusR(_s, $(this), stu);                 //焦点事件
            _s.blurR(_s, $(this), stu);                  //移除焦点事件
        });
        $(".yzmwrap span").click(function() {
            _s.reloadCode(_s, $(this));
        })
      /*  if ($("#formSubmit").size() > 0) this.formSubmit(_s, $("#formSubmit"));
        if ($("#postSubmit").size() > 0) this.postSubmit(_s, $("#postSubmit"));*/
    },
    nameKeypress:function(_s, dom, stu) {//用户名监听
        if (stu == 1 || stu == 6) {
            dom.bind('keyup', function(e) {
                _s.checkName($(this), _s, e);
            });
        } else if (stu == 2) {
            dom.bind('keyup', function(e) {
                if(GLOBAL.pagetype=='login') return;
                _s.checkLevel($(this), _s, e);
            })
        } else if (stu == 4) {
            dom.bind('keyup', function(e) {
                _s.checkVerion($(this), _s,true);
            })
        }
        dom.bind('keyup', function() {
            var s = $(this),val = s.val();
            if (val.length == 0) {
                s.parent().removeClass('nobk');
            }else{
				if(s.parent().find('input[type=button]').size()>0) return;
                s.parent().addClass('nobk');
            }
        })
        var bind_name = 'input';
        if (navigator.userAgent.indexOf("MSIE") != -1) {
            bind_name = 'propertychange';
        }
        dom.bind(bind_name, function(e) {
            if ($.syncProcessSign) return;
            $.syncProcessSign = true;
            if($(this).attr('stu')!=4){
                $(this).parent().addClass('nobk');
            }
            $.syncProcessSign = false
        })
    },
    focusR:function(_s, dom, stu) {
        dom.bind('focus', function(e) {
            if (stu == 1) {
               // _s.checkName($(this), _s, e);
            }
            var box = $(this).parent();
            if (stu == 2) {
                if (box.find('.level').is(':hidden')) {
                    box.find('.focus_text').show();
                }
            }else{
                box.find('.focus_text').show();
            }
            _s.removeTips(_s, dom);
			$(this).addClass('focus');
        })
    },
    blurR:function(_s, dom, stu) {
        var jsThis = this;
        dom.blur(function() {
            var s = $(this),val = s.val();
			_s.hideMailtips();
			s.removeClass('focus');
            $(this).parent().find('.focus_text').hide();
            if (val.length > 0) {
                _s.blurCheck(_s, s, val, stu);
            }
            if (_s.checkHolder($(this).val())) return;			
        });
    },
    blurCheck:function(_s, s, val, stu,type) {
		_s.hideMailtips();
        var logType = false ;
        if(typeof type!='undefined'){
            logType = type;
        }else{
            logType = GLOBAL.pagetype == 'login';
        }
        if (stu == 1) {
            if(!$("#mailtips").is(":hidden")) return;
            if (GLOBAL.pagename == 'login') {
                if ($.trim(s.val()) == '') {
                    _s.showErrorMsg(s, _s.tipsText.public[0]);
                }
                return;
            }
            if (val.indexOf('@') != -1 && val.indexOf('@') != 0) {
                _s.checkEmail(_s, s);
                _s.ajaxRegName(_s, s, val, 'emailreg', 0);
            } else {
                _s.checkMobile(_s, s);
                if (_s.isMobeil(val)) {
                    _s.ajaxRegName(_s, s, val, 'mobilereg', 1)
                }else{
                    if (GLOBAL.pagename == 'lost_pass') {
                        _s.ajaxRegOldName(_s, s, val);
                    }
                }
            }
        } else if (stu == 2) {
            if (GLOBAL.pagename == 'login') {
                if (logType) return;
            }
            _s.checkPass(s, _s);
        } else if (stu == 3) {
            _s.checkRePass(s, _s);
        } else if (stu == 4) {
            _s.checkVerion(s, _s,type)
        } else if (stu == 6) {
            if (val.indexOf('@') != -1 && val.indexOf('@') != 0) {
                _s.checkEmail(_s, s);
            } else {
                if (_s.isMobeil(val)) {
                    _s.checkMobile(_s, s);
                } else {
                    if (_s.isLengthNull(val)) {
                        _s.noticeHide(_s, s);
                    } else {
                        _s.showErrorMsg(s, _s.tipsText.public[0]);
                    }
                }
            }
            _s.hideMailtips();
        }
    },
    checkHolder:function(val) {
        var f = true;
        for (var i = 0; i < this.holderText.length; i++) {
            if (val === this.holderText[i]) {
                f = false;
                break;
            }
        }
        return f;
    },
    checkName:function(dom, _s, e) {
        var s = dom,val = s.val();
        //if (val.length > 0) s.parent().find('.focus_text').hide();
        if (val.indexOf('@') != -1 && val.indexOf('@') != 0) {
            if (e.which != 38 && e.which != 40) {
                _s.showMailtips(val, _s, s);
            }
            _s.bindMailKeyup(_s, dom, e)
        } else {
            _s.hideMailtips();
        }
    },
    checkEmail:function(_s, s) {
        //邮箱验证
        var val = s.val();
        var emailReg = /^([\-a-zA-Z0-9]+[_|\_|\.]?)*[\-a-zA-Z0-9]+@([\-a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
        _s.showNotice(s, _s.tipsText.mail[0]);
        if (!emailReg.test(val)) {
            _s.showErrorMsg(s, _s.tipsText.mail[1][0]);
            return;
        } else {
            // 2012-11-07 修改https跨域问题
            _s.userName = val;
        }
        _s.noticeHide(_s, s);
        _s.showVerion(1);
    },

    checkMobile:function(_s, s) {
        var val = s.val(),jsThis = this;
        if (!jsThis.isLengthNull(val)) {
            _s.showErrorMsg(s, _s.tipsText.public[0]);
            return;
        }
        if (GLOBAL.pagename != 'lost_pass') {
            if (!jsThis.isMobeil(val)) {
                _s.showErrorMsg(s, _s.tipsText.public[1]);
                return;
            }
            var emailReg = /^1[3|5|7|8|4][0-9]\d{8}$/;
            _s.showNotice(s, _s.tipsText.mobile[0]);
            if (!emailReg.test(val)) {
                _s.showErrorMsg(s, _s.tipsText.mobile[1][0]);
            } else {
                _s.userName = val;
                // 2012-11-07 修改https跨域问题
            }
            _s.noticeHide(_s, s);
            _s.showVerion(2);
        }
    },
    checkPass:function(dom, _s,type) {
        var val = dom.val().trim();
        if (GLOBAL.pagename == 'login') {
            if(val.length!=0) return;
            if (typeof type != 'undefined') {
                if (!type) return;
            }
        }
        if (dom.parent().find('.level').length > 0) {
            _s.checkLevel(dom, _s);
        }
        if(val.length==0){
            dom.parent().find('.focus_text').hide();
            _s.showErrorMsg(dom, '请输入密码');
        }else if(val.length<6){
            dom.parent().find('.focus_text').hide();
            _s.showErrorMsg(dom, '密码长度需6-16位字符');
        } else if (val.length > 16) {
            dom.parent().find('.focus_text').hide();
            _s.showErrorMsg(dom, '密码长度需6-16位字符');
            return;
        } else if(_s.passLevel< 1){
            dom.parent().find('.focus_text').hide();
            _s.showErrorMsg(dom, '密码较简单，试试字母、数字或常用符号的组合');
            return;
        } else {
            if(_s.checkLevel(dom,_s)) return;
            _s.passWord = val;
            _s.noticeHide(_s, dom);
        }
    },
    checkLevel:function(dom, _s) {
        var val = dom.val().trim(),n = Math.floor(val.length / 6);
        var levelDom = dom.parent().find('.level');
        _s.passWord = val;
		if(val.length >16){
			dom.parent().find('.focus_text').hide();
			_s.showErrorMsg(dom, '密码长度需6-16位字符');	
			return;
		}
        if (val.length > 5) {
            dom.parent().find('.focus_text').hide();
            _s.noticeHide(_s, dom);
//        }else if(val.length == 6){
//            dom.parent().find('.focus_text').hide();           
//            return;
        } else {
            levelDom.hide();
            dom.parent().find('.focus_text').show();
            _s.removeTips(_s, dom);
        }
        dom.val(val);
        /(^\d*$)|(^[a-z]*$)/.test(val) && n--;
        if (/[\W_]/.test(val) && /[\d]/.test(val) && /[a-z]/.test(val)) {
            n++;
        }
        n > 2 && n--;
        levelDom.find('b').removeClass('on');
        _s.passLevel = n;
        if (n == 0) {
            //levelDom.hide();
            //dom.parent().find('.focus_text').show();
            //_s.removeTips(_s,dom);
			dom.parent().find('.errorIcon').addClass('no');
			levelDom.find('b').removeClass('on').eq(n).addClass('on');
            return true;
//        }else if(n==0){
//            dom.parent().find('.focus_text').hide();
//            _s.showErrorMsg(dom, '密码较简单，试试字母、数字或常用符号的组合');
//            return true;
        } else {
            levelDom.find('b').removeClass('on').eq(n).addClass('on');
        }
    },
    passLevel:0,
    checkRePass:function(dom, _s) {
        var val = dom.val().trim();
        if (val.length == 0) {
            _s.showErrorMsg(dom, _s.tipsText.password[1][4]);
            return;
        }
        if (val != _s.passWord) {
            _s.showErrorMsg(dom, _s.tipsText.password[1][1]);
            return;
        }
        _s.noticeHide(_s, dom);
    },
    //检验验证码
    checkVerion:function(dom, _s, type) {
        var val = dom.val().trim(),jsThis = this;
        if (dom.parent().find('span').size() > 1 && !dom.parent().find('span[mode=2]').is(':hidden')) {
            if (!type) {
                if (val.length == 0) {
                    _s.showErrorMsg(dom, '请输入验证码');
                    return;
                }
                if (val.length < 6) {
                    _s.showErrorMsg(dom, '验证码输入错误');
                    return;
                }
            }
            if (val.length > 6) {
                dom.val(val.substr(0, 6));
            }
            return;
        }
        if (!type) {
            if (val.length == 0) {
                _s.showErrorMsg(dom, '请输入验证码');
                return;
            }
            if (val.length < 4) {
                _s.showErrorMsg(dom, '验证码输入错误');
                return;
            }
        }
		var ttl = $("#sendButton").size()?6:4;
        if (val.length == ttl) {
            if (_s.ajaxFlag) {
                _s.noticeHide(_s, dom);
				if($("#sendButton").size()) return;
                _s.showNotice(dom, _s.tipsText.verion[0][0]);				
                _s.ajaxLoginCode(val, _s, dom);
                _s.ajaxFlag = false;
            }
        } else if (val.length > ttl) {
            if (!jsThis.isMobeil(_s.userName)) {
                dom.val(val.substr(0, ttl));
            }
        }

    },
    showErrorMsg:function(s, text) {
        var lidom = s.parent();
        lidom.addClass('er');
        if (lidom.find('.errorTips').size() == 0) {
            lidom.append('<div class="errorTips">' + text + '</div>');
        } else {
            lidom.find('.errorTips').text(text);
        }
        lidom.find('.level').hide();
        lidom.find('.errorTips').removeClass().addClass('errorTips error');
        if (lidom.find('.errorIcon').size() == 0) {
            lidom.append('<div class="errorIcon no"></div>');
        } else {
            lidom.find('.errorIcon').addClass('no')
        }
    },
    showNotice:function(s, text) {
        var lidom = s.parent();
        if (lidom.find('.errorTips').size() == 0) {
            lidom.append('<div class="errorTips">' + text + '</div>');
        } else {
            lidom.find('.errorTips').text(text);
        }
        lidom.find('.errorTips').removeClass().addClass('errorTips check');
    },
    showVerion:function(mode) {// mode 1,邮件验证码显示 2,手机验证码显示
        if ($(".yzmwrap span").size() == 1) return;
        if (mode == 1) {
            $(".yzmwrap h2").text('验证码')
            $(".yzmwrap span").hide().eq(0).show();
        } else if (mode == 2) {
            $(".yzmwrap h2").text('手机验证码')
            $(".yzmwrap span").hide().eq(1).show();
        }
    },
    noticeHide:function(_s, s, flag) {
        var box = s.parent();
        box.removeClass('er');
        box.find('.errorTips').remove();
        if (box.find('.errorIcon').size() == 0) {
            box.append('<div class="errorIcon"></div>');
        } else {
            box.find('.errorIcon').removeClass('no');
        }
        if (flag) box.find('.errorIcon').remove();
        box.find('.level').show();
        $("#mailtips").hide();
    },
    removeTips:function(_s, s) {
        var box = s.parent();
        box.removeClass('er');
        box.find('.errorIcon').remove();
        box.find('.errorTips').remove();
    },
    showMailtips:function(val, _s, s) {
        var box = $("#mailtips");
        var html = _s.setMailList(val);
        if (html.length == 0) {
            _s.hideMailtips();
            return;
        }
        box.html(html);
        box.show();
        _s.bindMailClick(_s, s, box);
        if (box.find('dl').size() == 0) {
            _s.hideMailtips();
        }
    },
    setMailList:function(val) {
        var mail = ["qq.com","163.com","126.com","sina.com","hotmail.com","sohu.com","gmail.com"],ta = []
        var index = val.indexOf('@'),temp = val.split('@')[1];
        for (var i = 0; i < mail.length; i++) {
            if (temp.length == 0) {
                ta.push('<dl><a href="#">$VAL$'.replace('$VAL$', val) + mail[i] + '</a></dl>');
            } else {
                if (mail[i].substr(0,temp.length).indexOf(temp) != -1) {
                    ta.push('<dl><a href="#">$VAL$'.replace('$VAL$', val.split('@')[0] + '@<b>' + temp + '</b>') + mail[i].substr(temp.length) + '</a></dl>')
                } else {
                    continue;
                }
            }
        }
        return ta.join('');
    },
    hideMailtips:function() {
        setTimeout(function () {
            $("#mailtips").hide().children().remove();
        }, 100)
    },
    bindMailClick:function (_s, s, dom) {
        dom.find('a').click(function() {
            s.val($(this).text());
            s.focus();
            _s.hideMailtips();
        });
        dom.find('dl').bind('mouseenter',function(){
           $(this).siblings().removeClass('on');
           $(this).addClass('on');
        })
    },
    bindMailKeyup:function(_s, dom, e) {
        var li = $('#mailtips dl');
        if (li.size() == 0) return;
        var index = $("#mailtips").find('dl.on').index();
        switch (e.which) {
            case 37: //左
                return;
                break;
            case 9:  //tab
                _s.checkEmail(_s, $(this));
                _s.hideMailtips();
                break;
            case 13: //回车
                _s.hideMailtips();
                break;
            case 38://上
                if (index == -1) {
                    index = li.size()
                }
                li.removeClass();
                index--;
                li.eq(index).addClass("on");
                dom.val(li.eq(index).text());
                break;
            case 39://右
                return;
                break;
            case 40://下
                if (li.size() == 1) index = -1;
                li.removeClass();
                index++;
                if (li.size() == index) {
                    index = 0;
                }
                li.eq(index).addClass("on");
                dom.val(li.eq(index).text());
                break;
            default:
                li_index = 0;
                break;
        }
    },
    tipsObj: {
        '0':"操作成功",
        '-1':"您的账户名不能为空，请重新输入",
        '-2':"您的密码不能为空，请重新输入",
        '-3':"您输入的账户不存在，请重新输入",
        '-4':"您输入的账户和密码不匹配，请重新输入",
        '-5':"您的验证码不能为空，请重新输入",
        '-6':"您输入的验证码错误，请重新输入",
        '-10':"您的账户名为黑名单用户，请重新输入",
        '-100':"注册账号不能为空，请重新输入",
        '-101':"邮箱/手机格式输入有误，请重新输入",
        '-102':"邮箱/手机不能为空，请重新输入",
        '-103':"邮箱已经存在，请重新输入",
        '-104':"手机已经存在，请重新输入",
        '-105':"密码长度在6-16位字符之间",
        '-106':"两次输入密码不一致",
        '-107':"注册账号中含有特殊符号，请重新输入",
        '-108':"注册账号已经存在，请重新输入",
        '-109':"注册账号只能是邮箱或手机，请重新输入"
    },
    ajaxRegName:function(_s, s, val, param, statu) { //用户名,this,dom,参数(emailreg,mobilereg),电话 or email(0,1)
        if (GLOBAL.pagetype == 'reg') {
            $.getJSON("/ajax/passport/ajaxCheckLogin.jsp?callback=?", {login:val}, function (data) {
                var href='/login.jsp';
                if(GLOBAL.pagename=='cart|register'){
                    href='login.jsp?fLoginSuccessCallback'
                }
                if (data.flag == '0') {
                    _s.noticeHide(_s, s);
                    _s.showNotice(s, '');
                    if (GLOBAL.pagename == 'lost_pass') {
                        _s.showErrorMsg(s, '您输入的账户不存在，请核对后重新输入!');
                    }
                } else if (data.flag == '-103') {
                    if (GLOBAL.pagename != 'lost_pass') {
                        _s.showErrorMsg(s, '该邮箱已注册,请更换邮箱或 <a href="'+href+'">立即登录</a> ');
                    }
                } else if (data.flag == '-104') {
                    if (GLOBAL.pagename != 'lost_pass') {
                        _s.showErrorMsg(s, '该手机号码已注册,请更换手机号码或 <a href="'+href+'">立即登录</a> ');
                    }
                } else {
                    if (GLOBAL.pagename != 'lost_pass') {
                        _s.showErrorMsg(s, _s.tipsObj[data.flag]);
                    }
                }
            });
        }
    },
    ajaxLoginCode:function(val, _s, s) {
        var page = (GLOBAL.pagetype == 'login') ? 'ajaxCheckLoginImgYzm' : 'ajaxCheckRegImgYzm';
        $.getJSON("/ajax/passport/" + page + ".jsp?callback=?", {code:val}, function(data) {
            if (data.flag == 0) {
                _s.noticeHide(_s, s);
                _s.showNotice(s, '');
            } else {
                _s.showErrorMsg(s, '验证码错误或已过期');
            }
            _s.ajaxFlag = true;
        })
    },
    SMSBind:function(_s, s) {
        s.bind('click', function() {
            var jqThis = $(this);
            if (!jqThis.attr('send')) {
				jqThis.removeClass('on');
                _s.SMSNum += 1;
                jqThis.attr('send', '1');
                var timeNum = 59,timer;
                timer = setTimeout(function() {
                    jqThis.val('(' + timeNum + ')秒后重新获取');
                    if (timeNum == 0) {
                        clearTimeout(timer);
                        jqThis.removeAttr('send');
                        jqThis.val('获取短信验证码');
						jqThis.addClass('on');
                    } else {
                        timeNum--;
                        setTimeout(arguments.callee, 1e3);
                    }
                }, 1e3);
                _s.subSMSCode(_s.userName, _s, jqThis, timer);
            }
        })
    },
    subSMSCode:function(val, _s, s, timer) {
        if(GLOBAL.pagename=='lost_pass'){
            $.getJSON('/user/passwd/send_verify.jsp?callback=?', {mobile:val,param:GLOBAL.sendcodeParam}, function(data) {
                var statusCode = parseInt(data.statusCode, 10),
                        count = 2 - data.count;
                if (statusCode == 0) {
                    if (count == 0) {
                        clearTimeout(timer);
                        _s.showErrorMsg(s.parent(), "您的短信发送次数已达到3次，请明天再发");
                        s.removeAttr('send');
                        s.val('获取短信验证码');
                    } else {
                        if (count < 2) {
                            _s.showNotice(s.parent(), "验证码已发送，请查收短信，您今天还可发送" + count + "次");
                        }else{
                            _s.showNotice(s.parent(), "验证码已发送，请查收短信");
                        }
                    }
                } else if (statusCode == 1) {
                    clearTimeout(timer);
                    _s.showErrorMsg(s.parent(), "您今天的短信发送量已达到上限!");
                    s.removeAttr('send');
                    s.val('获取短信验证码');
                } else {
                    clearTimeout(timer);
                    _s.showErrorMsg(s.parent(), "服务器忙，请稍微重试!");
                    s.removeAttr('send');
                    s.val('获取短信验证码');
                }
            })
        }else{
            $.getJSON('/ajax/passport/ajaxSendMobileYzm.jsp?callback=?',{mobile:val},function(data){
                var statusCode = data.resStatusCode,count = data.count ;
                if(statusCode==0){
                    if (count > 2) {
                        _s.showNotice(s.parent(), "验证码已发送，请查收短信，您今天还可发送" + (3 - count) + "次");
                    } else {
                        _s.showNotice(s.parent(), "验证码已发送，请查收短信");
                    }
                }else if(statusCode==2){
                    clearTimeout(timer);
                    _s.showErrorMsg(s.parent(), "手机号无效");
                    s.removeAttr('send');
                    s.val('获取短信验证码');
                }else if(statusCode==3){
                    clearTimeout(timer);
                    _s.showErrorMsg(s.parent(), "手机号被注册");
                    s.removeAttr('send');
                    s.val('获取短信验证码');
                }else if(statusCode==4){
                    clearTimeout(timer);
                    _s.showErrorMsg(s.parent(), "发送间隔小于1分钟");
                    s.removeAttr('send');
                    s.val('获取短信验证码');
                }else if(statusCode==5){
                    clearTimeout(timer);
                    _s.showErrorMsg(s.parent(), "短信发送次数过于频繁，请于1小时后重试");
                    s.removeAttr('send');
                    s.val('获取短信验证码');
                }else if(statusCode==6){
                    clearTimeout(timer);
                    _s.showErrorMsg(s.parent(), "您的短信发送次数已达到3次，请明天再发");
                    s.removeAttr('send');
                    s.val('获取短信验证码');
                }
            })
        }
    },
    postSubmit:function(_s, s) {
        s.click(function() {
            var obj = _s.validateForm(_s);
            if (obj.flag) return;
            $.getJSON("/union_login/ajax_sina_reg_check.jsp", obj.Obj, function(data) {
                if (data == 0) {
                    window.location.href = "/user/user_wb.jsp?returnback=" + $('input[name=toUrl]').val();
                } else{
                    var errObj ={'login':[-1,-3,-10,-100,-101,-102,-103,-104,-107,-108,-109],'password':[-2,-4,-105,-106],'yzm':[-5,-6]},name = '';
                    for(var i in errObj){
                        for(var j=0;j<errObj[i].length;j++){
                            if(errObj[i][j]==data){
                                  name = i;
                            }
                        }
                    }
                    _s.showErrorMsg($("input[name="+name+"]"), _s.tipsObj[data]);
                }
            }, "text");
        })
    },
   /* formSubmit:function(_s, s) {
        s.click(function() {
            if(GLOBAL.pagetype=="verify_mobile"){
                _s.ajaxCheckOldCode(_s,$(this),document.forms[0])
                return;
            }
            var obj = _s.validateForm(_s);
            if (obj.flag) {
                return;
            } else {
                if (GLOBAL.checkcodeParam != "login_cart") {
                    if (GLOBAL.pagetype == "login") {
                        if (GLOBAL.pagename.split('|')[0] != 'cart') {
                            $(document.forms[0]).attr('target', 'oper');
                            $("body").append('<iframe name="oper" id="oper" src="' + document.location.protocol + '//passport.lefeng.com/login_do.jsp" style="display: none;"></iframe>')
                        }
                    }
                }
                document.forms[0].submit();
            }
        })
    },*/
    validateForm:function(_s) {
        var postObj = {},errTip = []
        $(".loginContent input").each(function() {
            if ($.trim($(this).val()) == "") {
                errTip.push($(this).attr('name'));
            }else if($(this).parent().find('.errorTips').text().length>0){
                errTip.push($(this).attr('name'));
            }
            postObj[$(this).attr('name')] = $(this).val();
        });
        for (var i = 0; i < errTip.length; i++) {
            _s.blurCheck(_s, $("input[name=" + errTip[i] + ']'), '', $("input[name=" + errTip[i] + ']').attr('stu'),false);
        } //_s,s,val,stu}
        return {'flag':errTip.length > 0,Obj:postObj}
    },
    /*reloadCode:function(_s, s) {
        s.find('img').attr('src', "/RandomCode.do?type="+GLOBAL.pagetype+"&rc=" + Math.random());
        s.prev().val("").focus();
        _s.noticeHide(_s, s, true);
    }*/
}
regedit.prototype.isMobeil = function (str) {
    var reg = /^1[3|5|7|8|4][0-9]\d{8}$/;
    return reg.test(str);
}
regedit.prototype.isLengthNull = function(str) {
    return str.length > 0;
}
regedit.prototype.constructor = regedit;
$().ready(function() {
    var r = new regedit();
    r.init('input');
    var name = $("input[name=loginName]");
    if($.trim(name.val())=="") name.focus();
    $(".loginInput li").each(function(){if($(this).find('.error').size()>0) $(this).addClass('er')});
})


$.extend({addFavorite:function(o, title, url) {
            var title = title || $('title').text(),url = url || location.href;
            o.click(function() {
                if (window.sidebar) {
                    window.sidebar.addPanel(title, url, "");
                } else if (document.all) {
                    window.external.AddFavorite(url, title);
                } else {
                    alert("\u8BF7\u4F7F\u7528Ctrl+D\u52A0\u5165\u6536\u85CF");
                }
                return false;
            });
        }});
$.addFavorite($('#Chead_save'),'乐蜂网','http://www.lefeng.com');

//var imgArray = [
//    ['login.jpg','#acc0be'],
//    ['lost_pass.jpg','#d2d2d2'],
//    ['register.jpg','#a8b1b0'],
//    ['union_login.jpg','#e2ddd7']
//];
//    if(GLOBAL.pagename=='login'){
//        appendImgDom(imgArray[0]);
//    } else if (GLOBAL.pagename == 'register') {
//        appendImgDom(imgArray[2]);
//    } else if (GLOBAL.pagename == 'lost_pass') {
//        appendImgDom(imgArray[1]);
//    } else if (GLOBAL.pagename == 'union_login') {
//        appendImgDom(imgArray[3]);
//    }
//function appendImgDom(img){
//    $('body').append('<div class="autoImage" id="autoImage"></div>');
//    $('body').css('background', img[1]);
//    var img = $('<img src="/images/'+img[0]+'" alt=""  />');
//    img.load(function() {
//        $("#autoImage").append($(this))
//        if (document.body.clientHeight > 800) {
//            $(this).css({height:$(window).height() + 'px',width:'auto'});
//        } else {
//            $(this).css({width:$(window).width() + 'px',heigth:'auto'});
//        }
//        $("#autoImage").fadeIn(1500);
//    });
//}