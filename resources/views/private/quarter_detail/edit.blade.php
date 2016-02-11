<div class="table-responsive">
<table class="table table-bordered">
    <thead>
    <tr>
        <th rowspan="2">Detail indikator</th>
        <th rowspan="2">Pagu</th>
        <th colspan="2">Fisik</th>
        <th colspan="2">Anggaran</th>
    </tr>
    <tr>
        <th>RN</th>
        <th>RL</th>
        <th>RN</th>
        <th>RL</th>
    </tr>
    </thead>
    <tbody>
    @foreach($documents as $doc)
    <tr class="document item" data-id="{{ isset($doc['achievement_value'][$quarter]) ? $doc['achievement_value'][$quarter]['id'] : 0}}">
        <td>{{$doc['description']}}</td>
        <td>
            <a href="#"
               class="pagu"
               id="pagu-{{ isset($doc['achievement_value'][$quarter]) ? $doc['achievement_value'][$quarter]['id'] : $doc['id']}}"
            >
                {{ isset($doc['achievement_value'][$quarter]) ? $doc['achievement_value'][$quarter]['dipa'] : 0}}
            </a>
        </td>
        <td>
            <a href="#" class="fsk-plan" id="fsk-plan-{{ isset($doc['achievement_value'][$quarter]) ? $doc['achievement_value'][$quarter]['id'] : $doc['id']}}"
            >
                {{ isset($doc['achievement_value'][$quarter]) ? $doc['achievement_value'][$quarter]['fisik_plan'] : 0}}
            </a>
        </td>
        <td>
            <a href="#" class="fsk-real" id="fsk-real-{{ isset($doc['achievement_value'][$quarter]) ? $doc['achievement_value'][$quarter]['id'] : $doc['id']}}"
            >
                {{ isset($doc['achievement_value'][$quarter]) ? $doc['achievement_value'][$quarter]['fisik_real'] : 0}}
            </a>
        </td>
        <td>
            <a href="#" class="bgt-plan" id="bgt-plan-{{ isset($doc['achievement_value'][$quarter]) ? $doc['achievement_value'][$quarter]['id'] : $doc['id']}}"
            >
                {{ isset($doc['achievement_value'][$quarter]) ? $doc['achievement_value'][$quarter]['budget_plan'] : 0}}
            </a>
        </td>
        <td>
            <a href="#" class="bgt-real" id="bgt-real-{{ isset($doc['achievement_value'][$quarter]) ? $doc['achievement_value'][$quarter]['id'] : $doc['id']}}"
            >
                {{ isset($doc['achievement_value'][$quarter]) ? $doc['achievement_value'][$quarter]['budget_real'] : 0}}
            </a>
        </td>
    </tr>
    @endforeach
    </tbody>
</table>
</div>

<script>
    @foreach($documents as $doc)


    $('#pagu-{{ isset($doc['achievement_value'][$quarter]) ? $doc['achievement_value'][$quarter]['id'] : $doc['id']}}').editable({
        type: 'text',
        pk: function() {
            return $(this).closest('tr.document.item').attr('data-id');
        },
        url: '{{route('quarter.detail.update')}}',
        title: 'Pagu',
        ajaxOptions: {
            type: 'put'
        },
        params: function(params) {
            params._token = '{{csrf_token()}}';
            params.field = 'dipa';
            params.achievement_id = '{{$id['achievement']}}';
            params.detail_id = '{{$doc['id']}}';
            return params;
        },
        success: function(response, newValue) {

            var $this = $(this);
            $this.closest('tr.document.item').attr('data-id', response.id);
        }
    });

    $('#fsk-plan-{{ isset($doc['achievement_value'][$quarter]) ? $doc['achievement_value'][$quarter]['id'] : $doc['id']}}').editable({
        type: 'text',
        pk: function() {
            return $(this).closest('tr.document.item').attr('data-id');
        },
        url: '{{route('quarter.detail.update')}}',
        title: 'Pagu',
        ajaxOptions: {
            type: 'put'
        },
        params: function(params) {
            params._token = '{{csrf_token()}}';
            params.field = 'fisik_plan';
            params.achievement_id = '{{$id['achievement']}}';
            params.detail_id = '{{$doc['id']}}';
            return params;
        },
        success: function(response, newValue) {

            var $this = $(this);
            $this.closest('tr.document.item').attr('data-id', response.id);
        }
    });

    $('#fsk-real-{{ isset($doc['achievement_value'][$quarter]) ? $doc['achievement_value'][$quarter]['id'] : $doc['id']}}').editable({
        type: 'text',
        pk: function() {
            return $(this).closest('tr.document.item').attr('data-id');
        },
        url: '{{route('quarter.detail.update')}}',
        title: 'Pagu',
        ajaxOptions: {
            type: 'put'
        },
        params: function(params) {
            params._token = '{{csrf_token()}}';
            params.field = 'fisik_real';
            params.achievement_id = '{{$id['achievement']}}';
            params.detail_id = '{{$doc['id']}}';
            return params;
        },
        success: function(response, newValue) {

            var $this = $(this);
            $this.closest('tr.document.item').attr('data-id', response.id);
        }
    });

    $('#bgt-plan-{{ isset($doc['achievement_value'][$quarter]) ? $doc['achievement_value'][$quarter]['id'] : $doc['id']}}').editable({
        type: 'text',
        pk: function() {
            return $(this).closest('tr.document.item').attr('data-id');
        },
        url: '{{route('quarter.detail.update')}}',
        title: 'Pagu',
        ajaxOptions: {
            type: 'put'
        },
        params: function(params) {
            params._token = '{{csrf_token()}}';
            params.field = 'budget_plan';
            params.achievement_id = '{{$id['achievement']}}';
            params.detail_id = '{{$doc['id']}}';
            return params;
        },
        success: function(response, newValue) {

            var $this = $(this);
            $this.closest('tr.document.item').attr('data-id', response.id);
        }
    });

    $('#bgt-real-{{ isset($doc['achievement_value'][$quarter]) ? $doc['achievement_value'][$quarter]['id'] : $doc['id']}}').editable({
        type: 'text',
        pk: function() {
            return $(this).closest('tr.document.item').attr('data-id');
        },
        url: '{{route('quarter.detail.update')}}',
        title: 'Pagu',
        ajaxOptions: {
            type: 'put'
        },
        params: function(params) {
            params._token = '{{csrf_token()}}';
            params.field = 'budget_real';
            params.achievement_id = '{{$id['achievement']}}';
            params.detail_id = '{{$doc['id']}}';
            return params;
        },
        success: function(response, newValue) {

            var $this = $(this);
            $this.closest('tr.document.item').attr('data-id', response.id);
        }
    });
    @endforeach
</script>