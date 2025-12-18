<?php
error_reporting(E_ALL); // Включение отображения всех типов ошибок
ini_set('display_errors', 1); // Настройка для вывода ошибок на экран

session_start(); // Запуск сессии для работы с переменными сессии

require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php'; // Подключение конфигурационного файла

if(!empty($_GET['act']) && $_GET['act'] == 'login') { // Проверка, если в GET-параметре act указано 'login'
  require_once $_SERVER['DOCUMENT_ROOT'] . '/templates/login.php'; // Подключение шаблона страницы входа
  die(); // Прекращение выполнения скрипта
}

if(empty($_SESSION['login'])) { // Проверка, если пользователь не авторизован (сессия 'login' пуста)
  header('Location: /admin/index.php/?act=login'); // Перенаправление на страницу входа
}

    //Считываем файл, но переменная $news недоступна из внешнего файла. В веб шторме ругается на это. Н оможно определить доп блок и ругаться не будет. // Чтение новостей из файлов
    require_once $_SERVER['DOCUMENT_ROOT'] . '/modules/readnews.php';  // Подключение модуля для чтения новостей
    if(!empty($_GET) && $_GET['act'] == 'edit') { // Если в GET-запросе указано действие 'edit'
      $id = (int)$_GET['id']; // Получение и преобразование ID новости в целое число
      $contentItem = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/data/' . $id . '.txt'); // Чтение содержимого файла с новостью
      $newsItem = unserialize($contentItem); // Десериализация строки в массив с данными новости
    }
    //Определим доп блок // Дополнительный блок для IDE
    /**
     * @var $news array
     */
    if(!empty($_POST['title']) && !empty($_POST['text']) && !empty($_POST['id'])) { // Если отправлены данные для редактирования существующей новости
      $id = (int)$_POST['id']; // Получение и преобразование ID новости из POST-запроса
      $data = [ // Формирование массива с данными новости
            'id' => $id, // ID новости
            'title' => $_POST['title'], // Заголовок новости
            'text' => $_POST['text'] // Текст новости
        ];
      $data = serialize($data); // Сериализация массива в строку
      file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/data/' . $id . '.txt', $data); // Запись сериализованных данных в файл
      header('Location: /admin'); // Перенаправление на главную страницу админ-панели
      die(); // Прекращение выполнения скрипта
    } elseif(!empty($_POST['title']) && !empty($_POST['text'])) { // Если отправлены данные для создания новой новости
        $files = scandir($_SERVER['DOCUMENT_ROOT'] . '/data'); // Сканирование директории с данными
        $i = 1; // Инициализация счетчика для нового ID
        //Считаем количество файлов в каталоге // Подсчет файлов для определения нового ID
        foreach($files as $file) { // Перебор всех файлов в директории
            if($file == '.' || $file == '..') { // Пропуск системных директорий '.' и '..'
            continue; // Переход к следующей итерации цикла
            }
            $i++; // Увеличение счетчика
        }
        $data = [ // Формирование массива с данными новой новости
            'id' => $i, // Присвоение нового ID
            'title' => $_POST['title'], // Заголовок из POST-запроса
            'text' => $_POST['text'] // Текст из POST-запроса
        ];
        //Массив в файл записать нельзя, можно только строки // Комментарий о невозможности прямой записи массива в файл
        //Преобразует массив в строку // Сериализация для записи
        $data = serialize($data); // Сериализация массива в строку
        //Помещаем строку в файл 1.txt // Некорректный комментарий, имя файла будет динамическим
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/data/' . $i . '.txt', $data); // Запись данных в новый файл
        //Перезапускаем страницу // Перенаправление после создания
        header('Location: /admin'); // Перенаправление на главную страницу админ-панели
        die(); // Прекращение выполнения скрипта
    }
?>

<?php
  require_once $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php'; // Подключение файла заголовка страницы
?>
<body>
    <?php
      require_once $_SERVER['DOCUMENT_ROOT'] . '/templates/menu.php'; // Подключение файла меню
    ?>
    <main>
      <div class="container mt-3">
        <div class="row">
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">ID</th>
                  <th scope="col">Title</th>
                  <th scope="col">Text</th>
                </tr>
              </thead>
              <tbody class="table-group-divider">
                <?php foreach ($news as $item): ?>
                <tr>
                  <th scope="row"><?=$item['id']?></th>
                  <td><?=$item['title']?></td>
                  <td><a href="/admin/?act=edit&id=<?=$item['id']?>">Edit</a></td>
                </tr>
                <?php endforeach ?>
              </tbody>
            </table>

            <form action="" method="post">
              <input type="hidden" name="id" value="<?php echo $newsItem['id'] ?? 0;?>">
                <div class="mb-3 row">
                    <label for="staticEmail" class="col-sm-2 col-form-label">Title</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control-plaintext" id="staticEmail" placeholder="Enter text" name="title" value="<?php echo $newsItem['title'] ?? '';?>">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">Example textarea</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="15" name="text"><?php echo $newsItem['text'] ?? '';?></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submin</button>
            </form>
        </div>
      </div>

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
      src="/js/bootstrap.bundle.min.js"
      class="astro-vvvwv3sm"
    ></script>
  </body>
</html>
