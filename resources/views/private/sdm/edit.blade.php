{!! Form::model($staff, [
    'route' => ['sdm.update',
        $staff->id
    ],
    'method' => 'PUT',
    'id' => 'form-'.$viewId.'-edit',
    'class' => 'app-form-edit',
    'data-table' => $viewId . '-datatables',
    'data-modal-id' => $viewId
    ]) !!}

<div class="alert-wrapper"></div>

<div class="form-group">
    <label for="name">Nama</label>
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    <label for="organization_id">Organization</label>
    {!! Form::select('organization_id', $organizations, null, ['class' => 'form-control', 'id' => 'organization_id', 'placeholder' => '- organisasi -']) !!}
</div>

<div class="form-group">
    <label for="position">Posisi</label>
    {!! Form::text('position', null, ['class' => 'form-control']) !!}

</div>

<div class="form-group">
    <label class="radio-inline">
        {!! Form::radio('status', 'pns', null) !!} PNS
    </label>
    <label class="radio-inline">
        {!! Form::radio('status', 'non-pns', null) !!} Non PNS
    </label>
</div>

<button type="submit" class="btn btn-info btn-block btn-lg save">
    <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Update
</button>

{!! Form::close() !!}

<script>
    "use strict";

    updateForm();

</script>