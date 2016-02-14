
<div class="row mbot-15">
    <div class="col-md-12">
        <b><u>Indikator</u></b> <br>
        <b>{{$indicator->name}}</b>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-condensed table-striped table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Deskripsi</th>
                <th>Rencana aksi</th>
                <th>Pagu</th>
                <th>Realisasi</th>
                <th>Persentase</th>
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
            <td>{{$detail->action_plan}}</td>
            <td>{{money_format('%.2n', $detail->dipa)}}</td>
            <td>{{isset($detail->achievementValues[0]) ? money_format('%.2n', $detail->achievementValues[0]->budget_real) : money_format('%.2n', 0)}}</td>
            <td>
                @if(isset($detail->achievementValues[0]))
                    {{ round($detail->achievementValues[0]->budget_real / $detail->dipa * 100, 2)}}&percnt;
                @else
                    0&percnt;
                @endif
            </td>
        </tr>
            <?php $i++; ?>
        @endforeach
        </tbody>
    </table>
</div>