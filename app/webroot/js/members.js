$(document).ready(function() {

	$("#membersList li").hover(function() {
		$(this).find(".member-details").stop().animate({
			marginTop: '-90px',
			height: '126px'
		}, 500);

	}, function() {
		$(this).find(".member-details").stop().animate({
			marginTop: 0,
			height: '36px'
		}, 500);
	});

//    $(".notactive").css("display", "none");
//    $(".membernav").append('&nbsp;&nbsp|&nbsp;&nbsp;<a class="toggle" href="#">pokaż/ukryj nieaktywnych i byłych</a>');
//    $("a.toggle").click(function() {
//        $(".notactive").toggle();
//        return false;
//    });
//
//    $(".photo a").lightBox({
//		// overlayBgColor: '#FFF',
//		// overlayOpacity: 0.6,
//		imageLoading: getRoot('img/lightbox-ico-loading.gif'),
//		imageBtnClose: getRoot('img/lightbox-btn-close.gif'),
//		imageBtnPrev: getRoot('img/lightbox-btn-prev.gif'),
//		imageBtnNext: getRoot('img/lightbox-btn-next.gif'),
//		// containerResizeSpeed: 350,
//		txtImage: 'Zdjęcie',
//		txtOf: 'z'
//	});

});