
<div class="row mbot-15">
    <div class="col-md-12">
        <b><u>Indikator</u></b> <br>
        <b>{{$indicator->name}}</b>
    </div>
</div>



<table class="table table-condensed table-striped table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Deskripsi</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $i = 1;
    ?>
    @foreach($details as $detail)
    <tr>
        <td>{{$i}}</td>
        <td>{{$detail->description}}</td>
    </tr>
        <?php $i++; ?>
    @endforeach
    </tbody>
</table>