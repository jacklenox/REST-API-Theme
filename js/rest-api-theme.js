jQuery(document).ready(function($) {

	var app = app || {};
	var templateUrl = script_data.templateUrl;

	console.log( rest_api_theme_data.ajaxurl );

	$(document).delegate("a", "click", function(evt) {
		// Get the anchor href and protcol
		var href = $(this).attr("href");
		var protocol = this.protocol + "//";
		var pathname = this.pathname;

		// Ensure the protocol is not part of URL, meaning its relative.
		// Stop the event bubbling to ensure the link will not cause a page refresh.
		if (href.slice(protocol.length) !== protocol) {
			evt.preventDefault();

			// Note by using Backbone.history.navigate, router events will not be
			// triggered.  If this is a problem, change this to navigate on your
			// router.
			app.router.navigate( pathname, true );
		}
	});

	var Post = Backbone.Model.extend({
		defaults: {
			'the-loop': ''
		},
		parse: function(response) {
			var data = response;
			var innerWrapper = [];
			innerWrapper.push(data);

			var wrapper = {};
			wrapper['the-loop'] = innerWrapper;

			return wrapper;
		}
	});

	app.post = new Post();

	var View = Backbone.View.extend({
		events: {
			'click a' : "getPost"
		},

		initialize: function() {
			this.model.on('change', this.render);
		},

		el: $('#content'),

		getPost: function (event) {
			event.preventDefault();
			
			var pathname = event.target.pathname;

			app.router.navigate( pathname, { trigger: true } );
		},

		render: function() {
			$.get( templateUrl + '/views/index.mustache', function ( html ) {
				$('#content').html(Mustache.render(html, app.post.toJSON()));
			});
		},
	});

	app.view = new View({ model: app.post });

	var Router = Backbone.Router.extend({
		routes: {
			'*url': 'getPost'
		},

		getPost: function ( url ) {
			jQuery.post(
				rest_api_theme_data.ajaxurl,
				{
					'action': 'get_post_id',
					'data': url
				},
				function ( response ) {
					console.log('The server responded: ' + response.data);
					id = response.data;
					app.post.url = '/wp-json/posts/' + id;
					app.post.fetch({
						reset: true,
						success: function() {
							// Tada, model gets updated and re-render occurs automatically
						}
					});
				}
			);
		}
	});

	app.router = new Router();

	Backbone.history.start({
		pushState: true,
	});

});