{!! Form::model($program, [
    'route' => ['renstra.program.update',
        $program->plan->id,
        $program->id
    ],
    'method'    => 'PUT',
    'id'        => 'form-'.$viewId.'-edit',
    'class'     => 'app-form-edit',
    'data-table' => $viewId . '-datatables',
    'data-modal-id' => $viewId
]) !!}

<div class="alert-wrapper"></div>

<div class="form-group">
    <label for="name">Progam name</label>
    {!! Form::text('name', null, ['class'=>"form-control", 'placeholder'=>"Progam name", 'id'=>"name"]) !!}
</div>

<button type="submit" class="btn btn-info btn-block btn-lg save">
    <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Update
</button>

{!! Form::close() !!}

<script>
    "use strict";

    updateForm();
</script>