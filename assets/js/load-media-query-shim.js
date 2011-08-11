/**
Workaround: load CSS3 Media Queries shim if IE8, since current build crashes IE8
@see https://github.com/scottjehl/Respond/issues/27

Load respond.js for everyone else.
In future, lets remove this, once respond.js gets it's act together.
 */
;(function(window, M, CFCP) {
	var url = CFCP.scriptsDirUrl,
		nav = window.navigator;

	M.load({
		test: (nav.appName === 'Microsoft Internet Explorer' && nav.appVersion.search('MSIE 8.0') > 0),
		yep:  url + 'css3-media-queries.min.js',
		nope: url + 'respond.min.js'
	});
})(window, Modernizr, CFCP);