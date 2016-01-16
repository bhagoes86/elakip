<div class="btn-group">

    @if(!Gate::check('read-only'))
    <a class="btn btn-warning btn-xs" href="{{$edit_action}}" title="Edit">
        <i class="fa fa-pencil"></i>
    </a>
    <button class="btn btn-danger btn-xs" id="trash" onclick="{{$destroy_action}}" {{$destroy_data}} title="Hapus">
        <i class="fa fa-trash"></i>
    </button>
    @endif

    <a href="{{$show_action}}" class="btn btn-xs btn-primary" title="Lihat detail">
        <i class="fa fa-eye"></i>
    </a>

    <a href="{{$export_action}}" class="btn btn-xs btn-success" title="Export ke excel">
        <i class="fa fa-file-excel-o"></i>
    </a>

    <a href="{{$pdf_action}}" class="btn btn-xs btn-danger" title="Download pdf">
        <i class="fa fa-file-pdf-o"></i>
    </a>

</div>

{{--
<div class="btn-group">
    <button class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="bottom" title="Export to Excel">
        <i class="fa fa-file-excel-o"></i>
    </button>
</div>--}}
