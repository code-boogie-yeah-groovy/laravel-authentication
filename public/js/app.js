$(document).ready( function() {
    var postId =0;
    var postBodyElement = null;

    $('.post').find('.edit-post').on('click', function(event) {
      event.preventDefault();

      postBodyElement = event.target.parentNode.parentNode.childNodes[1]
      var postBody = postBodyElement.textContent;
      postId = event.target.parentNode.parentNode.dataset['postid'];
      $('#post-body').val(postBody);
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
});
