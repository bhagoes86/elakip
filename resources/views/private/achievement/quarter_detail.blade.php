<div class="col-md-3">
    <div class="panel rounded shadow">

        <div class="panel-heading">
            <div class="pull-left">
                <button class="btn btn-primary btn-documents"
                        data-tw="{{$id}}"
                        data-achievement-id="{{$achievements[$key]['id']}}">{{$panel_title}}</button>
                {{--<h3 class="panel-title">{{$panel_title}}</h3>--}}
            </div>
            <div class="clearfix"></div>
        </div>

        <div class="panel-body">

            @can('read-only')

            <div class="form-group">
                <label for="{{$id}}-rl">Realisasi</label>
                <div class="form-control" id="{{$id}}-rl">{{$achievements[$key]['realization']}}</div>

            </div>

            <div class="form-group">
                <label for="{{$id}}-rl">Persentase</label>
                <div class="input-group">
                    <div class="form-control" id="{{$id}}-rl">{{$achievements[$key]['percentation']}}</div>
                    <span class="input-group-addon">&percnt;</span>
                </div>
            </div>
            <hr/>

            <div class="form-group">
                <label for="budget-{{$id}}-rn">DIPA (Rp)</label>
                <div class="form-control" id="budget-{{$id}}-rn">{{$achievements[$key]['budget_plan']}}</div>
            </div>
            <div class="form-group">
                <label for="budget-{{$id}}-rl">Realisasi Total (Rp)</label>
                <div class="form-control" id="budget-{{$id}}-rl">{{$achievements[$key]['budget_realization']}}</div>

            </div>

            @else

                {{--{!! Form::open(['route' => ['capaian.fisik.goal.achievement.store', $goal->id], 'id' => 'form-' . $id, 'class' => 'achievement-form']) !!}

                <input type="hidden" name="id" value="{{$achievements[$key]['id']}}"/>
                <input type="hidden" name="quarter" value="{{$achievements[$key]['quarter']}}"/>

                <div class="alert-wrapper"></div>--}}
                <div class="form-group">
                    <label for="{{$id}}-rl">Rencana</label>
                    {{--<input type="number" name="realization" id="{{$id}}-rl" placeholder="Realisasi" class="form-control" value="{{$achievements[$key]['realization']}}"/>--}}
                    <p class="form-control-static">{{$achievements[$key]['plan']}}%</p>
                </div>

                <div class="form-group">
                    <label for="{{$id}}-rl">Realisasi</label>
                    {{--<input type="number" name="realization" id="{{$id}}-rl" placeholder="Realisasi" class="form-control" value="{{$achievements[$key]['realization']}}"/>--}}
                    <p class="form-control-static">{{$achievements[$key]['realization']}}%</p>
                </div>
                {{--<div class="form-group">
                    <label for="{{$id}}-rl">Persentase</label>
                    <div class="input-group">
                        <input type="text" name="percentation" id="{{$id}}-rl" placeholder="Persentase" class="form-control" value="{{$achievements[$key]['percentation']}}"/>

                        <span class="input-group-addon">&percnt;</span>
                    </div>
                </div>--}}

                <hr/>

                <div class="form-group">
                    <label for="budget-{{$id}}-rn">DIPA (Rp)</label>
                    <p class="form-control-static">Rp.{{$achievements[$key]['budget_plan']}}</p>

                    {{--<div class="input-group">--}}
                        {{--<span class="input-group-addon">Rp.</span>--}}
                        {{--<input type="text" name="budget_plan" id="budget-{{$id}}-rn" placeholder="Rencana" class="form-control" value="{{$achievements[$key]['budget_plan']}}"/>--}}
                    {{--</div>--}}
                </div>
                <div class="form-group">
                    <label for="budget-{{$id}}-rl">Realisasi Total (Rp)</label>
                    <p class="form-control-static">Rp.{{$achievements[$key]['budget_realization']}}</p>

                   {{-- <div class="input-group">
                        <span class="input-group-addon">Rp.</span>
                        <input type="text" name="budget_realization" id="budget-{{$id}}-rl" placeholder="Realisasi" class="form-control" value="{{$achievements[$key]['budget_realization']}}"/>
                    </div>--}}
                </div>

               {{-- <button type="submit" class="btn btn-block btn-primary mbot-15 save">
                    <i class="fa fa-save"></i> Save
                </button>--}}
               {{-- {!! Form::close() !!}--}}

                @endcan

                <div class="attachment">
                    @if(!Gate::check('read-only'))

                        <button type="button" class="btn btn-success btn-block" id="attach-{{$id}}">
                            <i class="fa fa-paperclip"></i> Attach Documents
                        </button>
                    @endif
                    <div class="table-responsive">
                    <table class="table table-condensed table-bordered table-striped" id="table-attach-{{$id}}">
                        <thead>
                        <tr>
                            <th>Title</th>
                            @if(!Gate::check('read-only'))
                                <th>Action</th>
                            @endif
                        </tr>
                        </thead>
                    </table>
                    </div>
                </div>

        </div>
    </div>
</div>

@section('script')
    @parent

    <script>

        $('#table-attach-{{$id}}').DataTable({
            bFilter: false,
            // bInfo: false,
            bPaginate: false,
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{route('capaian.media.data')}}",
                data: function(d) {
                    d.achievement = {{$achievements[$key]['id']}};
                    d.key = '{{$id}}';
                }
            },
            columns: [
                {data:'name',name:'name',orderable:false,searchable:false},

                    @if(!Gate::check('read-only'))
                {data:'action',name:'action',orderable:false,searchable:false}
                @endif
            ]
        });

        $('#attach-{{$id}}').click(function(){
            var modalId = '{{$viewId}}',
                    $modalId = $('#'+modalId);

            $modalId .modal();
            $('#'+modalId+' .modal-body').html('');
            $('.modal #'+modalId+'-label').html('Attach Documents {{$panel_title}}');

            $.get('{{route('goal.capaian.doc.create', [$goal->id, $achievements[$key]['id']])}}', {
                twId: '{{$id}}'
            }, function (response) {
                $('#'+modalId+' .modal-body').html(response);

            });
        });

    </script>
@stop