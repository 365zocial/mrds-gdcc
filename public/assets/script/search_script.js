$("#taxa_chkbox").change(function () {
  hideSubmit();

  if (this.checked) {
    $(".taxa_select").show();
    $("#taxa_id").attr("required", "true");
    $(".submit_select").show();
    $(".hr_search").show();
  } else {
    $(".taxa_select").hide();
    $("#taxa_header_id").val($("#taxa_header_id option:first").val());
    $("#domain").val($("#domain option:first").val());
    $("#kingdom").val($("#kingdom option:first").val());
    $("#phylum").val($("#phylum option:first").val());
    $("#subphylum").val($("#subphylum option:first").val());
    $("#class").val($("#class option:first").val());
    $("#order").val($("#order option:first").val());
    $("#suborder").val($("#suborder option:first").val());
    $("#infraorder").val($("#infraorder option:first").val());
    $("#superfamily").val($("#superfamily option:first").val());
    $("#family").val($("#family option:first").val());
    $("#genus").val($("#genus option:first").val());
    $("#species").val($("#species option:first").val());
    $("#classification").val($("#classification option:first").val()); // (ชื่อวิทยาศาสตร์)
  }
});

$("#local_chkbox").change(function () {
  hideSubmit();

  if (this.checked) {
    $(".local_select").show();
    $("#country").attr("required", "true");
    $(".submit_select").show();
    $(".hr_search").show();
  } else {
    $(".local_select").hide();
    $("#dd_locality").val($("#dd_locality option:first").val());
    $("#locality_country").val($("#locality_country option:first").val());
    $("#locality_province").val($("#locality_province option:first").val());
    $("#locality_district").val($("#locality_district option:first").val());
    $("#locality_county").val($("#locality_county option:first").val());
  }
});

$("#expan_chkbox").change(function () {
  hideSubmit();

  if (this.checked) {
    $(".expan_select").show();
    $("#expan_id").attr("required", "true");
    $(".submit_select").show();
    $(".hr_search").show();
  } else {
    $(".expan_select").hide();
    $("#expan_id").val($("#expan_id option:first").val());
  }
});

$("#marinecenter_chkbox").change(function () {
  hideSubmit();
  if (this.checked) {
    $(".marinecenter_select").show();
    $("#marinecenter_id").attr("required", "true");
    $(".submit_select").show();
    $(".hr_search").show();
  } else {
    $(".marinecenter_select").hide();
    $("#marinecenter_id").val($("#marinecenter_id option:first").val());
  }
});

function hideSubmit() {
  // console.log( $('#expan_chkbox').is(":checked") );
  if (
    !$("#expan_chkbox").is(":checked") &&
    !$("#local_chkbox").is(":checked") &&
    !$("#taxa_chkbox").is(":checked")
  ) {
    $(".submit_select").hide();
    $(".hr_search").hide();
  }
}

$("#dd_locality").change(function () {
  $(".dd_locality_sub").hide();
  if ($(this).val() == "country") {
    $(".dd_locality_sub").eq(1).show();
  } else if ($(this).val() == "province") {
    $(".dd_locality_sub").eq(2).show();
  } else if ($(this).val() == "district") {
    $(".dd_locality_sub").eq(3).show();
  } else if ($(this).val() == "county") {
    $(".dd_locality_sub").eq(4).show();
  }
});

$(".dd_taxa_sub").eq(0).show();
$("#taxa_header_id").change(function () {
  $(".dd_taxa_sub").hide();
  if ($(this).val() == "domain") {
    $(".dd_taxa_sub").eq(1).show();
  }
  if ($(this).val() == "kingdom") {
    $(".dd_taxa_sub").eq(2).show();
  }
  if ($(this).val() == "phylum") {
    $(".dd_taxa_sub").eq(3).show();
  }
  if ($(this).val() == "subphylum") {
    $(".dd_taxa_sub").eq(4).show();
  }
  if ($(this).val() == "class") {
    $(".dd_taxa_sub").eq(5).show();
  }
  if ($(this).val() == "order") {
    $(".dd_taxa_sub").eq(6).show();
  }
  if ($(this).val() == "suborder") {
    $(".dd_taxa_sub").eq(7).show();
  }
  if ($(this).val() == "infraorder") {
    $(".dd_taxa_sub").eq(8).show();
  }
  if ($(this).val() == "superfamily") {
    $(".dd_taxa_sub").eq(9).show();
  }
  if ($(this).val() == "family") {
    $(".dd_taxa_sub").eq(10).show();
  }
  if ($(this).val() == "genus") {
    $(".dd_taxa_sub").eq(11).show();
  }
  if ($(this).val() == "species") {
    $(".dd_taxa_sub").eq(12).show();
  }
  if ($(this).val() == "classification") {
    $(".dd_taxa_sub").eq(13).show();
  }
});

checkBeforeSubmit();

function checkBeforeSubmit() {
  $("#form").submit(function (e) {
    var can_submit = true;
    var select_tag;
    e.preventDefault();
    e.returnValue = false;

    if ($("#taxa_chkbox").is(":checked")) {
      if ($("#taxa_header_id").val() == null) {
        can_submit = false;
        select_tag = $("#taxa_header_id");
      } else {
        var taxa_h = $("#taxa_header_id").val();
        if (
          taxa_h == "domain" &&
          $(".dd_taxa_sub").eq(1).children().val() == 0
        ) {
          can_submit = false;
          select_tag = $(".dd_taxa_sub").eq(1).children();
        }
        if (
          taxa_h == "kingdom" &&
          $(".dd_taxa_sub").eq(2).children().val() == 0
        ) {
          can_submit = false;
          select_tag = $(".dd_taxa_sub").eq(2).children();
        }
        if (
          taxa_h == "phylum" &&
          $(".dd_taxa_sub").eq(3).children().val() == 0
        ) {
          can_submit = false;
          select_tag = $(".dd_taxa_sub").eq(3).children();
        }
        if (
          taxa_h == "subphylum" &&
          $(".dd_taxa_sub").eq(4).children().val() == 0
        ) {
          can_submit = false;
          select_tag = $(".dd_taxa_sub").eq(4).children();
        }
        if (
          taxa_h == "class" &&
          $(".dd_taxa_sub").eq(5).children().val() == 0
        ) {
          can_submit = false;
          select_tag = $(".dd_taxa_sub").eq(5).children();
        }
        if (
          taxa_h == "order" &&
          $(".dd_taxa_sub").eq(6).children().val() == 0
        ) {
          can_submit = false;
          select_tag = $(".dd_taxa_sub").eq(6).children();
        }
        if (
          taxa_h == "suborder" &&
          $(".dd_taxa_sub").eq(7).children().val() == 0
        ) {
          can_submit = false;
          select_tag = $(".dd_taxa_sub").eq(7).children();
        }
        if (
          taxa_h == "infraorder" &&
          $(".dd_taxa_sub").eq(8).children().val() == 0
        ) {
          can_submit = false;
          select_tag = $(".dd_taxa_sub").eq(8).children();
        }
        if (
          taxa_h == "superfamily" &&
          $(".dd_taxa_sub").eq(9).children().val() == 0
        ) {
          can_submit = false;
          select_tag = $(".dd_taxa_sub").eq(9).children();
        }
        if (
          taxa_h == "family" &&
          $(".dd_taxa_sub").eq(10).children().val() == 0
        ) {
          can_submit = false;
          select_tag = $(".dd_taxa_sub").eq(10).children();
        }
        if (
          taxa_h == "genus" &&
          $(".dd_taxa_sub").eq(11).children().val() == 0
        ) {
          can_submit = false;
          select_tag = $(".dd_taxa_sub").eq(11).children();
        }
        if (
          taxa_h == "species" &&
          $(".dd_taxa_sub").eq(12).children().val() == 0
        ) {
          can_submit = false;
          select_tag = $(".dd_taxa_sub").eq(12).children();
        }
        if (
          taxa_h == "classification" &&
          $(".dd_taxa_sub").eq(13).children().val() == 0
        ) {
          can_submit = false;
          select_tag = $(".dd_taxa_sub").eq(13).children();
        }
      }
    }
    if ($("#local_chkbox").is(":checked")) {
      if ($("#dd_locality").val() != null) {
        if (
          $("#dd_locality").val() == "country" &&
          $("#locality_country option:selected").val() == 0
        ) {
          can_submit = false;
          select_tag = $("#locality_country");
        }
        if (
          $("#dd_locality").val() == "province" &&
          $("#locality_province option:selected").val() == 0
        ) {
          can_submit = false;
          select_tag = $("#locality_province");
        }
        if (
          $("#dd_locality").val() == "district" &&
          $("#locality_district option:selected").val() == 0
        ) {
          can_submit = false;
          select_tag = $("#locality_district");
        }
        if (
          $("#dd_locality").val() == "county" &&
          $("#locality_county option:selected").val() == 0
        ) {
          can_submit = false;
          select_tag = $("#locality_county");
        }
      } else {
        can_submit = false;
        select_tag = $("#dd_locality");
      }
    }
    if ($("#expan_chkbox").is(":checked")) {
      if ($("#expan_id").val() == null) {
        can_submit = false;
        select_tag = $("#expan_id");
      }
    }

    if (can_submit) {
      // alert("send");
      if (useAjax) {
        $(".loader").show();
        getDataAjax();
      } else {
        $("form").off("submit");
        $("form").submit();
      }
    } else {
      // alert("You have to select dropdown for search");
      // console.log(select_tag);
      select_tag.select2("open");
    }
  });
}
