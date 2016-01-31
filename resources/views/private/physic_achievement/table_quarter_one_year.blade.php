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
            <table class="table table-condensed table-bordered table-hover">
                <thead>
                <tr>
                    <th rowspan="2">Indikator</th>
                    <th rowspan="2">Target</th>
                    <th colspan="3" class="text-center">TW I</th>
                    <th colspan="3" class="text-center">TW II</th>
                    <th colspan="3" class="text-center">TW III</th>
                    <th colspan="2" class="text-center danger">TW IV</th>
                    <th rowspan="2" class="danger">Capaian Kinerja</th>
                </tr>
                <tr>
                    <th>RN</th>
                    <th>RL</th>
                    <th>%&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>

                    <th>RN</th>
                    <th>RL</th>
                    <th>%&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>

                    <th>RN</th>
                    <th>RL</th>
                    <th>%&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>

                    <th class="danger">RN</th>
                    <th class="danger">RL</th>
                </tr>
                </thead>

                <tbody>
                    @foreach($indicators as $indicator => $attribute )
                    <tr>
                        <td>
                            {{--<a href="{{url('capaian/fisik/goal/'.$attribute['goal_id'].'/achievement')}}" target="_blank">{{$indicator}}</a>--}}
                            {{$indicator}}
                        </td>
                        <td>{{$attribute['target']}} {{$attribute['satuan']}}</td>

                        <td>{{$attribute['quarter'][1]['target']}}</td>
                        <td>{{$attribute['quarter'][1]['capaian']}}</td>
                        <td>{{round($attribute['quarter'][1]['prosentase'], 2)}} %</td>

                        <td>{{$attribute['quarter'][2]['target']}}</td>
                        <td>{{$attribute['quarter'][2]['capaian']}}</td>
                        <td>{{round($attribute['quarter'][2]['prosentase'], 2)}} %</td>

                        <td>{{$attribute['quarter'][3]['target']}}</td>
                        <td>{{$attribute['quarter'][3]['capaian']}}</td>
                        <td>{{round($attribute['quarter'][3]['prosentase'], 2)}} %</td>

                        <td class="danger">{{$attribute['quarter'][4]['target']}}</td>
                        <td class="danger">{{$attribute['quarter'][4]['capaian']}}</td>
                        <td class="danger">{{round($attribute['quarter'][4]['prosentase'], 2)}} %</td>
                    </tr>
                    @endforeach

                </tbody>

            </table>
        </div>
    </div>
</div>