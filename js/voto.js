$(function(){
      //にゃーボタン　参考：http://satohmsys.info/likebutton/
     $('.nya').on('click' , function(){
          
          $this = $(this);
          var id = $this.data("id");
          var num_span = ".count_good" + id;
          var now_count = $this.data("count");
          //このままだと同じタイミングでにゃーしたのがカウントされないので要対策
          var new_count = now_count + 1;

          $.ajax({
               type : "POST",
               url : "php/voto.php",
               data: {
                    "cat_id" : id,
                    "count" : new_count
               }
          }).done(function(data){
                  alert(data);
                  if(data == "「にゃー」しました！"){
                    $(num_span).html(new_count);
                  }
               }).fail(function(XMLHttpRequest, textStatus, errorThrown) {
                      $("#XMLHttpRequest").html("XMLHttpRequest : " + XMLHttpRequest.status);
                      $("#textStatus").html("textStatus : " + textStatus);
                      $("#errorThrown").html("errorThrown : " + errorThrown.message);
                  });
　　　　});
});