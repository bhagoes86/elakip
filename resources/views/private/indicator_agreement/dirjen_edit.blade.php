{!! Form::model($goal, [
    'route' => ['pk.program.sasaran.indikator.update',
        $id['agreement'],
        $id['program'],
        $id['target'],
        $id['indicator'],
    ],
    'method' => 'PUT',
    'id' => 'form-'.$viewId.'-edit',
    'class' => 'app-form-edit',
    'data-table' => $viewId . '-datatables',
    'data-modal-id' => $viewId
    ]) !!}

<div class="alert-wrapper"></div>

<div class="form-group">
    <label for="count">Target</label>
    <div class="input-group">
        {!! Form::text('count', null, ['class'=>"form-control", 'placeholder'=>"Target", 'id'=>"count", 'aria-describedby'=>"basic-addon2"]) !!}
        <span class="input-group-addon" id="basic-addon2">{{$goal->indicator->unit}}</span>
    </div>
</div>



<button type="submit" class="btn btn-info btn-block btn-lg save">
    <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Update
</button>

{!! Form::close() !!}

<script>
    "use strict";

    updateForm();

</script>