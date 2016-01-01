{!! Form::model($indicator, [
    'route' => ['renstra.program.kegiatan.sasaran.indikator.update',
        $id['plan'],
        $id['program'],
        $id['activity'],
        $id['target'],
        $id['indicator']
    ],
    'method'    => 'PUT',
    'id'        => 'form-'.$viewId.'-edit',
    'class'     => 'app-form-edit',
    'data-table' => $viewId . '-datatables',
    'data-modal-id' => $viewId
]) !!}

<div class="alert-wrapper"></div>

<div class="form-group">
    <label for="name">Nama sasaran</label>
    {!! Form::textarea('name', null, ['class'=>"form-control autosize", "rows" => null, 'placeholder'=>"Nama sasaran", 'id'=>"name"]) !!}
</div>

<div class="form-group">
    <label for="name">Satuan</label>
    {!! Form::text('unit', null, ['class'=>"form-control ", 'placeholder'=>"Satuan", 'id'=>"unit"]) !!}
</div>

<div class="form-group">
    <label for="name">Location</label>
    {!! Form::text('location', null, ['class'=>"form-control ", 'placeholder'=>"Location", 'id'=>"location"]) !!}
</div>

<button type="submit" class="btn btn-info btn-block btn-lg save">
    <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Update
</button>

{!! Form::close() !!}

<script>
    "use strict";

    updateForm();
    autosize($('textarea'));

</script>