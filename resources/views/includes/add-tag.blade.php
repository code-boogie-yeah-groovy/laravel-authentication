









<div class="modal fade" id="addTagModal" role="dialog">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Add Tag</h4>
      </div>
      <div class="modal-body">
        <a href="#" id="1" class="addTag btn btn-secondary btn-lg btn-block" data-dismiss="modal">Dog</a>
        <a href="#" id="2" class="addTag btn btn-secondary btn-lg btn-block" data-dismiss="modal">Cat</a>
        <a href="#" id="3" class="addTag btn btn-secondary btn-lg btn-block" data-dismiss="modal">Bird</a>
        <a href="#" id="4" class="addTag btn btn-secondary btn-lg btn-block" data-dismiss="modal">Fish</a>
        <a href="#" id="5" class="addTag btn btn-secondary btn-lg btn-block" data-dismiss="modal">Exotic</a>
        <a href="#" id="7" class="addTag btn btn-secondary btn-lg btn-block" data-dismiss="modal">Trading</a>
        <a href="#" id="9" class="addTag btn btn-secondary btn-lg btn-block" data-dismiss="modal">Tutorial</a>
        <a href="#" id="8" class="addTag btn btn-secondary btn-lg btn-block" data-dismiss="modal">Help</a>
        <a href="#" id="6" class="addTag btn btn-secondary btn-lg btn-block" data-dismiss="modal">Others</a>
      </div>
      <div class="modal-footer">
        @if(Session::has('post_ts'))
          <p hidden>{{Session::get('post_ts')}}</p>
        @endif
      </div>
    </div>
  </div>
</div>
