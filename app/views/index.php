<!doctype html>
<html>
	<head>
		<title>Отзывы о работадателях - Инсайдим</title>
		<meta name="viewport" content="width=device-width">
		<link rel="stylesheet" href="css/style.css"/>
		<link rel="stylesheet" href="css/bootstrap.min.css"/>
		<meta content="отзывы о работе, работодателях" name="description">
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
						<a class="btn btn-block btn-info btn-add-company" data-toggle="modal" data-target=".add-company-form">Добавить компанию</a>
					</ul>
				</div>
				<div class="col-md-9">
					{{outlet}}
				</div>
			</div>

			<div class="modal fade add-company-form" tabindex="-1" role="dialog" aria-labelledby="add-comany-label" aria-hidden="true">
				<div class="modal-dialog modal-sm">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title" id="add-comany-label">Добавление компании</h4>
						</div>
						<div class="modal-body">
							<form role="form" {{action "saveCompany" on="submit"}}>
								<div class="form-group">
									{{input type="text" class="form-control" placeholder="название компании" value=companyName name="company"}}
								</div>
								<button type="submit" class="btn btn-default">Добавить</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</script>

		<script type="text/x-handlebars" id="index/index">
			<div class="intro-text">
				<h2>Информация о компаниях из первых рук</h2>
				<p>
				На этом сайте люди делятся мнением о работодателях или работе компании в целом.
				<br/>
				Напишите свой отзыв <a href="mailto:podmoga@inside.im">podmoga@inside.im</a></p>
			</div>
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
			<p class="tags-title" style>Популярные эпитеты {{#unless isAddingTag}}<a class="btn-add-tag btn-link" {{action 'addTag'}}>добавить</a>{{/unless}}</p>
			<div class="tags-area">
				{{#if isAddingTag}}
					<p class="form-inline">
						{{input value=newTagName placeholder="введите эпитет" class="form-control"}}
						<a class="btn btn-xs btn-primary" {{action 'saveTag'}}>сохранить</a>
					</p>
				{{/if}}
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

		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		  var locatio = window.location.protocol +
			    '//' + window.location.hostname +
			    window.location.pathname +
			    window.location.search;
		  ga('create', 'UA-48920543-1', 'inside.im');
		  ga('send', 'pageview', locatio);
		</script>

		<!-- Yandex.Metrika counter -->
		<script type="text/javascript">
		(function (d, w, c) {
		    (w[c] = w[c] || []).push(function() {
		        try {
		            w.yaCounter24308977 = new Ya.Metrika({id:24308977,
		                    webvisor:true,
		                    clickmap:true,
		                    trackLinks:true,
		                    accurateTrackBounce:true,
		                    trackHash:true});
		        } catch(e) { }
		    });

		    var n = d.getElementsByTagName("script")[0],
		        s = d.createElement("script"),
		        f = function () { n.parentNode.insertBefore(s, n); };
		    s.type = "text/javascript";
		    s.async = true;
		    s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

		    if (w.opera == "[object Opera]") {
		        d.addEventListener("DOMContentLoaded", f, false);
		    } else { f(); }
		})(document, window, "yandex_metrika_callbacks");
		</script>
		<noscript><div><img src="//mc.yandex.ru/watch/24308977" style="position:absolute; left:-9999px;" alt="" /></div></noscript>

	</body>
</html>
