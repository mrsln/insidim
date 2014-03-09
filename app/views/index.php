<!doctype html>
<html>
	<head>
		<title>Отзывы о работадателях</title>
		<meta name="viewport" content="width=device-width">
		<link rel="stylesheet" href="css/style.css"/>
		<link rel="stylesheet" href="css/bootstrap.min.css"/>
	</head>
	<body>
		<script type="text/x-handlebars">
			<div class="insider-alerts">
				{{view App.FlashListView}}
			</div>
			<div class="container">
				<div class="cold-md-3 pull-right">
					{{#if auth}}
						{{email}} (<a href="javascript:void(0)" {{action 'logout'}}>выход</a>)
					{{else}}
						<a href="javascript:void(0)" data-toggle="modal" data-target=".login-form">Вход</a>
					{{/if}}
				</div>
			</div>
			<div class="container">
				{{outlet}}
			</div>

			<div class="modal fade login-form" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-sm">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title" id="mySmallModalLabel">Авторизация</h4>
						</div>
						<div class="modal-body">
							<form role="form" {{action "login" on="submit"}}>
								<div class="form-group">
									{{input type="email" class="form-control" placeholder="Введите email" value=email name="email"}}
								</div>
								<div class="form-group">
									{{input type="password" class="form-control" placeholder="Введите пароль" value=password name="password"}}
								</div>
								<button type="submit" class="btn btn-default">Войти</button>
								<button type="submit" class="btn btn-link btn-reg pull-right" {{action "reg"}}>Зарегистрироваться</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</script>

		<script type="text/x-handlebars" id="index">
			<div class="row">
				<div class="col-md-3">
					<h1 class="company-title">Компании</h1>
					<ul class="list-group list-company">
						 {{#each item in model}}
							{{#link-to 'company' item.id class="list-group-item"}}{{item.name}}{{/link-to}}
						{{/each}}
						{{!<a class="btn btn-block btn-info btn-add-company">Добавить компанию</a>}}
					</ul>
				</div>
				<div class="col-md-9">
					{{outlet}}
				</div>
			</div>
		</script>

		<script type="text/x-handlebars" id="index/index">
			выберите компанию в меню
		</script>

		<script type="text/x-handlebars" id="company">
			<p class="company-name">{{name}}</p>
			<table class="table table-bordered company-facts-table">
				<tbody>
					{{#each facts}}
						<tr>
							<td class="col-md-2">{{name}}</td>
							<td class="col-md-10">{{value}}</td>
						</tr>
					{{/each}}
				</tbody>
			</table>
			<p class="tags-title" style>Популярные эпитеты</p>
			<div class="tags-area">
				{{#each characteristics}}
					<div class="progress progress-striped">
						<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" 
                  {{bind-attr style="wp"}}>
							<span class="sr-only pr-label">{{name}} - {{count}}</span>
							<div class="tag-plus" {{action 'vote' ccid}}>+</div>
						</div>
					</div>
				{{/each}}
			</div>
			{{!<a class="btn-add-tag btn-link">добавить тег</a>}}
		</script>

		<script type="text/x-handlebars" data-template-name="_alert">
			<div class="alert alert-danger alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				 {{view.content.message}}
			</div>
		</script>

		<script src="js/libs/jquery-1.10.2.js"></script>
		<script src="js/libs/handlebars-1.1.2.js"></script>
		<script src="js/libs/ember-1.4.0.js"></script>
		<script src="js/libs/bootstrap.js"></script>
		<script src="js/app.js"></script>
	</body>
</html>
