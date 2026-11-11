$("#name_record_type").change(function () {
  $(".dd_filter_name_record_sub").hide();
  let name_record_type = $("#name_record_type").val();
  $(".dd_filter_name_record_sub." + name_record_type).show();
});

$("#name_type").change(function () {
  $(".dd_filter_name_sub").hide();
  let name_type = $("#name_type").val();
  $(".dd_filter_name_sub." + name_type).show();
});

$(".dd_filter_name_record_sub").eq(0).show();
$(".dd_filter_name_sub").eq(0).show();
