<?php
$form_nm = "reserve";

//運営者メール宛先(店舗に直接メールしない場合のみ設定)
$mail_to = "";

//運営側メールのcc
$mail_cc = "";

//運営側メールのbcc
$mail_bcc = "cv@fancplant.net";

//フォーム項目の配列
$fm_data = array(
  "fm_name" => array(
    "cap" => "お名前",
    "default" => null,
    "validate" => array(
      "req" => 1,
      "length" => 20,
      "pattern" => null,
      "equals" => null,
    ),
  ),
  "fm_kana" => array(
    "cap" => "フリガナ",
    "validate" => array(
      "req" => 1,
      "length" => 20,
      "pattern" => "katakana",
    ),
  ),
  "fm_zip" => array(
    "cap" => "郵便番号",
    "validate" => array(
      "req" => 0,
      "length" => 8,
      "pattern" => "zip",
    ),
  ),
  "fm_city" => array(
    "cap" => "ご住所",
    "validate" => array(
      "req" => 0,
      "length" => 50,
    ),
  ),
  "fm_age" => array(
    "cap" => "ご年齢",
    "validate" => array(
      "req" => 1,
    ),
  ),
  "fm_tel1" => array(
    "cap" => "お電話番号(市外局番)",
    "validate" => array(
      "req" => 1,
      "length" => 4,
      "pattern" => "phone",
    ),
  ),
  "fm_tel2" => array(
    "cap" => "お電話番号(市内局番)",
    "validate" => array(
      "req" => 1,
      "length" => 4,
      "pattern" => "phone",
    ),
  ),
  "fm_tel3" => array(
    "cap" => "お電話番号(下4桁)",
    "validate" => array(
      "req" => 1,
      "length" => 4,
      "pattern" => "phone",
    ),
  ),
  "fm_mail" => array(
    "cap" => "メールアドレス",
    "validate" => array(
      "req" => 1,
      "length" => 100,
      "pattern" => "email",
    ),
  ),
  "fm_shop" => array(
    "cap" => "ご希望サロン",
    "validate" => array(
      "req" => 1,
    ),
  ),
  "fm_cource" => array(
    "cap" => "ご希望コース",
    "validate" => array(
      "req" => 1,
    ),
  ),
  "fm_contact" => array(
    "cap" => "電話連絡が可能な時間帯",
    "validate" => array(
      "req" => 1,
      "length" => 10,
    ),
  ),
  "fm_date1" => array(
    "cap" => "ご予約希望日1",
    "validate" => array(
      "req" => 1,
      "length" => 10,
    ),
  ),
  "fm_time1" => array(
    "cap" => "ご予約希望時間帯1",
    "validate" => array(
      "req" => 1,
      "length" => 12,
    ),
  ),
  "fm_date2" => array(
    "cap" => "ご予約希望日2",
    "validate" => array(
      "req" => 1,
      "length" => 10,
    ),
  ),
  "fm_time2" => array(
    "cap" => "ご予約希望時間帯2",
    "validate" => array(
      "req" => 1,
      "length" => 12,
    ),
  ),
  "fm_date3" => array(
    "cap" => "ご予約希望日3",
    "validate" => array(
      "req" => 1,
      "length" => 10,
    ),
  ),
  "fm_time3" => array(
    "cap" => "ご予約希望時間帯3",
    "validate" => array(
      "req" => 1,
      "length" => 12,
    ),
  ),
  "fm_message" => array(
    "cap" => "その他伝達事項",
    "validate" => array(
    ),
  ),
);

$cam_names = array(

);
?>