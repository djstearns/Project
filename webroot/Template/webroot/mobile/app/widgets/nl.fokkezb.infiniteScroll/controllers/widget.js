var args = arguments[0] || {};

var options = {
	msgTap: L('isTap', 'Tap to load more...'),
	msgDone: L('isDone', 'No more to load...'),
	msgError: L('isError', 'Tap to try again...')
};

var loading = false,
	position = null,
	currentState = 1;

init();

function init() {

	// delete special args
	delete args.__parentSymbol;
	delete args.__itemTemplate;
	delete args.$model;

	// set args as options
	setOptions(args);

	// set default text & remove indicator
	$.isText.text = options.msgTap;
	$.isCenter.remove($.isIndicator);

	// listen to scroll
	__parentSymbol.addEventListener('scroll', onScroll);

	return;
}

function state(_state, _message) {

	// remove indicator
	$.isIndicator.hide();
	$.isCenter.remove($.isIndicator);

	// set state
	if (_state === 0 || _state === false || _state === -1 || _state === 1 || _state === true) {
		currentState = _state;
	} else {
		throw Error('Pass a valid state');
	}

	// set message
	_updateMessage(_message);

	// add text
	$.isCenter.add($.isText);
	$.isText.show(); // so it can be hidden on init via TSS

	// small time-out to prevent scroll-load-state loop with fast syncs
	setTimeout(function () {
		loading = false;
	}, 25);

	return true;
}

function load() {

	if (loading) {
		return false;
	}

	loading = true;

	// remove text
	$.isCenter.remove($.isText);

	// add indicator
	$.isCenter.add($.isIndicator);
	$.isIndicator.show();

	// trigger listener to load
	$.trigger('end', {
		success: function(msg) {
			return state(exports.SUCCESS, msg);
		},
		error: function(msg) {
			return state(exports.ERROR, msg);
		},
		done: function(msg) {
			return state(exports.DONE, msg);
		},
	});

	return true;
}

function onScroll(e) {
	var triggerLoad;

	if (OS_ANDROID) {

		// last item shown
		triggerLoad = (position && e.firstVisibleItem > position && e.totalItemCount <= (e.firstVisibleItem + e.visibleItemCount));

		// remember position
		position = e.firstVisibleItem;

	} else if (OS_IOS) {

		// last pixel shown
		triggerLoad = (position && e.contentOffset.y > position) && (e.contentOffset.y + e.size.height > e.contentSize.height);

		// remember position
		position = e.contentOffset.y;
	}

	// trigger
	if (triggerLoad) {
		load();
	}

	return;
}

function dettach() {

	// set as done
	state(exports.DONE);

	// remove listener
	__parentSymbol.removeEventListener('scroll', onScroll);

	return;
}

function setOptions(_options) {
	_.extend(options, _options);

	_updateMessage();
}

function _updateMessage(_message) {

	if (_message) {
		$.isText.text = _message;

	} else {

		if (currentState === 0 || currentState === false) {
			$.isText.text = options.msgError;
		} else if (currentState === -1) {
			$.isText.text = options.msgDone;
		} else {
			$.isText.text = options.msgTap;
		}
	}
}

exports.SUCCESS = 1;
exports.ERROR = 0;
exports.DONE = -1;

exports.setOptions = setOptions;
exports.load = load;
exports.state = state;
exports.dettach = dettach;