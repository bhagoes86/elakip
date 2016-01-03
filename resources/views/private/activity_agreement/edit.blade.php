@if(!Gate::check('read-only'))

    {!! Form::model($activity, [
    'route' => ['pk.program.kegiatan.update',
        $id['agreement'],
        $id['program'],
        $id['activity'],
    ],
    'method' => 'PUT',
    'id' => 'form-'.$viewId.'-edit',
    'class' => 'app-form-edit',
    'data-table' => $viewId . '-datatables',
    'data-modal-id' => $viewId
    ]) !!}

    <div class="alert-wrapper"></div>

    <div class="form-group">
        <label for="pagu">Pagu</label>
        {!! Form::text('pagu', $activity->budget->pagu, ['class'=>"form-control", 'placeholder'=>"Pagu", 'id'=>"pagu"]) !!}

    </div>

    <button type="submit" class="btn btn-info btn-block btn-lg save">
        <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Update
    </button>

    {!! Form::close() !!}

    <script>
        "use strict";

        updateForm();

    </script>
@endif