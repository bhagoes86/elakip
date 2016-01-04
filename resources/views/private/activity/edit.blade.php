@if(!Gate::check('read-only'))

    {!! Form::model($activity, [
    'route' => ['renstra.program.kegiatan.update',
        $id['plan'],
        $id['program'],
        $id['activity'],
    ],
    'method' => 'PUT',
    'id' => 'form-'.$viewId.'-edit',
    'class' => 'app-form-edit',
    'data-table' => $viewId . '-kegiatan-datatables',
    'data-modal-id' => $viewId
    ]) !!}

    <div class="alert-wrapper"></div>

    @can('choose-unit', null)
    <div class="form-group">
        <label for="name">Unit</label>
        {!! Form::select('unit_id', $units, null, ['class' => 'form-control', 'placeholder' => '[ Pilih Unit ]']) !!}
    </div>
    @else
    <input type="hidden" name="unit_id" value="{{$authUser->positions[0]->unit->id}}"/>
    @endcan

    <div class="form-group">
        <label for="name">Nama kegiatan</label>
        {!! Form::textarea('name', null, ['rows' => null, 'class' => 'form-control autosize','placeholder'=> 'Nama kegiatan','id'=> 'name']) !!}
    </div>

    <div class="checkbox">
        <label>
            {!! Form::checkbox('in_agreement', 1, null) !!} Perjanjian Kinerja
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
@endif