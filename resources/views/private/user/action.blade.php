<div class="btn-group">
    <a class="btn btn-warning btn-xs" href="{{$edit_action}}">
        <i class="fa fa-pencil"></i>
    </a>
    <button class="btn btn-danger btn-xs" id="trash" onclick="{{$destroy_action}}" {{$destroy_data}}>
        <i class="fa fa-trash"></i>
    </button>
    <button class="btn btn-default btn-xs" id="pass" onclick="{{$pass_action}}" {{$pass_data}}>
        <i class="fa fa-key"></i>
    </button>
</div>