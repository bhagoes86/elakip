{!! Form::model($indicator, [
    'route' => ['renstra.program.sasaran.indikator.update',
        $id['plan'],
        $id['program'],
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
    <label for="name">Indikator</label>
    {!! Form::textarea('name', null, ['class'=>"form-control autosize", 'rows' => null, 'placeholder'=>"Nama sasaran", 'id'=>"name"]) !!}
</div>


<div class="form-group">
    <label for="name">Satuan</label>
    {!! Form::text('unit', null, ['id' => 'unit', 'placeholder' => 'Unit', 'class' => 'form-control']) !!}
</div>

<div class="form-group">
    <label for="name">Lokasi</label>
    {!! Form::text('location', null, ['id' => 'location', 'placeholder' => 'Lokasi', 'class' => 'form-control']) !!}
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