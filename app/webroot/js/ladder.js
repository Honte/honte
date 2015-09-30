$(document).ready(function() { 

    $("#ladder_table .photo a").lightBox({
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


