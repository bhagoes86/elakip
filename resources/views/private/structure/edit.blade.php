{!! Form::model($organization, [
    'route' => ['structure.update',
        $organization->id
    ],
    'method' => 'PUT',
    'id' => 'form-'.$viewId.'-edit',
    'class' => 'app-form-edit',
    'data-table' => $viewId . '-datatables',
    'data-modal-id' => $viewId
    ]) !!}

<div class="alert-wrapper"></div>

<div class="form-group">
    <label for="parent_id">Parent</label>
    {!! Form::select('parent_id', $organizations, null, ['class' => 'form-control', 'id' => 'parent_id', 'placeholder' => '-none-']) !!}
</div>
<div class="form-group">
    <label for="name">Nama</label>
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<button type="submit" class="btn btn-info btn-block btn-lg save">
    <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Update
</button>

{!! Form::close() !!}

<script>
    "use strict";

    updateForm();

</script>