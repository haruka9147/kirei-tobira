<?php
require_once("./config.php");
require_once("./function.php");

$exclude = array();
form_check();
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
<form method="post" action="./" class="form h-adr" id="form" novalidate>
  <h1 class="maintitle">ご予約フォーム</h1>
  <input type="hidden" name="mode" value="confirm">
  <input type="hidden" name="referrer">
  <input type="hidden" name="campaign">
  <input type="hidden" name="repeater">
  <input type="hidden" name="fm_shopnm">
  <span class="p-country-name" style="display:none;">Japan</span>
  <div class="input">
    <div class="flow">
      <p>お申込みの流れ</p>
      <ul>
        <li class="act">
          <span>ご予約情報の入力</span>
          以下のお申込みフォームに必要事項を記入ください。
        </li>
        <li>
          <span>ご予約確認</span>
          お申込み後、ご指定のサロンよりご予約内容確認のお電話をさせていただきます。
        </li>
        <li>
          <span>ご予約完了</span>
          サロンからのお電話での確認が終わりますと、ご予約完了となります。
        </li>
      </ul>
    </div>
    <!--div class="login">
      <p class="catch">SNSアカウントから自動で入力</p>
      <p>各種サービスにログインすることで、お名前とメールアドレスの入力を省略することができます。</p>
      <ul>
        <li><a class="flogin">facebookでログイン</a></li>
        <li><a class="glogin">googleでログイン</a></li>
        <li><a class="ylogin">yahooでログイン</a></li>
      </ul>
    </div-->
    <div class="meiwaku">
      <p class="catch">携帯メールアドレスをご使用の方へ</p>
      <p>携帯電話のメールアドレスで当サロンからのメールを受信するには、各キャリアごとの設定をご確認の上、当サロン「@kirei-tobira.jp」からのメールを受信できるように予め設定をご変更いただきますようお願いいたします。</p>
    </div>
    <p class="red">※当サロンは女性限定サロンです。男性のご利用はお断りしておりますので、予めご了承ください。</p>
<?php if($fm_error) : ?>
    <div id="error">
      <p>以下の不備があります。ご確認の上ご修正ください。</p>
      <ul>
<?php echo $fm_error; ?>
      </ul>
    </div>
<?php endif; ?>
    <table class="base">
      <tr>
        <th class="req"><div class="item">お名前</div></th>
        <td><?php fm_input("fm_name", array("ipt100", "ime_on"), "例:山田花子"); ?></td>
      </tr>
      <tr>
        <th class="req"><div class="item">フリガナ</div></th>
        <td><?php fm_input("fm_kana", array("ipt100", "ime_on"), "例:ヤマダハナコ"); ?></td>
      </tr>
      <tr>
        <th class="opt"><div class="item">郵便番号<span>※入力すると住所が自動で入ります。</span></div></th>
        <td>
          <?php fm_input("fm_zip", array("ipt50", "ime_off", "p-postal-code"), "例:100-0001"); ?>
          <input type="hidden" name="fm_city" id="fm_city" class="p-region p-locality p-street-address p-extended-address" placeholder="例:東京都千代田区千代田">
        </td>
      </tr>
      <!-- <tr>
        <th class="req"><div class="item">ご住所<span>※番地以降は不要です</span></div></th>
        <td>
          <?php fm_input("fm_city", array("ipt100", "ime_on", "p-region", "p-locality", "p-street-address", "p-extended-address"), "例:東京都千代田区千代田"); ?>
        </td>
      </tr> -->
      <tr>
        <th class="req"><div class="item">ご年齢</div></th>
        <td>
<?php fm_select("fm_age", array("ipt100"), array("20歳～24歳", "25歳～29歳", "30歳～34歳", "35歳～39歳", "40歳～44歳", "45歳～49歳", "50歳～54歳", "55歳～59歳", "60歳以上")); ?>
        </td>
      </tr>
      <tr>
        <th class="req"><div class="item">お電話番号</div></th>
        <td>
          <?php fm_input("fm_tel1", array("ipt30", "ime_off telfm"), "例:090"); ?> -
          <?php fm_input("fm_tel2", array("ipt30", "ime_off telfm"), "例:1111"); ?> -
          <?php fm_input("fm_tel3", array("ipt30", "ime_off telfm"), "例:2222"); ?>
          <p class="telcheck">サロンからはお電話にてご連絡差し上げております。<br>こちらの電話番号でお間違いないか慎重にご確認ください。</p>
        </td>
      </tr>
      <tr>
        <th class="req"><div class="item">メールアドレス</div></th>
        <td>
          <?php fm_input("fm_mail", array("ipt100", "ime_off"), "例:hanako@example.com"); ?>
          <p class="mailcheck">メールアドレスの間違いが多くなっています。<br>こちらのアドレスでお間違いないか慎重にご確認ください。</p>
        </td>
      </tr>
      <tr>
        <th class="req"><div class="item">ご希望コース</div></th>
        <td class="course">
<?php
  $cource_sel = array(
    "フェイシャル",
    "痩身",
    "脱毛",
    "ネイル",
    "岩盤スタジオ",
  );
?>
<?php fm_checkbox("fm_cource", array(), $cource_sel); ?>

        </td>
      </tr>
      <tr>
        <th class="req"><div class="item">ご予約希望日</div></th>
        <td>
          <p>第一希望</p>
          <div class="sec">
<?php fm_select("fm_date1", array("ipt50"), dateselect(61)); ?>
<?php fm_select("fm_time1", array("ipt50"), array("午前中", "12:00～15:00", "15:00～18:00", "18:00～")); ?>
          </div>
          <p>第二希望</p>
          <div class="sec">
<?php fm_select("fm_date2", array("ipt50"), dateselect(61)); ?>
<?php fm_select("fm_time2", array("ipt50"), array("午前中", "12:00～15:00", "15:00～18:00", "18:00～")); ?>
          </div>
          <p>第三希望</p>
          <div class="sec">
<?php fm_select("fm_date3", array("ipt50","ng"), dateselect(61)); ?>
<?php fm_select("fm_time3", array("ipt50","ng"), array("午前中", "12:00～15:00", "15:00～18:00", "18:00～")); ?>
          </div>
        </td>
      </tr>
      <tr>
        <th class="req"><div class="item">ご連絡時間帯</div></th>
        <td>
          <p class="sec">お申し込み完了後、翌日までにご予約いただいたサロンより、確認のお電話をさせていただきます。お電話のご都合の良い時間帯をお選びください。(複数可)</p>
          <table class="intable">
            <thead>
              <tr class="head">
                <th></th>
                <th>10-14時</th>
                <th>13-18時</th>
                <th>17-20時</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th><span>平日</span></th>
                <td><label><input name="fm_contact[]" id="fm_contact1" value="平日10-14時" class="required validate[required]" type="checkbox"></label></td>
                <td><label><input name="fm_contact[]" id="fm_contact2" value="平日13-18時" class="required validate[required]" type="checkbox"></label></td>
                <td><label><input name="fm_contact[]" id="fm_contact3" value="平日17-21時" class="required validate[required]" type="checkbox"></label></td>
              </tr>
              <tr>
                <th><span class="sat">土曜</span>・<span class="sun">祝日</span></th>
                <td><label><input name="fm_contact[]" id="fm_contact4" value="土日祝10-14時" class="required validate[required]" type="checkbox"></label></td>
                <td><label><input name="fm_contact[]" id="fm_contact5" value="土日祝13-18時" class="required validate[required]" type="checkbox"></label></td>
                <td><label><input name="fm_contact[]" id="fm_contact6" value="土日祝17-21時" class="required validate[required]" type="checkbox"></label></td>
                </td>
              </tr>
            </tbody>
          </table>
          <p>
            ※ご予約日時がせまっている場合は、ご希望の曜日・時間帯以外にご連絡させていただく場合がございます。<br>
            ※ご予約確認のお電話に出られない場合は、留守番電話または伝言メモの設定をお願いいたします。
          </p>
        </td>
      </tr>
      <tr>
        <th class="opt"><div class="item">その他伝達事項</div></th>
        <td>
          <?php fm_textarea("fm_message", array("ipt100"), "何か有りましたらご記入ください"); ?>
        </td>
      </tr>
    </table>

    <div class="privacy">
      <h2>プライバシーポリシーをご確認ください</h2>
      <p>きれいのとびら（以下「当社」）は、以下のとおり個人情報保護方針を定め、個人情報保護の仕組みを構築し、全従業員に個人情報保護の重要性の認識と取組みを徹底させることにより、個人情報の保護を推進致します。</p>
      <div class="hidbox">
        <h3>1. 個人情報保護方針</h3>
        <p>当社は、情報サービス業として個人情報保護の重要性を認識し、個人情報保護の方針を定めるとともに、 全社一丸となり個人情報の適切な保護に努めます。<br>個人情報の収集、利用に関する基本原則、管理方法ならびに実効性を持たせる手段として教育・訓練、 監査等について以下のとおり規定し、実行して参ります。</p>
        <h3>2. 個人情報の収集、利用、提供等に関する基本事項</h3>
        <p>個人情報を直接収集する際は、適法かつ公正な手段により、本人の同意を得た上で行います。<br>収集にあたっては、利用目的を明確にし、その目的のために必要な範囲内にとどめます。<br>個人の利益を侵害する可能性が高い機微な情報は、本人の明確な同意がある場合または法令等の裏付けがある 場合以外には収集しません。<br>当社が個人情報の処理を伴う業務を外部から受託する場合や外部へ委託する場合は、個人情報に関する秘密の保持、 再委託に関する事項、事故時の責任分担、契約終了時の個人情報の返却および消去等について定め、それに従います。<br>個人情報は、本人の同意を得た範囲内で利用、提供します。</p>
        <h3>3. 個人情報の管理について</h3>
        <p>当社が直接収集または外部から業務を受託する際に入手した個人情報は、正確な状態に保ち、不正アクセス、紛失・破壊・改ざんおよび漏洩等を防止するための措置を講じます。<br>個人情報の処理を伴う業務を外部から受託する場合は、委託者が個人情報を入手した際、本人の同意を得た上で、適法かつ公正な手段によって収集したものであることを確認します。</p>
        <h3>4. リマーケティングについて</h3>
        <p> ヤフー及びGoogle を含む第三者配信事業者によりインターネット上のさまざまなサイトに当院の広告が掲載されています。 当ウェブサイトでは、ヤフー及びGoogle を含む第三者配信事業者から配信される広告が掲載される場合があり、 これに関連して、当該第三者配信事業者が、当ウェブサイトを訪問したユーザーのクッキー情報等を取得し、 利用している場合があります。</p>
        <p>ユーザーは、当該第三者配信事業者のウェブサイト内に設けられたオプトアウトページにアクセスして、 当該第三者配信事業者によるクッキー情報等の広告配信への利用を停止することができます（または、 Network Advertising Initiative のオプトアウト ページにアクセスして、当該第三者配信事業者によるクッ キー情報等の広告配信への利用を停止することができます）。</p>
        <p>クッキーとは、ウェブページを利用したときに、ブラウザとサーバーとの間で送受信した利用履歴や入力内容などを、 お客様のコンピュータにファイルとして保存しておく仕組みです。次回、同じページにアクセスすると、クッキーの情報を使って、 ページの運営者はお客様ごとに表示を変えたりすることができます。お客様がブラウザの設定でクッキーの送受信を許可してい る場合、ウェブサイトは、ユーザーのブラウザからクッキーを取得できます。なお、お客様のブラウザは、プライバシー保護のため、 そのウェブサイトのサーバーが送受信したクッキーのみを送信します。</p>
        <p>お客様は、クッキーの送受信に関する設定を「すべてのクッキーを許可する」、「すべてのクッキーを拒否する」、 クッキーを受信したらユーザーに通知する」などから選択できます。設定方法は、ブラウザにより異なります。 クッキーに関する設定方法は、お使いのブラウザの「ヘルプ」メニューでご確認ください。</p>
        <p>すべてのクッキーを拒否する設定を選択されますと、認証が必要なサービスを受けられなくなる等、 インターネット上の各種のサービスの利用上、制約を受ける場合がありますのでご注意ください。</p>
        <h3>5. 法令及びその他の規範について</h3>
        <p> 当社は、個人情報の保護に関係する日本の法令及びその他の規範を遵守し、本方針の継続的改善に努めます。</p>
        <h3>6. コンプライアンス・プログラムの継続的改善</h3>
        <p>当社は、個人情報保護に関するコンプライアンス・プログラムを定め実践・遵守するとともにコンプライアンス・プログラムの継続的改善に努めます。</p>
        <h3>7. 本人からのお問合せ</h3>
        <p>本人からの個人情報の取扱いに関するお問い合わせには、妥当な範囲において、すみやかな対応に努めます。<br>このページの内容に関するご質問及びお客様がご自身の個人情報についてご確認されたい場合には、【reserve@kirei-tobira.jp】までお問い合わせ下さい。</p>
      </div>
      <p>本サイトを利用するにあたり、上記「プライバシーポリシー」をご確認の上、内容に同意してください。</p>
      <p class="p_privacy">
        <input name="fm_privacy" id="fm_privacy" value="同意する" class="btn_radio required validate[required]" type="checkbox">
        <label for="fm_privacy">プライバシーポリシーに同意する</label>
      </p>
    </div>
    <input name="fm_shop" id="fm_shop1" value="0" type="hidden">
    <button type="submit" id="conf" style="display:none;">入力内容を確認</button>
    <div id="conf_block"><span>フォームの入力が<br>完了していません！</span></div>
  </div>

  <div class="confirm" style="display:none;">
    <table class="base">
      <tr>
        <th><div class="item">お名前</div></th>
        <td><span id="conf_fm_name"></span> 様</td>
      </tr>
      <tr>
        <th><div class="item">フリガナ</div></th>
        <td><span id="conf_fm_kana"></span> 様</td>
      </tr>
      <tr>
        <th><div class="item">ご住所</div></th>
        <td>〒<span id="conf_fm_zip"></span></td>
      </tr>
      <tr>
        <th><div class="item">ご年齢</div></th>
        <td><span id="conf_fm_age"></span></td>
      </tr>
      <tr>
        <th><div class="item">お電話番号</div></th>
        <td><span id="conf_fm_tel1"></span>-<span id="conf_fm_tel2"></span>-<span id="conf_fm_tel3"></span></td>
      </tr>
      <tr>
        <th><div class="item">メールアドレス</div></th>
        <td><span id="conf_fm_mail"></span></td>
      </tr>
      <tr>
        <th><div class="item">ご希望コース</div></th>
        <td><span id="conf_fm_cource"></span></td>
      </tr>
      <tr>
        <th><div class="item">ご予約希望日</div></th>
        <td>
          第一希望： <span id="conf_fm_date1"></span> <span id="conf_fm_time1"></span><br>
          第二希望： <span id="conf_fm_date2"></span> <span id="conf_fm_time2"></span><br>
          第三希望： <span id="conf_fm_date3"></span> <span id="conf_fm_time3"></span>
        </td>
      </tr>
      <tr>
        <th><div class="item">ご連絡時間帯</div></th>
        <td><span id="conf_fm_contact"></span></td>
      </tr>
      <tr>
        <th><div class="item">その他伝達事項</div></th>
        <td><span id="conf_fm_message"></span></td>
      </tr>
    </table>
    <div class="send">
      <button type="submit" id="send">送信する</button>
      <span>修正する</span>
    </div>
  </div>
</form>
</main>

<div class="remain_box" style="display:none;"></div>

<footer>
  <p><small>Copyright c きれいのとびら. All Right Reserved.</small></p>
</footer>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="//yubinbango.github.io/yubinbango/yubinbango.js" charset="UTF-8"></script>
<script src="./js/jquery.validationEngine.js"></script>
<script src="./js/jquery.validationEngine-ja.js"></script>
<script src="./js/jquery.autoKana.js"></script>
<script src="./js/form.js"></script>
</body>
</html>