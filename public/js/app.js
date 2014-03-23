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

App.IndexController = Ember.Controller.extend({
	actions: {
		saveCompany: function() {
			var company = Ember.Object.create({'name': this.get('companyName')});
			this.get('model').pushObject(company);
			var me = this;
			Ember.$.post("/api/company", this.getProperties("companyName")).then(function(data) {
				if (data > 0) {
					company.set('id', data);
					$('.add-company-form').modal('hide');
					me.transitionTo('company', data);
				} else {
					var obj = Ember.Object.create({message: 'Нужно авторизоваться или такая компания уже существует'});
					App.flashController.pushObject(obj);
					setTimeout(function() {
							App.flashController.removeObject(obj);
						}, 2000);
					me.get('model').removeObject(company);
				}
			});
		}
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
	isAddingFact: false,

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
			} else {
				me.set('newTagName', '');
			}
		}, function() {
			me.get('characteristics').removeObject(tag);
			me.send('percentCalc');
		});
	},
	addFact: function() {
		this.set('isAddingFact', true);
	},
	saveFact: function() {
		var newFactName = this.get('newFactName');
		var newFactValue = this.get('newFactValue');
		var companyId = this.get('companyId');
		var me = this;

		me.set('isAddingFact', false);
		var fact = Ember.Object.create({name: newFactName, value: newFactValue});
		me.get('facts').pushObject(fact);

		Ember.$.post('/api/company/addFact', {'name': newFactName, 'value': newFactValue, 'companyId': companyId}).then(function(response) {
			if (response.hasOwnProperty('error')) {
				App.showMessage(response['error']);
				me.get('facts').removeObject(fact);
				me.set('isAddingFact', true);
			} else {
				me.set('newFactName', '');
				me.set('newFactValue', '');
			}
		}, function() {
			App.showMessage('general');
			me.get('facts').removeObject(fact);
			me.set('isAddingFact', true);
		});
	},
	addComment: function() {
		this.set('isAddingComment', true);
	},
	saveComment: function() {

		var comment = this.get('comment');
		var companyId = this.get('companyId');
		var me = this;

		var commentObj = Ember.Object.create({comment: comment, created_at: 'только что', author: '123'});
		me.get('comments').addObject(commentObj);
		me.set('isAddingComment', false);

		Ember.$.post('/api/company/addComment', {comment: comment, 'companyId': companyId}).then(function(response) {
			if (response.hasOwnProperty('error')) {
				App.showMessage(response['error']);
				me.get('comments').removeObject(commentObj);
				me.set('isAddingComment', true);
			} else {
				me.set('comment', '');
			}
		}, function() {
			App.showMessage('general');
			me.get('comments').removeObject(commentObj);
			me.set('isAddingComment', true);
		});
	}
});

App.showMessage = function(error) {
	var msg = {
		'duplicate': 'Такой тег уже существует',
		'auth': 'Необходимо авторизоваться',
		'general': 'Что-то пошло не так. Попробуйте позже.'
	};
	if (!msg.hasOwnProperty(error)) error = 'general';
	var obj = Ember.Object.create({message: msg[error]});
	App.flashController.pushObject(obj);
	setTimeout(function() {
			App.flashController.removeObject(obj);
		}, 2000);
}

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
