$("#rejestr").click(function() { // Jeżeli kliknę w znacznik o id "rejestr", wtedy wykona się function, który sprawi, że zniknie płynnie ekran logowania i przeniesie na wierzch ekran rejestracji
	$("#content").fadeOut(100);
	setTimeout('$("#contentv2").css("z-index","2")',100);
})
$("#zalog").click(function() {
	$("#contentv2").css("z-index","-1");
	$("#content").fadeIn(100);
})