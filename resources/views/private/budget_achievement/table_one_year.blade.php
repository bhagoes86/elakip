<div class="row mbot-15">
    <div class="col-md-12">
        <table class="table">
          {{--  <tr>
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
            </tr>--}}
        </table>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <table class="table table-condensed table-bordered">
            <thead>
            <tr>
                <th>Kegiatan</th>
                <th>Anggaran</th>
                <th>Realisasi</th>
                <th>&percnt;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            @foreach($activities as $key => $val)
                <tr>
                    <td>{{$key}}</td>
                    <td>{{money_format('%.2n', $val['pagu'])}}</td>
                    <td>{{money_format('%.2n', $val['real'])}}</td>
                    <td>@if($val['pagu'] == 0)
                            -
                        @else
                            {{round($val['real'] / $val['pagu'] * 100, 2)}} %
                        @endif

                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>