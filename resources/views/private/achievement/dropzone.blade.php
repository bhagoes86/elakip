<form id="agreement-files" class="dropzone">
    <div class="fallback">
        <input name="file" type="file" multiple />
    </div>
</form>

{{-- FIle yang berhasil di upload akan masuk ke sini sebagai input hidden  --}}
<div id="uploaded-files"></div>

<button class="btn btn-primary" id="add-to-{{$id['tw']}}">
    <i class="fa fa-plus"></i> Tambah ke ..
</button>

<script>
    $("#agreement-files").dropzone({
        url: "{{route('media.store')}}",
        params: {
            _token: '{{csrf_token()}}',
            destination: 'capaian'
        },
        acceptedFiles: 'image/jpeg,image/png,image/gif,application/pdf,',
        init: function () {
            this.on('success', function (file, response) {
                /*console.log(file);
                 console.log(response);*/

                if(file.status == 'success') {
                    $('#uploaded-files').append('<input type="hidden" ' +
                    'value="'+response.id+'" ' +
                    'data-order="" ' +
                    'data-original-name="'+response.original_name+'" ' +
                    'data-location="'+response.location+'"/>');
                }
            });
        }
    });

    $('#add-to-{{$id['tw']}}').click(function(){
        var files = $('#uploaded-files').children();
        var mediaId = [];

        files.each(function(i, file){
            //console.log(file);
            var $file = $(file);
            // console.log($file.data('location'))

            mediaId.push($file.val());
        });

        $.post('{{route('goal.capaian.doc.store', [$id['goal'], $id['achievement']])}}', {
            mediaId: mediaId,
            _token: '{{csrf_token()}}'
        }, function(r) {
            if(r) {


                var table = $('#table-attach-{{$id['tw']}}').DataTable();
                table.ajax.reload();
                $('#achievement').modal('hide');
            }
        });
    });
</script>