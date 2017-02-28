function Gallery(container, opts) {
	opts = opts || {};

	var prev = container.querySelector('.' + opts.nextClass);
	var next = container.querySelector('.' + opts.prevClass);

	var first_item = container.querySelector('.' + opts.itemClass + ':first-child');
	var last_item = container.querySelector('.' + opts.itemClass + ':last-child');

	var current_item = container.querySelector('.' + opts.currentItemClass);
	if (!current_item) {
		current_item = first_item;
		current_item.classList.add(opts.currentItemClass);
	}

	function goPrev() {
		var current_item = container.querySelector('.' + opts.currentItemClass);
		if (current_item) {
			var next_item = current_item.nextElementSibling || first_item;
			if (next_item) {
				current_item.classList.remove(opts.currentItemClass);
				next_item.classList.add(opts.currentItemClass);
			}
		}
	}

	function goNext() {
		var current_item = container.querySelector('.' + opts.currentItemClass);
		if (current_item) {
			var prev_item = current_item.previousElementSibling || last_item;
			if (prev_item) {
				current_item.classList.remove(opts.currentItemClass);
				prev_item.classList.add(opts.currentItemClass);
			}
		}
	}

	next.addEventListener('mousedown', function(e) {
		goNext();
		e.stopPropagation();
		e.preventDefault();
	}, false);

	prev.addEventListener('mousedown', function(e) {
		goPrev();
		e.stopPropagation();
		e.preventDefault();
	}, false);

	if (opts.keyNavigation) {
		document.addEventListener('keydown', function(e) {
			var key = e.which || e.keyCode;
			// left
			if (key ===  37) {
				goPrev();
			}
			// right 
			else if (key === 39) {
				goNext();
			}
		});
	}
}

var galleries = [].slice.call(document.querySelectorAll('.gallery'));
galleries.forEach(function(container) {
	Gallery(container, {
		nextClass: 'gallery__nav--next',
		prevClass: 'gallery__nav--prev',
		itemClass: 'gallery__item',
		currentItemClass: 'gallery__item--current',
		keyNavigation: galleries.length === 1
	});
});