<div class="btn-group">

    @if(!Gate::check('read-only'))
    <a class="btn btn-warning btn-xs" href="{{$edit_action}}">
        <i class="fa fa-pencil"></i>
    </a>
    <button class="btn btn-danger btn-xs" id="trash" onclick="{{$destroy_action}}" {{$destroy_data}}>
        <i class="fa fa-trash"></i>
    </button>
    @endif

    <a href="{{$show_action}}" class="btn btn-xs btn-primary">
        <i class="fa fa-eye"></i>
    </a>
</div>

{{--
<div class="btn-group">
    <button class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="bottom" title="Export to Excel">
        <i class="fa fa-file-excel-o"></i>
    </button>
</div>--}}
