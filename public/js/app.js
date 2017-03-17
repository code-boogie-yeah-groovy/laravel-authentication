$(document).ready( function() {
    var postId =0;
    var postBodyElement = null;

    $('.post').find('.edit-post').on('click', function(event) {
      event.preventDefault();

      postBodyElement = event.target.parentNode.parentNode.childNodes[5]
      var postBody = postBodyElement.textContent;
      postId = event.target.parentNode.parentNode.dataset['postid'];
      $('#post-body').val($.trim(postBody));
      $('#edit-modal').modal();
    });

    $('#modal-save').on('click', function(){
      $.ajax({
        method: 'POST',
        url: urlEdit,
        data: { body:$('#post-body').val(), postId: postId, _token: token }
      })
      .done(function(msg){
        $(postBodyElement).text(msg['new_body']);
        $('#edit-modal').modal('hide');
      });
    });

    $('.vote').on('click', function(event){
      event.preventDefault();
      var isVote = event.target.previousElementSibling == null;
      postId = event.target.parentNode.parentNode.dataset['postid'];
      $.ajax({
        method: 'POST',
        url: urlVote,
        data: {isVote: isVote, postId: postId, _token: token}
      })
      .done(function(){
        event.target.innerText = isVote ? event.target.innerText == 'Upvote' ? 'You upvoted this post' : 'Upvote' : event.target.innerText == 'Downvote' ? 'You downvoted this post' : 'Downvote';
        if (isVote) {
            event.target.nextElementSibling.innerText = 'Downvote';
        } else {
            event.target.previousElementSibling.innerText = 'Upvote';
        }
      });
    });


    function readURL(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#avatar_preview').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
      }
    }

    $("#input_avatar").change(function(){
      if(this.files[0].type.indexOf("image")==-1){
            alert("Invalid File Type");
            return false;
        } else if (this.files[0].size>528385) {
            alert("Image Size should not be greater than 500Kb");
            return false;
        } else {
            readURL(this);
        }
    });

    $('.delete-post').on('click', function(){
      return confirm('delete?');
    });

    $('.comment').on('click', function() {
      var $target = $($(this).attr('data-toggle'));
      $target.toggle();
    });

    $('.post').find('.post-comment').on('click', function(event){
      postId = event.target.parentNode.parentNode.dataset['postid'];
      commentBody = $('#comment_body' . postId).val();
      $.ajax({
        method: 'POST',
        url: urlComment,
        data: {postId: postId, commentBody: commentBody, _token: token},
        success: function(data) { alert("succsess") },
        error: function(ts) { window.open(ts.responseText) }
      });
    });

});
