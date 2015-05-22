;( function( window ) {
	
	'use strict';

	var transEndEventNames = {
			'WebkitTransition': 'webkitTransitionEnd',
			'MozTransition': 'transitionend',
			'OTransition': 'oTransitionEnd',
			'msTransition': 'MSTransitionEnd',
			'transition': 'transitionend'
		},
		transEndEventName = transEndEventNames[ Modernizr.prefixed( 'transition' ) ],
		support = { transitions : Modernizr.csstransitions };

	function extend( a, b ) {
		for( var key in b ) { 
			if( b.hasOwnProperty( key ) ) {
				a[key] = b[key];
			}
		}
		return a;
	}

	function SVGEl( el ) {
		this.el = el;
		this.paths = [].slice.call( this.el.querySelectorAll( 'path' ) );
		this.pathsArr = new Array();
		this.lengthsArr = new Array();
		this._init();
	}

	SVGEl.prototype._init = function() {
		var self = this;
		this.paths.forEach( function( path, i ) {
			self.pathsArr[i] = path;
			path.style.strokeDasharray = self.lengthsArr[i] = path.getTotalLength();
		} );
		this.draw(0);
	}

	SVGEl.prototype.draw = function( val ) {
		for( var i = 0, len = this.pathsArr.length; i < len; ++i ){
			this.pathsArr[ i ].style.strokeDashoffset = this.lengthsArr[ i ] * ( 1 - val );
		}
	}

	function UIProgressButton( el, options ) {
		this.el = el;
		this.options = extend( {}, this.options );
		extend( this.options, options );
		this._init();
	}

	UIProgressButton.prototype.options = {
		statusTime : 1500
	}

	UIProgressButton.prototype._init = function() {
		this.button = this.el.querySelector( 'button' );
		this.progressEl = new SVGEl( this.el.querySelector( 'svg.progress-circle' ) );
		this.successEl = new SVGEl( this.el.querySelector( 'svg.checkmark' ) );
		this.errorEl = new SVGEl( this.el.querySelector( 'svg.cross' ) );
		this._initEvents();
		this._enable();
	}

	UIProgressButton.prototype._initEvents = function() {
		var self = this;
		this.button.addEventListener( 'click', function() { self._submit(); } );
	}

	UIProgressButton.prototype._submit = function() {
		classie.addClass( this.el, 'loading' );
		
		var self = this,
			onEndBtnTransitionFn = function( ev ) {
				if( support.transitions ) {
					if( ev.propertyName !== 'width' ) return false;
					this.removeEventListener( transEndEventName, onEndBtnTransitionFn );
				}
				
				this.setAttribute( 'disabled', '' );

				if( typeof self.options.callback === 'function' ) {
					self.options.callback( self );
				}
				else {
					self.setProgress(1);
					self.stop();
				}
			};

		if( support.transitions ) {
			this.button.addEventListener( transEndEventName, onEndBtnTransitionFn );
		}
		else {
			onEndBtnTransitionFn();
		}
	}

	UIProgressButton.prototype.stop = function( status ) {
		var self = this,
			endLoading = function() {
				self.progressEl.draw(0);
				
				if( typeof status === 'number' ) {
					var statusClass = status >= 0 ? 'success' : 'error',
						statusEl = status >=0 ? self.successEl : self.errorEl;

					statusEl.draw( 1 );
					classie.addClass( self.el, statusClass );
					setTimeout( function() {
						classie.remove( self.el, statusClass );
						statusEl.draw(0);
						self._enable();
					}, self.options.statusTime );
				}
				else {
					self._enable();
				}
				classie.removeClass( self.el, 'loading' );
			};

		setTimeout( endLoading, 300 );
	}

	UIProgressButton.prototype.setProgress = function( val ) {
		this.progressEl.draw( val );
	}

	UIProgressButton.prototype._enable = function() {
		this.button.removeAttribute( 'disabled' );
	}

	window.UIProgressButton = UIProgressButton;

})( window );