function setAttribute(e,t,r,s){if(r){$(e).removeAttr(t)}else{$(e).attr(t,s)}}$(document).ready(function(e){var t=[],r=e("#prf-enduser-state-selector #prf-enduser-state"),s=e("#prf-enduser-state-selector .mandatory");e("#prf-enduser-state-selector #prf-enduser-state option").each(function(){if(e(this).val()){t.push({label:e(this).html(),value:e(this).val(),country:e(this).data("country")})}});function i(){s.hide();r.html("");r.attr("disabled","disabled")}function a(){e(".tx-project-registration").parsley()}e("#prf-enduser-country-selector #prf-enduser-country").on("change",function(){var o=e(this).val();i();e.each(t,function(){if(this.country==o){r.append('<option value="'+this.value+'">'+this.label+"</option>")}});if(e("#prf-enduser-state-selector #prf-enduser-state option").length){s.show();r.prepend('<option value="" selected="selected"></option>');r.attr("required","required");r.attr("data-parsley-required","true");r.removeAttr("disabled")}else{r.prepend('<option value="0" selected="selected"></option>');r.removeAttr("required");r.removeAttr("data-parsley-required")}a()});e("select#prf-product").on("change",function(){e(".prf-property-selector").each(function(){e(this).hide();if(e(this).hasClass("prf-form-type-radio")){setAttribute("#"+e(this).attr("id")+' input[type="radio"]',"required",true,"")}if(e(this).hasClass("prf-form-type-select")){setAttribute("#"+e(this).attr("id")+" select","required",true,"")}});var t=e(this).children("option:selected");if(t.length===1&&t.first().data("properties")){var r=t.first().data("properties"),s=[];if(r.indexOf(",")!==-1){s=r.split(",")}else{s.push(r)}e.each(s,function(t,r){var s=e(r);s.show();if(s.hasClass("prf-form-type-radio")){setAttribute(r+' input[type="radio"]',"required",false,"required")}if(s.hasClass("prf-form-type-select")){setAttribute(r+" select","required",false,"required")}})}});i();a()});