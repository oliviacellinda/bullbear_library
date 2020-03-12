(function() {
	let pdfInstance = null;
	let currentPage = 0;
	let totalPage = 0;
	let currentScale = 1;

	const viewport = document.querySelector('#viewport');

	window.initPDFViewer = function(pdfData) {
		pdfjsLib.getDocument({data: pdfData}).then(pdf => {
			pdfInstance = pdf;
			totalPage = pdf.numPages;
			initPager();
			initScale();
			render();
		});
	};

	function render() {
		pdfInstance.getPage(currentPage + 1).then(page => {
			viewport.innerHTML = '<div><canvas></canvas></div>';
			renderPage(page, currentScale);
		});
	}

	function renderPage(page, scale) { console.log(scale);
		let pdfViewport = page.getViewport({scale: scale});
		const container = viewport.children[0];
		const canvas = container.children[0];
		const context = canvas.getContext("2d");
		canvas.height = pdfViewport.height;
		canvas.width = pdfViewport.width;

		page.render({
		    canvasContext: context,
		    viewport: pdfViewport
		});
	}

	function initPager() {
		const pager = document.querySelector('#pager');
		pager.addEventListener('click', onChangePage);
	}

	function initScale() {
		const scale = document.querySelector('#scale');
		scale.addEventListener('click', onChangeScale);
	}

	function onChangePage(event) {
		const action = event.target.getAttribute('data-pager');
		if(action === 'prev') {
			if(currentPage === 0) {
				return;
			}
			currentPage -= 1;
			if(currentPage < 0) {
				currentPage = 0;
			}
			render();
		}
		if(action === 'next') {
			if(currentPage === totalPage - 1) {
				return;
			}
			currentPage += 1;
			if(currentPage > totalPage - 1) {
				currentPage = totalPage - 1;
			}
			render();
		}
	}

	function onChangeScale(event) {
		const action = event.target.getAttribute('data-scale');
		if(action === 'minus') {
			if(currentScale === 1) {
				return;
			}
			currentScale -= 0.5;
			if(currentScale < 1) {
				currentScale = 1;
			}
			render();
		}
		if(action === 'plus') {
			if(currentScale === 5) {
				return;
			}
			currentScale += 0.5;
			if(currentScale > 5) {
				currentScale = 5;
			}
			render();
		}
	}
})();