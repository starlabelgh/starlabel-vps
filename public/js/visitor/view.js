/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

"use strict";
$( document ).ready(function() {
var css = idCardCss;
function printData(data,css)
{
    var frame1 = $('<iframe />');
    frame1[0].name = "frame1";
    frame1.css({ "position": "absolute", "top": "-1000000px" });
    $("body").append(frame1);
    var frameDoc = frame1[0].contentWindow ? frame1[0].contentWindow : frame1[0].contentDocument.document ? frame1[0].contentDocument.document : frame1[0].contentDocument;
    frameDoc.document.open();
    //Create a new HTML document.
    frameDoc.document.write('<html><head><title>visitor ID Card</title>');
    frameDoc.document.write('<link href="'+css+'" rel="stylesheet" type="text/css" />');
    frameDoc.document.write('</head><body>');
    //Append the external CSS file.
    //Append the DIV contents.
    frameDoc.document.write(data);
    frameDoc.document.write('</body></html>');
    frameDoc.document.close();
    setTimeout(function () {
        window.frames["frame1"].focus();
        window.frames["frame1"].print();
        frame1.remove();
    }, 500);
}

$('#print').on('click',function(){
    var data = $("#printidcard").html();
    printData(data,css);
});
});

