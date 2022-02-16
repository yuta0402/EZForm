<?php

namespace EZForm;

use PHPMailer\PHPMailer\PHPMailer;

class Mailer extends PHPMailer
{
  public function __construct($settings)
  {
    $this->settings = $settings;
  }

  public function sendMail($mail_body,$mail_to)
  {

    try {
      $this->isHTML(false);
      $this->isSMTP();   // SMTP を使用
      $this->Host       = $this->settings['host'];  // SMTP サーバーを指定
      $this->SMTPAuth   = true;   // SMTP authentication を有効に
      $this->Username   = $this->settings['user_name'];;  // SMTP ユーザ名
      $this->Password   = $this->settings['password'];  // SMTP パスワード
      $this->SMTPSecure = 'tls';  // 暗号化を有効に
      $this->Port       = $this->settings['port'];   // TCP ポートを指定
      $this->CharSet = 'UTF-8';
      $this->Encoding = 'base64';

      //受信者設定 
      //※名前などに日本語を使う場合は文字エンコーディングを変換
      //差出人アドレス, 差出人名
      $this->setFrom($this->settings['from'] , $this->settings['from_name']);
      //受信者アドレス, 受信者名（受信者名はオプション）
      $this->addAddress($mail_to);
      // //追加の受信者（受信者名は省略可能なのでここでは省略）
      // $this->addAddress('someone@gmail.com');
      // //返信用アドレス（差出人以外に別途指定する場合）
      // $this->addReplyTo('info@example.com', mb_encode_mimeheader("お問い合わせ"));
      // //Cc 受信者の指定
      if($this->settings['admin']){
        $this->addBCC($this->settings['admin']);
      }

      //コンテンツ設定
      //メール表題（文字エンコーディングを変換）
      $this->Subject = $this->settings['title'];
      //HTML形式の本文（文字エンコーディングを変換）
      $this->Body  = $mail_body;
      //テキスト形式の本文（文字エンコーディングを変換）
      // $this->AltBody = $mail_body;

      $this->send();  //送信
    } catch (\Exception $e) {
      //エラー（例外：Exception）が発生した場合
      echo "Message could not be sent. Mailer Error: {$this->ErrorInfo}";
    }
  }
}
