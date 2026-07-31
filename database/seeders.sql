-- Kernel — directorio de proyectos (seed)
--
-- Generado desde la base de datos el 2026-07-14 17:39:00 UTC.
-- Contiene 18 proyectos y 37 enlaces.
--
-- Uso:  mysql -u root kernel_tickets < database/seeders.sql
--
-- Es idempotente: reejecutarlo actualiza las filas existentes (por id / slug) en
-- lugar de duplicarlas, y no borra nada — importante, porque borrar un proyecto
-- arrastra en cascada sus tickets.

START TRANSACTION;

INSERT INTO `projects` (`id`, `name`, `slug`, `env`, `image`, `status`, `prod_url`, `local_url`, `hidden_from_boss`, `created_at`, `updated_at`) VALUES
    (1, 'ZEROTOPLAN — PRODUCCIÓN', 'zerotoplan-produccion', 'prod', 'zerotoplan.webp', 'actualizado', 'https://zerotoplan.com', 'http://localhost/new_zerotoplan', 0, '2026-07-14 16:38:48', '2026-07-14 16:38:48'),
    (2, 'ZEROTOPLAN — QA', 'zerotoplan-qa', 'qa', 'zerotoplan.webp', 'actualizado', 'https://prev.zerotoplan.com', 'http://localhost/new_zerotoplan', 0, '2026-07-14 16:38:49', '2026-07-14 16:38:49'),
    (3, 'ATEX — PRODUCCIÓN', 'atex-produccion', 'prod', 'Atex.webp', 'actualizado', 'https://atexgrp.com', 'http://localhost/new_atex', 0, '2026-07-14 16:38:49', '2026-07-14 16:38:49'),
    (4, 'ATEX — QA', 'atex-qa', 'qa', 'Atex.webp', 'actualizado', 'https://prevatex.zerotoplan.com', 'http://localhost/new_atex', 0, '2026-07-14 16:38:49', '2026-07-14 16:38:49'),
    (5, 'MARSTON — PRODUCCIÓN', 'marston-produccion', 'prod', 'marston.webp', 'actualizado', 'http://mar-ston.com', 'http://localhost/MARSTON', 0, '2026-07-14 16:38:49', '2026-07-14 16:38:49'),
    (6, 'MARSTON — QA', 'marston-qa', 'qa', 'marston.webp', 'actualizado', 'http://prevmarston.zerotoplan.com', 'http://localhost/MARSTON', 0, '2026-07-14 16:38:49', '2026-07-14 16:38:49'),
    (7, 'MARSTON.ORG — PRODUCCION', 'marstonorg-produccion', 'prod', 'marston_f.jpg', 'actualizado', 'http://mar-ston.org', 'http://localhost/MARSTON', 0, '2026-07-14 16:38:49', '2026-07-14 16:38:49'),
    (8, 'MARSTON.ORG — QA', 'marstonorg-qa', 'qa', 'marston_f.jpg', 'actualizado', 'http://prevmarstonorg.zerotoplan.com/', 'http://localhost/MARSTON', 0, '2026-07-14 16:38:49', '2026-07-14 16:38:49'),
    (9, 'GME ALLIANCE — PRODUCCION', 'gme-alliance-produccion', 'prod', 'gmealliance.png', 'actualizado', 'http://gmealliance.com', 'http://localhost/gmealliance', 0, '2026-07-14 16:38:49', '2026-07-14 16:38:49'),
    (10, 'GME ALLIANCE — PREV', 'gme-alliance-prev', 'qa', 'gmealliance.png', 'actualizado', 'http://prevgmealliance.zerotoplan.com', 'http://localhost/gmealliance', 0, '2026-07-14 16:38:49', '2026-07-14 16:38:49'),
    (11, 'GREENLINE — PRODUCCIÓN', 'greenline-produccion', 'prod', 'greenline.webp', 'actualizado', 'https://greenlinepmc.com/', '', 0, '2026-07-14 16:38:49', '2026-07-14 16:38:49'),
    (12, 'GREENLINE — QA', 'greenline-qa', 'qa', 'greenline.webp', 'actualizado', 'http://prevgreenline.zerotoplan.com/', '', 0, '2026-07-14 16:38:49', '2026-07-14 16:38:49'),
    (13, 'ROMA — PRODUCCIÓN', 'roma-produccion', 'prod', 'Roma.svg', 'actualizado', 'https://rome.zerotoplan.com', '', 0, '2026-07-14 16:38:49', '2026-07-14 16:38:49'),
    (14, 'ROMA — QA', 'roma-qa', 'qa', 'Roma.svg', 'actualizado', 'https://qarome.zerotoplan.com', '', 0, '2026-07-14 16:38:49', '2026-07-14 16:38:49'),
    (15, 'LAND BUSTERS — PRODUCCION', 'land-busters-produccion', 'prod', '', 'actualizado', 'http://landbuster.zerotoplan.com', 'http://localhost/landbusters', 0, '2026-07-14 16:38:49', '2026-07-14 16:38:49'),
    (16, 'VINE ON 19 — PRODUCCION', 'vine-on-19-produccion', 'prod', 'vine2.png', 'actualizado', 'http://vineon19.com', 'http://localhost/vineon19', 0, '2026-07-14 16:38:49', '2026-07-14 16:38:49'),
    (17, 'ARCONDAL - QA', 'arcondal-qa', 'qa', 'arcondal.png', 'actualizado', 'https://prevarcondal.zerotoplan.com', '', 0, '2026-07-14 16:38:49', '2026-07-14 16:38:49'),
    (18, 'PERSONAL LINKS', 'personal-links', '', 'Personals.png', 'actualizado', 'https://folderlinks.zerotoplan.com/', '', 0, '2026-07-14 16:38:49', '2026-07-14 16:38:49')
ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `slug` = VALUES(`slug`),
    `env` = VALUES(`env`),
    `image` = VALUES(`image`),
    `status` = VALUES(`status`),
    `prod_url` = VALUES(`prod_url`),
    `local_url` = VALUES(`local_url`),
    `hidden_from_boss` = VALUES(`hidden_from_boss`),
    `updated_at` = VALUES(`updated_at`)
;

INSERT INTO `project_links` (`id`, `project_id`, `label`, `prod_url`, `local_url`, `created_at`, `updated_at`) VALUES
    (1, 1, 'Panel de control', 'https://zerotoplan.com/dashboard', 'http://localhost:5175/dashboard', '2026-07-14 16:38:48', '2026-07-14 16:38:48'),
    (2, 1, 'Land Form', 'https://zerotoplan.com/land_form.html', 'http://localhost:5175/land_form.html', '2026-07-14 16:38:49', '2026-07-14 16:38:49'),
    (3, 1, 'Client Form', 'https://zerotoplan.com/client_form.html', 'http://localhost:5175/client_form.html', '2026-07-14 16:38:49', '2026-07-14 16:38:49'),
    (4, 1, 'Contact Form', 'https://zerotoplan.com/index.html#pricing', 'http://localhost:5175/index.html#pricing', '2026-07-14 16:38:49', '2026-07-14 16:38:49'),
    (5, 1, 'Broker Criteria', 'https://zerotoplan.com/broker-criteria.html', 'http://localhost:5175/broker-criteria.html', '2026-07-14 16:38:49', '2026-07-14 16:38:49'),
    (6, 1, 'Broker Partnership', 'https://zerotoplan.com/broker-partnership.html', 'http://localhost:5175/broker-partnership.html', '2026-07-14 16:38:49', '2026-07-14 16:38:49'),
    (7, 1, 'Broker Referental Program', 'https://zerotoplan.com/broker-referental-program.html', 'http://localhost:5175/broker-referental-program.html', '2026-07-14 16:38:49', '2026-07-14 16:38:49'),
    (8, 2, 'Panel de control', 'https://zerotoplan.com/dashboard', 'http://localhost:5175/dashboard', '2026-07-14 16:38:49', '2026-07-14 16:38:49'),
    (9, 2, 'Land Form', 'https://prev.zerotoplan.com/land_form.html', 'http://localhost:5175/land_form.html', '2026-07-14 16:38:49', '2026-07-14 16:38:49'),
    (10, 2, 'Client Form', 'https://prev.zerotoplan.com/client_form.html', 'http://localhost:5175/client_form.html', '2026-07-14 16:38:49', '2026-07-14 16:38:49'),
    (11, 2, 'Contact Form', 'https://prev.zerotoplan.com/index.html#pricing', 'http://localhost:5175/index.html#pricing', '2026-07-14 16:38:49', '2026-07-14 16:38:49'),
    (12, 2, 'Broker Criteria', 'https://prev.zerotoplan.com/broker-criteria.html', 'http://localhost:5175/broker-criteria.html', '2026-07-14 16:38:49', '2026-07-14 16:38:49'),
    (13, 2, 'Broker Partnership', 'https://prev.zerotoplan.com/broker-partnership.html', 'http://localhost:5175/broker-partnership.html', '2026-07-14 16:38:49', '2026-07-14 16:38:49'),
    (14, 2, 'Broker Referental Program', 'https://prev.zerotoplan.com/broker-referental-program.html', 'http://localhost:5175/broker-referental-program.html', '2026-07-14 16:38:49', '2026-07-14 16:38:49'),
    (15, 3, 'Dashboard', 'https://atexgrp.com/dashboard', 'http://localhost:5173/dashboard', '2026-07-14 16:38:49', '2026-07-14 16:38:49'),
    (16, 3, 'Contact Form', 'https://atexgrp.com/contact', 'http://localhost:5175/contact', '2026-07-14 16:38:49', '2026-07-14 16:38:49'),
    (17, 4, 'Dashboard', 'https://atexgrp.com/dashboard', 'http://localhost:5173/dashboard', '2026-07-14 16:38:49', '2026-07-14 16:38:49'),
    (18, 4, 'Contact Form', 'https://prevatex.zerotoplan.com/contact', 'http://localhost:5175/contact', '2026-07-14 16:38:49', '2026-07-14 16:38:49'),
    (19, 5, 'Landing', 'http://mar-ston.com/landing', 'http://localhost:5174/landing', '2026-07-14 16:38:49', '2026-07-14 16:38:49'),
    (20, 5, 'Contact Form', 'https://mar-ston.com/form.html', 'http://localhost:5175/form.html', '2026-07-14 16:38:49', '2026-07-14 16:38:49'),
    (21, 6, 'Landing', 'http://mar-ston.com/landing', 'http://localhost:5174/landing', '2026-07-14 16:38:49', '2026-07-14 16:38:49'),
    (22, 6, 'Contact Form', 'https://prevmarston.zerotoplan.com/form.html', 'http://localhost:5175/form.html', '2026-07-14 16:38:49', '2026-07-14 16:38:49'),
    (23, 7, 'Landing', 'http://mar-ston.com/landing', 'http://localhost:5174/landing', '2026-07-14 16:38:49', '2026-07-14 16:38:49'),
    (24, 8, 'Landing', 'http://prevmarstonorg.zerotoplan.com/landing', 'http://localhost:5174/landing', '2026-07-14 16:38:49', '2026-07-14 16:38:49'),
    (25, 9, 'Landing', 'http://mar-ston.com/landing', 'http://localhost:5174/landing', '2026-07-14 16:38:49', '2026-07-14 16:38:49'),
    (26, 10, 'Landing', 'http://mar-ston.com/landing', 'http://localhost:5174/landing', '2026-07-14 16:38:49', '2026-07-14 16:38:49'),
    (27, 11, 'Intake Form', 'https://greenlinepmc.com/apply', '', '2026-07-14 16:38:49', '2026-07-14 16:38:49'),
    (28, 12, 'Intake Form', 'http://prevgreenline.zerotoplan.com/apply', '', '2026-07-14 16:38:49', '2026-07-14 16:38:49'),
    (29, 15, 'Landing', 'http://mar-ston.com/landing', 'http://localhost:5174/landing', '2026-07-14 16:38:49', '2026-07-14 16:38:49'),
    (30, 16, 'Landing', 'http://mar-ston.com/landing', 'http://localhost:5174/landing', '2026-07-14 16:38:49', '2026-07-14 16:38:49'),
    (31, 18, 'Anthony Links', 'anthonylinks.atexgrp.com', '', '2026-07-14 16:38:49', '2026-07-14 16:38:49'),
    (32, 18, 'Giovanni Links', 'https://giovannilinks.atexgrp.com/', '', '2026-07-14 16:38:49', '2026-07-14 16:38:49'),
    (33, 18, 'Juliana Links', 'julianalinks.atexgrp.com', '', '2026-07-14 16:38:49', '2026-07-14 16:38:49'),
    (34, 18, 'Ray Links', 'https://raylinks.atexgrp.com/', '', '2026-07-14 16:38:49', '2026-07-14 16:38:49'),
    (35, 18, 'Rey Links', 'https://reylinks.atexgrp.com', '', '2026-07-14 16:38:49', '2026-07-14 16:38:49'),
    (36, 18, 'Dana Links', 'http://dana.mar-ston.org/', '', '2026-07-14 16:38:49', '2026-07-14 16:38:49'),
    (37, 18, 'Tatum Links', 'https://tmlinks.atexgrp.com/', '', '2026-07-14 16:38:49', '2026-07-14 16:38:49')
ON DUPLICATE KEY UPDATE
    `project_id` = VALUES(`project_id`),
    `label` = VALUES(`label`),
    `prod_url` = VALUES(`prod_url`),
    `local_url` = VALUES(`local_url`),
    `updated_at` = VALUES(`updated_at`)
;

COMMIT;
