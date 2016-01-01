{!! Form::model($target, [
    'route' => ['renstra.program.sasaran.update',
        $id['plan'],
        $id['program'],
        $id['target']
    ],
    'method'    => 'PUT',
    'id'        => 'form-'.$viewId.'-edit',
    'class'     => 'app-form-edit',
    'data-table' => $viewId . '-sasaran-datatables',
    'data-modal-id' => $viewId
]) !!}

<div class="alert-wrapper"></div>

<div class="form-group">
    <label for="name">Nama sasaran</label>
    {!! Form::textarea('name', null, ['class'=>"form-control autosize", 'rows' => null, 'placeholder'=>"Nama sasaran", 'id'=>"name"]) !!}
</div>

<button type="submit" class="btn btn-info btn-block btn-lg save">
    <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Update
</button>

{!! Form::close() !!}

<script>
    "use strict";

    updateForm();
    autosize($('textarea'));

</script>