@extends('layouts/app')

@section('styles')
<style>
  #listTables_wrapper>.dt-buttons { display: none; }
  #listTables_filter { text-align: center; }
  #x_listTables_wrapper>.dataTables_scroll { display: none; }
  #x_listTables_wrapper>.dataTables_info { display: none; }
  #x_listTables_wrapper>.dataTables_paginate { display: none; }
  #x_listTables_processing { opacity: 0; }
@endsection

@section('content')

<div class="row">
  <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="card card-custom {{ @$class }}">
      {{-- Body --}}
      <div class="card-body pt-4 table-responsive" >
        <table class="table data-thumb-view table-striped" id="listTables">
          <thead>
            <tr>
              <th width="32">No</th>
              <th>No Tiket</th>
              <th>Status</th>
              <th>Tipe</th>
              <th width="80">Action</th>
            </tr>
          </thead>

        </table>
      </div>
    </div>
  </div>
</div>

@endsection

@section('scripts')
{{-- Page js files --}}
<script>

  window.ticket = {
    cache: {},
    line: 0,
    detail: {
      open: function(source) {
        if (ticket.line>0) return false;
        let row = $(source).closest('TR')[0];
        ticket.line = row.children[0].innerText*1;

        let url = 'histori-tiket/'+row.children[1].innerText;
        $('TR[current-detail=true]').remove();
        $(row).attr('id', "TL"+ticket.line);
        /* console.log('## TDO', url); */
        console.log('## TDO', url);
        $.post( url, {_token: "{{ csrf_token() }}"} )
          .done(function( response ) {
            console.log({response});
            if (response.status=='ok') {
              let html = '<tr current-detail=true><td style="background-color: #fff"></td><td colspan=4 style="background-color: #fafafa; border-bottom: 3px solid #ccc;border-right: 1px solid #eee"><b>Histori Tiket</b>:<table>';
              Object.values(response.data.history).forEach( track => {
                const d = new Date(track.created_at);
                html += '<tr style="background-color: #fafafa!important"><td style="border: 0px!important; padding: 0px 0px 0px 15px!important; color: #3699FF">'+track.status.status+'</td><td style="border: 0px!important; padding: 0px 0px 0px 15px!important">'+d.toLocaleDateString('id-ID', { year:"numeric", month:"long", day:"numeric"})+" "+(d.getHours() < 10 ? "0" : "")+d.getHours()+":"+(d.getMinutes() < 10 ? "0" : "")+d.getMinutes()+":"+(d.getSeconds() < 10 ? "0" : "")+d.getSeconds()+'</td></tr>';
              })
              html +='</table></td></tr>';
              let node = $('#TL'+ticket.line);
              let info = $(html);
              $(info).insertAfter(node);
              $(info).attr('current-detail', true);
              ticket.line = 0;
            } else {
              ticket.line = 0;
            }
          })
          .fail(function(xhr, status, error) {
            ticket.line = 0;
          });
      }
    }
  }

  $(document).ready(function () {
    loadList([
      { data:'DT_RowIndex', name:'DT_RowIndex', searchable: false, orderable: false  },
      { data:'no_tiket', name:'no_tiket' },
      { data:'status_id', name:'status_id' },
      { data:'type_id', name:'type_id' },
      { data:'action', name: 'action', searchable: false, orderable: false }
      ]);

/*
  $('#listTables_wrapper').on( 'draw.dt', function () {

    if (($('input[type="search"]')[0]).value.trim().length > 0) {
        $('#listTables_wrapper>.dataTables_scroll').show();
        $('#listTables_wrapper>.dataTables_info').show();
        $('#listTables_wrapper>.dataTables_paginate').show();
      } else {
        $('#listTables_wrapper>.dataTables_scroll').hide();
        $('#listTables_wrapper>.dataTables_info').hide();
        $('#listTables_wrapper>.dataTables_paginate').hide();
      }

  } );
*/
    /* $('input[type="search"]').on('hover', (e) => {
      e.preventDefault();
      e.stopPropagation();
    })

    $('input[type="search"]').on('keyup', (e) => {
      if (e.target.value.trim().length > 0) {
        $('#listTables_wrapper>.dataTables_scroll').show();
        $('#listTables_wrapper>.dataTables_info').show();
        $('#listTables_wrapper>.dataTables_paginate').show();
      } else {
        $('#listTables_wrapper>.dataTables_scroll').hide();
        $('#listTables_wrapper>.dataTables_info').hide();
        $('#listTables_wrapper>.dataTables_paginate').hide();
      }
    }) */

  });
</script>
@endsection
