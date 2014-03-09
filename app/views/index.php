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
				<h1>Компании</h1>
			</div>
			<div class="container">
				{{outlet}}
			</div>
		</script>

		<script type="text/x-handlebars" id="index">
				<div class="row">
					<div class="col-md-3">
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
		<!--script src="js/libs/bootstrap.js"></script-->
		<script src="js/app.js"></script>
	</body>
</html>
