/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

"use strict";

load_data();

function load_data(status = '',requests='') {
  var table = $('#maintable').DataTable({
    processing : true,
    serverSide : true,
    ajax : {
      url : $('#maintable').attr('data-url'),
      data : {status : status, requested : requests}
    },
    columns : [
      {data : 'id', name : 'id'},
      {data : 'name', name : 'name'},
      {data : 'flag', name : 'flag'},
      {data : 'code', name : 'code'},
      {data : 'status', name : 'status'},
      {data : 'action', name : 'action'},

    ],
    "ordering" : false
  });
}

