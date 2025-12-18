<?php
$error = ''; // Инициализация переменной для хранения сообщений об ошибках
if(!empty($_POST['email']) && !empty($_POST['password'])) { // Проверка, были ли отправлены email и пароль через форму
    if($_POST['email'] == EMAIL && $_POST['password'] == PASSWORD) { // Сравнение введенных данных с константами
        $_SESSION['login'] = 'artur.levashoff@gmail.com'; // Установка сессии для авторизованного пользователя
        header('Location: /admin/'); // Перенаправление на страницу администратора
        die(); // Прекращение выполнения скрипта
    } else { // Если данные не совпали
        $error = 'Неверный логин или пароль'; // Запись сообщения об ошибке
    }
}
  require_once $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php'; // Подключение файла заголовка страницы
?>
  <body>
    <?php
      require_once $_SERVER['DOCUMENT_ROOT'] . '/templates/menu.php'; // Подключение файла меню
    ?>
    <main>
      <div class="container marketing">
        <!-- Three columns of text below the carousel -->
         <?=$error?>
        <div class="row">
            <form action="" method="post">
                <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" name="email">
                    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="password">
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Check me out</label>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
      </div>
      <!-- /.container -->
      <!-- FOOTER -->
      <footer class="container">
        <p class="float-end"><a href="#">Back to top</a></p>
        <p>
          &copy; 2017–2025 Company, Inc. &middot;
          <a href="#">Privacy</a> &middot; <a href="#">Terms</a>
        </p>
      </footer>
    </main>
    <script
      src="../js/bootstrap.bundle.min.js"
      class="astro-vvvwv3sm"
    ></script>
  </body>
</html>
