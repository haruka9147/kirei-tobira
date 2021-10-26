<?php
$mail_shop_subject = "{$subject_header}-{$referrer}-{$shop_nm})";

$mail_shop_body = <<<EOD
LPより下記の内容にて、お問い合わせを受け付けました。

■参照元メディア
$referrer

■過去の来店
$repeater

■成果識別ID
$uniq

■お名前
{$fm_name}({$fm_kana}) 様

■ご住所
〒{$fm_zip}
{$fm_city}

■ご年齢
$fm_age

■お電話番号
{$fm_tel1}-{$fm_tel2}-{$fm_tel3}

■メールアドレス
$fm_mail

■ご希望コース
$fm_cource

■ご連絡時間帯
$fm_contact

■ご予約希望日
第一希望： $fm_date1 $fm_time1
第二希望： $fm_date2 $fm_time2
第三希望： $fm_date3 $fm_time3

■その他伝達事項
$fm_message

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
◆{$shop_br} {$shop_nm}
TEL　{$shop_tl}
{$shop_ei}
{$shop_ad}
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
EOD;

?>