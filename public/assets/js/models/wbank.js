define([
	'backbone'
], function() {
	
	var Wbank = Backbone.Model.extend({})
		defaults: {},
		url: function() {
			return '/wbank';
		}
	return Wbank;	
});