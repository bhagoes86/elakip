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
        <div class="table-responsive">
            <table class="table table-condensed table-bordered table-striped table-hover">
                <thead>
                <tr>
                    <th rowspan="2">Indikator</th>
                    <th rowspan="2">Target</th>
                    <th colspan="3" class="text-center">I</th>
                    <th colspan="3" class="text-center">II</th>
                    <th colspan="3" class="text-center">III</th>
                    <th colspan="2" class="text-center">IV</th>
                    <th rowspan="2">Capian Kinerja</th>
                </tr>
                <tr>
                    <th>Target</th>
                    <th>Capaian</th>
                    <th>Kinerja</th>

                    <th>Target</th>
                    <th>Capaian</th>
                    <th>Kinerja</th>

                    <th>Target</th>
                    <th>Capaian</th>
                    <th>Kinerja</th>

                    <th>Target</th>
                    <th>Capaian</th>
                </tr>
                </thead>

                <tbody>
                    @foreach($indicators as $indicator => $attribute )
                    <tr>
                        <td>{{$indicator}}</td>
                        <td>{{$attribute['target']}} {{$attribute['satuan']}}</td>

                        <td>{{$attribute['quarter'][1]['target']}}</td>
                        <td>{{$attribute['quarter'][1]['capaian']}}</td>
                        <td>{{$attribute['quarter'][1]['prosentase']}} %</td>

                        <td>{{$attribute['quarter'][2]['target']}}</td>
                        <td>{{$attribute['quarter'][2]['capaian']}}</td>
                        <td>{{$attribute['quarter'][2]['prosentase']}} %</td>

                        <td>{{$attribute['quarter'][3]['target']}}</td>
                        <td>{{$attribute['quarter'][3]['capaian']}}</td>
                        <td>{{$attribute['quarter'][3]['prosentase']}} %</td>

                        <td>{{$attribute['quarter'][4]['target']}}</td>
                        <td>{{$attribute['quarter'][4]['capaian']}}</td>
                        <td>{{$attribute['quarter'][4]['prosentase']}} %</td>
                    </tr>
                    @endforeach

                </tbody>

            </table>
        </div>
    </div>
</div>