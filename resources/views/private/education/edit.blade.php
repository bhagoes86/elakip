{!! Form::model($education, [
    'route' => ['sdm.education.update',
        $id['staff'],
        $education->id
    ],
    'method'    => 'PUT',
    'id'        => 'form-'.$viewId.'-edit',
    'class'     => 'app-form-edit',
    'data-table' => $viewId . '-datatables',
    'data-modal-id' => $viewId
    ]) !!}

<div class="alert-wrapper"></div>

<div class="form-group">
    <label for="level">Jenjang</label>
    {!! Form::select('level', $levels, null, ['class' => 'form-control', 'placeholder' => '- Pilih Satu -']) !!}
</div>

<div class="form-group">
    <label for="institution">Institusi</label>
    {!! Form::text('institution', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    <label for="major">Jurusan</label>
    {!! Form::text('major', null, ['class' => 'form-control']) !!}
</div>

<button type="submit" class="btn btn-info btn-block btn-lg save">
    <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Update
</button>

{!! Form::close() !!}

<script>
    "use strict";

    updateForm();

</script>