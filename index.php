<?php
header('Content-Type: text/html; charset=UTF-8');
if ($_SERVER['REQUEST_METHOD'] == 'GET') {// В суперглобальном массиве $_GET PHP хранит все параметры, переданные в текущем запросе через URL.
    // Массив для временного хранения сообщений пользователю.
  $messages = array();
  // В суперглобальном массиве $_COOKIE PHP хранит все имена и значения куки текущего запроса.
  // Выдаем сообщение об успешном сохранении.
  if (!empty($_COOKIE['save'])) {
    setcookie('save', '', 100);
    $messages['save'] = 'Спасибо, результаты сохранены.';
  }
  // Складываем признак ошибок в массив.
  $errors = array();
  $errors['name'] = !empty($_COOKIE['name_error']);
  $errors['email'] = !empty($_COOKIE['email_error']);
  $errors['year'] = !empty($_COOKIE['year_error']);
  $errors['gender'] = !empty($_COOKIE['gender_error']);
  $errors['limbs'] = !empty($_COOKIE['limbs_error']);
  $errors['superpowers'] = !empty($_COOKIE['superpowers_error']);
  $errors['biography'] = !empty($_COOKIE['biography_error']);
  // Выдаем сообщения об ошибках.
  if ($errors['name']) {
    setcookie('name_error', '+', 100);// Удаляем куку, указывая время устаревания в прошлом.
    $messages['name_message'] = '<div class="error">Заполните имя.</div>';// Выводим сообщение.
  }
  if ($errors['email']) {
    setcookie('email_error', '+', 100);
    $messages['email_message'] = '<div class="error">Введите e-mail<br></div>';
  }
  if ($errors['year']) {
    setcookie('year_error', '', 100);
    $messages['year_message'] = '<div class="error">Выберите из списка год рождения<br></div>';
  }
  if ($errors['gender']) {
    setcookie('gender_error', '', 100);
    $messages['gender_message'] = '<div class="error">Укажите ваш пол<br></div>';
  }
  if ($errors['limbs']) {
    setcookie('limbs_error', '', 100);
    $messages['limbs_message'] = '<div class="error">Выберите количество конечностей<br></div>';
  }
  if ($errors['superpowers']) {
    setcookie('superpowers_error', '', 100);
    $messages['superpowers_message'] = '<div class="error">Выберите минимум одну сверхспособность<br></div>';
  }
  if ($errors['biography']) {
    setcookie('biography_error', '', 100);
    $messages['bigraphy_message'] = '<div class="error">Расскажите о себе<br></div>';
  }
  // Складываем предыдущие значения полей в массив, если есть.
  $values = array();
  $values['name'] = empty($_COOKIE['name_value']) ? '' : $_COOKIE['name_value'];
  $values['email'] = empty($_COOKIE['email_value']) ? '' : $_COOKIE['email_value'];
  $values['year'] = empty($_COOKIE['year_value']) ? '' : $_COOKIE['year_value'];
  $values['gender'] = empty($_COOKIE['gender_value']) ? '' : $_COOKIE['gender_value'];
  $values['limbs'] = empty($_COOKIE['limbs_value']) ? '' : $_COOKIE['limbs_value'];
  $values['biography'] = empty($_COOKIE['biography_value']) ? '' : $_COOKIE['biography_value'];
  $values['superpowers'] = [];
  if(!empty($_COOKIE['superpowers_value'])) {
    $super_value = unserialize($_COOKIE['superpowers_value']);
    foreach ($super_value as $s) {
      if (!empty($super[$s])) {
          $values['superpowers'][$s] = $s;
      }
    }
  }
  // Включаем содержимое файла form.php.
  // В нем будут доступны переменные $messages, $errors и $values для вывода сообщений, полей с ранее заполненными данными и признаками ошибок.
  include('form.php');
}
else{
  $errors=FALSE;
  if(empty($_POST['name'])){
    setcookie('name_error','',time+24*60*60);
    $errors=TRUE;
  }
  else if(!preg_match("/^[а-яё]|[a-z]$/iu",$_POST['name'])){
    setcookie('name_error',$_POST['name'],time+24*60*60);
    $errors=TRUE;
  }
  else{
    setcookie('name_value',$_POST['name'],time()+30*24*60*60);
  }
  if(empty($_POST['email'])){
    setcookie('email_error','',time()+24*60*60);
    $errors=TRUE;
  }
  else if(!preg_match("/^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+.[a-zA-Z.]{2,5}$/", $_POST['email'])){
    setcookie('email_error',$_POST['email'],time()+24*60*60);
    $errors=TRUE;
  }
  else{
    setcookie('email_value',$_POST['email'],time()+30*24*60*60);
  }
  if($_POST['year']==''){
    setcookie('year_error','',time()+24*60*60);
    $errors=TRUE;
  }
  else{
    setcookie('year_value',$_POST['year'],time()+30*24*60*60);
  }
  if(empty($_POST['gender'])){
    setcookie('gender_error','',time()+24*60*60);
    $errors=TRUE;
  }
  else{
    setcookie('gender_value',$_POST['gender'],time()+30*24*60*60);
  }
  if(empty($_POST['limbs'])){
    setcookie('limbs_error','',time()+24*60*60);
    $errors=TRUE;
  }
  else{
    setcookie('limbs_value',$_POST['limbs'],time()+30*24*60*60);
  }
  if(empty($_POST['biography'])){
    setcookie('biography_error','',time()+24*60*60);
    $errors=TRUE;
  }
  else{
    setcookie('biography_value',$_POST['biography'],time()+30*24*60*60);
  }
  if($errors){
    header('Location: index.php');
    exit();
  }
  else{
    setcookie('name_error','',100);
    setcookie('email_error','',100);
    setcookie('gender_error','',100);
    setcookie('year_error','',100);
    setcookie('name_error','',100);
    setcookie('name_error','',100);
  }
  // Сохранение в базу данных.
$user = 'u52984';
$pass = '8295850';
$db = new PDO('mysql:host=localhost;dbname=u52984', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
// Подготовленный запрос. Не именованные метки.
try {
    $stmt = $db->prepare("INSERT INTO person (name, email, year, gender, limbs, biography) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt -> execute([$_POST['name'], $_POST['email'], $_POST['year'], $_POST['gender'], $_POST['limbs'], $_POST['biography']]);
    $last_index=$db->lastInsertId();
    $stmt = $db->prepare("SELECT id_power FROM superpower WHERE superpower = ?");
    foreach ($_POST['superpowers'] as $value) {
        $stmt->execute([$value]);
        $id_power=$stmt->fetchColumn();
        $stmt1 = $db->prepare("INSERT INTO ability (id_user, id_superpower) VALUES (?, ?)");
        $stmt1 -> execute([$last_index, $id_power]);
    }
    unset($value);
}
catch(PDOException $e){
print('Error: ' . $e->getMessage());
exit();
}
setcookie('save','1');
header('Location: ?save=1');
}