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
        <div class="row">
          <div class="col-md-3">
            {{outlet}}
          </div>
          <div class="col-md-9">
            <p class="company-name">Prognoz</p>
            <table class="table table-bordered">
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
            <p class="tags-title" style>Популярные эпитеты</p>
            <div class="tags-area">
              <div class="progress progress-striped">
                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                  <span class="sr-only pr-label">белая зарплата</span>
                  <div class="tag-plus">+</div>
                </div>
              </div>
            </div>
            <a class="btn-add-tag btn-link">добавить тег</a>
          </div>
        </div>
      </div>
    </script>

    <script type="text/x-handlebars" id="index">
      <ul class="list-group list-company">
         {{#each item in model}}
          <li class="list-group-item">{{item.name}}</li>
        {{/each}}
        <a class="btn btn-block btn-info btn-add-company">Добавить компанию</a>
      </ul>
    </script>

    <script src="js/libs/jquery-1.10.2.js"></script>
    <script src="js/libs/handlebars-1.1.2.js"></script>
    <script src="js/libs/ember-1.4.0.js"></script>
    <script src="js/app.js"></script>
  </body>
</html>
