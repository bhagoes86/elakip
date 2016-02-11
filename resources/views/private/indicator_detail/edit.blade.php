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
    {!! Form::text('description', null, ['class' => 'form-control', 'placeholder' => 'Deskripsi']) !!}
</div>

<div class="form-group">
    <label for="rencana-aksi">Rencana aksi</label>
    {!! Form::textarea('action_plan', null, ['class' => 'form-control', 'placeholder' => 'Rencana aksi']) !!}
</div>

<div class="form-group">
    <label for="dipa">Pagu</label>
    {!! Form::text('dipa', null, ['class' => 'form-control', 'placeholder' => 'Pagu', 'id' => 'dipa']) !!}
</div>

<button type="submit" class="btn btn-info btn-block btn-lg save">
    <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Update
</button>

{!! Form::close() !!}

<script>
    "use strict";

    updateForm();

</script>