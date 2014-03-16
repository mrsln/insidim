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

App.ApplicationRoute = Ember.Route.extend({
	setupController: function (controller, model){
		controller.set('auth', model['auth']);
		controller.set('email', model['email']);
	},
	model: function() {
		var me = this;
		return Ember.$.getJSON('/api/user').then(function(data) {
			me.set('auth', data['auth']);
			me.set('email', data['email']);
			return data;
		});
	}
});

App.ApplicationController = Ember.Controller.extend({
	actions: {
		'reg': function() {
			var me = this;
			Ember.$.post("/api/user", this.getProperties("email", "password")).then(function(data) {
				me.send('login');
			});
		}, 
		'login': function() {
			var me = this;
			Ember.$.post("/api/user/auth", this.getProperties("email", "password")).then(function(data) {
				me.set('auth', data['auth']);
				if (data['auth']) {
					me.set('email', data['email']);
					$('.login-form').modal('hide');
				}
			});
		},
		'logout': function() {
			this.set('auth', false);
			this.set('email', '');
			return Ember.$.getJSON('/api/user/logout').then(function(data) {});
		}
	}
});

App.CompanyRoute = Ember.Route.extend({
	model: function(params) {
		return Ember.$.getJSON('/api/company/' + params.companyId).then(function(data) {
			var totalCount = 0;
			data['characteristics'].forEach(function(ch) {
				totalCount += ~~ch['count'];
			});
			data['characteristics'].forEach(function(ch) {
				ch['wp'] = 'width: ' + ((ch['count'] / totalCount).toFixed(2)*100) + '%';
			});
			return data;
		});
	}
});

App.CompanyController = Ember.ObjectController.extend({
	isEditing: false,
	isAddingTag: false,

	actions: {
		percentCalc: function() {
			var totalCount = 0;
			this.get('characteristics').forEach(function(ch) {
				totalCount += ~~ch['count'];
			});
			this.get('characteristics').forEach(function(ch) {
				Ember.set(ch, 'wp', 'width: ' + ((ch['count'] / totalCount).toFixed(2)*100) + '%');
			});
		},
		vote: function(ccid) {
			var me = this;
			function setCount(count) {
				me.get('characteristics').forEach(function(ch) {
					if (Ember.get(ch, 'ccid') == ccid)
						Ember.set(ch, 'count', ~~ch.count + ~~count);
				});
				me.send('percentCalc');
			}

			// увеличение количества голосов на экране до изменения в базе
			setCount(1);

			Ember.$.post('/api/company/vote', {'ccid': ccid}).then(function(count) {
				if (count.hasOwnProperty('error')) {
					var msg = {
						'duplicate': 'Вы уже голосовали',
						'auth': 'Необходимо авторизоваться'
					};
					var obj = Ember.Object.create({message: msg[count['error']]});
					App.flashController.pushObject(obj);
					setTimeout(function() {
							App.flashController.removeObject(obj);
						}, 2000);
					setCount(-1);
				}
			}, function() {
				setCount(-1);
			});
		}
	},
	addTag: function() {
		this.set('isAddingTag', true);
	},
	saveTag: function() {
		this.set('isAddingTag', false);
		var tagName = this.get('newTagName');
		var companyId = this.get('companyId');
		console.log(companyId);
		var tag = Ember.Object.create({'name': tagName, 'count': 1, 'wp': 'width: 30%'});
		this.get('characteristics').pushObject(tag);
		this.send('percentCalc');
		var me = this;

		Ember.$.post('/api/company/addTag', {'name': tagName, 'companyId': companyId}).then(function(count) {
			if (count.hasOwnProperty('error')) {
				var msg = {
					'duplicate': 'Такой тег уже существует',
					'auth': 'Необходимо авторизоваться'
				};
				var obj = Ember.Object.create({message: msg[count['error']]});
				App.flashController.pushObject(obj);
				setTimeout(function() {
						App.flashController.removeObject(obj);
					}, 2000);
				me.get('characteristics').removeObject(tag);
				me.send('percentCalc');
			}
		}, function() {
			me.get('characteristics').removeObject(tag);
			me.send('percentCalc');
		});
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
