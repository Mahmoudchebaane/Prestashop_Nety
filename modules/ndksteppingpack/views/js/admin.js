/**
 *  Tous droits réservés NDKDESIGN
 *
 *  @author Hendrik Masson <postmaster@ndk-design.fr>
 *  @copyright Copyright 2013 - 2014 Hendrik Masson
 *  @license   Tous droits réservés
 */

zoneCurrent = 0;
selectionCurrent = null;
valueOfZoneEdited = null;

// Last item is used to save the current zone and
// allow to replace it if user cancel the editing
lastEditedItem = null;

/* functions called by cropping events */

/*
 ** Pointer function do handle event by key released
 */
function handlePressedKey(keyNumber, fct) {
  // KeyDown isn't handled correctly in editing mode
  $(document).keyup(function (event) {
    if (event.keyCode == keyNumber) fct();
  });
}

function afterTextInserted(event, data, formatted) {
  if (data == null) return false;

  // If the element exist, then the user confirm the editing
  // The variable need to be reinitialized to null for the next
  if (lastEditedItem != null) lastEditedItem.remove();
  lastEditedItem = null;

  zoneCurrent++;
  var idProduct = data[1];
  var nameProduct = data[0];
  oldVal = $("#products").val();
  oldValArray = oldVal.split(",");
  console.log(oldValArray);

  if (oldVal == "") separator = "";
  else separator = ",";
  newVal = oldVal + separator + idProduct;
  if ($.inArray(idProduct, oldValArray) == -1) {
    $("#products").val(newVal);
    newRow =
      '<button data-id="' +
      idProduct +
      '" class="btn btn-default prodrow" type="button"><i class="icon-remove"></i>' +
      nameProduct +
      "</button>";
    $(".prodlist").append(newRow);
  }
}

$(".prodrow").live("click", function () {
  idProduct = $(this).attr("data-id");
  oldVal = $("#products").val();
  oldValArray = oldVal.split(",");

  oldValArray.splice($.inArray(idProduct, oldValArray), 1);
  newVal = "";
  console.log(oldValArray);
  for (var i = 0; i < oldValArray.length; i++) {
    if (typeof oldValArray[i] != "undefined") {
      newVal += oldValArray[i] + (i < oldValArray.length - 1 ? "," : "");
    }
  }
  $("#products").val(newVal);
  $(this).remove();
});

$("#type").live("change", function () {
  console.log($(this).val());
  if ($(this).val() == 0) {
    $("#fixed_price").parent().parent().slideUp();
  } else {
    $("#fixed_price").parent().parent().slideDown();
  }
});

function getProdsIds() {
  if ($("#inputAccessories").val() === undefined) return "";
  return $("#inputAccessories").val().replace(/\-/g, ",");
}

$(window).load(function () {
  /* function autocomplete */
  $("#product_autocomplete_input")
    .autocomplete(
      currentIndex +
        "&token=" +
        token +
        "&query_ajax_request&exclude_packs=false&excludeVirtuals=false&action=ajaxGetProducts&ajax=1",
      {
        minChars: 1,
        autoFill: true,
        max: 20,
        matchContains: true,
        mustMatch: true,
        scroll: false,
        //extraParams: {excludeIds : getProdsIds()}
        extraParams: { excludeIds: "9999999" },
      }
    )
    .result(afterTextInserted);

  $("input#products").hide();
});

$(function () {
  $('[name="false_display_categories[]"]').addClass("implode_input");
  setTimeout(function () {
    $(".serialize_input").trigger("change");
    $(".implode_input").trigger("change");
  }, 1500);
});

//évite la modification du POST dans le controller
$(document).on(
  "change",
  "input.serialize_input, select.serialize_input, textarea.serialize_input, .serialize_input input, serialize_input select",
  function () {
    input_name = $(this).attr("name").split("[")[0];
    ndkModifyPost(input_name, "serialize");
  }
);

$(document).on("change", ".implode_input", function () {
  input_name = $(this).attr("name").split("[")[0];
  inputs = $("[name^='" + input_name + "']");
  values = [];
  selected = $(this).val();

  inputs.each(function () {
    if ($(this).is(":checked") || $(this).is(":selected"))
      if (
        $(this).val() != "" &&
        $(this).val() != " " &&
        typeof $(this).val() != "undefined" &&
        $(this).val() != "undefined"
      )
        values.push($(this).val());
  });

  if (Array.isArray(selected)) {
    for (i = 0; i <= selected.length; i++) {
      if (
        selected[i] != "" &&
        selected[i] != " " &&
        typeof selected[i] != "undefined"
      )
        values.push(selected[i]);
    }
  }
  //console.log(values.join(','))
  if ($("[name^='" + input_name.replace("false_", "") + "']").length == 0)
    $("[name^='" + input_name + "']:eq(0)").after(
      '<input type="hidden" class="modified_post" name="' +
        input_name.replace("false_", "") +
        '" />'
    );

  joined = values.join(",");

  $("input[name^='" + input_name.replace("false_", "") + "']").val(joined);
});

function ndkModifyPost(input_name, my_function) {
  values = $("[name^='" + input_name + "']").serializeObject();

  data = JSON.stringify(values);
  reg = new RegExp(input_name, "g");
  data = data.replace(reg, "");
  data = data.replace(/[\][]/g, "");
  //console.log(data)
  //console.log(values)
  if ($("[name^='" + input_name.replace("false_", "") + "']").length == 0)
    $("[name^='" + input_name + "']:eq(0)").after(
      '<input type="hidden" name="' + input_name.replace("false_", "") + '" />'
    );
  if (data.length == 0)
    $("input[name^='" + input_name.replace("false_", "") + "']").val("");
  else $("input[name^='" + input_name.replace("false_", "") + "']").val(data);

  /*$.ajax({
	            type: "POST",
	            url: currentIndex+'&token='+token+'&query_ajax_request&action=modifyPost&function='+my_function+'&ajax=1',
	            data: {values :JSON.stringify( values ), input_name : input_name},
	            success: function(data) {
		            if($("[name^='"+input_name.replace('false_', '')+"']").length == 0)
		            	$("[name^='"+input_name+"']:eq(0)").after('<input type="hidden" name="'+input_name.replace('false_', '')+'" />');
		            if(data.length == 0)
		            $("input[name^='"+input_name.replace('false_', '')+"']").val('');
		            else
		            $("input[name^='"+input_name.replace('false_', '')+"']").val(data)
	           },
	         });*/
}

$.fn.serializeObject = function () {
  var o = {};
  var a = this.serializeArray();
  $.each(a, function () {
    if (o[this.name]) {
      if (!o[this.name].push) {
        o[this.name] = [o[this.name]];
      }
      o[this.name].push(this.value || "");
    } else {
      o[this.name] = this.value || "";
    }
  });
  return o;
};
//fin évite la modification du POST dans le controller
