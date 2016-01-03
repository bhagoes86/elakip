@if(!Gate::check('read-only'))

    <div class="btn-group" xmlns="http://www.w3.org/1999/html">

        <button class="btn btn-danger btn-xs" id="trash" onclick="{{$destroy_action}}" {{$destroy_data}}>
            <i class="fa fa-trash"></i>
        </button>
    </div>
@endif