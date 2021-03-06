<div id="makeComments-{{ $task->id }}" class="modal modal-fixed-footer">
    <form action="{{ Asset($link.$task->id.'/add_comment') }}" method="post" autocomplete="off">
        <div class="modal-content">
            <h4 class="header2">Make Comments</h4>
            <b>{{ $task->task_desc }}</b>
            
            @csrf

            @if($task->status == 0)
            <div class="row">
                <div class="input-field col s12 l12">
                    <i class="mdi-content-create prefix"></i>
                    {!! Form::text('comment',null,['id' => 'comment','required' => 'required']) !!}
                    <label for="comment">Comment</label>
                </div>
            </div>
            @endif

            <div class="row">
                <div class="input-field col s12 l12">
                    <?php $comments_user = $task_comment->where('task_id',$task->id)->orderby('id','desc')->get(); ?>
                    @foreach($comments_user as $comment_user)
                    <span>
                        {{ $comment_user->comment }}
                        <br>
                        <small>{{ date('d-M-Y',strtotime($comment_user->created_at)) }}</small>
                        <br><br>
                    </span>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <a href="javascript:void(0);" class="waves-effect waves-red btn-flat modal-action modal-close">Close</a>
            @if($task->status == 0)
            <button type="submit" class="btn blue modal-action modal-close">Submit</button>
            @endif
        </div>
    </form>
</div>