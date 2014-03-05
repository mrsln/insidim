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
    vote: function(ccid) {
      var me = this;

      me.get('characteristic').forEach(function(ch) {
        if (ch.characteristicId == ccid)
          Ember.set(Ember.get(ch, 'company_characteristic'), 'count', 1+~~Ember.get(ch, 'company_characteristic').count);
      });

      Ember.$.post('/api/company/vote', {'ccid': ccid}).then(function(count) {
        me.get('characteristic').forEach(function(ch) {
          if (ch.characteristicId == ccid)
            Ember.set(Ember.get(ch, 'company_characteristic'), 'count', count);
        });
      });
    }
  }
});