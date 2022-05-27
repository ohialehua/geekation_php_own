$(function () {
  let favorite = $('.favorite-toggle');
  let favoritePostId;
  favorite.on('click', function () { //onはイベントハンドラー
    let $this = $(this); //this=イベントの発火した要素＝iタグを代入
    favoritePostId = $this.data('post-id'); //iタグに仕込んだdata-post-idの値を取得
    //ajax処理スタート
    $.ajax({
      headers: { //HTTPヘッダ情報をヘッダ名と値のマップで記述
        'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
      },  //↑name属性がcsrf-tokenのmetaタグのcontent属性の値を取得
      url: '/user/favorite/create', //通信先アドレスで、このURLをあとでルートで設定します
      method: 'POST', //HTTPメソッドの種別を指定します。1.9.0以前の場合はtype:を使用。
      data: { //サーバーに送信するデータ
        'user_post_id': favoritePostId //いいねされた投稿のidを送る
      },
    })
    //通信成功した時の処理
    .done(function (data) {
      $this.toggleClass('favorited'); //likedクラスのON/OFF切り替え。
      $this.next('.favorite-counter').html(data.post_favorites_count);
    })
    //通信失敗した時の処理
    .fail(function () {
      console.log('fail');
    });
  });
  });