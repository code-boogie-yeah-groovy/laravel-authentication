<div class="modal-dialog">

  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4 class="modal-title">Post something.</h4>
    </div>
    <div class="modal-body">
      <section class="row new-post">
        <div class="col-md-6 col-md-offset-3">
          <header><h3>What do you want to say?</h3></header>
          <form class="" action="{{ route('post.create') }}" method="post" enctype="multipart/form-data">
            <div class="form-group">
              <textarea class="form-control" name="body" id="new-post" rows="5" placeholder="Your post" style="resize:none;"></textarea>
            </div>
            <div class="form-group">
              <span class="btn btn-default btn-file">
                Add Photo/Video<input type="file" name="media" accept="image/*, video/mp4,video/x-m4v,video/*" class="input_image form-control">
              </span>
            </div>
            <div class="form-group">
              <div>
                <img src="" alt="" class="image_preview big-avatar center-block img-responsive" id="media_preview">
              </div>
            </div>
            <input type="hidden" value="{{ Session::token() }}" name="_token">
        </div>
      </section>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      <button type="submit" class="btn btn-primary">&nbsp;&nbsp; Post &nbsp;&nbsp;</button>
    </div>
  </div>
</div>

<script type="text/javascript">

</script>
