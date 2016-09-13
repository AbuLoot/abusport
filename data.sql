

-- Countries
INSERT INTO `countries` (`sort_id`, `slug`, `title`, `lang`) VALUES
(1, 'kazakhstan', 'Казахстан', 'ru');


-- Cities
INSERT INTO `cities` (`sort_id`, `country_id`, `slug`, `title`, `lang`) VALUES
(1, 1, 'almaty', 'Алматы', 'ru'),
(2, 1, 'astana', 'Астана', 'ru'),
(3, 1, 'aktau', 'Актау', 'ru'),
(4, 1, 'aktobe', 'Актобе', 'ru'),
(5, 1, 'atyrau', 'Атырау', 'ru'),
(6, 1, 'zhezkazgan', 'Жезказган', 'ru'),
(7, 1, 'karaganda', 'Караганда', 'ru'),
(8, 1, 'kokshetau', 'Кокшетау', 'ru'),
(9, 1, 'kostanay', 'Костанай', 'ru'),
(10, 1, 'kyzylorda', 'Кызылорда', 'ru'),
(11, 1, 'pavlodar', 'Павлодар', 'ru'),
(12, 1, 'petropavlovsk', 'Петропавловск', 'ru'),
(13, 1, 'semey', 'Семей', 'ru'),
(14, 1, 'taldykorgan', 'Талдыкорган', 'ru'),
(15, 1, 'taraz', 'Тараз', 'ru'),
(16, 1, 'temirtau', 'Темиртау', 'ru'),
(17, 1, 'uralsk', 'Уральск', 'ru'),
(18, 1, 'ust-kamenogorsk', 'Усть-Каменогорск', 'ru'),
(19, 1, 'shymkent', 'Шымкент', 'ru'),
(20, 1, 'ekibastuz', 'Экибастуз', 'ru');


-- Districts
INSERT INTO `districts` (`sort_id`, `city_id`, `slug`, `title`, `lang`) VALUES
(1, 1, 'alatauskij', 'Алатауский район', 'ru'),
(2, 1, 'almalinskij', 'Алмалинский район', 'ru'),
(3, 1, 'aujezovskij', 'Ауэзовский район', 'ru'),
(4, 1, 'bostandykskij', 'Бостандыкский район', 'ru'),
(5, 1, 'zhetysuskij', 'Жетысуский район', 'ru'),
(6, 1, 'medeuskij', 'Медеуский район', 'ru'),
(7, 1, 'nauryzbajskiy', 'Наурызбайский район', 'ru'),
(8, 1, 'turksibskij', 'Турксибский район', 'ru');


-- Sports
INSERT INTO `sports` (`sort_id`, `slug`, `title`, `image`, `lang`) VALUES
(1, 'football', 'Футбол', '', 'ru'),
(2, 'basketball', 'Баскетбол', '', 'ru'),
(3, 'volleyball', 'Волейбол', '', 'ru'),
(4, 'paintball', 'Пейнтбол', '', 'ru'),
(5, 'hockey', 'Хоккей', '', 'ru'),
(6, 'tennis', 'Теннис', '', 'ru'),
(7, 'table-tennis', 'Настольный теннис', '', 'ru'),
(8, 'golf', 'Гольф', '', 'ru');


-- Organization types
INSERT INTO `org_types` (`slug`, `title`, `short_title`) VALUES
('tovarishchestvo-s-ogranichennoy-otvetstvennostyu', 'Товарищество с ограниченной ответственностью', 'ТОО'),
('individualnoe-predprinimatelstvo', 'Индивидуальное предпринимательство', 'ИП'),
('tovarishchestvo-s-dopolnitelnoy-otvetstvennostyu', 'Товарищество с дополнительной ответственностью', 'ТДО'),
('gos-predpriyatie', 'Гос предприятие', 'ГП'),
('gos-predpriyatie-na-prave-khozyaystvennogo-vedeniya', 'Гос предприятие на праве хозяйственного ведения', 'ГПНПХВ'),
('gos-predpriyatie-na-prave-operativnogo-upravleniya', 'Гос предприятие на праве оперативного управления', 'ГПНПОУ'),
('khozyaystvennoe-tovarishchestvo', 'Хозяйственное товарищество', 'ХТ'),
('polnoe-tovarishchestvo', 'Полное товарищество', 'ПТ'),
('kommanditnoe-tovarishchestvo', 'Коммандитное товарищество', 'КТ'),
('aktsionernoe-obshchestvo', 'Акционерное общество', 'АО'),
('drugaya-organizatsionno-pravovye-forma', 'Другая организационно-правовые форма', 'ДОПФ'),
('proizvodstvennyy-kooperativ', 'Производственный кооператив', 'ПК'),
('uchrezhdenie', 'Учреждение', 'У'),
('obshchestvennoe-obedinenie', 'Общественное объединение', 'ОУ'),
('potrebitelskiy-kooperativ', 'Потребительский кооператив', 'ПК'),
('fond', 'Фонд', 'Ф'),
('religioznoe-obedinenie', 'Религиозное объединение', 'РО'),
('obedinenie-yuridicheskikh-lits-v-forme-assotsiatsii', 'Объединение юридических лиц в форме ассоциации', 'ОЮЛВФА'),
('selskokhozyaystvennoe-tovarishchestvo', 'Сельскохозяйственное товарищество', 'СТ'),
('lichnoe-predprinimatelstvo', 'Личное предпринимательство', 'ЛП'),
('individualnoe-pr-vo-na-osnove-sovmestnogo-pr-va', 'Индивидуальное пр-во на основе совместного пр-ва', 'ИПНОСП'),
('prostoe-tovarishchestvo', 'Простое товарищество', 'ПП'),
('predprinimatelstvo-suprugov', 'Предпринимательство супругов', 'ПС'),
('semeynoe-predprinimatelstvo', 'Семейное предпринимательство', 'СП'),
('inaya-forma-nekommercheskoy-organizatsii', 'Иная форма некоммерческой организации', 'ИОПФНО');