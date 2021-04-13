(function (window, undefined) {
  'use strict';

  /*
  NOTE:
  ------
  PLACE HERE YOUR OWN JAVASCRIPT CODE IF NEEDED
  WE WILL RELEASE FUTURE UPDATES SO IN ORDER TO NOT OVERWRITE YOUR JAVASCRIPT CODE PLEASE CONSIDER WRITING YOUR SCRIPT HERE.  */

  $('.ui.dropdown')
    .dropdown({
      "clearable": "true"
    });

  $(document).on("click", ".browse", function () {
    var file = $(this).parents().find(".file");
    file.trigger("click");
  });
  $('input.file[type="file"]').change(function (e) {
    var fileName = e.target.files[0].name;
    $("#file").val(fileName);

    var reader = new FileReader();
    reader.onload = function (e) {
      // get loaded data and render thumbnail.
      document.getElementById("preview").src = e.target.result;
    };
    // read the image file as a data URL.
    reader.readAsDataURL(this.files[0]);
  });

  $(document).on("click", ".browse-second", function () {
    var file = $(this).parents().find(".file-second");
    file.trigger("click");
  });
  $('input.file-second[type="file"]').change(function (e) {
    var fileName = e.target.files[0].name;
    $("#file-second").val(fileName);

    var reader = new FileReader();
    reader.onload = function (e) {
      // get loaded data and render thumbnail.
      document.getElementById("preview-second").src = e.target.result;
    };
    // read the image file as a data URL.
    reader.readAsDataURL(this.files[0]);
  });


  $(document).on("click", ".browse-thard", function () {
    var file = $(this).parents().find(".file-thard");
    file.trigger("click");
  });
  $('input.file-thard[type="file"]').change(function (e) {
    var fileName = e.target.files[0].name;
    $("#file-thard").val(fileName);

    var reader = new FileReader();
    reader.onload = function (e) {
      // get loaded data and render thumbnail.
      document.getElementById("preview-thard").src = e.target.result;
    };
    // read the image file as a data URL.
    reader.readAsDataURL(this.files[0]);
  });


  $(document).on("click", ".browse-alternate-image-one", function () {
    var file = $(this).parents().find(".file-alternate-image-one");
    file.trigger("click");
  });
  $('input.file-alternate-image-one[type="file"]').change(function (e) {
    var fileName = e.target.files[0].name;
    $("#file-thard").val(fileName);

    var reader = new FileReader();
    reader.onload = function (e) {
      // get loaded data and render thumbnail.
      document.getElementById("preview-alternate-image-one").src = e.target.result;
    };
    // read the image file as a data URL.
    reader.readAsDataURL(this.files[0]);
  });

  $(document).on("click", ".browse-alternate-image-two", function () {
    var file = $(this).parents().find(".file-alternate-image-two");
    file.trigger("click");
  });
  $('input.file-alternate-image-two[type="file"]').change(function (e) {
    var fileName = e.target.files[0].name;
    $("#file-thard").val(fileName);

    var reader = new FileReader();
    reader.onload = function (e) {
      // get loaded data and render thumbnail.
      document.getElementById("preview-alternate-image-two").src = e.target.result;
    };
    // read the image file as a data URL.
    reader.readAsDataURL(this.files[0]);
  });

   $(document).on("click", ".browse-alternate-image-three", function () {
    var file = $(this).parents().find(".file-alternate-image-three");
    file.trigger("click");
  });
  $('input.file-alternate-image-three[type="file"]').change(function (e) {
    var fileName = e.target.files[0].name;
    $("#file-thard").val(fileName);

    var reader = new FileReader();
    reader.onload = function (e) {
      // get loaded data and render thumbnail.
      document.getElementById("preview-alternate-image-three").src = e.target.result;
    };
    // read the image file as a data URL.
    reader.readAsDataURL(this.files[0]);
  });


  $('#sandbox-container input').datepicker({
    autoclose: true,
    todayHighlight: true,
    format: "M dd, yyyy",
    timePicker: true,
  });


//   var quill = new Quill('#editor-container', {
//     modules: {
//       'toolbar': [
//         [{
//           'font': []
//         }, {
//           'size': []
//         }],
//         ['bold', 'italic', 'underline', 'strike'],
//         [{
//           'color': []
//         }, {
//           'background': []
//         }],
//         [{
//           'script': 'super'
//         }, {
//           'script': 'sub'
//         }],
//         [{
//           'header': '1'
//         }, {
//           'header': '2'
//         }, 'blockquote', 'code-block'],
//         [{
//           'list': 'ordered'
//         }, {
//           'list': 'bullet'
//         }, {
//           'indent': '-1'
//         }, {
//           'indent': '+1'
//         }],
//         ['direction', {
//           'align': []
//         }],
//         ['link', 'image', 'video', 'formula'],

//       ],
//     },

//     theme: 'snow' // or 'bubble'
//   });
//   var quill = new Quill('#editor-container-a', {
//     modules: {
//       'toolbar': [
//         [{
//           'font': []
//         }, {
//           'size': []
//         }],
//         ['bold', 'italic', 'underline', 'strike'],
//         [{
//           'color': []
//         }, {
//           'background': []
//         }],
//         [{
//           'script': 'super'
//         }, {
//           'script': 'sub'
//         }],
//         [{
//           'header': '1'
//         }, {
//           'header': '2'
//         }, 'blockquote', 'code-block'],
//         [{
//           'list': 'ordered'
//         }, {
//           'list': 'bullet'
//         }, {
//           'indent': '-1'
//         }, {
//           'indent': '+1'
//         }],
//         ['direction', {
//           'align': []
//         }],
//         ['link', 'image', 'video', 'formula'],

//       ],
//     },
//     theme: 'snow' // or 'bubble'
//   });

  $('#timepicker input ').timepicker();

  var fixHelperModified = function (e, tr) {
      var $originals = tr.children();
      var $helper = tr.clone();
      $helper.children().each(function (index) {
        $(this).width($originals.eq(index).width())
      });
      return $helper;
    },
    updateIndex = function (e, ui) {
      $('td.index', ui.item.parent()).each(function (i) {
        $(this).html(i + 1);
      });
      $('input[type=text]', ui.item.parent()).each(function (i) {
        $(this).val(i + 1);
      });
    };

  $("#myTable tbody").sortable({
    helper: fixHelperModified,
  }).disableSelection();

  $("#myTable tbody").sortable({
    distance: 5,
    delay: 100,
    opacity: 0.6,
    cursor: 'move',
    update: function () {}
  });
  $(document).ready(function () {
      $("#discount-btn").click(function(){
         $('#discount-promo').modal('show');
      });
      $("#add-transcation").click(function(){
         $('#add-new-transcation').modal('show');
      });

    //   $("#product-variants").click(function(){
    //      $('#create-variants').modal('show');
    //       $('#add-variants').modal('hide');
    //   });
    //     $("#add-variants").click(function(){
    //      $('#add-variants').modal('show');
    //   });

 });
})(window);
