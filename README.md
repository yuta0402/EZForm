# EZForm
簡単にフォームを作りましょう。

## Description
簡単にお問い合わせフォームでメールが飛ばせしたい人のためにおすすめです。

## Usage
・適当な場所でgit clone https://github.com/yuta0402/EZForm.git
・EZFormフォルダ内のform_settings.json.sampleをform_settings.jsonにリネームして設定
・example内に入力・確認・完了に必要な記述が書いてありますので参考してください
・各ファイルでrequire_once('../EZform/vendor/autoload.php');のパス設定が大事です。
## For Developer
docker run -p 4000:80 -v ${PWD}:/var/www/html -d php:apache