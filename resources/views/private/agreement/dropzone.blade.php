<form id="agreement-files" class="dropzone">
    <div class="fallback">
        <input name="file" type="file" multiple />
    </div>
</form>

{{-- FIle yang berhasil di upload akan masuk ke sini sebagai input hidden  --}}
<div id="uploaded-files"></div>

<button class="btn btn-primary" id="add-to-pk">
    <i class="fa fa-plus"></i> Tambah ke PK
</button>

<script>
    $("#agreement-files").dropzone({
        url: "{{route('media.store')}}",
        params: {
            _token: '{{csrf_token()}}',
            destination: 'scan'
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

    $('#add-to-pk').click(function(){
        var files = $('#uploaded-files').children();
        var mediaId = [];

        files.each(function(i, file){
            //console.log(file);
            var $file = $(file);
            // console.log($file.data('location'))

            mediaId.push($file.val());
        });

        $.post('{{route('pk.doc.store', $id)}}', {
            mediaId: mediaId,
            _token: '{{csrf_token()}}'
        }, function(r) {
            if(r) {
                $('ul#dokumen-pk').html('');
                r.forEach(function(i){
                    $('ul#dokumen-pk').append('<li><a target="_blank" href="{{url('/')}}/'+i.location+'">'+i.original_name+'</a></li>');
                });

                $('#view').modal('hide');
            }
        });
    });
</script>