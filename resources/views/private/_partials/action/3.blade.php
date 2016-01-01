<div class="btn-group">

    <button class="btn btn-warning btn-xs" onclick="{{$edit_action}}" {{$edit_data}}>
        <i class="fa fa-pencil"></i>
    </button>
    <button class="btn btn-danger btn-xs" id="trash" onclick="{{$destroy_action}}" {{$destroy_data}}>
        <i class="fa fa-trash"></i>
    </button>
    <a href="{{$show_action}}" class="btn btn-xs btn-primary">
        <i class="fa fa-eye"></i>
    </a>
</div>