<div class="row">
    <div class="col-md-12">
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <table class="table table-condensed table-bordered">
            <thead>
                <tr>
                    <th>Indikator</th>
                    <th>Target</th>
                    <th>Capaian</th>
                    <th>Prosentase</th>
                </tr>
            </thead>
            <tbody>
                @foreach($indicators as $key => $val)
                <tr>
                    <td>{{$key}}</td>
                    <td>{{$val['pagu']}}</td>
                    <td>{{$val['real']}}</td>
                    <td>{{round($val['real'] / $val['pagu'] * 100, 2)}} %</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>