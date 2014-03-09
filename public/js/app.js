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
			var totalCount = 0;
			data['characteristic'].forEach(function(ch) {
				totalCount += ~~ch['count'];
			});
			data['characteristic'].forEach(function(ch) {
				ch['wp'] = 'width: ' + ((ch['count'] / totalCount).toFixed(2)*100) + '%';
			});
			console.log(JSON.stringify(data));
			return data;
		});
	}
});

App.CompanyController = Ember.ObjectController.extend({
	isEditing: false,

	actions: {
		vote: function(ccid) {
			var me = this;

			function percentCalc(model) {
				var totalCount = 0;
				me.get('characteristic').forEach(function(ch) {
					totalCount += ~~ch['count'];
				});
				me.get('characteristic').forEach(function(ch) {
					Ember.set(ch, 'wp', 'width: ' + ((ch['count'] / totalCount).toFixed(2)*100) + '%');
				});
			}
			function setCount(count) {
				me.get('characteristic').forEach(function(ch) {
					if (Ember.get(ch, 'ccid') == ccid)
						Ember.set(ch, 'count', ~~ch.count + ~~count);
				});
				percentCalc(me);
			}

			// увеличение количества голосов на экране до изменения в базе
			setCount(1);

			Ember.$.post('/api/company/vote', {'ccid': ccid}).then(function(count) {
				if (count.hasOwnProperty('error')) {
					var obj = Ember.Object.create({message: "Вы уже голосовали!"});
					App.flashController.pushObject(obj);
					setTimeout(function() {
							App.flashController.removeObject(obj);
						}, 2000);
				}
				setCount(-1);
			});
		}
	}
});

App.FlashController = Ember.ArrayController.extend();
App.flashController = App.FlashController.create({content: Ember.A()});
App.FlashListView = Ember.CollectionView.extend({
	itemViewClass: "App.AlertView",
	contentBinding: "App.flashController"
});
App.AlertView = Ember.View.extend({
	templateName: "_alert",
	tagName: "div",
	classNameBindings: ["defaultClass", "kind"],
	defaultClass: "alert-box",
	kind: null,
	click: function(){
		this.$().fadeOut(300, function(){ this.remove();});
	},
	didInsertElement: function(){
			this.$().hide().fadeIn(300);
			var me = this;
			setTimeout(function() {
					if (me.$() != void(0))
					 me.$().fadeOut(300, function(){ me.remove();});
				}, 2000);
	}
});
