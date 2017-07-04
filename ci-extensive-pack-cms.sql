-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Czas generowania: 23 Cze 2017, 15:16
-- Wersja serwera: 10.1.19-MariaDB
-- Wersja PHP: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `ci-extensive-pack-cms`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `menu`
--

CREATE TABLE `menu` (
  `me_id` int(11) UNSIGNED NOT NULL,
  `me_title` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `me_title_alt` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `me_link` varchar(255) COLLATE utf8_polish_ci DEFAULT NULL,
  `me_order` int(11) UNSIGNED NOT NULL,
  `me_created_at` datetime DEFAULT NULL,
  `me_created_by` int(11) UNSIGNED DEFAULT NULL,
  `me_updated_at` datetime DEFAULT NULL,
  `me_updated_by` int(11) UNSIGNED DEFAULT NULL,
  `me_deleted_at` datetime DEFAULT NULL,
  `me_deleted_by` int(11) UNSIGNED DEFAULT NULL,
  `me_pa_slug` varchar(255) COLLATE utf8_polish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `menu`
--

INSERT INTO `menu` (`me_id`, `me_title`, `me_title_alt`, `me_link`, `me_order`, `me_created_at`, `me_created_by`, `me_updated_at`, `me_updated_by`, `me_deleted_at`, `me_deleted_by`, `me_pa_slug`) VALUES
(7, 'Link testowy', 'Link testowy 2 3', '#', 0, '2017-06-23 10:56:28', 1, '2017-06-23 15:12:00', 1, NULL, NULL, NULL),
(8, 'Kontakt', 'Kontakt', NULL, 1, '2017-06-23 11:06:02', 1, '2017-06-23 15:12:00', NULL, NULL, NULL, 'kontakt'),
(11, 'Strona domowa', 'Strona domowa', NULL, 2, '2017-06-23 12:27:51', 1, '2017-06-23 15:12:00', NULL, NULL, NULL, 'strona-domowa');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `module`
--

CREATE TABLE `module` (
  `mo_id` int(11) UNSIGNED NOT NULL,
  `mo_variables` text COLLATE utf8_polish_ci NOT NULL,
  `mo_form` text COLLATE utf8_polish_ci,
  `mo_layout` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `mo_body` text COLLATE utf8_polish_ci NOT NULL,
  `mo_description` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `mo_order` int(11) UNSIGNED NOT NULL,
  `mo_created_at` datetime DEFAULT NULL,
  `mo_created_by` int(11) UNSIGNED DEFAULT NULL,
  `mo_updated_at` datetime DEFAULT NULL,
  `mo_updated_by` int(11) UNSIGNED DEFAULT NULL,
  `mo_deleted_at` datetime DEFAULT NULL,
  `mo_deleted_by` int(11) UNSIGNED DEFAULT NULL,
  `mo_pa_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `module`
--

INSERT INTO `module` (`mo_id`, `mo_variables`, `mo_form`, `mo_layout`, `mo_body`, `mo_description`, `mo_order`, `mo_created_at`, `mo_created_by`, `mo_updated_at`, `mo_updated_by`, `mo_deleted_at`, `mo_deleted_by`, `mo_pa_id`) VALUES
(23, '{"var-main-text":"Rejestruj si\\u0119 tera!","var-helper-text":"lalala","var-button-text":"Zapisz","var-uri":"\\/kontakt"}', '<p><strong class="c-white">Wezwanie do działania</strong></p>\r\n<p><small>Pola oznaczone <code>*</code> są obowiązkowe</small></p>\r\n<div class="row">\r\n    <div class="col-sm-12">\r\n        <div class="form-group"><label for="var-main-text" class="col-sm-3 control-label">Tekst główny <code>*</code></label>\r\n            <div class="col-sm-9"><input type="text" name="var-main-text" class="form-control" value="Rejestruj się tera!" placeholder="Np. Zarejestruj się teraz"></div>\r\n        </div>\r\n        <div class="form-group"><label for="var-helper-text" class="col-sm-3 control-label">Tekst pomocniczy </label>\r\n            <div class="col-sm-9"><input type="text" name="var-helper-text" class="form-control" value="lalala" placeholder="Np. Otrzymasz 20% zniżki"></div>\r\n        </div>\r\n        <div class="form-group"><label for="var-button-text" class="col-sm-3 control-label">Nazwa przycisku <code>*</code></label>\r\n            <div class="col-sm-9"><input type="text" name="var-button-text" class="form-control" value="Zapisz" placeholder="Np. Rejestruj"></div>\r\n        </div>\r\n        <div class="form-group"><label for="var-uri" class="col-sm-3 control-label">Odnośnik <code>*</code></label>\r\n            <div class="col-sm-9"><input type="text" name="var-uri" class="form-control" value="/kontakt" placeholder="Np. /kontakt"></div>\r\n        </div>\r\n        <hr />\r\n        <div class="form-group"><label for="mo_description" class="col-sm-3 control-label">Własny opis modulu </label>\r\n            <div class="col-sm-9"><input type="text" name="mo_description" class="form-control" value="Homero CTA" placeholder="Np. Zapisanie do newslettera"></div>\r\n        </div>\r\n    </div>\r\n</div>', 'CTA.twig', '<section id="action-box" class="pad-25">\r\n    <div class="container">\r\n        <div class="action-box">\r\n            <h3>Rejestruj się tera!</h3>\r\n            <p>lalala</p>\r\n            <a href="/kontakt" class="btn btn-flat flat-color">Zapisz</a>\r\n        </div>\r\n        <!-- /.action-box -->\r\n    </div>\r\n    <!-- /.container -->\r\n</section>\r\n<!-- /#action-box -->', 'Homero CTA', 0, '2017-06-22 14:08:44', 1, '2017-06-23 11:26:24', NULL, NULL, NULL, 3),
(25, '{"var-main-text":"Hello My Friends","var-helper-text":"A nic nie stracisz ;)","var-button-text":"Zapisz","var-uri":"Test3"}', '<p><strong class="c-white">Wezwanie do działania</strong></p>\r\n<p><small>Pola oznaczone <code>*</code> są obowiązkowe</small></p>\r\n<div class="row">\r\n    <div class="col-sm-12">\r\n        <div class="form-group"><label for="var-main-text" class="col-sm-3 control-label">Tekst główny <code>*</code></label>\r\n            <div class="col-sm-9"><input type="text" name="var-main-text" class="form-control" value="Hello My Friends" placeholder="Np. Zarejestruj się teraz"></div>\r\n        </div>\r\n        <div class="form-group"><label for="var-helper-text" class="col-sm-3 control-label">Tekst pomocniczy </label>\r\n            <div class="col-sm-9"><input type="text" name="var-helper-text" class="form-control" value="A nic nie stracisz ;)" placeholder="Np. Otrzymasz 20% zniżki"></div>\r\n        </div>\r\n        <div class="form-group"><label for="var-button-text" class="col-sm-3 control-label">Nazwa przycisku <code>*</code></label>\r\n            <div class="col-sm-9"><input type="text" name="var-button-text" class="form-control" value="Zapisz" placeholder="Np. Rejestruj"></div>\r\n        </div>\r\n        <div class="form-group"><label for="var-uri" class="col-sm-3 control-label">Odnośnik <code>*</code></label>\r\n            <div class="col-sm-9"><input type="text" name="var-uri" class="form-control" value="Test3" placeholder="Np. /kontakt"></div>\r\n        </div>\r\n        <hr />\r\n        <div class="form-group"><label for="mo_description" class="col-sm-3 control-label">Własny opis modulu </label>\r\n            <div class="col-sm-9"><input type="text" name="mo_description" class="form-control" value="Ihaaa" placeholder="Np. Zapisanie do newslettera"></div>\r\n        </div>\r\n    </div>\r\n</div>', 'CTA.twig', '<section id="action-box" class="pad-25">\r\n    <div class="container">\r\n        <div class="action-box">\r\n            <h3>Hello My Friends</h3>\r\n            <p>A nic nie stracisz ;)</p>\r\n            <a href="Test3" class="btn btn-flat flat-color">Zapisz</a>\r\n        </div>\r\n        <!-- /.action-box -->\r\n    </div>\r\n    <!-- /.container -->\r\n</section>\r\n<!-- /#action-box -->', 'Ihaaa', 1, '2017-06-22 21:20:04', 1, '2017-06-23 11:26:24', NULL, NULL, NULL, 3),
(26, '{"var-main-text":"Hello My Friends","var-helper-text":"A nic nie stracisz ;)","var-button-text":"Come With ME","var-uri":"\\/kontakt\\/1"}', '<p><strong class="c-white">Wezwanie do działania</strong></p>\r\n<p><small>Pola oznaczone <code>*</code> są obowiązkowe</small></p>\r\n<div class="row">\r\n    <div class="col-sm-12">\r\n        <div class="form-group"><label for="var-main-text" class="col-sm-3 control-label">Tekst główny <code>*</code></label>\r\n            <div class="col-sm-9"><input type="text" name="var-main-text" class="form-control" value="Hello My Friends" placeholder="Np. Zarejestruj się teraz"></div>\r\n        </div>\r\n        <div class="form-group"><label for="var-helper-text" class="col-sm-3 control-label">Tekst pomocniczy </label>\r\n            <div class="col-sm-9"><input type="text" name="var-helper-text" class="form-control" value="A nic nie stracisz ;)" placeholder="Np. Otrzymasz 20% zniżki"></div>\r\n        </div>\r\n        <div class="form-group"><label for="var-button-text" class="col-sm-3 control-label">Nazwa przycisku <code>*</code></label>\r\n            <div class="col-sm-9"><input type="text" name="var-button-text" class="form-control" value="Come With ME" placeholder="Np. Rejestruj"></div>\r\n        </div>\r\n        <div class="form-group"><label for="var-uri" class="col-sm-3 control-label">Odnośnik <code>*</code></label>\r\n            <div class="col-sm-9"><input type="text" name="var-uri" class="form-control" value="/kontakt/1" placeholder="Np. /kontakt"></div>\r\n        </div>\r\n        <hr />\r\n        <div class="form-group"><label for="mo_description" class="col-sm-3 control-label">Własny opis modulu </label>\r\n            <div class="col-sm-9"><input type="text" name="mo_description" class="form-control" value="Wezwanie do działania 1987" placeholder="Np. Zapisanie do newslettera"></div>\r\n        </div>\r\n    </div>\r\n</div>', 'CTA.twig', '<section id="action-box" class="pad-25">\r\n    <div class="container">\r\n        <div class="action-box">\r\n            <h3>Hello My Friends</h3>\r\n            <p>A nic nie stracisz ;)</p>\r\n            <a href="/kontakt/1" class="btn btn-flat flat-color">Come With ME</a>\r\n        </div>\r\n        <!-- /.action-box -->\r\n    </div>\r\n    <!-- /.container -->\r\n</section>\r\n<!-- /#action-box -->', 'Wezwanie do działania 1987', 0, '2017-06-22 21:34:50', 1, '2017-06-22 21:34:56', NULL, NULL, NULL, 4);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `page`
--

CREATE TABLE `page` (
  `pa_id` int(11) UNSIGNED NOT NULL,
  `pa_title` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `pa_slug` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `pa_description` text COLLATE utf8_polish_ci,
  `pa_order` int(10) UNSIGNED DEFAULT NULL,
  `pa_parent_id` int(11) UNSIGNED DEFAULT '0',
  `pa_layout` varchar(255) COLLATE utf8_polish_ci DEFAULT NULL COMMENT 'Nie wiem czy to zostanie... trza coś pomyśleć',
  `pa_status` varchar(255) COLLATE utf8_polish_ci NOT NULL DEFAULT 'Aktywna',
  `pa_created_at` datetime DEFAULT NULL,
  `pa_created_by` int(11) UNSIGNED DEFAULT NULL,
  `pa_updated_at` datetime DEFAULT NULL,
  `pa_updated_by` int(11) UNSIGNED DEFAULT NULL,
  `pa_deleted_at` datetime DEFAULT NULL,
  `pa_deleted_by` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `page`
--

INSERT INTO `page` (`pa_id`, `pa_title`, `pa_slug`, `pa_description`, `pa_order`, `pa_parent_id`, `pa_layout`, `pa_status`, `pa_created_at`, `pa_created_by`, `pa_updated_at`, `pa_updated_by`, `pa_deleted_at`, `pa_deleted_by`) VALUES
(2, 'Strona domowa', 'strona-domowa', 'To jest opis strony domowej', 0, 7, 'kulemolehahaha', 'Aktywna', '2017-06-16 10:31:22', 1, '2017-06-23 14:53:26', 1, NULL, NULL),
(3, 'Kontakt', 'kontakt', 'To jest opis strony kontaktowej', 1, 7, 'f2', 'Aktywna', '2017-06-21 20:31:27', 1, '2017-06-23 14:53:27', 1, NULL, NULL),
(4, 'Mapka dojazdu', 'mapka-dojazdu', NULL, 0, 0, NULL, 'Aktywna', '2017-06-22 21:22:31', 1, '2017-06-23 14:59:37', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `session`
--

CREATE TABLE `session` (
  `id` varchar(128) COLLATE utf8_polish_ci NOT NULL,
  `ip_address` varchar(45) COLLATE utf8_polish_ci NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `session`
--

INSERT INTO `session` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('2j3h9bkoq94figmr1rfq5hm1olr2m8qi', '::1', 1498203122, 0x5f5f63695f6c6173745f726567656e65726174657c693a313439383230333031303b75735f69647c733a313a2231223b75735f666e616d657c733a343a224d617275223b75735f6c6e616d657c733a383a2244617265636b6961223b75735f656d61696c7c733a363a226440642e6465223b75735f617574687c733a31313a2253757065722041646d696e223b6c6f67676564696e7c623a313b75735f706173735f74656d707c623a313b),
('q5kaap3ojamjunn7grbqnc7opjat9upm', '::1', 1498203506, 0x5f5f63695f6c6173745f726567656e65726174657c693a313439383230333530363b75735f69647c733a313a2231223b75735f666e616d657c733a343a224d617275223b75735f6c6e616d657c733a383a2244617265636b6961223b75735f656d61696c7c733a363a226440642e6465223b75735f617574687c733a31313a2253757065722041646d696e223b6c6f67676564696e7c623a313b75735f706173735f74656d707c623a313b),
('jhamlh7rsfj67bufss6iqiau2pa9hduq', '::1', 1498204115, 0x5f5f63695f6c6173745f726567656e65726174657c693a313439383230333837323b75735f69647c733a313a2231223b75735f666e616d657c733a343a224d617275223b75735f6c6e616d657c733a383a2244617265636b6961223b75735f656d61696c7c733a363a226440642e6465223b75735f617574687c733a31313a2253757065722041646d696e223b6c6f67676564696e7c623a313b75735f706173735f74656d707c623a313b),
('fv0dafeer7p047gktm9qgvk3e6e81ajl', '::1', 1498204567, 0x5f5f63695f6c6173745f726567656e65726174657c693a313439383230343330313b75735f69647c733a313a2231223b75735f666e616d657c733a343a224d617275223b75735f6c6e616d657c733a383a2244617265636b6961223b75735f656d61696c7c733a363a226440642e6465223b75735f617574687c733a31313a2253757065722041646d696e223b6c6f67676564696e7c623a313b75735f706173735f74656d707c623a313b),
('u0o9e54qshdcppmpfi62g362gfaa9gau', '::1', 1498205753, 0x5f5f63695f6c6173745f726567656e65726174657c693a313439383230353732383b75735f69647c733a313a2231223b75735f666e616d657c733a343a224d617275223b75735f6c6e616d657c733a383a2244617265636b6961223b75735f656d61696c7c733a363a226440642e6465223b75735f617574687c733a31313a2253757065722041646d696e223b6c6f67676564696e7c623a313b75735f706173735f74656d707c623a313b),
('d6i1v2gvq42tcjf3m8ujeprtchubvo56', '::1', 1498206615, 0x5f5f63695f6c6173745f726567656e65726174657c693a313439383230363538363b75735f69647c733a313a2231223b75735f666e616d657c733a343a224d617275223b75735f6c6e616d657c733a383a2244617265636b6961223b75735f656d61696c7c733a363a226440642e6465223b75735f617574687c733a31313a2253757065722041646d696e223b6c6f67676564696e7c623a313b75735f706173735f74656d707c623a313b),
('323behe848unqtrrfb5rromjhi7duk1k', '::1', 1498207179, 0x5f5f63695f6c6173745f726567656e65726174657c693a313439383230363839303b75735f69647c733a313a2231223b75735f666e616d657c733a343a224d617275223b75735f6c6e616d657c733a383a2244617265636b6961223b75735f656d61696c7c733a363a226440642e6465223b75735f617574687c733a31313a2253757065722041646d696e223b6c6f67676564696e7c623a313b75735f706173735f74656d707c623a313b),
('1a0am4kdmqisgqcov5vpndmss7qph07u', '::1', 1498207901, 0x5f5f63695f6c6173745f726567656e65726174657c693a313439383230373638323b75735f69647c733a313a2231223b75735f666e616d657c733a343a224d617275223b75735f6c6e616d657c733a383a2244617265636b6961223b75735f656d61696c7c733a363a226440642e6465223b75735f617574687c733a31313a2253757065722041646d696e223b6c6f67676564696e7c623a313b75735f706173735f74656d707c623a313b),
('6grhpi1qogce2aa23rm8n8bv0qidp486', '::1', 1498208458, 0x5f5f63695f6c6173745f726567656e65726174657c693a313439383230383138313b75735f69647c733a313a2231223b75735f666e616d657c733a343a224d617275223b75735f6c6e616d657c733a383a2244617265636b6961223b75735f656d61696c7c733a363a226440642e6465223b75735f617574687c733a31313a2253757065722041646d696e223b6c6f67676564696e7c623a313b75735f706173735f74656d707c623a313b),
('dn89omnij682uq66hehvl8tvrs5qccdm', '::1', 1498208808, 0x5f5f63695f6c6173745f726567656e65726174657c693a313439383230383532343b75735f69647c733a313a2231223b75735f666e616d657c733a343a224d617275223b75735f6c6e616d657c733a383a2244617265636b6961223b75735f656d61696c7c733a363a226440642e6465223b75735f617574687c733a31313a2253757065722041646d696e223b6c6f67676564696e7c623a313b75735f706173735f74656d707c623a313b),
('06mlo6slup8p9j76g6vo0j4uf1k0n42r', '::1', 1498209106, 0x5f5f63695f6c6173745f726567656e65726174657c693a313439383230383833323b75735f69647c733a313a2231223b75735f666e616d657c733a343a224d617275223b75735f6c6e616d657c733a383a2244617265636b6961223b75735f656d61696c7c733a363a226440642e6465223b75735f617574687c733a31313a2253757065722041646d696e223b6c6f67676564696e7c623a313b75735f706173735f74656d707c623a313b),
('b2knmsk5k1h0a3r56r9tck5b1prl07tf', '::1', 1498209692, 0x5f5f63695f6c6173745f726567656e65726174657c693a313439383230393230323b75735f69647c733a313a2231223b75735f666e616d657c733a343a224d617275223b75735f6c6e616d657c733a383a2244617265636b6961223b75735f656d61696c7c733a363a226440642e6465223b75735f617574687c733a31313a2253757065722041646d696e223b6c6f67676564696e7c623a313b75735f706173735f74656d707c623a313b),
('8dsmqod12gn648c6g3h4nrlageksj4lh', '::1', 1498209985, 0x5f5f63695f6c6173745f726567656e65726174657c693a313439383230393830393b75735f69647c733a313a2231223b75735f666e616d657c733a343a224d617275223b75735f6c6e616d657c733a383a2244617265636b6961223b75735f656d61696c7c733a363a226440642e6465223b75735f617574687c733a31313a2253757065722041646d696e223b6c6f67676564696e7c623a313b75735f706173735f74656d707c623a313b),
('rj167vsc32bg7e4utkh97t56fen5bkh7', '::1', 1498210359, 0x5f5f63695f6c6173745f726567656e65726174657c693a313439383231303231303b75735f69647c733a313a2231223b75735f666e616d657c733a343a224d617275223b75735f6c6e616d657c733a383a2244617265636b6961223b75735f656d61696c7c733a363a226440642e6465223b75735f617574687c733a31313a2253757065722041646d696e223b6c6f67676564696e7c623a313b75735f706173735f74656d707c623a313b),
('eaa4crtai1md8j7im34jeela859lh4sd', '::1', 1498210622, 0x5f5f63695f6c6173745f726567656e65726174657c693a313439383231303632313b75735f69647c733a313a2231223b75735f666e616d657c733a343a224d617275223b75735f6c6e616d657c733a383a2244617265636b6961223b75735f656d61696c7c733a363a226440642e6465223b75735f617574687c733a31313a2253757065722041646d696e223b6c6f67676564696e7c623a313b75735f706173735f74656d707c623a313b),
('ff5siroh6fb61sbdo7tkkidbc56m1qbg', '::1', 1498212621, 0x5f5f63695f6c6173745f726567656e65726174657c693a313439383231323335373b75735f69647c733a313a2231223b75735f666e616d657c733a343a224d617275223b75735f6c6e616d657c733a383a2244617265636b6961223b75735f656d61696c7c733a363a226440642e6465223b75735f617574687c733a31313a2253757065722041646d696e223b6c6f67676564696e7c623a313b75735f706173735f74656d707c623a313b),
('rhcevj5ae5k608fll09fpgetvvhpqdch', '::1', 1498213061, 0x5f5f63695f6c6173745f726567656e65726174657c693a313439383231323839363b75735f69647c733a313a2231223b75735f666e616d657c733a343a224d617275223b75735f6c6e616d657c733a383a2244617265636b6961223b75735f656d61696c7c733a363a226440642e6465223b75735f617574687c733a31313a2253757065722041646d696e223b6c6f67676564696e7c623a313b75735f706173735f74656d707c623a313b),
('6vv8p0n6e98peaonr8uq1lotb141guf1', '::1', 1498213682, 0x5f5f63695f6c6173745f726567656e65726174657c693a313439383231333431373b75735f69647c733a313a2231223b75735f666e616d657c733a343a224d617275223b75735f6c6e616d657c733a383a2244617265636b6961223b75735f656d61696c7c733a363a226440642e6465223b75735f617574687c733a31313a2253757065722041646d696e223b6c6f67676564696e7c623a313b75735f706173735f74656d707c623a313b),
('7lpcnunml5jum50465t6i43f1hfulk41', '::1', 1498213827, 0x5f5f63695f6c6173745f726567656e65726174657c693a313439383231333832363b75735f69647c733a313a2231223b75735f666e616d657c733a343a224d617275223b75735f6c6e616d657c733a383a2244617265636b6961223b75735f656d61696c7c733a363a226440642e6465223b75735f617574687c733a31313a2253757065722041646d696e223b6c6f67676564696e7c623a313b75735f706173735f74656d707c623a313b),
('ci7rkk9idt3u6qkptna059f5l4u8ovmr', '::1', 1498220573, 0x5f5f63695f6c6173745f726567656e65726174657c693a313439383232303334383b75735f69647c733a313a2231223b75735f666e616d657c733a343a224d617275223b75735f6c6e616d657c733a383a2244617265636b6961223b75735f656d61696c7c733a363a226440642e6465223b75735f617574687c733a31313a2253757065722041646d696e223b6c6f67676564696e7c623a313b75735f706173735f74656d707c623a313b),
('mpp3fvuaas4un4njj84v6i8b5f6o1tn8', '::1', 1498220821, 0x5f5f63695f6c6173745f726567656e65726174657c693a313439383232303636313b75735f69647c733a313a2231223b75735f666e616d657c733a343a224d617275223b75735f6c6e616d657c733a383a2244617265636b6961223b75735f656d61696c7c733a363a226440642e6465223b75735f617574687c733a31313a2253757065722041646d696e223b6c6f67676564696e7c623a313b75735f706173735f74656d707c623a313b),
('1k96ngs4e4vtf7sp7i6rl9flj3nra6de', '::1', 1498221197, 0x5f5f63695f6c6173745f726567656e65726174657c693a313439383232303939383b75735f69647c733a313a2231223b75735f666e616d657c733a343a224d617275223b75735f6c6e616d657c733a383a2244617265636b6961223b75735f656d61696c7c733a363a226440642e6465223b75735f617574687c733a31313a2253757065722041646d696e223b6c6f67676564696e7c623a313b75735f706173735f74656d707c623a313b),
('a8n5ng02qhcdfdbrd8c1ljsr7r8ubdm7', '::1', 1498221643, 0x5f5f63695f6c6173745f726567656e65726174657c693a313439383232313338303b75735f69647c733a313a2231223b75735f666e616d657c733a343a224d617275223b75735f6c6e616d657c733a383a2244617265636b6961223b75735f656d61696c7c733a363a226440642e6465223b75735f617574687c733a31313a2253757065722041646d696e223b6c6f67676564696e7c623a313b75735f706173735f74656d707c623a313b),
('024t2n7fpv72pe60eatsbd106jguevh2', '::1', 1498222036, 0x5f5f63695f6c6173745f726567656e65726174657c693a313439383232313734373b75735f69647c733a313a2231223b75735f666e616d657c733a343a224d617275223b75735f6c6e616d657c733a383a2244617265636b6961223b75735f656d61696c7c733a363a226440642e6465223b75735f617574687c733a31313a2253757065722041646d696e223b6c6f67676564696e7c623a313b75735f706173735f74656d707c623a313b),
('alv7q4cu5t3mm650o8cauqqffo8dokl3', '::1', 1498222059, 0x5f5f63695f6c6173745f726567656e65726174657c693a313439383232323035383b75735f69647c733a313a2231223b75735f666e616d657c733a343a224d617275223b75735f6c6e616d657c733a383a2244617265636b6961223b75735f656d61696c7c733a363a226440642e6465223b75735f617574687c733a31313a2253757065722041646d696e223b6c6f67676564696e7c623a313b75735f706173735f74656d707c623a313b),
('qh2rf7phn4735ur3tq9n4e4r211b5q3p', '::1', 1498222706, 0x5f5f63695f6c6173745f726567656e65726174657c693a313439383232323430363b75735f69647c733a313a2231223b75735f666e616d657c733a343a224d617275223b75735f6c6e616d657c733a383a2244617265636b6961223b75735f656d61696c7c733a363a226440642e6465223b75735f617574687c733a31313a2253757065722041646d696e223b6c6f67676564696e7c623a313b75735f706173735f74656d707c623a313b),
('7ah07kq5v1jar71ivbohles374qt3hmd', '::1', 1498223041, 0x5f5f63695f6c6173745f726567656e65726174657c693a313439383232323737373b75735f69647c733a313a2231223b75735f666e616d657c733a343a224d617275223b75735f6c6e616d657c733a383a2244617265636b6961223b75735f656d61696c7c733a363a226440642e6465223b75735f617574687c733a31313a2253757065722041646d696e223b6c6f67676564696e7c623a313b75735f706173735f74656d707c623a313b);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `template`
--

CREATE TABLE `template` (
  `xx_created_at` datetime DEFAULT NULL,
  `xx_created_by` int(11) UNSIGNED DEFAULT NULL,
  `xx_updated_at` datetime DEFAULT NULL,
  `xx_updated_by` int(11) UNSIGNED DEFAULT NULL,
  `xx_deleted_at` datetime DEFAULT NULL,
  `xx_deleted_by` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user`
--

CREATE TABLE `user` (
  `us_id` int(11) UNSIGNED NOT NULL,
  `us_fname` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `us_lname` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `us_email` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `us_pass` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `us_pass_temp` varchar(255) COLLATE utf8_polish_ci DEFAULT NULL,
  `us_auth` varchar(255) COLLATE utf8_polish_ci NOT NULL DEFAULT 'Admin',
  `us_status` varchar(255) COLLATE utf8_polish_ci NOT NULL DEFAULT 'Aktywny',
  `us_created_at` datetime DEFAULT NULL,
  `us_created_by` int(11) UNSIGNED DEFAULT NULL,
  `us_updated_at` datetime DEFAULT NULL,
  `us_updated_by` int(11) UNSIGNED DEFAULT NULL,
  `us_deleted_at` datetime DEFAULT NULL,
  `us_deleted_by` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `user`
--

INSERT INTO `user` (`us_id`, `us_fname`, `us_lname`, `us_email`, `us_pass`, `us_pass_temp`, `us_auth`, `us_status`, `us_created_at`, `us_created_by`, `us_updated_at`, `us_updated_by`, `us_deleted_at`, `us_deleted_by`) VALUES
(1, 'Maru', 'Dareckia', 'd@d.de', 'bb48ce2a84ececeef296fb0110dd42470448058d639fd22b95331817d14a90ab88a8bcdd2712d8c7bbccbb8db7932c82497598e642a56ad254077ae4291fd21a', 'bb48ce2a84ececeef296fb0110dd42470448058d639fd22b95331817d14a90ab88a8bcdd2712d8c7bbccbb8db7932c82497598e642a56ad254077ae4291fd21a', 'Super Admin', 'Aktywny', NULL, NULL, '2017-06-13 10:06:33', 1, NULL, NULL),
(2, 'Jan', 'Testowyaa', 'j@d.de', 'bb48ce2a84ececeef296fb0110dd42470448058d639fd22b95331817d14a90ab88a8bcdd2712d8c7bbccbb8db7932c82497598e642a56ad254077ae4291fd21a', '785beb42c72e8d0390e8cda7436861e6b955c9b2841ed7949dab34fbc773e9653d7b4b8bec4e4de3a036f0e3671cacaa277063cdc92a518b01622add77cbfc8a', 'Admin', 'Aktywny', NULL, NULL, '2017-06-13 13:05:33', 1, NULL, NULL),
(14, 'Puzel', 'Nuzel', 'aa@ds.de', 'bb48ce2a84ececeef296fb0110dd42470448058d639fd22b95331817d14a90ab88a8bcdd2712d8c7bbccbb8db7932c82497598e642a56ad254077ae4291fd21a', 'd49133db26663443993b705e74b18ea11849308f2ee7dc79a2d0774bfc2549447b6f6e08f990caa343a16d7576b1d631bb0c6258e7cb72ef2333fd238120a736', 'Admin', 'Aktywny', '2017-06-12 21:26:41', 1, '2017-06-13 11:59:02', 1, NULL, NULL);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`me_id`);

--
-- Indexes for table `module`
--
ALTER TABLE `module`
  ADD PRIMARY KEY (`mo_id`);

--
-- Indexes for table `page`
--
ALTER TABLE `page`
  ADD PRIMARY KEY (`pa_id`);

--
-- Indexes for table `session`
--
ALTER TABLE `session`
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`us_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `menu`
--
ALTER TABLE `menu`
  MODIFY `me_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT dla tabeli `module`
--
ALTER TABLE `module`
  MODIFY `mo_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT dla tabeli `page`
--
ALTER TABLE `page`
  MODIFY `pa_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT dla tabeli `user`
--
ALTER TABLE `user`
  MODIFY `us_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;