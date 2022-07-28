var object = $('#rotate_object');

$(window).load(function(){
  //show loading
  $('#loading').show();

  //resize rotate container
  var image = $('#previewimg'),
      image_w = image.width(),
      image_h = image.height();

  $('#rotate_container').css('height',image_h).css('width',image_w);
  $('.preview_bg').css('height',image_h).css('width',image_w);

  //cal scale
  var image_true_w, scale=1;
  image_true_w=$("#truesize").attr("src", $(image).attr("src")).width();
    scale = image_w/image_true_w;

    //resize object
    var object_w = image_w*0.5,
        object_h = object_w*(883/693),
    //wrap_left = 20,
    // = image_h - object_h - 20;
    wrap_left = 0,
    wrap_top = image_h - object_h;
    object.css('width',object_w).css('height',object_h);
    object.css('left',wrap_left).css('top',wrap_top);

    //refresh object info
  RefreshObjectInfo();

  //done
  $('#loading').hide();
  $('#rotate_container').fadeTo(500,1);
});

$(document).ready(function(){

  // checkbox
  $(".checkbox").button();

    //form submit
  $("#normalSubmit").click(function() {
    $('#directpost').val('');
    $('#iamForm').attr("target","_self").submit();
  });
  $("#facebookSubmit").click(function() {
    $('#directpost').val('1');
    $('#iamForm').attr("target","_blank").submit();
  });
  $("#genbgSubmit").click(function() {
    $('#generating').show();
    $('#loading').show();
    $.ajax({
      url: 'genbackground',
      dataType: 'html',
      type:'POST',
      data: { source: $("#source").val(),
          part_x: $("#part_x").val(),
          part_y: $("#part_y").val(),
          part_w: $("#part_w").val(),
          part_h: $("#part_h").val(),
          mirror_h: $("#mirror_h").prop('checked'),
          mirror_v: $("#mirror_v").prop('checked'),
          wb: $("#wb").val()
        },
      error: function(xhr){
        // alert(xhr);
      },
      success: function(response){
        var filename = response;
            $('#filename').attr('value',filename);
            $('#source').attr('value',filename);
            $('#previewimg').attr('src','upload/'+filename).load(function() {

          $('#rotate_container').css('height','inherit').css('width','inherit');
          $('.preview_bg').css('height','inherit').css('width','inherit');

          //resize rotate container
          var image = $('#previewimg'),
              image_w = image.width(),
              image_h = image.height();
          $('#rotate_container').css('height',image_h).css('width',image_w);
          $('.preview_bg').css('height',image_h).css('width',image_w);

          if(object.height() > image_h) {
            var scale = object.width()/object.height();
              new_object_h = image_h*0.5,
              new_object_w = new_object_h*scale;
            object.css('width',new_object_w).css('height',new_object_h);
          }
          else if(object.width() > image_w) {
            var scale = object.height()/object.width();
              new_object_w = image_w*0.5,
              new_object_h = new_object_w*scale;
            object.css('width',new_object_w).css('height',new_object_h);
          }
          object.css('left', 10).css('top',10);

          RefreshObjectInfo();
          $('#generating').fadeOut();
          $('#loading').hide();
        });
      }
    });
  });

  //mouseup event
  $('body').mouseup(function(){
    RefreshObjectInfo();
  });

  //setting event
  $('#mirror_h,#mirror_v,#wb').change(function(){
    $('#loading').show();
    var wb = $('#wb').val();
    if(wb!=='') wb = '_' + wb;
    if($('#mirror_v').prop('checked') == true && $("#mirror_h").prop('checked') == true) {
      $('#kaneshiro').attr('src','images/object/kaneshiro_vh' + wb + '.png').load(function() {
        $('#loading').hide();
      });
    }
    else if($("#mirror_v").prop('checked') == true && $("#mirror_h").prop('checked') == false) {
      $('#kaneshiro').attr('src','images/object/kaneshiro_v' + wb + '.png').load(function() {
        $('#loading').hide();
      });
    }
    else if($("#mirror_v").prop('checked') == false && $("#mirror_h").prop('checked') == true) {
      $('#kaneshiro').attr('src','images/object/kaneshiro_h' + wb + '.png').load(function() {
        $('#loading').hide();
      });
    }
    else {
      $('#kaneshiro').attr('src','images/object/kaneshiro' + wb + '.png').load(function() {
        $('#loading').hide();
      });
    }
  });

  $("#show").click(function() {
    if($(".preview").css('z-index') == '1200') {
      $(".preview").css('z-index','-9999').css('opacity',0);
    }
    else if($(".preview").css('z-index') == '-9999') {
      $(".preview").css('z-index','1200').css('opacity',1);
    }
  });
});

//window resize event
var w = $(window).width();
$(window).resize(function() {

    var nw = $(window).width();
  if(w !== nw) {
    //resize rotate container
    var image = $('#previewimg'),
        image_w = image.width(),
        image_h = image.height();
    $('#rotate_container').css('height',image_h).css('width',image_w);
    $('.preview_bg').css('height',image_h).css('width',image_w);

    //cal scale
    var image_true_w, scale=1;
    image_true_w=$("#truesize").attr("src", $(image).attr("src")).width();
    scale = image_w/image_true_w;

    //resize object
    var object_w = image_w*0.5,
      object_h = object_w*(883/693),
      wrap_left = 20,
      wrap_top = image_h - object_h - 20;
    object.css('width',object_w).css('height',object_h);
    object.css('left',wrap_left).css('top',wrap_top);

    //refresh object info
    RefreshObjectInfo();
    w = nw;
  }
});

//paste url upload
$(document).bind('paste', function(e) {
  var url = e.originalEvent.clipboardData.getData('Text');
  $('#loading').fadeIn();
  $('#uploading').show();
  $.ajax({
    url: 'urloader',
    dataType: 'html',
    type:'POST',
    data: { url: url },
    error: function(xhr){
      // alert(xhr);
    },
    success: function(response){
      if(response!=='error') {
        var filename = response;
            $('#filename').attr('value',filename);
            $('#source').attr('value',filename);
            $('#previewimg').attr('src','upload/'+filename).load(function() {

          $('#rotate_container').css('height','inherit').css('width','inherit');
          $('.preview_bg').css('height','inherit').css('width','inherit');

          //resize rotate container
          var image = $('#previewimg'),
              image_w = image.width(),
              image_h = image.height();
          $('#rotate_container').css('height',image_h).css('width',image_w);
          $('.preview_bg').css('height',image_h).css('width',image_w);

          if(object.height() > image_h) {
            var scale = object.width()/object.height();
              new_object_h = image_h*0.5,
              new_object_w = new_object_h*scale;
            object.css('width',new_object_w).css('height',new_object_h);
          }
          else if(object.width() > image_w) {
            var scale = object.height()/object.width();
              new_object_w = image_w*0.5,
              new_object_h = new_object_w*scale;
            object.css('width',new_object_w).css('height',new_object_h);
          }
          object.css('left', 10).css('top',10);

          RefreshObjectInfo();
          $('#uploading').fadeOut();
          $('#loading').hide();
        });
      }
      else {
        alert('上傳失敗');
        $('#uploading').hide();
        $('#loading').hide();
      }
    }
  });
});

//uploader
$(function(){
    $('.uploadBtn').click(function(){
        $('#uploadInput').click();
    });
  $('#uploadInput, .drop').fileUpload({
    url: 'uploader',
    type: 'POST',
    dataType: 'json',
    beforeSend: function () {
      $('#uploading').fadeIn();
      $('#loading').show();
    },
    complete: function () {
    },
    success: function (result, status, xhr) {
      var filename = result.filename;
          $('#filename').attr('value',filename);
          $('#source').attr('value',filename);
          $('#previewimg').attr('src','upload/'+filename).load(function() {

        $('#rotate_container').css('height','inherit').css('width','inherit');
        $('.preview_bg').css('height','inherit').css('width','inherit');

        //resize rotate container
        var image = $('#previewimg'),
            image_w = image.width(),
            image_h = image.height();
        $('#rotate_container').css('height',image_h).css('width',image_w);
        $('.preview_bg').css('height',image_h).css('width',image_w);

        if(object.height() > image_h) {
          var scale = object.width()/object.height();
            new_object_h = image_h*0.5,
            new_object_w = new_object_h*scale;
          object.css('width',new_object_w).css('height',new_object_h);
        }
        else if(object.width() > image_w) {
          var scale = object.height()/object.width();
            new_object_w = image_w*0.5,
            new_object_h = new_object_w*scale;
          object.css('width',new_object_w).css('height',new_object_h);
        }
        object.css('left', 10).css('top',10);

        RefreshObjectInfo();
        $('#uploading').fadeOut();
        $('#loading').hide();
      });
    }
  });
});

function RefreshObjectInfo(){
  var image = $('#previewimg');
  var image_w = image.width();
  var image_true_w, scale=1;
  image_true_w=$("#truesize").attr("src", $(image).attr("src")).width();
    scale = image_w/image_true_w;

  var object = $('#rotate_object');
    var object_w = object.width()/scale+1;
    var object_h = object.height()/scale+1;

  $("#part_w").attr('value',object_w);
  $("#part_h").attr('value',object_h);

  getRotateTruePosition();
}
function getRotateTruePosition(){
  //copy html to temp div
  var image = $('#previewimg');
  var image_w = image.width();
  var image_h = image.height();
  $('#rotateCopy').css('height',image_h).css('width',image_w);
  var rotate_container = $('#rotate_container').html();
  $('#rotateCopy').html(rotate_container);

  //cal scale
  var image_true_w, scale=1;
  image_true_w=$("#truesize").attr("src", $(image).attr("src")).width();
    scale = image_w/image_true_w;

  //get position
  var copy_position = $('#rotateCopy').offset();
  var copy_obj_position = $('#rotateCopy #rotate_object').offset();
  var true_x = (copy_obj_position.left-copy_position.left)/scale;
  var true_y = (copy_obj_position.top-copy_position.top)/scale;

  $("#part_x").attr('value',true_x);
  $("#part_y").attr('value',true_y);
}

//mobile scripts

function detectmob() {
   if(window.innerWidth <= 560) {
     return true;
   } else {
     return false;
   }
}
if(!detectmob()){
  //object rotate
  object.resizable({
    handles: 'ne, nw, se, sw',
    containment: 'parent',
    // aspectRatio: true
  }).draggable({
      // containment: 'parent'
  });
  $('#rotate_container').mouseenter(function(){
    $(".ui-resizable-handle").show();
  });
  $('#rotate_container').mouseleave(function(){
    $(".ui-resizable-handle").hide();
  });
}
else {
  //object rotate
  object.resizable({
    handles: 'ne, nw, se, sw',
    containment: 'parent'
  }).draggable({
    // containment: 'parent'
  });
  $('#rotate_container').click(function(){
    if($(".ui-resizable-handle").css('display')=='none') {
      $(".ui-resizable-handle").show();
    }
    else{
      $(".ui-resizable-handle").hide();
    }
  });
}

// scroll to top
$(window).scroll(function (event) {
  var scroll = $(window).scrollTop();
  var height = $(window).height();
  if(scroll > height*0.5)
    $('.gototop').show();
  else
    $('.gototop').hide();
});
$('.gototop').click(function(){
  $('html,body').animate({scrollTop: 0},'fast');
});
