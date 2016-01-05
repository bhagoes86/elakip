{!! Form::model($position, [
    'route' => ['position.update',
        $position->id
    ],
    'method' => 'PUT',
    'id' => 'form-'.$viewId.'-edit',
    'class' => 'app-form-edit',
    'data-table' => $viewId . '-datatables',
    'data-modal-id' => $viewId
    ]) !!}

<div class="alert-wrapper"></div>

<div class="form-group">
    <label for="year" >Year</label>
    {!! Form::select('year', $years, null, ['id' => 'year', 'class' => 'form-control']) !!}
</div>

<div class="form-group">
    <label for="user" >Name</label>
    {!! Form::select('user_id', $users, null, ['id' => 'user', 'class' => 'form-control']) !!}

</div>

<div class="form-group">
    <label for="unit" >Unit</label>
    {!! Form::select('unit_id', $units, null, ['id' => 'unit', 'class' => 'form-control']) !!}
</div>

<div class="form-group">
    <label for="position" >Posisi</label>
    {!! Form::text('position', null, ['id' => 'position', 'class' => 'form-control']) !!}
</div>

<button type="submit" class="btn btn-info btn-block btn-lg save">
    <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Update
</button>

{!! Form::close() !!}

<script>
    "use strict";

    updateForm();

</script>