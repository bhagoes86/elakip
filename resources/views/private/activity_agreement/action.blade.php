@if(!Gate::check('read-only'))
<div class="btn-group" xmlns="http://www.w3.org/1999/html">
    <button class="btn btn-warning btn-xs" onclick="{{$edit_action}}" {{$edit_data}}>
        <i class="fa fa-pencil"></i>
    </button>
</div>
@endif