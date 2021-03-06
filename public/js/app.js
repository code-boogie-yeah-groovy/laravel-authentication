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

    $('.post').find('.delete-post').on('click', function(event) {
      event.preventDefault();
      postId = event.target.parentNode.parentNode.dataset['postid'];
    });

    $('#modal-delete').on('click', function(){
      $.ajax({
        method: 'POST',
        url: urlDelete,
        data: { postId: postId, _token: token }
      })
      .done(function(msg){
        setTimeout(function(){
           location.reload();
         }, 1000);
        $('#deleteModal').modal('hide');
      });
    });

    $('.vote').on('click', function(event){
      event.preventDefault();
      var isVote = event.target.previousElementSibling == null;
      postId = event.target.parentNode.parentNode.dataset['postid'];
      pointId = event.target.parentNode.previousElementSibling.childNodes[1];
      pointVal = parseInt(pointId.innerText);
      buttonVal = event.target.innerText;
      url = window.location.href;
      $.ajax({
        method: 'POST',
        url: urlVote,
        data: {isVote: isVote, postId: postId, _token: token}
      })
      .done(function(){
        if(isVote) {
          if(buttonVal == 'Upvote') {
            event.target.innerText = 'You upvoted this post'
            if(event.target.nextElementSibling.innerText == 'Downvote') {
              pointId.innerText = pointVal + 1;
            } else {
              pointId.innerText = pointVal + 2;
            }
          } else {
            event.target.innerText = 'Upvote'
            pointId.innerText = pointVal - 1;
          }
        } else {
          if(buttonVal == 'Downvote') {
            event.target.innerText = 'You downvoted this post'
            if(event.target.previousElementSibling.innerText == 'Upvote') {
              pointId.innerText = pointVal - 1;
            } else {
              pointId.innerText = pointVal - 2;
            }
          } else {
            event.target.innerText = 'Downvote'
            pointId.innerText = pointVal + 1;
          }
        }

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

    $('.comment').on('click', function() {
      var $target = $($(this).attr('data-toggle'));
      $target.toggle();
    });

    $('.post').find('.post-comment').on('click', function(event){
      event.preventDefault();
      postId = event.target.parentNode.parentNode.parentNode.dataset['postid'];
      commentBody = $('#comment_body' + postId).val();
      $.ajax({
        method: 'GET',
        url: urlComment,
        data: {postId: postId, commentBody: commentBody, _token: token},
        success: function() {
          $('<div>Comment posted!</div>').insertBefore('#comment_body' + postId).delay(3000).fadeOut();
          location.reload();
          $('input[type=text]').val('');
        },
        error: function() { alert('There was an error. Comment not posted.') }
      });
    });

    $('.addTag').on('click', function(event){
      event.preventDefault();
      var tagId = event.target.id;
      $.ajax({
        method: 'POST',
        url: urlAddTag,
        data: { tagId: tagId, postTs: postTs, _token: token }
      })
      .done(function(msg){
        setTimeout(function(){
           location.reload();
         }, 1);
        $('#addTagModal').modal('hide');
      });
    });

});
