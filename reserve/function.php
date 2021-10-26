<?php

//タイムゾーンを日本に設定(CPIではコメントアウト)
date_default_timezone_set("Asia/Tokyo");

// エラーメッセージを全て出力するように設定
error_reporting(E_ALL);

// 文字コードの検出順序を設定
mb_detect_order("ASCII,JIS,UTF-8,EUC-JP,SJIS");

// 内部文字コードを設定
mb_internal_encoding("UTF-8");

// 正規表現の文字コードを設定
mb_regex_encoding("UTF-8");

$fm_error = "";

// パターンリスト
$fm_pattern = array(
  'onlyNumberSp' => array('数字',"\d０１２３４５６７８９"),
  'onlyLetterSp' => array('アルファベット',"a-zA-ZａｂｃｄｅｆｇｈｉｊｋｌｍｎｏｐｑｒｓｔｕｖｗｘｙｚＡＢＣＤＥＦＧＨＩＪＫＬＭＮＯＰＱＲＳＴＵＶＷＸＹＺ"),
  'onlyLetterNumber' => array('半角英数',"\d０１２３４５６７８９a-zA-ZａｂｃｄｅｆｇｈｉｊｋｌｍｎｏｐｑｒｓｔｕｖｗｘｙｚＡＢＣＤＥＦＧＨＩＪＫＬＭＮＯＰＱＲＳＴＵＶＷＸＹＺ_"),
  'katakana' => array('カタカナ',"ｧｱｨｲｩｳｪｴｫｵｶｷｸｹｺｻｼｽｾｿﾀﾁｯﾂﾃﾄﾅﾆﾇﾈﾉﾊﾋﾌﾍﾎﾏﾐﾑﾒﾓｬﾔｭﾕｮﾖﾗﾘﾙﾚﾛﾜｦﾝﾞﾟｰァアィイゥウェエォオカガキギクグケゲコゴサザシジスズセゼソゾタダチヂッツヅテデトドナニヌネノハバパヒビピフブプヘベペホボポマミムメモャヤュユョヨラリルレロヮワヰヱヲンヴヵヶ゛゜ーヽヾ　 "),
  'hiragana' => array('ひらがな',"ぁあぃいぅうぇえぉおかがきぎくぐけげこごさざしじすずせぜそぞただちぢっつづてでとどなにぬねのはばぱひびぴふぶぷへべぺほぼぽまみむめもゃやゅゆょよらりるれろゎわゐゑをん゛゜ーゝゞ　 "),
  'email' => array('正しいメールアドレス',"[\w\-\.]+@[\w\-]+\.[\w\-\.]+"),
  'phone' => array('半角数字のみ',"\d０１２３４５６７８９\-‐－"),
  'zip' => array('半角数字のみ',"\d０１２３４５６７８９\-‐－"),
);

// 文字コードを変換
function encode($buffer,$encoding_new){
  $encoding_old = mb_detect_encoding($buffer);
  if($encoding_new !== $encoding_old){
    $buffer = mb_convert_encoding($buffer,$encoding_new,$encoding_old);
  }
  return $buffer;
}

// POST値を取得
function getPost($k){
  if(isset($_POST[$k]) === true){
    $v = $_POST[$k];
    if(is_array($v) === false){
      $v = encode($v,'UTF-8');
      $v = stripslashes($v);
    }else{
      for($i = 0; $i < count($v); $i++){
        $v[$i] = encode($v[$i],'UTF-8');
        $v[$i] = stripslashes($v[$i]);
      }
    }
    return $v;
  }
  return '';
}

function mail_send(){

  // カレントの言語を日本語に設定する
  mb_language("ja");
  // 内部文字エンコードを設定する
  mb_internal_encoding("UTF-8");

  global $_POST, $fm_data, $cam_names, $mail_to, $mail_cc, $mail_bcc, $mail_trans;
  require_once("./shop_config.inc");

  foreach($fm_data as $key => $value){
    if(is_array($value["value"])){
      $$key = implode("、", $value["value"]);
    }else{
      $$key = $value["value"];
    }
  }

  $shop_br = $shop[$fm_shop]["brand_nm"];
  $shop_nm = $shop[$fm_shop]["shop_nm"];
  $shop_ad = $pref[$shop[$fm_shop]["pref_id"]] . $shop[$fm_shop]["shop_address"] . " " . $shop[$fm_shop]["shop_building"];
  $shop_ml = $shop[$fm_shop]["shop_mail"];
  $shop_tl = $shop[$fm_shop]["shop_tel"];
  $shop_ei = str_replace("<br>", "\n", $shop[$fm_shop]["shop_eigyo"]);

  $referrer = $_POST["referrer"];
  $campaign = $_POST["campaign"];
  $repeater = $_POST["repeater"];
  $uniq = date('YmdHi') . uniqid("_");
  if($mail_to != "") $shop_ml = $mail_to;

  if(isset($cam_names["$campaign"])){
    $subject_header = "【きれいのとびら】ご予約({$cam_names["$campaign"]}";
  }else{
    $subject_header = "【きれいのとびら】ご予約(LP不明";
  }

  require_once("mail_shop.php");
  require_once("mail_user.php");

  $file_nm = './log/' . $uniq . '.txt';

  if($deftext = @file_get_contents($file_nm)) {
    $logtext = $deftext . "\n\n";
    $logtext .= $mail_shop_subject . "\n\n" . $mail_shop_body;
  }else{
    $logtext = $mail_shop_subject . "\n\n" . $mail_shop_body;
  }

  if($fp = fopen($file_nm,"w")){
    flock($fp,LOCK_EX);
    fputs($fp,$logtext);
    flock($fp,LOCK_UN);
    fclose($fp);
  }
  
  $mail_user_header = "From: " . $shop_ml;
  $mail_shop_header = "From: " . $fm_mail;
  if($mail_cc != "") $mail_shop_header .= "\nCc: " . $mail_cc;
  if($mail_bcc != "") $mail_shop_header .= "\nBcc: " . $mail_bcc;

  if(mb_send_mail($shop_ml,$mail_shop_subject,$mail_shop_body,$mail_shop_header)){
    mb_send_mail($fm_mail,$mail_user_subject,$mail_user_body,$mail_user_header);

    $url = "./thanks.php?uniq=" . $uniq . "&source=" . urlencode($referrer);
    header("Location: " . $url);
  }else{
    echo "メール送信失敗しました<br />\n";
  }
}

function form_check(){

  global $fm_data, $fm_pattern, $fm_error;

  if(isset($_POST["mode"])){
    // POST値取得
    foreach($fm_data as $k => $v){
      $fm_data[$k]["value"] = getPost($k);
    }

    // POST値チェック
    foreach($fm_data as $k => $v){

      // 文字種変換
      if(is_array($v["value"])){
        foreach($v["value"] as $k_arr => $v_arr){
          $v_arr = mb_convert_kana($v_arr,'KV');

          if(isset($v["validate"]["pattern"]) && $v["validate"]["pattern"] === 'onlyNumberSp'){
            $v_arr = mb_convert_kana($v_arr,'n');
          }elseif(isset($v["validate"]["pattern"]) && $v["validate"]["pattern"] === 'phone'){
            $v_arr = mb_convert_kana($v_arr,'n');
            $v_arr = mb_ereg_replace('‐|－','-',$v_arr);
          }

          $fm_data[$k]["value"][$k_arr] = $v_arr;
        }

        continue;
      }

      $v["value"] = mb_convert_kana($v["value"],'KV');

      if(isset($v["validate"]["pattern"]) && $v["validate"]["pattern"] === 'onlyNumberSp'){
        $v["value"] = mb_convert_kana($v["value"],'n');
      }elseif(isset($v["validate"]["pattern"]) && $v["validate"]["pattern"] ==='phone'){
        $v["value"] = mb_convert_kana($v["value"],'n');
        $v["value"] = mb_ereg_replace('‐|－','-',$v["value"]);
      }

      $fm_data[$k]["value"] = $v["value"];

      // 必須項目チェック
      if(isset($v["validate"]["req"]) && $v["validate"]["req"] && $v["value"] == ""){
        $fm_error .= '<li>【' . $v["cap"] . '】をご入力ください。</li>';
        continue;
      }

      // 文字種チェック
      if(isset($v["validate"]["pattern"]) && $v["validate"]["pattern"] !== "" && isset($fm_pattern[$v["validate"]["pattern"]])){
        $pattern = '';

        $pattern = $fm_pattern[$v["validate"]["pattern"]][1];
        $pattern_message = $fm_pattern[$v["validate"]["pattern"]][0];

        $pattern = $v["validate"]["pattern"] === 'email' ? '^'.$pattern.'$' : '^['.$pattern.']*$';

        if(mb_ereg_match($pattern,$v["value"]) ===false){
          if($v["validate"]["pattern"] == "email"){
            $fm_error .= '<li>【' . $v["cap"] . '】が正しくありません。</li>';
          }else{
            $fm_error .= '<li>【' . $v["cap"] . '】は' . $pattern_message . 'でご入力ください。</li>';
          }
        }
      }

      // 最大入力文字数チェック
      if(isset($v["validate"]["length"]) && $v["validate"]["length"] !== ''){
        if($v["validate"]["length"] < mb_strlen($v["value"])){
          $fm_error .= '<li>【' . $v["cap"] . '】は' . $v["validate"]["length"] . '文字以内でご入力ください。</li>';
        }
      }

    }

    if($fm_error ==''){
      mail_send();
    }
  }
}

function dateselect($date_cnt,$close_w = array(),$close_d = array()){
  $date = array();
  $week = array("日", "月", "火", "水", "木", "金", "土");

  for ($i=1; $i < $date_cnt; $i++) { 
    $i_date = mktime(0,0,0,date('n'),date('j') + $i,date('Y'));

    if(!in_array(date('w', $i_date),$close_w) && !in_array(date('Y/n/j', $i_date), $close_d)){
      $w = '(' . $week[date('w', $i_date)] . ')';
      $date[$i - 1] = date('n月j日', $i_date) . $w;
    }
  }
  
  return $date;
}

function timeselect($st_hour,$ed_hour,$minute_span){
  for ($i = $st_hour; $i <= $ed_hour; $i++) {
    for ($n = 0; $n < 6; $n += $minute_span) { 
      $time[$i . ":" . $n] = $i . ":" . $n . "0";
    }
  }
  return $time;
}

function fm_input($param, $classes = array(), $placeholder = null){
  global $fm_data;

  if(isset($fm_data[$param]["validate"]["pattern"])){
    $pattern = $fm_data[$param]["validate"]["pattern"];
  }else{
    $pattern = "";
  }

  switch($pattern){
    case "phone":
      $type = "tel";
      break;
    
    case "zip":
      $type = "tel";
      break;
    
    case "email":
      $type = "email";
      break;
    
    case "url":
      $type = "url";
      break;
    
    default:
      $type = "text";
      break;
  }

  $class = validate($fm_data[$param]["validate"], $classes);

  if(isset($placeholder)) $placeholder = " placeholder=\"{$placeholder}\"";

  $value = "";
  if(isset($_POST[$param])) $value = " value=\"" . getPost($param) . "\"";

  echo "<input type=\"{$type}\" name=\"{$param}\" id=\"{$param}\"{$class}{$placeholder}{$value}>";
}

function fm_textarea($param, $classes = array(), $placeholder = null){
  global $fm_data;

  $class = validate($fm_data[$param]["validate"], $classes);

  if(isset($placeholder)) $placeholder = " placeholder=\"{$placeholder}\"";

  $value = getPost($param);

  echo "<textarea name=\"{$param}\" id=\"{$param}\"{$class}{$placeholder}>{$value}</textarea>";
}

function fm_radio($param, $classes = array(), $value = array()){
  global $fm_data;

  $class = validate($fm_data[$param]["validate"], $classes);

  foreach($value as $k => $v){
    echo "<label><input type=\"radio\" name=\"{$param}\" id=\"{$param}{$k}\" value=\"{$v}\"{$class}" . post_chk($param, $k, $v, "checked") . ">{$v}</label>";
  }
}

function fm_checkbox($param, $classes = array(), $value = array()){
  global $fm_data;

  $class = validate($fm_data[$param]["validate"], $classes);

  foreach($value as $k => $v){
    echo "<label><input type=\"checkbox\" name=\"{$param}[]\" id=\"{$param}{$k}\" value=\"{$v}\"{$class}" . post_chk_array($param, $k, $v, "checked") . ">{$v}</label>";
  }
}

function fm_select($param, $classes = array(), $value = array()){
  global $fm_data;

  $class = validate($fm_data[$param]["validate"], $classes);

  echo "<select name=\"{$param}\" id=\"{$param}\"{$class}>";
  echo "  <option value=\"\">--</option>";
  foreach($value as $k => $v){
    echo "  <option value=\"{$v}\"" . post_chk($param, $k, $v, "selected") . ">{$v}</option>";
  }
  echo "</select>";
}

function validate($validates = array(), $classes = array()){
  $validate = array();

  foreach($validates as $k => $v){
    if($v){
      switch($k){
        case "length":
          $validate[] = "maxSize[{$v}]";
          break;

        case "pattern":
          $validate[] = "custom[{$v}]";
          break;

        case "equals":
          $validate[] = "equals[{$v}]";
          break;

        case "req":
          $validate[] = "required";
          $classes[] = "required";
          break;
      }
    }
  }

  if(count($validate)){
    $classes[] = "validate[" . implode(",", $validate) . "]";
  }

  if($class = implode(" ", $classes)) return " class=\"{$class}\"";
}

function post_chk($param, $key, $value, $chk){
  global $fm_data;

  if(getPost($param)){
    if(getPost($param) == $value) return " " . $chk;
  }elseif(isset($_GET[$param])){
    if($_GET[$param] == $key) return " " . $chk;
  }elseif(isset($fm_data[$param]["default"]) && $fm_data[$param]["default"] == $value){
    return " " . $chk;
  }
}

function post_chk_array($param, $key, $value, $chk){
  global $fm_data;

  if(getPost($param)){
    if(in_array($value, getPost($param))) return " " . $chk;
  }elseif(isset($_GET[$param])){
    if(in_array($key, $_GET[$param])) return " " . $chk;
  }elseif(isset($fm_data[$param]["default"]) && $fm_data[$param]["default"] == $value){
    return " " . $chk;
  }
}
?>