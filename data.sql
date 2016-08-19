

-- Countries
INSERT INTO `coutries` (`sort_id`, `slug`, `title`, `lang`) VALUES
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