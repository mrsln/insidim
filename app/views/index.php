<!doctype html>
<html>
  <head>
    <title>Отзывы о работадателях</title>
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css"/>
  </head>
  <body>
    <script type="text/x-handlebars">
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
      {{!<table class="table table-bordered">
        <tbody>
          <tr>
            <td>Численность</td>
            <td>999</td>
          </tr>
          <tr>
            <td>Дата основания</td>
            <td>1998</td>
          </tr>
        </tbody>
      </table>
      }}
      <p class="tags-title" style>Популярные эпитеты</p>
      <div class="tags-area">
        {{#each characteristic}}
          <div class="progress progress-striped">
            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
              <span class="sr-only pr-label">{{name}} - {{count}}</span>
              <div class="tag-plus" {{action 'vote'}}>+</div>
            </div>
          </div>
        {{/each}}
      </div>
      {{!<a class="btn-add-tag btn-link">добавить тег</a>}}
    </script>

    <script src="js/libs/jquery-1.10.2.js"></script>
    <script src="js/libs/handlebars-1.1.2.js"></script>
    <script src="js/libs/ember-1.4.0.js"></script>
    <script src="js/app.js"></script>
  </body>
</html>
