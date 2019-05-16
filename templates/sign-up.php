<main>
    <nav class="nav">
        <ul class="nav__list container">
            <?php foreach ($categories as $category) : ?>
                <li class="nav__item">
                    <a href="pages/all-lots.html"><?=htmlspecialchars($category['title']); ?></a>
                </li>
            <?php endforeach;?>
        </ul>
    </nav>
    <form class="form container form--invalid" action="/sign-up.php" method="post" enctype="multipart/form-data"> <!-- form--invalid -->
        <h2>Регистрация нового аккаунта</h2>
        <?php $classname = isset($errors['email']) ? "form__item--invalid" : "";
        $value = isset($user['email']) ? $user['email'] : ""; ?>
        <div class="form__item <?=$classname;?>"> <!-- form__item--invalid -->
            <label for="email">E-mail <sup>*</sup></label>
            <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?php echo isset($user_data['email']) ? $user_data['email'] : "";?>">
            <span class="form__error"><?=$errors['email']?></span>
        </div>
        <?php $classname = isset($errors['password']) ? "form__item--invalid" : "";
        $value = isset($user['password']) ? $user['password'] : ""; ?>
        <div class="form__item <?=$classname;?>">
            <label for="password">Пароль <sup>*</sup></label>
            <input id="password" type="password" name="password" placeholder="Введите пароль" value="<?=$value;?>">
            <span class="form__error"><?=$errors['password']?></span>
        </div>
        <?php $classname = isset($errors['name']) ? "form__item--invalid" : "";
        $value = isset($user['name']) ? $user['name'] : ""; ?>
        <div class="form__item <?=$classname;?>">
            <label for="name">Имя <sup>*</sup></label>
            <input id="name" type="text" name="name" placeholder="Введите имя" value="<?=$value;?>">
            <span class="form__error"><?=$errors['name']?></span>
        </div>
        <?php $classname = isset($errors['contacts']) ? "form__item--invalid" : "";
        $value = isset($user['contacts']) ? $user['contacts'] : ""; ?>
        <div class="form__item <?=$classname;?>">
            <label for="message">Контактные данные <sup>*</sup></label>
            <textarea id="message" name="contacts" placeholder="Напишите как с вами связаться"><?=$value;?></textarea>
            <span class="form__error"><?=$errors['contacts']?></span>
        </div>
        <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
        <button type="submit" class="button">Зарегистрироваться</button>
        <a class="text-link" href="#">Уже есть аккаунт</a>
    </form>
</main>