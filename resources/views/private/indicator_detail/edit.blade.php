{!! Form::model($detail, [
    'route' => ['pk.program.kegiatan.sasaran.indikator.detail.update',
        $id['agreement'],
        $id['program'],
        $id['activity'],
        $id['target'],
        $id['indicator'],
        $id['detail']

    ],
    'method' => 'PUT',
    'id' => 'form-'.$viewId.'-edit',
    'class' => 'app-form-edit',
    'data-table' => $viewId . '-datatables',
    'data-modal-id' => $viewId
    ]) !!}

<div class="alert-wrapper"></div>

<div class="form-group">
    <label for="description">Deskripsi</label>
    {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
</div>

<button type="submit" class="btn btn-info btn-block btn-lg save">
    <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Update
</button>

{!! Form::close() !!}

<script>
    "use strict";

    updateForm();

</script>