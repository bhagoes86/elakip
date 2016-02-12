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
            <h4>Fisik</h4>

            <div class="form-group">
                <label for="{{$id}}-rn">Rencana</label>
                <div class="form-control" id="{{$id}}-rn">{{$achievements[$key]['plan']}}</div>

            </div>

            <div class="form-group">
                <label for="{{$id}}-rl">Realisasi</label>
                <div class="input-group">
                    <div class="form-control" id="{{$id}}-rl">{{$achievements[$key]['realization']}}</div>
                    <span class="input-group-addon">&percnt;</span>
                </div>
            </div>
            <hr/>
            <h4>Anggaran</h4>

            <div class="form-group">
                <label for="budget-{{$id}}-rn">Pagu</label>
                <div class="form-control" id="budget-{{$id}}-rn">{{$achievements[$key]['budget_plan']}}</div>
            </div>
            <div class="form-group">
                <label for="budget-{{$id}}-rl">Realisasi</label>
                <div class="form-control" id="budget-{{$id}}-rl">{{$achievements[$key]['budget_realization']}}</div>

            </div>

            @else

                <h4>Fisik</h4>

                <div class="form-group">
                    <label for="{{$id}}-rn">Rencana</label>
                    <p class="form-control-static">{{$achievements[$key]['plan']}}%</p>
                </div>

                <div class="form-group">
                    <label for="{{$id}}-rl">Realisasi</label>
                    <p class="form-control-static">{{$achievements[$key]['realization']}}%</p>
                </div>


                <hr/>
                <h4>Anggaran</h4>

                <div class="form-group">
                    <label for="budget-{{$id}}-rn">Pagu</label>
                    <p class="form-control-static">{{$achievements[$key]['budget_plan']}}%</p>


                </div>
                <div class="form-group">
                    <label for="budget-{{$id}}-rl">Realisasi</label>
                    <p class="form-control-static">{{$achievements[$key]['budget_realization']}}%</p>

                </div>

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