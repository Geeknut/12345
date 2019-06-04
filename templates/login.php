

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
    <form class="form container form--invalid" action="/login.php" method="post" enctype="multipart/form-data"> <!-- form--invalid -->
        <h2>Вход</h2>
        <?php $classname = isset($errors['email']) ? "form__item--invalid" : "";
        $value = isset($login['email']) ? $login['email'] : ""; ?>
        <div class="form__item <?=$classname;?>"> <!-- form__item--invalid -->
            <label for="email">E-mail <sup>*</sup></label>
            <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?php echo isset($login_data['email']) ? $login_data['email'] : "";?>">
            <span class="form__error"><?=$errors['email']?></span>
        </div>
        <?php $classname = isset($errors['password']) ? "form__item--invalid" : "";
        $value = isset($login['password']) ? $login['password'] : ""; ?>
        <div class="form__item form__item--last <?=$classname;?>">
            <label for="password">Пароль <sup>*</sup></label>
            <input id="password" type="password" name="password" placeholder="Введите пароль" value="<?=$value;?>">
            <span class="form__error"><?=$errors['password']?></span>
        </div>
        <button type="submit" class="button">Войти</button>
    </form>
</main>