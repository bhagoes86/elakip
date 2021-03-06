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
                    <th rowspan="2">Pagu</th>
                    <th colspan="2" class="text-center">Realisasi</th>
                    <th colspan="2" class="text-center">TW I</th>
                    <th colspan="2" class="text-center">TW II</th>
                    <th colspan="2" class="text-center">TW III</th>
                    <th colspan="2" class="text-center">TW IV</th>
                </tr>
                <tr>
                    <th>(Rp.)</th>
                    <th>(&percnt;)</th>

                    <th>RN</th>
                    <th>RL</th>

                    <th>RN</th>
                    <th>RL</th>

                    <th>RN</th>
                    <th>RL</th>

                    <th>RN</th>
                    <th>RL</th>
                </tr>
                </thead>

                <tbody>
                @foreach($indicators as $indicator => $attribute )
                    <tr>
                        <td>{{$indicator}}</td>
                        <td>{{money_format('%.2n', $attribute['total_dipa'])}}</td>

                        <td>{{money_format('%.2n',$attribute['realization']['money'])}}</td>
                        <td>{{$attribute['realization']['percent']}}%</td>

                        <td>{{$attribute['quarter'][1]['target']}}%</td>
                        <td>{{$attribute['quarter'][1]['capaian']}}%</td>

                        <td>{{$attribute['quarter'][2]['target']}}%</td>
                        <td>{{$attribute['quarter'][2]['capaian']}}%</td>

                        <td>{{$attribute['quarter'][3]['target']}}%</td>
                        <td>{{$attribute['quarter'][3]['capaian']}}%</td>

                        <td>{{$attribute['quarter'][4]['target']}}%</td>
                        <td>{{$attribute['quarter'][4]['capaian']}}%</td>
                    </tr>
                @endforeach

                </tbody>

            </table>
        </div>
    </div>
</div>