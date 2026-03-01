$(function () {
  "use strict";
  //Hide placeholder On focus
  $("[placeholder]")
    .focus(function () {
      $(this).attr("data-text", $(this).attr("placeholder"));
      $(this).attr("placeholder", "");
    })
    .blur(function () {
      $(this).attr("placeholder", $(this).attr("data-text"));
    });
});
// Add asckrisk to the requred input
$("input").each(function () {
  if ($(this).attr("required") == "required") {
    $(this).after(
      "<span class='asckrisk' title='Theis A required Form'>*</span>"
    );
  }
});
// Show Password in hover
var passField = $(".password");
$(".show-pass").hover(
  function () {
    passField.attr("type", "text");
  },
  function () {
    passField.attr("type", "password");
  }
);
// Confirme
$(".confirm").click(function () {
  return confirm("Are you Sure To Deleted !!");
});
//Category view Opsion
$(".cat h4").click(function () {
  $(this).next(".full-view").fadeToggle();
})
$(".order span").click(function (){
  $(this).addClass("active").siblings("span").removeClass("active");
  if($(this).data('view') === 'classic'){
    $(".full-view").fadeOut(200);
  }else{
    $(".full-view").fadeIn(200);
  }
})
//dashbord
$(".toggle-info").click(function(){
  $(this).toggleClass("selected").parent().next(".panel-body").fadeToggle();
  if($(this).hasClass("selected")){
    $(this).html("<i class='fa fa-minus'></i>");

  }else{
    $(this).html("<i class='fa fa-plus'></i>");
  }
})