var sent_ok = false;
var post_param = GetQueryString();

//フリガナ自動入力設定
var furigana = true;

var set_name = "#fm_name",
    set_kana = "#fm_kana",
    set_mail = "#fm_mail";

$(function(){
  if($("input[name=\"referrer\"]").length){
    if(isset(localStorage.referrer)){
      $("input[name=\"referrer\"]").val(localStorage.referrer + " / " + localStorage.medium);
    }else{
      $("input[name=\"referrer\"]").val("nodata");
    }
  }

  if($("input[name=\"campaign\"]").length){
    if(isset(post_param["lp"])){
      $("input[name=\"campaign\"]").val(post_param["lp"]);
    }else if(isset(localStorage.campaign)){
      $("input[name=\"campaign\"]").val(localStorage.campaign);
    }else{
      $("input[name=\"campaign\"]").val("nodata");
    }
  }

  if($("input[name=\"repeater\"]").length){
    if(isset(localStorage.repeater)){
      $("input[name=\"repeater\"]").val("あり");
    }else{
      $("input[name=\"repeater\"]").val("なし");
    }
  }

  if(isset(post_param["shop"])){
    shopselect(post_param["shop"]);
  }

  $("#form").validationEngine("attach", {
    promptPosition: "bottomLeft"
  });

  if(furigana){
    $.fn.autoKana(set_name, set_kana, {
      katakana : true
    });

    $(set_name).on("blur", function(){
      $(set_kana).validationEngine("validate");
    });
  }

  var el = getFormObject("#form");

  $.each(el, function(){
    if(this.attr("type") != "radio" && this.attr("type") != "checkbox"){
      if(this.val() == ""){
        if(this.hasClass("required")) this.addClass("ng");
      }else{
        if(this.validationEngine("validate")){
          this.removeClass("ng");
          this.addClass("ok");
        }else{
          this.removeClass("ok");
          this.addClass("ng");
        }
      }
    }else{
      if(this.hasClass("required")){
        var checked = false;

        $("input[name=\"" + this.attr("name") + "\"]").each(function(){
          if($(this).prop("checked")){
            checked = true;
          }
        });

        if(checked){
          this.removeClass("ng");
          this.addClass("ok");
        }else{
          this.removeClass("ok");
          this.addClass("ng");
        }
      }
    }
  });

  $("#form").bind("jqv.field.result", function(event, field, errorFound, prompText){
    if(errorFound){
      field.removeClass("ok");
      field.addClass("ng");
    }else{
      field.removeClass("ng");
      field.addClass("ok");
    }

    count_remain();
  });

  $(".ime_off").on('change', function(){
    var converted = $(this).val().replace(/[０-９ａ-ｚＡ-Ｚ．＠（）]/g, function(s) { // (1)
      return String.fromCharCode(s.charCodeAt(0) - 65248); // (2)
    });
    $(this).val(converted);
  });

  $(".send span").click(function(){
    confirm_back();
  });

  $(window).scroll(function(){
    if(!$(".remain_box").hasClass("ok")){
      if($(this).scrollTop() == 0){
        $(".remain_box").fadeOut();
      }else{
        $(".remain_box").fadeIn();
      }
    }
  });

  var suggest_id = "fm_mail"
  var suggest = $("#" + suggest_id)
  var domains = [
    'aol.com',
    'aol.jp',
    'au.com',
    'docomo.ne.jp',
    'disney.ne.jp',
    'emobile.ne.jp',
    'emobile-s.ne.jp',
    'excite.co.jp',
    'ezweb.ne.jp',
    'gmail.com',
    'goo.jp',
    'hotmail.co.jp',
    'hotmail.com',
    'i.softbank.jp',
    'icloud.com',
    'live.jp',
    'mopera.net',
    'outlook.com',
    'outlook.jp',
    'pdx.ne.jp',
    'softbank.ne.jp',
    'uqmobile.jp',
    'vodafone.ne.jp',
    'wcm.ne.jp',
    'willcom.com',
    'yahoo.co.jp',
    'yahoo.ne.jp',
    'ymobile.ne.jp',
    'y-mobile.ne.jp',
    'ymobile1.ne.jp',
    'zoho.com'
  ];

  suggest.on('keyup', function(e){
    var set = 0;
    var enter = false;

    switch(e.which){
      case 9: // Key[Tab]
        enter = true;
        break;

      case 13: // Key[Enter]
        enter = true;
        break;

      case 38: // Key[↑]
        set = -1;
        break;

      case 40: // Key[↓]
        set = 1;
        break;
    }

    if(set){
      var sel = $("#sug li").index($("#sug li.sel"));

      if(sel == -1 && set == 1){
        $("#sug li").eq(0).addClass("sel");
      }else if(sel + set == -1){
        $("#sug li").eq(0).removeClass("sel");
      }else if(sel + set > -1 && sel + set < $("#sug li").length){
        $("#sug li").eq(sel + set).addClass("sel");
        $("#sug li").eq(sel).removeClass("sel");
      }
    }else if(enter){
      $("#sug").remove();
    }else{
      var domain = $(this).val().split("@");
      var show_domain = [];

      if(domain.length > 1 && domain[1].length > 0){
        domains.forEach(function(element, index, array){
          if(!element.indexOf(domain[1])){
            if(element == domain[1]){
              return;
            }else{
              show_domain.push(element);
            }
          }
        });

        if(show_domain.length){
          $("#sug").remove();

          var t = suggest.offset().top + suggest.outerHeight();
          var l = suggest.offset().left;
          var w = suggest.outerWidth();

          suggest.after("<ul id=\"sug\" style=\"top:" + t + "px;left:" + l + "px;width:" + w + "px;\"></ul>");
          show_domain.forEach(function(element, index, array){
            $("#sug").append("<li>" + domain[0] + "@" + element + "</li>");
          });
        }else{
          $("#sug").remove();
        }
      }else{
        $("#sug").remove();
      }

      $(".mailcheck span").html($(this).val());
    }

    $("#sug li").mousedown(function(){
      $("#form").validationEngine("detach");
    }).mouseup(function(){
      $(".mailcheck span").html($("#sug li.sel").html());
      suggest.val($("#sug li.sel").html())
      $("#sug").remove();

      $("#form").validationEngine("attach", {
        promptPosition: "bottomLeft"
      });
      suggest.validationEngine("validate");
    });

    $("#sug li").hover(
      function(){
        $("#sug li").removeClass("sel");
        $(this).addClass("sel");
      },
      function(){
        $(this).removeClass("sel");
      }
    );
  });

  suggest.on('keydown', function(e){
    if(e.which == 13 || e.which == 9){
      if($("#sug li.sel").length > 0){
        if($(this).val() != $("#sug li.sel").html()){
          $(".mailcheck span").html($("#sug li.sel").html());
          $(this).val($("#sug li.sel").html());
          return false;
        }
      }
    }
  });

  suggest.on("paste input", function(){
    $(".mailcheck span").html($(this).val());
  });

  $(".telfm").on("paste input keyup", function(){
    if($("#fm_tel1").val() + $("#fm_tel2").val() + $("#fm_tel3").val()){
      if($("#fm_tel2").val()){
        if($("#fm_tel3").val()){
          $(".telcheck span").html($("#fm_tel1").val() + "-" + $("#fm_tel2").val() + "-" + $("#fm_tel3").val());
        }else{
          $(".telcheck span").html($("#fm_tel1").val() + "-" + $("#fm_tel2").val());
        }
      }else{
        $(".telcheck span").html($("#fm_tel1").val());
      }
    }else{
      $(".telcheck span").html("");
    }
  });

  $(window).on("beforeunload", function(){
    if(!sent_ok){
      return "";
    }
  });

  $('input, select, textarea').focusin(function(e){
    if($(this).attr("id") != suggest_id){
      $("#sug").remove();
    }

    $(this).validationEngine("hide");
  });

  $(".flogin").click(function(){
    var a = "https://www.facebook.com/dialog/oauth",
        i = F_CLIENT_ID,
        u = F_REDIRECT_URI,
        s = "email",
        r = "code";

    oauth(a,i,u,s,r);
  });

  $(".glogin").click(function(){
    var a = "https://accounts.google.com/o/oauth2/auth",
        i = G_CLIENT_ID,
        u = G_REDIRECT_URI,
        s = "https://www.googleapis.com/auth/userinfo.profile email",
        r = "code";

    oauth(a,i,u,s,r);
  });

  $(".ylogin").click(function(){
    var a = "https://auth.login.yahoo.co.jp/yconnect/v1/authorization",
        i = Y_CLIENT_ID,
        u = Y_REDIRECT_URI,
        s = "profile+email",
        r = "code";

    oauth(a,i,u,s,r);
  });

  $("input[name=\"fm_area\"]").change(function(){
    shopselchange($(this).val());
  });

  $(".shoplist").click(function(){
    url = "/saloninfo/";

    var query = [];
    if($("input[name=\"fm_area\"]:checked").val()){
      query.push("area="+ $("input[name=\"fm_area\"]:checked").val());
    }

    if($("input[name=\"fm_shop\"]:checked").val()){
      query.push("shop="+ $("input[name=\"fm_shop\"]:checked").val());
    }

    if(query.length) url += "?" + query.join("&");
    window.open(url, "店舗一覧", "width=400,height=540;scrollbars=yes,resizable=yes,status=yes");
  });

  $("a[href^=#]").click(function(){
    var speed = 400;
    var href = $(this).attr("href");
    var target = $(href == "#" || href == "" ? "html" : href);
    var position = target.offset().top;

    $('body,html').animate({scrollTop:position}, speed, 'swing');
    return false;
  });

  count_remain();
});


function getFormObject(form){
  var data = [];
  var check = [];

  $(form).find("input, select, textarea").each(function(){
    var el = $(this);
    var name = el.attr("name").replace("[]","");

    if(check.indexOf(name) < 0){
      data.push(el);
      check.push(name);
    }
  });

  return data;
}

function count_remain(){
  var items = 0;
  var ok = 0;
  var ng = 0;
  var el = getFormObject("#form");

  $.each(el, function(){
    if(this.hasClass("required")){
      items++;

      if(this.hasClass("ok")){
        ok++;
      }
    }
  });

  $(".ng").each(function(){
    if($(this).hasClass("required")){
      ng++;
    }
  });

  if(items - ok > 0){
    $(".remain_box").html("必須項目は、<br>残り<span>" + (items - ok) + "</span>件です。");
    $(".remain_box").removeClass("ok");
    $("#conf").css("display","none");
    $("#conf_block").css("display","block");
  }else if(ng > 0){
    $(".remain_box").html("入力エラーがあります。ご確認ください。");
    $(".remain_box").removeClass("ok");
    $("#conf").css("display","none");
    $("#conf_block").css("display","block");
  }else{
    $(".remain_box").html("入力内容を確認を押してください。");
    $(".remain_box").addClass("ok");
    $("#conf").css("display","block");
    $("#conf_block").css("display","none");
  }
}

function confirm_value(){
  // $("input[name=\"fm_shopnm\"]").val($("input[name=\"fm_shop\"]:checked + label").html().replace("<br>"," "));
  var param = $("#form").serializeArray();

  $(".confirm td span").each(function(){
    $(this).html("");
  });

  $.each(param, function(){
    var item = $("#conf_" + this.name.replace(/\[\]/g,''));

    if(item.html() == ""){
      item.html(this.value);
    }else{
      item.append("、" + this.value);
    }
  });

  $(".remain_box").css("display","none");
  $(".input").fadeOut("fast",function(){
    $(".confirm").fadeIn("fast",function(){
      var position = $("#form").offset().top;
      $('body,html').animate({scrollTop:position}, 400, 'swing');
    });
  });

  sent_ok = true;
}

function confirm_back(){
  $(".confirm").fadeOut("fast",function(){
    $(".input").fadeIn("fast",function(){
      var position = $("#form").offset().top;
      $('body,html').animate({scrollTop:position}, 400, 'swing');
      $(".remain_box").css("display","block");
    });
  });

  sent_ok = false;
}

function inputbysns(){
  if(isset(name) && isset(set_name)){
    $(set_name).val(name);
    $(set_name).validationEngine("validate");
  }

  if(isset(email) &&isset(set_mail)){
    $(set_mail).val(email);
    $(".mailcheck span").html(email);
    $(set_mail).validationEngine("validate");
  }
}

function shopselect(shop){
  $("input[name=\"fm_shop\"]").val([shop]);
  $("#fm_shop1").removeClass("ng");
  $("#fm_shop1").addClass("ok");

  count_remain();
}

function oauth(a,i,u,s,r){
    var url = a + "?client_id=" + i + "&redirect_uri=" + u + "&scope=" + s + "&response_type=" + r;
    window.open(url, "ログイン", "width=980, height=540, menubar=no, toolbar=no, scrollbars=no");
}

function isset(data){
  return(typeof(data) != "undefined");
}

function GetQueryString(){
  var result = {};
  if(1 < window.location.search.length){
    var query = window.location.search.substring(1);
    var parameters = query.split("&");

    for(var i = 0; i < parameters.length; i++){
      var element = parameters[i].split("=");
      var paramName = decodeURIComponent(element[0]);
      var paramValue = decodeURIComponent(element[1]);

      result[paramName] = paramValue;
    }
  }

  return result;
}