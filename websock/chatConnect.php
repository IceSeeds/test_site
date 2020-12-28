<?php
  if(isset( $_POST["leaveRoom"] ))
  {
    require_once __DIR__ . '/../contents/room/ioRoom.php';
    leave();
  }
 ?>
<!DOCTYPE html>
<html lang="ja">
<meta charset="utf-8">
<title>Chat</title>
<style>
.container {
    width: 600px;
}
.box{
    overflow:hidden;
}
.timebox{
    overflow:hidden;
}
.left {
    background-color: #D3D3D3;
    padding: 20px;
    margin: 5px;
    width: 300px;
    float:left;
}
.right {
    background-color: #ADFF2F;
    padding: 20px;
    margin: 5px;
    width: 300px;
    float:right;
}
</style>
<script src="http://code.jquery.com/jquery-2.2.4.js"></script>
<script>
(function($){

  /* TODO
    送信したら、自分のめっせが相手の方で送られてくる。なして？
  */

  <?php
    session_start();
    $room = $_SESSION['ROOMNAME'];
    $myname = $_SESSION['NAME'];
    $send_param["mode"] = "room";
    $send_param["room"] = $room;
  ?>
  var myname = "<?php echo $myname ?>";

  var settings = {};

  var methods = {
    init : function( options ) {
      settings = $.extend({
        'uri'   : 'ws://localhost:8080',
        'conn'  : null,
        'message' : '#message',
        'display' : '#display'
      }, options);
      $(settings['message']).keypress( methods['checkEvent'] );
      $(this).chat('connect');
    },

    checkEvent : function ( event ) {
      if (event && event.which == 13) {
        var message = $(settings['message']).val();
        if (message && settings['conn']) {
          settings['conn'].send(message + '');
          $(this).chat('drawText',message,'right');
          $(settings['message']).val('');
        }
      }
    },

    connect : function () {
      if (settings['conn'] == null) {
        settings['conn'] = new WebSocket(settings['uri']);
        settings['conn'].onopen = methods['onOpen'];
        settings['conn'].onmessage = methods['onMessage'];
        settings['conn'].onclose = methods['onClose'];
        settings['conn'].onerror = methods['onError'];
      }
    },

    onOpen : function ( event ) {
      $(this).chat('drawText','サーバに接続','left');
    },

    onMessage : function (event) {
      if (event && event.data) {
        $(this).chat('drawText',event.data,'left');
      }
    },

    onError : function(event) {
      $(this).chat('drawText','エラー発生!','left');
    },

    onClose : function(event) {
      $(this).chat('drawText','サーバと切断','left');
      settings['conn'] = null;
      setTimeout(methods['connect'], 1000);
    },

    drawText : function (message, align='left') {
      if ( align === 'left' ) {
        var inner = $('<div class="left"></div>').text(message);
        var t = $('<span class="time"></span>').text(nowTime());
      } else {
        var inner = $('<div class="right"></div>').text(message);
        var t = $('<span class="time"></span>').text(nowTime());
      }
      var box = $('<div class="box"></div>').html(inner);
      $('#chat').prepend(box);
      var timebox = $('<div class="box"></div>').html(t);
      $('#time').prepend(timebox);
    },
  }; // end of methods

  $.fn.chat = function( method ) {
    if ( methods[method] ) {
      return methods[ method ].apply( this, Array.prototype.slice.call( arguments, 1 ));
    } else if ( typeof method === 'object' || ! method ) {
      return methods.init.apply( this, arguments );
    } else {
      $.error( 'Method ' +  method + ' does not exist' );
    }
  } // end of function
})( jQuery );

$(function() {
  $(this).chat({
    'uri':'ws://localhost:8080?<?php echo(http_build_query($send_param))?>',
    'message' : '#message',
    'display' : '#chat'
  });
});

function nowTime()
{
  var jikan= new Date();

  //時・分・秒を取得する
  var hour = jikan.getHours();
  var minute = jikan.getMinutes();
  var second = jikan.getSeconds();

  var t = hour + ":" + minute;
  return t;
}
</script>
</head>
<body>
  <form action="" method="post">
    <button type="submit" id="leaveRoom" name="leaveRoom" class="btn btn-primary mb-2">Leave</button>
  </form>
  <input type="text" id="message" size="50" />
  </span><div id="chat" class="container"><span id="time" class="timecont"></div>
</body>
</html>
