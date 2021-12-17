<link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script>
  function loadList(dataList = [], classTable = '#listTables') {
    var page_url = '';
    @if(@$route)
      var page_url = "{{ (@$routeList) ? url($routeList).'/list' : route($route.'.list') }}";
    @endif

    var table = $(classTable).DataTable({
        processing: true,
        serverSide: true,
        responsive: false,
        autoWidth: false,
        scrollX: true,
        scrollY: 400,
        scrollCollapse: true,
        fixedHeader:true,
        lengthChange: false,
        ajax: {
          url: page_url,
          data: function (d) {
           d._token = "{{ csrf_token() }}";
           $('.filter-control').each(function(idx, el) {
            var name = $(el).data('post');
            var val = $(el).val();
            d[name] = val;
          })
         }
       },
      columns: dataList,
      dom: 'Bfrtip',
      buttons: [
        {
          extend: 'excelHtml5',
          text: "<i class='flaticon2-file'></i> Export Excel",
          className: "btn buttons-copy btn btn-light-success font-weight-bold mr-2 buttons-html5",
        },
        {
          extend: 'csvHtml5',
          text: "<i class='flaticon2-layers'></i> Export Csv",
          className: "btn buttons-copy btn btn-light-success font-weight-bold mr-2 buttons-html5",
        },
        {
          text: "<i class='flaticon2-paper'></i> Remove Select Data",
          className: "btn buttons-copy btn btn-light-success font-weight-bold mr-2 buttons-html5",
          action: function () {
            removeSelect()
          }
        }
      ],
      initComplete: function (settings, json) {
        $(".dt-buttons .btn").removeClass("btn-secondary")
      },
      drawCallback: function(row, data) {
        var api = this.api();
        
      }
    });

    $('.group-checkable').on('change',function() {
      $('.removeAll').prop('checked', true);
      var set = $(this).closest('table').find('td:first-child .removeAll');
      var checked = $(this).is(':checked');
      if (checked) {
        $(this).prop('checked', true);
        $('.removeAll').prop('checked', true);
      }else {
        $(this).prop('checked', false);
        $('.removeAll').prop('checked', false);
        
      }
    });

    $('.filter-data').on('click', function(e) {
      table.draw();
    });

    $('.clear').on('click', function(e) {
      $(".filter-control").val('');
      table.draw();
    });
  }

  function removeSelect(){
    var removeAll = $('.removeAll').serializeArray();

    if(removeAll.length == 0){
      Swal.fire({
        type: 'info',
        title: 'Tidak terdapat data yang mau di hapus  !',
        text: 'Silahkan pilih data terlebih dahulu',
        button: true,
        confirmButtonText:'Tutup',
        confirmButtonColor:'#0BB7AF'
      })
    }else{
      Swal.fire({
          title: "Anda Yakin Untuk Menghapus Data?",
          text: "Setelah dihapus, Anda tidak akan dapat memulihkan data!",
          type: "question",
          showCancelButton: true,
          confirmButtonText: 'Yes, delete it!',
          confirmButtonColor:'#F64E60',
          cancelButtonText: 'No, cancel!',
          reverseButtons: true
      }).then((result) => {
        if (result.value) {
            var valueUuid = removeAll.map(function(value){
              return value.value
            })
            $.ajax({
                url: "{{ (@$route) ? $route.'/removeMulti' : '' }}",
                type: 'POST',
                data: {
                    '_method' : 'DELETE',
                    '_token' : '{{ csrf_token() }}',
                    'id' : valueUuid
                }
            })
            .done(function(response) {
                Swal.fire({
                  type: 'success',
                  title: 'Terhapus',
                  text: 'Data berhasil dihapus!',
                  button: true,
                  confirmButtonText:'Tutup',
                  confirmButtonColor:'#0BB7AF'
                }).then((res) => {
                    if (result.value) {
                      location.href = "{{ (@$route) ? route($route.'.index') : url('/') }}";
                    }
                })
            })
            .fail(function(response) {
                console.log(response);
                if(response.responseJSON && response.responseJSON.status == false){
                    Swal.fire({
                      type: 'info',
                      title: 'Penghapusan data gagal !',
                      text: 'data sedang digunakan oleh modul lain',
                      button: true,
                      confirmButtonText:'Tutup',
                      confirmButtonColor:'#0BB7AF'
                    }).then((res) => {
                        if (result.value) {
                          location.href = "{{ (@$route) ? route($route.'.index') : url('/') }}";
                        }
                    })
                }else{
                    Swal.fire({
                      type: 'error',
                      title: 'Penghapusan data gagal !',
                      text: 'Terjadi Kesalahan Sistem',
                      button: true,
                      confirmButtonText:'Tutup',
                      confirmButtonColor:'#0BB7AF'
                    }).then((res) => {
                        if (result.value) {
                          location.href = "{{ (@$route) ? route($route.'.index') : url('/') }}";
                        }
                    })
                }
            })

        }
      })
    }
  }


</script>