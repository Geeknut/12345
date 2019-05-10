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
    <form class="form form--add-lot container form--invalid" action="/add.php" method="post" enctype="multipart/form-data"> <!-- form--invalid -->
        <h2>Добавление лота</h2>
        <div class="form__container-two">
            <?php $classname = isset($errors['title']) ? "form__item--invalid" : "";
            $value = isset($lot['title']) ? $lot['title'] : ""; ?>
            <div class="form__item <?=$classname;?>"> <!-- form__item--invalid -->

                <label for="lot-name">Наименование <sup>*</sup></label>
                <input id="lot-name" type="text" name="title" placeholder="Введите наименование лота" value="<?=$value;?>">
                <span class="form__error ">Введите наименование лота</span>
            </div>
            <?php $classname = isset($errors['category']) ? "form__item--invalid" : "";
            $value = isset($lot['category']) ? $lot['category'] : ""; ?>
            <div class="form__item <?=$classname;?>">
                <label for="category">Категория <sup>*</sup></label>

                <select id="category" name="category">

                    <option value="">Выберите категорию</option>
                    <?php foreach ($categories as $category) :?>
                    <option value="<?= htmlspecialchars($category['id']); ?>"><?= htmlspecialchars($category['title']); ?></option>
                    <?php endforeach;?>
                </select>
                <span class="form__error">Выберите категорию</span>
            </div>
        </div>

        <?php $classname = isset($errors['message']) ? "form__item--invalid" : "";
        $value = isset($lot['message']) ? $lot['message'] : ""; ?>
        <div class="form__item form__item--wide <?=$classname;?>">
            <label for="message">Описание <sup>*</sup></label>
            <textarea id="message" name="message" placeholder="Напишите описание лота" value="<?=$value;?>"></textarea>

            <span class="form__error <?=$classname;?>">Напишите описание лота</span>
        </div>


        <div class="form__item form__item--file">
            <label>Изображение <sup>*</sup></label>
            <div class="form__input-file">
                <input class="visually-hidden" type="file" id="lot-img" name="lot_img" value="">
                <label for="lot-img">
                    Добавить
                </label>
            </div>
        </div>
        <div class="form__container-three">
            <?php $classname = isset($errors['initial_price']) ? "form__item--invalid" : "";
            $value = isset($lot['initial_price']) ? $lot['initial_price'] : ""; ?>
            <div class="form__item form__item--small  <?=$classname;?>">
                <label for="lot-rate">Начальная цена <sup>*</sup></label>
                <input id="lot-rate" type="text" name="initial_price" placeholder="0" value="<?=$value;?>">
                <span class="form__error">Введите начальную цену</span>
            </div>
            <?php $classname = isset($errors['step_rate']) ? "form__item--invalid" : "";
            $value = isset($lot['step_rate']) ? $lot['step_rate'] : ""; ?>
            <div class="form__item form__item--small  <?=$classname;?>">
                <label for="lot-step">Шаг ставки <sup>*</sup></label>
                <input id="lot-step" type="text" name="step_rate" placeholder="0"  value="<?=$value;?>">
                <span class="form__error">Введите шаг ставки</span>
            </div>
            <?php $classname = isset($errors['lot_date']) ? "form__item--invalid" : "";
            $value = isset($lot['lot_date']) ? $lot['lot_date'] : ""; ?>
            <div class="form__item  <?=$classname;?>">
                <label for="lot-date">Дата окончания торгов <sup>*</sup></label>
                <input class="form__input-date" id="lot-date" type="text" name="lot_date" placeholder="Введите дату в формате ГГГГ-ММ-ДД"  value="<?=$value;?>">
                <span class="form__error">Введите дату завершения торгов</span>
            </div>
        </div>
        <?php if (isset($errors)): ?>
        <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
        <ul>
        <?php foreach ($errors as $err =>$val):?>
        <li><strong><?=$dict[$err];?>:</strong> <?=$val;?></li>
        <?php endforeach; ?>
        </ul>
        <?php endif;?>
        <button type="submit" class="button">Добавить лот</button>
    </form>
</main>