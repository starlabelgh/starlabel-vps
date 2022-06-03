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
      data : {status : 'status'}
    },
    columns : [
      {data : 'id', name : 'id'},
      {data : 'image', name : 'image'},
      {data : 'user', name : 'user'},
      {data : 'working', name : 'working'},
      {data : 'date', name : 'date'},
      {data : 'clockin', name : 'clockin'},
        {data : 'clockout', name : 'clockout'},
        {data : 'action', name : 'action'},
    ],
    "ordering" : false
  });


}

$('#maintable').on('draw.dt', function () {
  $('[data-toggle="tooltip"]').tooltip();
})
