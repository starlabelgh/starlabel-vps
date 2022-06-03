/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

"use strict";

load_data();

function load_data() {
  var table = $('#maintable').DataTable({
    processing : true,
    serverSide : true,
    ajax : {
      url : $('#maintable').attr('data-url'),
    },
    columns : [
      {data : 'id', name : 'id'},
      {data : 'name', name : 'name'},
      {data : 'email', name : 'email'},
      {data : 'phone', name : 'phone'},
      {data : 'employee_id', name : 'employee_id'},
      {data : 'expected_date', name : 'expected_date'},
      {data : 'expected_time', name : 'expected_time'},
      {data : 'action', name : 'action'},
    ],
    "ordering" : false
  });

  let hidecolumn = $('#maintable').data('hidecolumn');
  if(!hidecolumn) {
      table.column( 5 ).visible( false );
  }
}

$('#maintable').on('draw.dt', function () {
  $('[data-toggle="tooltip"]').tooltip();
})
