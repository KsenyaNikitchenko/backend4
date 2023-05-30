<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="utf-8">
    <title>Сверхспособности</title>
    <link rel="stylesheet" href="style_form.css">
</head>

<body>
<?php
if (!empty($messages)) {
  foreach ($messages as $m) {
    print($m);
  }
  print('</div>');
}
?>
    <div class="form">
        <h1>Сверхспособности</h1>
        <form action="index.php" method="POST">
            <label for="name">Введите имя:<br>
                <input name="name" placeholder="Введите имя" <?php if (!empty($errors['name'])) {print 'class="error"';} ?>
            <?php if(empty($errors['name'])&&!empty($values['name'])){print 'class="ok"';}?> value='<?php if(!empty($values['name'])) print $values['name'];?>'><br>
            </label>
            <label for="email">Адрес электронной почты:<br>
                <input name="email" type="email" placeholder="Введите email" <?php if (!empty($errors['email'])) {print 'class="error"';} ?>
            <?php if(empty($errors['email'])&&!empty($values['email'])){print 'class="ok"';}?> value='<?php if(!empty($values['email'])) print $values['email'];?>'><br>
            </label>
            <label for="year">Год рождения</label>
            <select name="year" <?php if (!empty($errors['year'])) {print 'class="error"';} ?>
            <?php if(empty($errors['year'])&&!empty($values['year'])){print 'class="ok"';}?>>
            <option selected ><?php !empty($values['year']) ? print ($values['year']) : print '' ?></option>
                <?php for ($i = 1922; $i <= 2022; $i++) {
                    printf('<option value="%d">%d</option>', $i, $i);
                }?>
            </select>
            <br>
            <label for="gender" <?php if (!empty($errors['gender'])) {print 'class="error"';} ?>>Выберите пол:</label><br>
            <label><input type="radio" checked="checked" name="gender" value="female" <?php if (isset($values['gender'])&&$values['gender'] == 'female') print("checked"); ?>>
                Женский</label>
            <label><input type="radio" name="gender" value="male" <?php if (isset($values['gender'])&&$values['gender'] == 'male') print("checked"); ?>>
                Мужской</label>
            <br>
            <label for="limbs" <?php if (!empty($errors['limbs'])) {print 'class="error_check"';} ?>>Количество конечностей:</label><br>
            <label><input type="radio" checked="checked" name="limbs" value="1" <?php if (isset($values['limbs'])&&$values['limbs'] == '1') print("checked"); ?>>1</label>
            <label><input type="radio" name="limbs" value="2" <?php if (isset($values['limbs'])&&$values['limbs'] == '2') print("checked"); ?>>2</label>
            <label><input type="radio" name="limbs" value="3" <?php if (isset($values['limbs'])&&$values['limbs'] == '3') print("checked"); ?>>3</label>
            <label><input type="radio" name="limbs" value="4" <?php if (isset($values['limbs'])&&$values['limbs'] == '4') print("checked"); ?>>4</label>
            <br>
            <label for="superpowers" <?php if (!empty($errors['superpowers'])) {print 'class="error"';} ?>>Сверхспособности:</label><br>
            <select name="superpowers[]" multiple="multiple">
                <option value="deathless">Бессмертие</option>
                <option value="walls" selected="selected">Прохождение сквозь стены</option>
                <option value="levitation">Левитация</option>
                <option value="elements">Управление стихиями</option>
                <option value="time travel">Путешествие во времени</option>
            </select>
            <br>
            <label for="biography" <?php if (!empty($errors['biography'])) {print 'class="error"';} ?>>Биография:</label><br>
            <textarea name="biography" <?php if (!empty($errors['biography'])) {print 'class="error"';} ?>
            <?php if(empty($errors['biography'])&&!empty($values['biography'])){print 'class="ok"';}?>><?php if(!empty($values['biography'])) print $values['biography'];?></textarea><br>
            <label><input type="checkbox" checked="checked" name="check-kontrol" <?php if (!empty($errors['check-kontrol'])) {print 'class="error"';} ?>>с контрактом ознакомлен(а)</label>
            <br>
            <input type="submit" class="submit" value="Отправить" />

        </form>
    </div>

</body>

</html>