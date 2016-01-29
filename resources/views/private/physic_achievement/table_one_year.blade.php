<div class="row mbot-15">
    <div class="col-md-12">
        <table class="table">
            <tr>
                <th>Unit organisasi</th>
                <td>{{$activity->unit->name}}</td>
            </tr>
            <tr>
                <th>Program</th>
                <td>{{$activity->program->name}}</td>
            </tr>
            <tr>
                <th>Kegiatan</th>
                <td>{{$activity->name}}</td>
            </tr>
            <tr>
                <th>Sasaran</th>
                <td>{{$target->name}}</td>
            </tr>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <table class="table table-condensed table-bordered">
            <thead>
                <tr>
                    <th>Indikator</th>
                    <th>Target</th>
                    <th>Realisasi</th>
                    <th>%&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                @foreach($indicators as $key => $val)
                <tr>
                    <td>{{$key}}</td>
                    <td>{{$val['pagu']}}</td>
                    <td>{{$val['real']}}</td>
                    <td>{{round($val['percentation'], 2)}} &percnt;</td>
                    {{--<td>{{round($val['real'] / $val['pagu'] * 100, 2)}} %</td>--}}
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>