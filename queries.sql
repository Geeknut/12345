INSERT INTO category
(title, code) VALUES ('Доски и лыжи', 'boards'), ('Крепления', 'attachment'), ('Ботинки', 'boots'), ('Одежда', 'clothing'), ('Инструменты', 'tools'), ('Разное', 'other');

INSERT INTO user
(email, name, password, contacts) VALUES ('ivan@mail.ru', 'Иван', '1111', 'РФ, г. Пермь'), ('konst@gmail.com', 'Константин', '1111', 'США'), ('evgen@yandex.ru', 'Евгений', '1111', 'г. Владивосток'), ('igor@mail.ru', 'Игорь', '1111', 'Литва');

INSERT INTO lot
(title, description, image, initial_price, end_time, step_rate, user_id, winner_id, category_id) VALUES ('DC Ply Mens 2016/2017 Snowboard', 'Легкий маневренный сноуборд, готовый дать жару в любом парке, растопив снег мощным щелчкоми четкими дугами. Стекловолокно Bi-Ax, уложенное в двух направлениях, наделяет этот снаряд отличной гибкостью и отзывчивостью, а симметричная геометрия в сочетании с классическим прогибом кэмбер позволит уверенно держать высокие скорости. А если к концу катального дня сил совсем не останется, просто посмотрите на Вашу доску и улыбнитесь, крутая графика от Шона Кливера еще никого не оставляла равнодушным.', 'http://yeticave/img/lot-image.jpg', '159999', '20.05.2019', '1000', '1', '', '1'), ('2014 Rossignol District Snowboard', 'Текст текст текст текст текст текст текст текст текст текст текст текст текст', 'http://yeticave/img/lot-1.jpg', '10999', '20.05.2019', '1000', '2', '', '1');

INSERT INTO rate
(price, user_id, lot_id) VALUES ('20000', '3', '1'), ('13000', '2', '2');

/*получить названия категорий*/
SELECT title FROM category;

/*показать самые новые, открытые лоты*/
SELECT title, initial_price, image, category_id FROM lot WHERE winner_id IS NULL ORDER BY create_time DESC;

/*показать лот по его id,а также название категории, к которой принадлежит лот*/
SELECT l.title, c.title FROM lot l INNER JOIN category c ON c.id = l.category_id WHERE l.id = '1';

/*обновить название лота по его идентификатору;*/
UPDATE lot SET title = 'DC' WHERE id = '1';

/*получить список самых свежих ставок для лота по его идентификатору.*/
SELECT r.create_time, r.price, u.name, l.title  FROM rate r INNER JOIN lot l ON r.lot_id = l.id INNER JOIN user u ON u.id = r.user_id WHERE l.id = '1' ORDER BY r.create_time DESC;
