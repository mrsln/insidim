App = Ember.Application.create();

App.Router.map(function() {
	this.resource('index', {path: '/'}, function() {
		this.resource('company', { path: '/company/:companyId' });
	});
});

App.IndexRoute = Ember.Route.extend({
  model: function() {
    return Ember.$.getJSON('/api/company').then(function(data) {
      return data;
    });
  }
});

App.CompanyRoute = Ember.Route.extend({
  model: function(params) {
    return Ember.$.getJSON('/api/company/' + params.companyId).then(function(data) {
      return data;
    });
  }
});

App.CompanyController = Ember.ObjectController.extend({
  isEditing: false,

  actions: {
    vote: function(e) {
      console.log('Нам важно ваше мнение (как бы)');
    }
  }
});