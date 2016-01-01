{!! Form::open([
    'route' => ['user.password.update', $user->id],
    'method' => 'PUT',
    'id' => 'form-'.$viewId.'-edit',
    'class' => 'app-form-edit',
    'data-table' => $viewId . '-datatables',
    'data-modal-id' => $viewId
    ]) !!}

<div class="alert-wrapper"></div>

<div class="form-group">
    <label for="password">Password</label>
    {!! Form::password('password', ['id' => 'password', 'placeholder' => 'Password', 'class' => 'form-control']) !!}
</div>

<div class="form-group">
    <label for="password2">Confirm password</label>
    {!! Form::password('password2', ['id' => 'password2', 'placeholder' => 'Confirm assword', 'class' => 'form-control']) !!}
</div>

<button type="submit" class="btn btn-info btn-block btn-lg save">
    <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Update
</button>

{!! Form::close() !!}

<script>
    "use strict";

    updateForm();
</script>