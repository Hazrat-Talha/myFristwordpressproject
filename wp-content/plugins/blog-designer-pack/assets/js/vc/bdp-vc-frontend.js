(function ( $ ) { 

	window.InlineShortcodeView_vc_column_text = window.InlineShortcodeView.extend({
		render: function () {
			var model_id = this.model.get( 'id' );
			window.InlineShortcodeView_vc_column_text.__super__.render.call( this );
			vc.frame_window.vc_iframe.addActivity( function () {
				this.bdp_init_post_slider();
				this.bdp_init_post_carousel();
				this.bdp_init_post_hticker();
				this.bdp_init_post_masonry();
			});
			return this;
		}
	});
	
	window.InlineShortcodeView_vc_raw_html = window.InlineShortcodeView.extend({
		render: function () {
			var model_id = this.model.get( 'id' );
			window.InlineShortcodeView_vc_raw_html.__super__.render.call( this );
			vc.frame_window.vc_iframe.addActivity( function () {
				this.bdp_init_post_slider();
				this.bdp_init_post_carousel();
				this.bdp_init_post_hticker();
				this.bdp_init_post_masonry();
			});
			return this;
		}
	});

})( window.jQuery );