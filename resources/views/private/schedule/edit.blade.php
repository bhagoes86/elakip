{!! Form::model($schedule, [
    'route' => ['schedule.update',
        $schedule->id
    ],
    'method' => 'PUT',
    'id' => 'form-'.$viewId.'-edit',
    'class' => 'app-form-edit',
    'data-table' => $viewId . '-datatables',
    'data-modal-id' => $viewId
    ]) !!}

<div class="alert-wrapper"></div>

<div class="form-group">
    <label for="task">Kegiatan</label>
    {!! Form::text('task', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    <label for="date">Tanggal</label>
    {!! Form::text('date', null, ['class' => 'form-control']) !!}
</div>


<button type="submit" class="btn btn-info btn-block btn-lg save">
    <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Update
</button>

{!! Form::close() !!}

<script>
    "use strict";

    updateForm();

</script>