<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Компании Перми - главная</title>
    <link rel="stylesheet" href="css/main.css">
    <script src="http://code.jquery.com/jquery-2.0.3.min.js"></script>
    <script>
        $(function() {
            $.get('/api/v1/company',function(data) {
                data.forEach(function(company) {
                    $('#list_company').append(company['name'] + '<br/>');
                });
            });
        });
    </script>
</head>
<body>
<div id="main">
    <aside id="search_company">
        <input type="text" plaseholder="Search input">
        <button name="search_company">Search</button>
        <div id="list_company">

        </div>
    </aside>
    <section class="info_about_company">
        <header>
            <img src="image/letter.jpg" alt="Логотип Прогноза">
            <h1 class="name_company">ООО Прогноз</h1>
        </header>
        <article>
            <div>
                Небольшое описание компании, а также таблица фактов: количество народу, возраст
            </div>
            <table>
                <thead>
                <tr>
                    <th>Column 1</th>
                    <th>Column 2</th>
                    <th>Column 3</th>
                </tr>
                <thead>
                <tbody>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                </tbody>
                <table>
        </article>
        <section>
            <div class="skills_company">
                <h2>Самые популярные эпитеты</h2>
            </div>
            <div class="comments_about_company">
                <h2>Комментарии</h2>
                <div class="comment">

                </div>
                <textarea>

                </textarea>
            </div>
        </section>
    </section>
</div>
</body>
</html>