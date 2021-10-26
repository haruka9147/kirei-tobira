<?php
$source = urldecode($_GET["source"]);
$uniq = $_GET["uniq"];
?>
<!Doctype html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" id="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no">
<title>ご予約フォーム｜きれいのとびら</title>

<link rel="stylesheet" href="./css/common.css">
<link rel="stylesheet" href="./css/sp.css" media="screen and (max-device-width: 768px)">
<link rel="stylesheet" href="./css/pc.css" media="screen and (min-device-width: 769px)">
<link rel="stylesheet" href="./css/validationEngine.jquery.css">
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
</head>
<body>
<header>
  <p class="main"><img src="./logo.svg" alt="きれいのとびら"></p>
</header>

<main>
<div class="form">
  <h1 class="maintitle">ご予約フォーム</h1>
  <div class="flow">
    <p>お申込みの流れ</p>
    <ul>
      <li>
        <span>ご予約情報の入力</span>
        以下のお申込みフォームに必要事項を記入ください。
      </li>
      <li class="act">
        <span>ご予約確認</span>
        お申込み後、ご指定のサロンよりご予約内容確認のお電話をさせていただきます。
      </li>
      <li>
        <span>ご予約完了</span>
        サロンからのお電話での確認が終わりますと、ご予約完了となります。
      </li>
    </ul>
  </div>
  <div class="thanks">
    <h2 class="subtitle">送信が完了いたしました</h2>
    <p>この度は、当店にご予約いただき、まことにありがとうございます。後ほどサロンより<span class="att">ご予約日の確認のご連絡</span>をさせていただきます。</p>
    <p>ご予約日時がせまっている場合は、<span class="att">ご希望の曜日・時間帯以外にご連絡させていただく</span>場合がございます。</p>
    <p>ご予約確認のお電話に出られない場合は、<span class="att">留守番電話または伝言メモの設定</span>をお願いいたします。</p>
    <p>ご不明な点がございましたら、お気軽にご相談ください。</p>
  </div>
</div>
</main>

<footer>
  <p><small>Copyright c きれいのとびら. All Right Reserved.</small></p>
</footer>
<script>localStorage.repeater = 1;</script>
</body>
</html>