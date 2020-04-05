(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

$(".show_info_test").bind("click",function(){
	if ($("#show_test_info").is(":hidden")) {
		$("#show_test_info").fadeIn(500);
	} 
	else {
		$("#show_test_info").hide();
	}
});
$(".fillter-test").find(".on").click(function(){
    $(this).siblings('.on').removeClass('active');
    if(!$(this).hasClass("active")){
        $(this).addClass("active");
        $("body").addClass("open");
    }
    else{
        $(this).removeClass("active");
        $("body").removeClass("open");
    }      
});
function cal_main_height() {
	var docHeight = $(window).height();
	var header_height = $(".listening-test_head").height();
	var main_height = docHeight - header_height;
	$(".scrollbar-inner").height(main_height);

}
function question_update_answer(position,value) {
  //console.log(position,value);
  if (value) {
    $(".answer_recheck_item_" + position).addClass("-done").removeClass("-not-done-yet");
  }
  else {
    $(".answer_recheck_item_" + position).removeClass("-done").addClass("-not-done-yet");
  }
}