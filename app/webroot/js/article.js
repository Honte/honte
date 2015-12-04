$(document).ready(function() {

    // dirty hack to disable lightbox when using on too small device and styles for phones are applied
    // don't do such hacks in future
    if ($('body').width() < 770) {
        return;
    }

	$('.article-gallery').find('a').lightBox({
		// overlayBgColor: '#FFF',
		// overlayOpacity: 0.6,
		imageLoading: getRoot('img/lightbox-ico-loading.gif'),
		imageBtnClose: getRoot('img/lightbox-btn-close.gif'),
		imageBtnPrev: getRoot('img/lightbox-btn-prev.gif'),
		imageBtnNext: getRoot('img/lightbox-btn-next.gif'),
		// containerResizeSpeed: 350,
		txtImage: 'Zdjęcie',
		txtOf: 'z'
	});
	
});