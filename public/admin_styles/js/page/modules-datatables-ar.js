"use strict";

$("[data-checkboxes]").each(function() {
  var me = $(this),
    group = me.data('checkboxes'),
    role = me.data('checkbox-role');

  me.change(function() {
    var all = $('[data-checkboxes="' + group + '"]:not([data-checkbox-role="dad"])'),
      checked = $('[data-checkboxes="' + group + '"]:not([data-checkbox-role="dad"]):checked'),
      dad = $('[data-checkboxes="' + group + '"][data-checkbox-role="dad"]'),
      total = all.length,
      checked_length = checked.length;

    if(role == 'dad') {
      if(me.is(':checked')) {
        all.prop('checked', true);
      }else{
        all.prop('checked', false);
      }
    }else{
      if(checked_length >= total) {
        dad.prop('checked', true);
      }else{
        dad.prop('checked', false);
      }
    }
  });
});

$("#table-1").dataTable({
  "columnDefs": [
    { "sortable": false, "targets": [2,3] }
  ]
});
$("#table-2").DataTable({
  "language": {
      "sEmptyTable":     "ليست هناك بيانات متاحة في الجدول",
      "sLoadingRecords": "جارٍ التحميل...",
      "sProcessing":   "جارٍ التحميل...",
      "sLengthMenu":   "أظهر _MENU_ مدخلات",
      "sZeroRecords":  "لم يعثر على أية سجلات",
      "sInfo":         "إظهار _START_ إلى _END_ من أصل _TOTAL_ مدخل",
      "sInfoEmpty":    "يعرض 0 إلى 0 من أصل 0 سجل",
      "sInfoFiltered": "(منتقاة من مجموع _MAX_ مُدخل)",
      "sInfoPostFix":  "",
      "sSearch":       "ابحث:",
      "sUrl":          "",
      "oPaginate": {
          "sFirst":    "الأول",
          "sPrevious": "السابق",
          "sNext":     "التالي",
          "sLast":     "الأخير"
      },
      "oAria": {
          "sSortAscending":  ": تفعيل لترتيب العمود تصاعدياً",
          "sSortDescending": ": تفعيل لترتيب العمود تنازلياً"
      }
  }
});
