<?php

$id = (int)$_GET['id']; // Получение ID новости из GET-параметра и преобразование его в целое число
$content = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/data/' . $id . '.txt'); // Чтение содержимого файла, соответствующего ID новости
$news = unserialize($content); // Десериализация данных из файла в переменную $news
?>
<?php
  require_once $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php'; // Подключение файла заголовка страницы
?>
  <body>
    <?php
      require_once $_SERVER['DOCUMENT_ROOT'] . '/templates/menu.php'; // Подключение файла меню
    ?>
    <main>
      <div class="container marketing">
        <!-- Three columns of text below the carousel -->
        <div class="row">
            <h1><?=$news['title']?></h1>
            <p>
              <?=$news['text']?>
            </p>
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
