-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 09-Jul-2020 às 17:39
-- Versão do servidor: 10.4.13-MariaDB
-- versão do PHP: 7.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `casa`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `avaliacoes`
--

CREATE TABLE `avaliacoes` (
  `idavaliacao` int(11) NOT NULL,
  `idutilizador` int(11) NOT NULL,
  `avaliacao` int(11) NOT NULL,
  `nome` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `comment` text NOT NULL,
  `data` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `banner_text`
--

CREATE TABLE `banner_text` (
  `idbanner_txt` int(11) NOT NULL,
  `tittle_pt` varchar(200) NOT NULL,
  `tittle_en` varchar(200) NOT NULL,
  `tittle_es` varchar(200) NOT NULL,
  `text_pt` text NOT NULL,
  `text_en` text NOT NULL,
  `text_es` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `banner_text`
--

INSERT INTO `banner_text` (`idbanner_txt`, `tittle_pt`, `tittle_en`, `tittle_es`, `text_pt`, `text_en`, `text_es`) VALUES
(1, 'São Gregório Alojamento Local', 'Sona A Luxury House', ' Sona, una casa de lujo', 'Aqui estão os melhores sites de reservas de hotéis, incluindo recomendações para viagens internacionais e para encontrar quartos com preços baixos.', 'Here are the best hotel booking sites, including recommendations for international travel and for finding low-priced hotel rooms.', 'Aquí están los mejores sitios de reserva de hoteles, incluidas las recomendaciones para viajes internacionales y la búsqueda de habitaciones de bajo precio.');

-- --------------------------------------------------------

--
-- Estrutura da tabela `categorias`
--

CREATE TABLE `categorias` (
  `idcategoriav` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `nome_en` varchar(100) NOT NULL,
  `nome_es` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `categorias`
--

INSERT INTO `categorias` (`idcategoriav`, `nome`, `nome_en`, `nome_es`) VALUES
(2, 'Viagem', 'Trip', 'Viaje'),
(4, 'Comida', 'Food', 'Comida');

-- --------------------------------------------------------

--
-- Estrutura da tabela `contactos`
--

CREATE TABLE `contactos` (
  `idcontacto` int(11) NOT NULL,
  `morada` varchar(250) NOT NULL,
  `tele` varchar(19) NOT NULL,
  `email` varchar(300) NOT NULL,
  `face` varchar(300) NOT NULL,
  `insta` varchar(300) NOT NULL,
  `twitter` varchar(300) NOT NULL,
  `mapa` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `contactos`
--

INSERT INTO `contactos` (`idcontacto`, `morada`, `tele`, `email`, `face`, `insta`, `twitter`, `mapa`) VALUES
(1, '856 Cordia Extension Apt. 356, Lake, US', '(+351) 912 345 678', 'info.casasaogregorio@gmail.com', '#', '#', '#', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2994.2316771540104!2d-8.48339504882931!3d41.369050979164044!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd24f60088a8d6e5%3A0x1ea946592b98996a!2sOFICINA%20-%20Escola%20Profissional%20do%20Instituto%20Nun\'Alvres!5e0!3m2!1spt-PT!2spt!4v1589456389186!5m2!1spt-PT!2spt\" width=\"1140\" height=\"470\" frameborder=\"0\" style=\"border:0;\" allowfullscreen=\"\" aria-hidden=\"false\" tabindex=\"0\"></iframe>');

-- --------------------------------------------------------

--
-- Estrutura da tabela `eventos`
--

CREATE TABLE `eventos` (
  `idevento` int(11) NOT NULL,
  `nome` varchar(250) NOT NULL,
  `data` date NOT NULL,
  `img` varchar(1000) NOT NULL,
  `link` varchar(300) NOT NULL,
  `ativo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `eventos`
--

INSERT INTO `eventos` (`idevento`, `nome`, `data`, `img`, `link`, `ativo`) VALUES
(1, 'Tremblant In Canadaaa', '2020-05-29', '87b3cc5a8f4b06b0ba16c6fa44185dc1.jpg', 'https://amera.com.pt/pt/', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `footer`
--

CREATE TABLE `footer` (
  `idfooter` int(11) NOT NULL,
  `texto` text NOT NULL,
  `texto_en` text NOT NULL,
  `texto_es` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `footer`
--

INSERT INTO `footer` (`idfooter`, `texto`, `texto_en`, `texto_es`) VALUES
(1, 'Inspiramos e alcançamos milhões de viajantes em 90 sites locais', 'We inspire and reach millions of travelers across 90 local websites', 'Inspiramos y llegamos a millones de viajeros en 90 sitios web locales.');

-- --------------------------------------------------------

--
-- Estrutura da tabela `galeria`
--

CREATE TABLE `galeria` (
  `idfoto` int(11) NOT NULL,
  `foto` varchar(1000) NOT NULL,
  `banner` int(11) NOT NULL,
  `galeria_principal` int(11) NOT NULL,
  `casa` int(11) NOT NULL,
  `galeria` int(11) NOT NULL,
  `ativo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `galeria`
--

INSERT INTO `galeria` (`idfoto`, `foto`, `banner`, `galeria_principal`, `casa`, `galeria`, `ativo`) VALUES
(2, '74c1d9766af8b9ff13485e467ee3d6f3.jpg', 1, 0, 0, 0, 1),
(6, 'f5153d89f6c326e2fe68bd5fb527bac5.jpg', 1, 0, 0, 0, 1),
(18, '3f0edd785562ec8c917137b108406408.jpg', 1, 0, 0, 0, 1),
(23, '2ebf36a85159d3a90856f7719fc76a72.jpg', 0, 1, 1, 0, 1),
(24, '62037ec274560cc9169c98017b6aee4e.jpg', 0, 1, 0, 1, 1),
(25, 'a4ee27d4b6276f2dc34afe4e516e2594.jpg', 0, 1, 0, 1, 1),
(26, '2e2e42c002368c49e9b1cfcdc7d0c69c.jpg', 0, 1, 0, 1, 1),
(28, '1c63aea3d1dcb83203798fc0c5d0c97f.jpg', 0, 1, 0, 1, 1),
(29, '883f5d2062be080e96236b88b40f3211.jpg', 0, 1, 0, 1, 1),
(35, 'b0cf19852df9b745efedbfe341cb3f59.jpg', 0, 1, 0, 1, 1),
(36, 'a865b874c4121c8362b57d6000fc3445.jpg', 0, 1, 1, 0, 1),
(37, '0c2ce1960f5a6e657c033d8331ac23a9.jpg', 0, 1, 1, 0, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `galeria_visita`
--

CREATE TABLE `galeria_visita` (
  `idfoto_visita` int(11) NOT NULL,
  `foto` varchar(1000) NOT NULL,
  `idvisita` int(11) NOT NULL,
  `ext` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `galeria_visita`
--

INSERT INTO `galeria_visita` (`idfoto_visita`, `foto`, `idvisita`, `ext`) VALUES
(37, 'c2594861a485b43cb383ef61291acb64.jpg', 40, '.jpg'),
(38, '730c367a1b2f41cc67a11aba7986d0da.jpg', 40, '.jpg'),
(39, '09b92fa884e8c33170793e24b04332d3.jpg', 40, '.jpg'),
(43, '51a22e39b08ab08c3113ee270fa73a58.jpg', 42, '.jpg'),
(44, '4fdcc4cc9b2832fb7c206c5274b41042.jpg', 42, '.jpg'),
(45, 'f1b9faf718a04cfa3e4c275dd9d95a62.jpg', 42, '.jpg'),
(46, '2943eeee38013c1bdc017b6d23069d06.jpg', 43, '.jpg'),
(47, '98aedab55ce87d7080cdcbe3d771b58e.jpg', 43, '.jpg'),
(48, '5ce85da72f0dfc233c7bd3b7333411fa.jpg', 43, '.jpg'),
(49, '70657f0f4b1fe7f25e44573f5d1e1703.jpg', 44, '.jpg'),
(50, '4c5a7341acb19eb05ec0ca1ca362d823.jpg', 44, '.jpg'),
(51, 'f7a5dffbcadd2a9425c3833dc5fddb5c.jpg', 44, '.jpg'),
(52, '8d37eac02f89062a020e96db5169662a.jpg', 45, '.jpg'),
(53, 'ff024944d3faabfc1d5a720bab1b331e.jpg', 45, '.jpg'),
(54, '0dc1394326c6b509b14c3b22c711bc7f.jpg', 45, '.jpg');

-- --------------------------------------------------------

--
-- Estrutura da tabela `mensagens`
--

CREATE TABLE `mensagens` (
  `idmensagem` int(11) NOT NULL,
  `idutilizador` int(11) NOT NULL,
  `email` varchar(300) CHARACTER SET utf8 NOT NULL,
  `assunto` varchar(150) CHARACTER SET utf8 NOT NULL,
  `mensagem` text CHARACTER SET utf8 NOT NULL,
  `data_escrita` timestamp NOT NULL DEFAULT current_timestamp(),
  `visto` int(11) NOT NULL,
  `respondido` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `mensagens`
--

INSERT INTO `mensagens` (`idmensagem`, `idutilizador`, `email`, `assunto`, `mensagem`, `data_escrita`, `visto`, `respondido`) VALUES
(2, 31, 'danieldosfarias@gmail.com', 'Coisa', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '2020-05-19 13:42:49', 1, 1),
(9, 0, 'danieldosfarias@gmail.com', 'A sua acoisa', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\\\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '2020-06-17 17:54:40', 1, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `page_reservas`
--

CREATE TABLE `page_reservas` (
  `idpager` int(11) NOT NULL,
  `preco` int(11) NOT NULL,
  `adultos` int(11) NOT NULL,
  `kids` int(11) NOT NULL,
  `foto` varchar(600) NOT NULL,
  `compart_pt` varchar(200) NOT NULL,
  `serv_pt` varchar(200) NOT NULL,
  `regras_pt` text NOT NULL,
  `compart_en` varchar(200) NOT NULL,
  `serv_en` varchar(200) NOT NULL,
  `regras_en` text NOT NULL,
  `compart_es` varchar(200) NOT NULL,
  `serv_es` varchar(200) NOT NULL,
  `regras_es` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `page_reservas`
--

INSERT INTO `page_reservas` (`idpager`, `preco`, `adultos`, `kids`, `foto`, `compart_pt`, `serv_pt`, `regras_pt`, `compart_en`, `serv_en`, `regras_en`, `compart_es`, `serv_es`, `regras_es`) VALUES
(1, 50, 9, 3, 'b2f205ea2ae1ff95b2c2ed0e5717295b.jpg', '1 cozinha, 2 quartos +1 suite, 2 casa de banho, Sala de estar, Sala de jantar, 2 terraços', 'Wifi, Espaço de churrasqueira, Espaço de churrasqueira', '<ul>\r\n	<li>Neque porro qui squam est, qui dolorem ipsum quia dolor sit amet, consectetur</li>\r\n	<li>Neque porro qui squam est, qui dolorem ipsum quia dolor sit amet, consectetur</li>\r\n	<li>Neque porro qui squam est, qui dolorem ipsum quia dolor sit amet, consectetur</li>\r\n	<li>Neque porro qui squam est, qui dolorem ipsum quia dolor sit amet, consectetur</li>\r\n</ul>\r\n', '1 cozinha, 2 quartos +1 suite, 2 casa de banho, Sala de estar, Sala de jantar, 2 terraços', 'Wifi, Espaço de churrasqueira, Espaço de churrasqueira', '<ul>\r\n	<li>Neque porro qui squam est, qui dolorem ipsum quia dolor sit amet, consectetur</li>\r\n	<li>Neque porro qui squam est, qui dolorem ipsum quia dolor sit amet, consectetur</li>\r\n	<li>Neque porro qui squam est, qui dolorem ipsum quia dolor sit amet, consectetur</li>\r\n	<li>Neque porro qui squam est, qui dolorem ipsum quia dolor sit amet, consectetur</li>\r\n</ul>\r\n', '1 cozinha, 2 quartos +1 suite, 2 casa de banho, Sala de estar, Sala de jantar, 2 terraços', 'Wifi, Espaço de churrasqueira, Espaço de churrasqueira', '<ul>\r\n	<li>Neque porro qui squam est, qui dolorem ipsum quia dolor sit amet, consectetur</li>\r\n	<li>Neque porro qui squam est, qui dolorem ipsum quia dolor sit amet, consectetur</li>\r\n	<li>Neque porro qui squam est, qui dolorem ipsum quia dolor sit amet, consectetur</li>\r\n	<li>Neque porro qui squam est, qui dolorem ipsum quia dolor sit amet, consectetur</li>\r\n</ul>\r\n');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pais`
--

CREATE TABLE `pais` (
  `idpais` tinyint(3) UNSIGNED NOT NULL,
  `paisNome` varchar(50) NOT NULL,
  `paisName` varchar(50) NOT NULL,
  `paisNomeES` varchar(70) NOT NULL,
  `telemovel` varchar(20) NOT NULL,
  `telemovel2` varchar(18) NOT NULL,
  `ISO` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `pais`
--

INSERT INTO `pais` (`idpais`, `paisNome`, `paisName`, `paisNomeES`, `telemovel`, `telemovel2`, `ISO`) VALUES
(1, 'AFEGANISTÃO', 'AFGHANISTAN', 'AFGANISTÁN', '+93', '00 000 0000', 'AF'),
(3, 'ÁFRICA DO SUL', 'SOUTH AFRICA', 'SUDÁFRICA', '+27 ', '00 000 0000', 'ZA'),
(4, 'ALBÂNIA', 'ALBANIA', 'ALBANIA', '+355', '0000000', 'AL'),
(5, 'ALEMANHA', 'GERMANY', 'ALEMANIA', '+49', '000 00000000', 'DE'),
(6, 'AMERICAN SAMOA', 'AMERICAN SAMOA', 'SAMOA AMERICANA', '+684', '000-0000', 'AS'),
(7, 'ANDORRA', 'ANDORRA', 'ANDORRA', '+376', '000 000', 'AD'),
(8, 'ANGOLA', 'ANGOLA', 'ANGOLA', '+244', '2 00 000 000', 'AO'),
(9, 'ANGUILLA', 'ANGUILLA', 'ANGUILA', '+1264', '000 0000', 'AI'),
(10, 'ANTÍGUA E BARBUDA', 'ANTIGUA AND BARBUDA', 'ANTIGUA Y BARBUDA', '+1268', '000 0000', 'AG'),
(11, 'ANTILHAS NEERLANDESAS', 'NETHERLANDS ANTILLES', 'ANTILHAS NEERLANDESAS', '+599', '000 0000', 'AN'),
(12, 'ARÁBIA SAUDITA', 'SAUDI ARABIA', 'ARABIA SAUDITA', '+966', '00 000 0000', 'SA'),
(13, 'ARGÉLIA', 'ALGERIA', 'ARGELIA', '+213', '00 000 000', 'DZ'),
(14, 'ARGENTINA', 'ARGENTINA', 'ARGENTINA', '+54', '(000) 000-0000', 'AR'),
(15, 'ARMÉNIA', 'ARMENIA', 'ARMENIA', '+374', '0000 0000', 'AM'),
(16, 'ARUBA', 'ARUBA', 'ARUBA', '+297', '0000 0000', 'AW'),
(17, 'AUSTRÁLIA', 'AUSTRALIA', 'AUSTRALIA', '+61', '0000 0000', 'AU'),
(18, 'ÁUSTRIA', 'AUSTRIA', 'Austria', '+43', '000 0000', 'AT'),
(19, 'AZERBAIJÃO', 'AZERBAIJAN', 'AZERBAIYÁN', '+994', '00 000 00 00', 'AZ'),
(20, 'BAHAMAS', 'BAHAMAS', 'BAHAMAS', '+1242', '000 000 0000', 'BS'),
(21, 'BANGLADECHE', 'BANGLADESH', 'BANGLADECHE', '+880', '00 0000 0000', 'BD'),
(22, 'BARBADOS', 'BARBADOS', 'BARBADOS', '+1246', '000 0000', 'BB'),
(23, 'BARÉM', 'BAHRAIN', 'BAHREIN', '+973', '0000 0000', 'BH'),
(25, 'BÉLGICA', 'BELGIUM', 'BELGICA', '+32', '0 00000000', 'BE'),
(26, 'BELIZE', 'BELIZE', 'BELICE', '+501', '000 0000', 'BZ'),
(27, 'BENIN', 'BENIN', 'BENIN', '+229', '00 00 0000', 'BJ'),
(28, 'BERMUDAS', 'BERMUDA', 'BERMUDA', '+1441', '000 0000', 'BM'),
(29, 'BIELORRÚSSIA', 'BELARUS', 'BIELORRUSIA', '+375', '0000-00000', 'BY'),
(30, 'BOLÍVIA', 'BOLIVIA', 'BOLIVIA', '+591', '0 0000000', 'BO'),
(31, 'BÓSNIA E HERZEGOVINA', 'BOSNIA AND HERZEGOVINA', 'BOSNIA Y HERZEGOVINA', '+387', '000 000 000', 'BA'),
(32, 'BOTSUANA', 'BOTSWANA', 'BOTSUANA', '+267', '000 0000', 'BW'),
(33, 'BRASIL', 'BRAZIL', 'BRASIL', '+55', '00 00000-0000', 'BR'),
(34, 'BRUNEI', 'BRUNEI', 'BRUNEI', '+673', '0000000', 'BN'),
(35, 'BULGÁRIA', 'BULGARIA', 'BULGARIA', '+359', '0 000 0000', 'BG'),
(36, 'BURQUINA FASO', 'BURKINA FASO', 'BURKINA FASO', '+226', '0000 0000', 'BF'),
(37, 'BURUNDI', 'BURUNDI', 'BURUNDI', '+257', '00 00 0000', 'BI'),
(38, 'BUTÃO', 'BHUTAN', 'BOTÓN', '+975', '00 000000', 'BT'),
(39, 'CABO VERDE', 'CAPE VERDE', 'CABO VERDE', '+238', '000 0000', 'CV'),
(40, 'CAMARÕES', 'CAMEROON', ' CAMERÚN', '+237', '000000000', 'CM'),
(41, 'CAMBOJA', 'CAMBODIA', 'CAMBOYA', '+855', '00 000 0000', 'KH'),
(42, 'CANADÁ', 'CANADA', 'CANADÁ', '+1', '0000000000', 'CA'),
(43, 'CATAR', 'QATAR', 'QATAR', '+974', '00 000000', 'QA'),
(44, 'CAZAQUISTÃO', 'KAZAKHSTAN', 'KAZAJSTÁN', '+7', '000 0000000', 'KZ'),
(45, 'CENTRO-AFRICANA REPÚBLICA', 'CENTRAL AFRICAN REPUBLIC', 'REPUBLICA CENTRO AFRICANA', '+236', '0000 0000', 'CF'),
(46, 'CHADE', 'CHAD', 'CHADE', '+235', '00 00 00 00', 'TD'),
(47, 'CHILE', 'CHILE', 'CHILE', '+56', '000-000-000', 'CL'),
(49, 'CHIPRE', 'CYPRUS', 'CHIPRE', '+357', '00-000000', 'CY'),
(50, 'COLÔMBIA', 'COLOMBIA', 'COLOMBIA', '+57', '000-000-0000', 'CO'),
(51, 'COMORES', 'COMOROS', 'COMORAS', '+269', '000 0000', 'KM'),
(52, 'RÉPUBLICA DO CONGO', 'REPUBLIC OF THE CONGO', 'REPÚBLICA DEL CONGO', '+242', '00 00 00000', 'CG'),
(53, 'REPÚBLICA DEMOCRÁTICA DO CONGO', 'DEMOCRATIC REPUBLIC OF THE CONGO', 'REPÚBLICA DEMOCRÁTICA DEL CONGO', '+243', '000 000 000', 'CD'),
(54, 'COREIA DO NORTE', 'NORTH KOREA', 'COREA DEL NORTE', '+850', '0 000 0000', 'KP'),
(55, 'COREIA DO SUL', 'SOUTH KOREA', 'COREA DEL SUR', '+82', '000-000-0000', 'KR'),
(56, 'COSTA DO MARFIM', 'IVORY COAST', 'COSTA DE MARFIL', '+225', '00000000', 'CI'),
(57, 'COSTA RICA', 'COSTA RICA', 'COSTA RICA', '+506', '00000000', 'CR'),
(58, 'CROÁCIA', 'CROATIA', 'CROACIA', '+385', '000 000 000', 'HR'),
(59, 'CUBA', 'CUBA', 'CUBA', '+53', '0000 0000', 'CU'),
(60, 'DINAMARCA', 'DENMARK', 'DINAMARCA', '+45', '00-00-00-00', 'DK'),
(61, 'DOMÍNICA', 'DOMINICA', 'DOMINIO', '+767', ' 000 0000', 'DM'),
(62, 'EGITO', 'EGYPT', 'EGIPTO', '+20', '00 0000 0000', 'EG'),
(63, 'EMIRADOS ÁRABES UNIDOS', 'UNITED ARAB EMIRATES', 'EMIRATOS ÁRABES UNIDOS', '+971', '00 000 0000', 'AE'),
(64, 'EQUADOR', 'ECUADOR', 'ECUADOR', '+593', '0-0000-0000', 'EC'),
(65, 'ERITREIA', 'ERITREA', 'ERITREA', '+291', '0000000', 'ER'),
(66, 'ESLOVÁQUIA', 'SLOVAKIA', 'ESLOVAQUIA', '+421', '0000 000 000', 'SK'),
(67, 'ESLOVÉNIA', 'SLOVENIA', 'ESLOVENIA', '+386', '00 000 000', 'SI'),
(68, 'ESPANHA', 'SPAIN', 'ESPAÑA', '+34', '000 000 000', 'ES'),
(69, 'ESTADOS UNIDOS', 'UNITED STATES', 'ESTADOS UNIDOS', '+1', '800-000-0000', 'US'),
(70, 'ESTÓNIA', 'ESTONIA', 'ESTONIA', '+372', '000 0000', 'EE'),
(71, 'ETIÓPIA', 'ETHIOPIA', 'ETIOPÍA', '+251', '91 000-0000', 'ET'),
(73, 'FIJI', 'FIJI', 'FIJI', '+679', '000 0000', 'FJ'),
(74, 'FILIPINAS', 'PHILIPPINES', 'FILIPINAS', '+63', '000 000 0000', 'PH'),
(75, 'FINLÂNDIA', 'FINLAND', 'FINLANDIA', '+358', '9 000 000', 'FI'),
(76, 'FRANÇA', 'FRANCE', 'FRANCIA', '+33', '00 00 00 00 00', 'FR'),
(77, 'GABÃO', 'GABON', 'GABON', '+241', '00 00 00 00', 'GA'),
(78, 'GÂMBIA', 'GAMBIA', 'GAMBIA', '+220', '000 0000', 'GM'),
(79, 'GANA', 'GHANA', 'GHANA', '+233', '000 0000000', 'GH'),
(80, 'GEÓRGIA', 'GEORGIA', 'GEORGIA', '+995', '-000-000 000', 'GE'),
(81, 'GIBRALTAR', 'GIBRALTAR', 'GIBRALTAR', '+350', '0000000', 'GI'),
(83, 'GRÉCIA', 'GREECE', 'GRECIA', '+30', '00 0 000 0000', 'GR'),
(84, 'GRONELÂNDIA', 'GREENLAND', 'GROENLANDIA', '+299', ' 00 00 00', 'GL'),
(86, 'GUAM', 'GUAM', 'GUAM', '+1', '000-0000', 'GU'),
(87, 'GUATEMALA', 'GUATEMALA', 'GUATEMALA', '+502', '000 0000', 'GT'),
(88, 'GUERNSEY', 'GUERNSEY', 'GUERNSEY', '+44', '00 0000 0000', 'GG'),
(89, 'GUIANA', 'GUYANA', 'GUYANA', '+592', '0000000', 'GY'),
(91, 'GUINÉ', 'GUINEA', 'GUINEA', '+224', '0 000 0000', 'GN'),
(92, 'GUINÉ EQUATORIAL', 'EQUATORIAL GUINEA', 'GUINEA ECUATORIAL', '+240', ' 00 000 0000', 'GQ'),
(93, 'GUINÉ-BISSAU', 'GUINEA-BISSAU', 'GUINEA-BISSAU', '+245', '000 0000', 'GW'),
(94, 'HAITI', 'HAITI', 'HAITÍ', '+509', '00 00 0000', 'HT'),
(95, 'HONDURAS', 'HONDURAS', 'HONDURAS', '+504', '0 000 0000', 'HN'),
(96, 'HONG KONG', 'HONG KONG', 'HONG KONG', '+852', '00000000', 'HK'),
(97, 'HUNGRIA', 'HUNGARY', 'HUNGRÍA', '+36', '06 00 000 0000', 'HU'),
(98, 'IÉMEN', 'YEMEN', 'YEMEN', '+967', '000000000', 'YE'),
(100, 'ILHA CHRISTMAS', 'CHRISTMAS ISLAND', 'ISLA DE NAVIDAD', '+61', '0 0000 0000', 'CX'),
(110, 'ILHAS COCOS (KEELING)', 'COCOS (KEELING) ISLANDS', 'ISLAS DE COCINA (KEELING)', '+61', '0 0000 0000', 'CCK'),
(113, 'ILHAS FALKLANDS (ILHAS MALVINAS)', 'FALKLAND ISLANDS (ISLAS MALVINAS)', ' ISLAS MALVINAS ', '+500', '00000', 'FK'),
(114, 'ILHAS FAROE', 'FAROE ISLANDS', 'ISLAS FAROE', '+298', '000000', 'FO'),
(116, 'ILHAS MARIANAS DO NORTE', 'NORTHERN MARIANA ISLANDS', 'ISLAS MARIANAS DEL NORTE', '+1', '000-0000', 'MP'),
(117, 'ILHAS MARSHALL', 'MARSHALL ISLANDS', 'ISLAS MARSHALL', '+692', '000 0000', 'MH'),
(119, 'ILHAS PITCAIRN', 'PITCAIRN ISLANDS', 'ISLAS PITCAIRN', '+64', '00 000000', 'PCN'),
(120, 'ILHAS SALOMÃO', 'SOLOMON ISLANDS', 'ISLAS SALOMÓN', '+677', '0000000', 'SB'),
(122, 'ILHAS VIRGENS AMERICANAS', 'UNITED STATES VIRGIN ISLANDS', 'ISLAS VIRGENES AMERICANAS', '+1', '000 000 0000', 'VIR'),
(123, 'ILHAS VIRGENS BRITÂNICAS', 'BRITISH VIRGIN ISLANDS', 'ISLAS VÍRGENES BRITÁNICAS', '+1284', '000 000', 'VG'),
(124, 'ÍNDIA', 'INDIA', 'INDIA', '+91', '00 0000 0000', 'IN'),
(126, 'IRÃO', 'IRAN', 'IRÁN', '+98', '0000-000-0000', 'IR'),
(127, 'IRAQUE', 'IRAQ', 'IRAK', '+964', '000 000 0000', 'IQ'),
(128, 'IRLANDA', 'IRELAND', 'IRLANDA', '+353', '00 0000 0000', 'IE'),
(129, 'ISLÂNDIA', 'ICELAND', 'ISLANDIA', '+354', '000 0000', 'IS'),
(130, 'ISRAEL', 'ISRAEL', 'ISRAEL', '+972', '000-000-0000', 'IL'),
(131, 'ITÁLIA', 'ITALY', 'ITALIA', '+39', '000 0000000', 'IT'),
(132, 'JAMAICA', 'JAMAICA', 'JAMAICA', '+876', '000-0000', 'JM'),
(133, 'JAN MAYEN', 'JAN MAYEN', 'JAN MAYEN', '+47', '000 00 000', 'SJ'),
(134, 'JAPÃO', 'JAPAN', 'JAPÓN', '+81', '000 00 0000', 'JP'),
(135, 'JERSEY', 'JERSEY', 'JERSEY', '+44', '800-000-0000', 'JE'),
(136, 'JIBUTI', 'DJIBOUTI', 'JIBUTI', '+253', '00 00 00 00', 'DJ'),
(137, 'JORDÂNIA', 'JORDAN', 'JORDANIA', '+962', '000000000', 'JO'),
(138, 'KIRIBATI', 'KIRIBATI', 'KIRIBATI', '+686', '00000000', 'KI'),
(139, 'KOWEIT', 'KUWAIT', 'KOWEIT', '+965', '0000 0000', 'KW'),
(140, 'LAOS', 'LAOS', 'LAOS', '+856', '00-000000', 'LA'),
(141, 'LESOTO', 'LESOTHO', 'LESOTHO', '+266', '0 0000', 'LS'),
(142, 'LETÓNIA', 'LATVIA', 'LETONIA', '+371', '000 00 000', 'LV'),
(143, 'LÍBANO', 'LEBANON', 'LÍBANO', '+961', '0 000 000', 'LB'),
(144, 'LIBÉRIA', 'LIBERIA', 'LIBERIA', '+231', '000 000 0000', 'LR'),
(145, 'LÍBIA', 'LIBYA', 'LIBIA', '+218', '000000000', 'LY'),
(146, 'LISTENSTAINE', 'LIECHTENSTEIN', 'ESCUCHA', '+423', '000 00 00', 'LI'),
(147, 'LITUÂNIA', 'LITHUANIA', 'LITUANIA', '+370', '0000 00000', 'LT'),
(148, 'LUXEMBURGO', 'LUXEMBOURG', 'LUXEMBURGO', '+352', '000 000 000', 'LU'),
(149, 'MACAU', 'MACAU', 'MACAU', '+853', '0000 0000', 'MO'),
(150, 'MACEDÓNIA', 'MACEDONIA', 'MACEDONIA', '+389', '00 000000', 'MK'),
(151, 'MADAGÁSCAR', 'MADAGASCAR', 'MADAGASCAR', '+261', '00 00 000 00', 'MG'),
(152, 'MALÁSIA', 'MALAYSIA', 'MALASIA', '+60', '16-000 0000', 'MY'),
(153, 'MALAVI', 'MALAWI', 'MALAVI', '+265', '0 0000 0000', 'MW'),
(154, 'MALDIVAS', 'MALDIVES', 'MALDIVAS', '+960', '0 000000', 'MV'),
(155, 'MALI', 'MALI', 'MALI', '+223', '00 00 00 00', 'ML'),
(156, 'MALTA', 'MALTA', 'MALTA', '+356', '0000 0000', 'MT'),
(157, 'MARROCOS', 'MOROCCO', 'MARRUECOS', '+212', '0000000000', 'MA'),
(159, 'MAURÍCIA', 'MAURITIUS', 'MAURICIO', '+230', '0 000 0000', 'MU'),
(160, 'MAURITÂNIA', 'MAURITANIA', 'MAURITANIA', '+222', '00000000', 'MR'),
(161, 'MAYOTTE', 'MAYOTTE', 'MAYOTTE', '+262', '639 00 00 00', 'YT'),
(162, 'MÉXICO', 'MEXICO', 'MÉXICO', '+52', '000 000 0000', 'MX'),
(163, 'MIANMAR', 'MYANMAR BURMA', 'MYANMAR', '+95', '0 00 00-0000', 'MMR'),
(164, 'MICRONÉSIA', 'MICRONESIA', 'MICRONESIA', '+691', '000 0000', 'FM'),
(165, 'MOÇAMBIQUE', 'MOZAMBIQUE', 'MOZAMBIQUE', '+258', '000 000000', 'MZ'),
(166, 'MOLDÁVIA', 'MOLDOVA', 'MOLDEVA', '+373', '00-00-00-00', 'MD'),
(167, 'MÓNACO', 'MONACO', 'MÓNACO', '+377', '00 00 00 00 00', 'MC'),
(168, 'MONGÓLIA', 'MONGOLIA', 'MONGOLIA', '+976', '00000000', 'MC'),
(169, 'MONTENEGRO', 'MONTENEGRO', 'MONTENEGRO', '+382', '000 000 000', 'ME'),
(170, 'MONTSERRAT', 'MONTSERRAT', 'MONTSERRAT', '+1', '000 0000', 'MS'),
(171, 'NAMÍBIA', 'NAMIBIA', 'NAMIBIA', '+264', '00 000 0000', 'NA'),
(172, 'NAURU', 'NAURU', 'NAURU', '+674', '000 0000', 'NR'),
(173, 'NEPAL', 'NEPAL', 'NEPAL', '+977', '0 0000 000', 'NP'),
(174, 'NICARÁGUA', 'NICARAGUA', 'NICARAGUA', '+505', '0000 0000', 'NI'),
(176, 'NIGÉRIA', 'NIGERIA', 'NIGERIA', '+234', '00000 000 000', 'NG'),
(177, 'NIUE', 'NIUE', 'NIUE', '+683', '0000000', 'NU'),
(178, 'NORUEGA', 'NORWAY', 'NORUEGA', '+47', '000 00 000', 'NO'),
(179, 'NOVA CALEDÓNIA', 'NEW CALEDONIA', 'NUEVA CALEDONIA', '+687', '00 00 00', 'NC'),
(180, 'NOVA ZELÂNDIA', 'NEW ZEALAND', 'NUEVA ZELANDA', '+64', '(03) 000-0000', 'NZ'),
(181, 'OMÃ', 'OMAN', 'OMAN', '+968', '00000000', 'OM'),
(182, 'PAÍSES BAIXOS', 'NETHERLANDS', 'PAÍSES BAJOS', '+31', '00 000 0000', 'NL'),
(183, 'PALAU', 'PALAU', 'PALAU', '+680', '000-0000', 'PW'),
(184, 'PALESTINA', 'PALESTINE', 'PALESTINA', '+970', '059 000 0000', 'PS'),
(185, 'PANAMÁ', 'PANAMA', 'PANAMÁ', '+507', '000-0000', 'PA'),
(187, 'PAQUISTÃO', 'PAKISTAN', 'PAKISTÁN', '+92', '300-0000000', 'PK'),
(188, 'PARAGUAI', 'PARAGUAY', 'PARAGUAY', '+595', '00 000 0000', 'PY'),
(189, 'PERU', 'PERU', 'PERU', '+51', '0 0000000', 'PE'),
(190, 'POLINÉSIA FRANCESA', 'FRENCH POLYNESIA', 'POLINESIA FRANCESA', '+689', '00 00 00 00', 'PF'),
(191, 'POLÓNIA', 'POLAND', 'POLONIA', '+48', '00 000 00 00', 'PL'),
(192, 'PORTO RICO', 'PUERTO RICO', 'PUERTO RICO', '+1', '1 (787) 000-0000', 'PR'),
(193, 'PORTUGAL', 'PORTUGAL', 'PORTUGAL', '+351', '000 000 000', 'PT'),
(194, 'QUÉNIA', 'KENYA', 'KENIA', '+254', '00 0000000', 'KE'),
(195, 'QUIRGUIZISTÃO', 'KYRGYZSTAN', 'KYRGYZSTAN', '+996', '00 0 000 000', 'KG'),
(196, 'REINO UNIDO', 'UNITED KINGDOM', 'REINO UNIDO', '+44', '0000 000000', 'GB'),
(197, 'REPÚBLICA CHECA', 'CZECH REPUBLIC', 'REPÚBLICA CHECA', '+420', '602 000 000', 'CZ'),
(198, 'REPÚBLICA DOMINICANA', 'DOMINICAN REPUBLIC', 'REPÚBLICA DOMINICANA', '+1', '000-0000', 'DO'),
(199, 'ROMÉNIA', 'ROMANIA', 'RUMANÍA', '+40', '098-000-000', 'RO'),
(200, 'RUANDA', 'RWANDA', 'RUANDA', '+250', '000 000 000', 'RW'),
(201, 'RÚSSIA', 'RUSSIA', 'RUSIA', '+7', '000 000-00-00', 'RU'),
(202, 'SAHARA OCCIDENTAL', 'WESTERN SAHARA', 'SAHARA OCCIDENTAL', '+212', '0000-00000', 'EH'),
(203, 'EL SALVADOR', 'EL SALVADOR', 'EL SALVADOR', '+503', '0000 0000', 'SV'),
(204, 'SAMOA', 'SAMOA', 'SAMOA', '+685', '000-000-0000', 'WS'),
(205, 'SANTA HELENA', 'SAINT HELENA', 'SANTA HELENA', '+290', '00000', 'SH'),
(206, 'SANTA LÚCIA', 'SAINT LUCIA', 'SANTA LUCIA', '+1758', '000 0000', 'LC'),
(208, 'SÃO CRISTÓVÃO E NEVES', 'SAINT KITTS AND NEVIS', 'SAN CRISTÓBAL Y NIEVES', '+1869', '000 0000', 'KN'),
(209, 'SÃO MARINO', 'SAN MARINO', 'SAN MARINO', '+378', '0549 000 000', 'SM'),
(211, 'SÃO TOMÉ E PRÍNCIPE', 'SAO TOME AND PRINCIPE', 'SAN TOME Y PRINCIPE', '+239', '00 00000', 'ST'),
(212, 'SÃO VICENTE E GRANADINAS', 'SAINT VINCENT AND THE GRENADINES', 'SAN VICENTE Y LAS GRANADINAS', '+1784', '000 0000', 'VC'),
(213, 'SEICHELES', 'SEYCHELLES', 'SEYCHELLES', '+248', '00 00 00', 'SC'),
(214, 'SENEGAL', 'SENEGAL', 'SENEGAL', '+221', '000000000', 'SN'),
(215, 'SERRA LEOA', 'SIERRA LEONE', 'SIERRA LEONA', '+232', '00 000000', 'SL'),
(216, 'SÉRVIA', 'SERBIA', 'SERBIA', '+381', '11 000 00 00', 'RS'),
(217, 'SINGAPURA', 'SINGAPORE', 'SINGAPUR', '+65', '0000 0000', 'SG'),
(218, 'SÍRIA', 'SYRIA', 'SIRIA', '+963', '00 000 0000', 'SY'),
(219, 'SOMÁLIA', 'SOMALIA', 'SOMALIA', '+252', '000 000 000', 'SO'),
(220, 'SRI LANKA', 'SRI LANKA', 'SRI LANKA', '+94', '000 0000000', 'LK'),
(221, 'SUAZILÂNDIA', 'SWAZILAND', 'SWAZILANDIA', '+268', '00 00 0000', 'SZ'),
(222, 'SUDÃO', 'SUDAN', 'SUDÁN', '+249', '00 000 0000', 'SD'),
(223, 'SUÉCIA', 'SWEDEN', 'SUECIA', '+46', '00 000 00 00', 'SE'),
(224, 'SUÍÇA', 'SWITZERLAND', 'SUIZA', '+41', '(0)00 000 00 00', 'CH'),
(225, 'SURINAME', 'SURINAME', 'SURINAME', '+597', '000 0000', 'SR'),
(227, 'TAILÂNDIA', 'THAILAND', 'TAILANDIA', '+66', '0 000 0000', 'TH'),
(228, 'TAIWAN', 'TAIWAN', 'TAIWÁN', '+886', '0 0000 0000', 'TW'),
(229, 'TAJIQUISTÃO', 'TAJIKISTAN', 'TAYIKISTÁN', '+992', '0000 0 0000', 'TJ'),
(230, 'TANZÂNIA', 'TANZANIA', 'TANZANIA', '+255', '000 000 000', 'TZ'),
(233, 'TIMOR-LESTE', 'EAST TIMOR', 'TIMOR ESTE', '+670', '0000-0000', 'TL'),
(234, 'TOGO', 'TOGO', 'TOGO', '+228', '00 000000', 'TG'),
(235, 'TOKELAU', 'TOKELAU', 'TOKELAU', '+690', '00000', 'TK'),
(236, 'TONGA', 'TONGA', 'TONGA', '+676', '00000', 'TO'),
(237, 'TRINDADE E TOBAGO', 'TRINIDAD AND TOBAGO', 'TRINIDAD Y TOBAGO', '+868', '000 0000', 'TT'),
(238, 'TUNÍSIA', 'TUNISIA', 'TÚNEZ', '+216', '00 000 000', 'TN'),
(239, 'TURKS E CAICOS', 'TURKS AND CAICOS ISLANDS', 'TURCAS Y CAICOS', '+1', '649 000 0000', 'TC'),
(240, 'TURQUEMENISTÃO', 'TURKMENISTAN', 'TURKMENISTÁN', '+993', '00-00-00', 'TM'),
(241, 'TURQUIA', 'TURKEY', 'TURQUÍA', '+90', '000 000 0000', 'R'),
(242, 'TUVALU', 'TUVALU', 'TUVALU', '+688', '0000000', 'TV'),
(243, 'UCRÂNIA', 'UKRAINE', 'UCRANIA', '+380', '00 000 0000', 'UA'),
(244, 'UGANDA', 'UGANDA', 'UGANDA', '+256', '000 000000', 'UG'),
(245, 'URUGUAI', 'URUGUAY', 'URUGUAY', '+598', '000000000', 'UY'),
(246, 'USBEQUISTÃO', 'UZBEKISTAN', 'UZBEKISTÁN', '+998', '00-0000000', 'UZ'),
(247, 'VANUATU', 'VANUATU', 'VANUATU', '+678', '00 00000', 'VU'),
(249, 'VIETNAME', 'VIETNAM', 'VIETNAM', '+84', '00 0000000', 'VN'),
(250, 'WALLIS E FUTUNA', 'WALLIS AND FUTUNA', 'WALLIS Y FUTUNA', '+681', '00 0000', 'WF'),
(251, 'ZÂMBIA', 'ZAMBIA', 'ZAMBIA', '+260', '000 00000', 'ZM'),
(252, 'ZIMBABUÉ', 'ZIMBABWE', 'ZIMBABUE', '+263', '0000 000 000', 'ZW');

-- --------------------------------------------------------

--
-- Estrutura da tabela `password_reset`
--

CREATE TABLE `password_reset` (
  `email` varchar(250) CHARACTER SET utf8 NOT NULL,
  `key` varchar(250) CHARACTER SET utf8 NOT NULL,
  `expDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `reservas`
--

CREATE TABLE `reservas` (
  `idreserva` int(11) NOT NULL,
  `idutilizador` int(11) NOT NULL,
  `datai` date NOT NULL,
  `dataf` date NOT NULL,
  `num_adults` int(11) NOT NULL,
  `num_child` int(11) NOT NULL,
  `preco_total` float NOT NULL,
  `paypal_fee` float NOT NULL,
  `paypal_trans` varchar(100) NOT NULL,
  `data_pagamento` timestamp NOT NULL DEFAULT current_timestamp(),
  `email_final` varchar(250) NOT NULL,
  `nome_final` varchar(250) NOT NULL,
  `estadia_conc` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `reservas`
--

INSERT INTO `reservas` (`idreserva`, `idutilizador`, `datai`, `dataf`, `num_adults`, `num_child`, `preco_total`, `paypal_fee`, `paypal_trans`, `data_pagamento`, `email_final`, `nome_final`, `estadia_conc`) VALUES
(24, 37, '2020-07-29', '2020-07-31', 2, 1, 103.87, 3.87, '27325825MT8989613', '2020-07-08 14:26:01', 'danieldosfarias@gmail.com', 'O_DANI', 2),
(25, 37, '2020-07-15', '2020-07-16', 3, 1, 52.17, 2.17, '3VN84017BB001414H', '2020-07-08 18:45:13', 'danieldosfarias@gmail.com', 'O_DANI', 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `reservas_anos`
--

CREATE TABLE `reservas_anos` (
  `idreserva_ano` int(11) NOT NULL,
  `ano` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `reservas_anos`
--

INSERT INTO `reservas_anos` (`idreserva_ano`, `ano`) VALUES
(1, 2020),
(4, 2021);

-- --------------------------------------------------------

--
-- Estrutura da tabela `reserva_cancelar`
--

CREATE TABLE `reserva_cancelar` (
  `idreservac` int(11) NOT NULL,
  `idreserva` int(11) NOT NULL,
  `expDate` datetime NOT NULL,
  `keyy` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `reserva_datas`
--

CREATE TABLE `reserva_datas` (
  `idreserva_data` int(11) NOT NULL,
  `data` date NOT NULL,
  `idreserva` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `resposta_mensagm`
--

CREATE TABLE `resposta_mensagm` (
  `idresposta` int(11) NOT NULL,
  `idmensagem` int(11) NOT NULL,
  `assunto` varchar(200) NOT NULL,
  `mensagem` text NOT NULL,
  `data_escrita` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `resposta_mensagm`
--

INSERT INTO `resposta_mensagm` (`idresposta`, `idmensagem`, `assunto`, `mensagem`, `data_escrita`) VALUES
(3, 2, 'Coisa - Resposta', '<h2>What is Lorem Ipsum?</h2>\r\n\r\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.<br />\r\n<br />\r\nAtenciosamente,<br />\r\nDaniel Faria</p>\r\n', '2020-06-17 13:58:43');

-- --------------------------------------------------------

--
-- Estrutura da tabela `sobre_casa`
--

CREATE TABLE `sobre_casa` (
  `idsobre_casa` int(11) NOT NULL,
  `tittle_pt` varchar(100) NOT NULL,
  `tittle_en` varchar(100) NOT NULL,
  `tittle_es` varchar(100) NOT NULL,
  `frase` text NOT NULL,
  `frase_en` text NOT NULL,
  `frase_es` text NOT NULL,
  `video` varchar(1000) NOT NULL,
  `foto1` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `sobre_casa`
--

INSERT INTO `sobre_casa` (`idsobre_casa`, `tittle_pt`, `tittle_en`, `tittle_es`, `frase`, `frase_en`, `frase_es`, `video`, `foto1`) VALUES
(1, 'Bem Vindo ao Sona.', 'Welcome To Sona.', 'Bienvenido a Sona', 'Construído em 1910 durante o período Belle Epoque, este hotel está localizado no centro de Paris, com fácil acesso às atrações turísticas da cidade. Oferece quartos decorados com bom gosto.', 'Built in 1910 during the Belle Epoque period, this hotel is located in the center of Paris, with easy access to the city’s tourist attractions. It offers tastefully decorated rooms.', 'Construido en 1910 durante el período Belle Epoque, este hotel está situado en el centro de París, con fácil acceso a las atracciones turísticas de la ciudad. Ofrece habitaciones decoradas con buen gusto.', '#', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `sobre_home`
--

CREATE TABLE `sobre_home` (
  `idsobre_home` int(11) NOT NULL,
  `tittle_pt` varchar(200) NOT NULL,
  `tittle_en` varchar(200) NOT NULL,
  `tittle_es` varchar(200) NOT NULL,
  `text_pt` text NOT NULL,
  `text_en` text NOT NULL,
  `text_es` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `sobre_home`
--

INSERT INTO `sobre_home` (`idsobre_home`, `tittle_pt`, `tittle_en`, `tittle_es`, `text_pt`, `text_en`, `text_es`) VALUES
(1, 'Casa São Gregório ', 'House São Gregório', 'Casa São Gregório', 'SãoGregório.com é um site líder em acomodações on-line. Somos apaixonados por viagens. Todos os dias, inspiramos e alcançamos milhões de viajantes em 90 sites locais em 41 idiomas.', 'Sona.com is a leading online accommodation site. We’re passionate about travel. Every day, we inspire and reach millions of travelers across 90 local websites in 41 languages.', 'SãoGregório.com es un sitio web líder para alojamiento en línea. Nos apasiona viajar. Todos los días, inspiramos y llegamos a millones de viajeros en 90 sitios web locales en 41 idiomas.');

-- --------------------------------------------------------

--
-- Estrutura da tabela `swap_image`
--

CREATE TABLE `swap_image` (
  `idtroca` int(11) NOT NULL,
  `foto` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `utilizadores`
--

CREATE TABLE `utilizadores` (
  `idutilizador` int(11) NOT NULL,
  `nome` varchar(200) CHARACTER SET utf8 NOT NULL,
  `email` varchar(300) CHARACTER SET utf8 NOT NULL,
  `password` varchar(200) CHARACTER SET utf8 NOT NULL,
  `prefix` varchar(20) CHARACTER SET utf8 NOT NULL,
  `telemovel` varchar(18) CHARACTER SET utf8 NOT NULL,
  `data` date NOT NULL,
  `idpais` int(11) NOT NULL,
  `foto` varchar(500) CHARACTER SET utf8 NOT NULL,
  `tipo` int(11) NOT NULL COMMENT 'Tipo 1 - admin / 0 - cliente',
  `verificado` tinyint(4) NOT NULL,
  `google_account` int(11) NOT NULL,
  `googleid` varchar(100) NOT NULL,
  `reserva_conc` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `utilizadores`
--

INSERT INTO `utilizadores` (`idutilizador`, `nome`, `email`, `password`, `prefix`, `telemovel`, `data`, `idpais`, `foto`, `tipo`, `verificado`, `google_account`, `googleid`, `reserva_conc`) VALUES
(27, 'Daniel Fariaaaaa', 'mrplaygames2002@gmail.com', '$2y$10$E6Va/XSZ7/fWEXVkvPjClOpUc407an6vUcOL..2jh.U.A7kRgfMai', '+374', '1111 1111', '2002-02-28', 193, '', 0, 1, 0, '', 0),
(32, 'Dani', 'info.casa@gmail.com', '$2y$10$rU3PRRvnOvx7RnZGMPzLU.oGzgAKP.Vn4Rbod/x8PxgjJeK7aTJZ.', '+351', '910 000 000', '2002-02-28', 193, '', 1, 1, 0, '', 0),
(37, 'O_DANI', 'danieldosfarias@gmail.com', '$2y$10$4ekqOIZsOU4dSeaoAT08KOPoXBitNaG6fEs.WsPn1eQQHP0cSGwmW', '', '', '2002-02-28', 0, '1593523360.jpg', 0, 1, 1, '118132415881936521209', 1),
(41, 'DanieldosFarias', 'a8458@oficina.pt', '$2y$10$MjCRrUPNuf/P0CglTl5r.e2m5aU5agPCa1uCwYX/0Z3uja828xAV.', '', '', '0000-00-00', 193, '', 0, 0, 0, '', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `utilizadores_block`
--

CREATE TABLE `utilizadores_block` (
  `iduser_block` int(11) NOT NULL,
  `email` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `verify_user`
--

CREATE TABLE `verify_user` (
  `email` varchar(250) NOT NULL,
  `key` varchar(250) NOT NULL,
  `expDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `verify_user`
--

INSERT INTO `verify_user` (`email`, `key`, `expDate`) VALUES
('a8458@oficina.pt', 'fcd575c9d72a467caab909a85b008407bd913fd3a8', '2020-07-01 19:36:03'),
('danieldosfarias@gmail.com', '3b4cdc9194a6b70c14c2cb1c7b0649ef9d8843bbfd', '2020-07-04 13:35:48'),
('contaparatestes28022002@gmail.com', '5a73e78d083262cb6641e36c59616ae3042367b6ca', '2020-07-04 20:47:00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `visitas`
--

CREATE TABLE `visitas` (
  `idvisita` int(11) NOT NULL,
  `nome` varchar(200) NOT NULL,
  `texto_pt` text NOT NULL,
  `texto_en` text NOT NULL,
  `texto_es` text NOT NULL,
  `idcategoriav` int(11) NOT NULL,
  `foto` varchar(700) NOT NULL,
  `fotoban` varchar(600) NOT NULL,
  `ativo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `visitas`
--

INSERT INTO `visitas` (`idvisita`, `nome`, `texto_pt`, `texto_en`, `texto_es`, `idcategoriav`, `foto`, `fotoban`, `ativo`) VALUES
(40, 'Tremblant In Canada', '<h3>Se voc&ecirc; mora em Nova York</h3>\r\n&nbsp;\r\n\r\n<p>Pensando em viagens de aventura ao exterior? Voc&ecirc; j&aacute; pensou nos melhores lugares para viajar quando se trata de viagens de aventura ao exterior? O Nepal &eacute; um dos lugares mais populares de todos, quando voc&ecirc; visitar este pa&iacute;s m&aacute;gico, ter&aacute; as melhores aventuras ali mesmo &agrave; sua porta. Somente as viagens de aventura ao exterior no Nepal oferecem esse tipo de oportunidade; portanto, se essa ainda n&atilde;o estiver na sua lista de poss&iacute;veis lugares para visitar, agora &eacute; a hora de coloc&aacute;-la l&aacute;!<br />\r\n<br />\r\nNo Nepal, sua viagem de aventura ao exterior ser&aacute; fascinante. Voc&ecirc; ver&aacute; as montanhas do Himalaia e experimentar&aacute; tudo o que a rica cultura nepalesa tem a oferecer. S&atilde;o pessoas incr&iacute;veis que conseguiram manter sua pr&oacute;pria cultura e cren&ccedil;as por mais tempo do que a maioria dos outros pa&iacute;ses. Quando as viagens de aventura ao exterior o levarem ao Nepal, voc&ecirc; ter&aacute; a oportunidade de ver todos os lagos e florestas fant&aacute;sticos e &uacute;nicos e voc&ecirc; pode at&eacute; passar dias ou semanas acampando em suas florestas com um guia especializado. E as cachoeiras no Nepal s&atilde;o de morrer, voc&ecirc; nunca ver&aacute; nada mais lindo em sua vida do que as cachoeiras! Isso deve estar no topo da sua lista de destinos de viagens de aventura no exterior, com certeza!</p>\r\n', '<h3>If you live in New York City</h3>\r\n&nbsp;\r\n\r\n<p>Thinking about overseas adventure travel? Have you put any thought into the best places to go when it comes to overseas adventure travel? Nepal is one of the most popular places of all, when you visit this magical country you will have the best adventures right there at your doorstep. Only overseas adventure travel in Nepal will give you these kinds of opportunities so if this is not on your list of possible places to visit yet then now is the time to put it on there!</p>\r\n\r\n<p>In Nepal your overseas adventure travel is going to be fascinating. You will get to see the Himalayan Mountains and experience all that the rich Nepalese culture has to offer. They are an amazing people who have managed to hang on to their own culture and beliefs longer than most other countries. When overseas adventure travel takes you to Nepal you will have the chance to see all of the fantastic and one of a kind lakes and forests and you can even spend days or weeks camping out in their forests with a specialized guide. And the waterfalls in Nepal are to die for, you will never see anything more gorgeous in your life as their waterfalls! This should be at the top of your overseas adventure travel destination list for sure!</p>\r\n', '<h3>Si vives en la ciudad de Nueva York &iquest;</h3>\r\n&nbsp;\r\n\r\n<p>Pensando en viajes de aventura en el extranjero? &iquest;Has pensado en los mejores lugares para ir cuando se trata de viajes de aventura en el extranjero? Nepal es uno de los lugares m&aacute;s populares de todos, cuando visites este pa&iacute;s m&aacute;gico tendr&aacute;s las mejores aventuras justo en tu puerta. Solo los viajes de aventura en el extranjero en Nepal le dar&aacute;n este tipo de oportunidades, por lo que si a&uacute;n no est&aacute; en su lista de posibles lugares para visitar, &iexcl;ahora es el momento de ponerlo all&iacute;!</p>\r\n\r\n<p>En Nepal, su viaje de aventura al extranjero ser&aacute; fascinante. Podr&aacute;s ver las monta&ntilde;as del Himalaya y experimentar todo lo que la rica cultura nepal&iacute; tiene para ofrecer. Son personas incre&iacute;bles que han logrado conservar su propia cultura y creencias durante m&aacute;s tiempo que la mayor&iacute;a de los otros pa&iacute;ses. Cuando un viaje de aventura en el extranjero lo lleve a Nepal, tendr&aacute; la oportunidad de ver todos los fant&aacute;sticos y &uacute;nicos lagos y bosques e incluso puede pasar d&iacute;as o semanas acampando en sus bosques con un gu&iacute;a especializado. Y las cascadas en Nepal son para morirse, &iexcl;nunca ver&aacute;s nada m&aacute;s hermoso en tu vida como sus cascadas! &iexcl;Esto deber&iacute;a estar en la parte superior de su lista de destinos de viajes de aventura en el extranjero seguro!</p>\r\n\r\n<p><br />\r\n&nbsp;</p>\r\n', 4, 'f79437e52daaed65d53c37a9ce209869.jpg', 'c856059cf17542585d447906d90bbdea5.jpg', 1),
(42, 'Tremblantttt In Canada', '<h3>If you live in New York City</h3>\r\n<br />\r\nThinking about overseas adventure travel? Have you put any thought into the best places to go when it comes to overseas adventure travel? Nepal is one of the most popular places of all, when you visit this magical country you will have the best adventures right there at your doorstep. Only overseas adventure travel in Nepal will give you these kinds of opportunities so if this is not on your list of possible places to visit yet then now is the time to put it on there!<br />\r\n<br />\r\nIn Nepal your overseas adventure travel is going to be fascinating. You will get to see the Himalayan Mountains and experience all that the rich Nepalese culture has to offer. They are an amazing people who have managed to hang on to their own culture and beliefs longer than most other countries. When overseas adventure travel takes you to Nepal you will have the chance to see all of the fantastic and one of a kind lakes and forests and you can even spend days or weeks camping out in their forests with a specialized guide. And the waterfalls in Nepal are to die for, you will never see anything more gorgeous in your life as their waterfalls! This should be at the top of your overseas adventure travel destination list for sure!', '<h3>If you live in New York City</h3>\r\n<br />\r\nThinking about overseas adventure travel? Have you put any thought into the best places to go when it comes to overseas adventure travel? Nepal is one of the most popular places of all, when you visit this magical country you will have the best adventures right there at your doorstep. Only overseas adventure travel in Nepal will give you these kinds of opportunities so if this is not on your list of possible places to visit yet then now is the time to put it on there!<br />\r\n<br />\r\nIn Nepal your overseas adventure travel is going to be fascinating. You will get to see the Himalayan Mountains and experience all that the rich Nepalese culture has to offer. They are an amazing people who have managed to hang on to their own culture and beliefs longer than most other countries. When overseas adventure travel takes you to Nepal you will have the chance to see all of the fantastic and one of a kind lakes and forests and you can even spend days or weeks camping out in their forests with a specialized guide. And the waterfalls in Nepal are to die for, you will never see anything more gorgeous in your life as their waterfalls! This should be at the top of your overseas adventure travel destination list for sure!<br />\r\n&nbsp;', '<h3>If you live in New York City</h3>\r\n<br />\r\nThinking about overseas adventure travel? Have you put any thought into the best places to go when it comes to overseas adventure travel? Nepal is one of the most popular places of all, when you visit this magical country you will have the best adventures right there at your doorstep. Only overseas adventure travel in Nepal will give you these kinds of opportunities so if this is not on your list of possible places to visit yet then now is the time to put it on there!<br />\r\n<br />\r\nIn Nepal your overseas adventure travel is going to be fascinating. You will get to see the Himalayan Mountains and experience all that the rich Nepalese culture has to offer. They are an amazing people who have managed to hang on to their own culture and beliefs longer than most other countries. When overseas adventure travel takes you to Nepal you will have the chance to see all of the fantastic and one of a kind lakes and forests and you can even spend days or weeks camping out in their forests with a specialized guide. And the waterfalls in Nepal are to die for, you will never see anything more gorgeous in your life as their waterfalls! This should be at the top of your overseas adventure travel destination list for sure!<br />\r\n&nbsp;', 4, '3c6402dfe58406d47aee8653202b2cd0.jpg', 'c800059cf17542585d447906d90bbdea5.jpg', 1),
(43, 'Tremblant In Canada', '<h3>If you live in New York City</h3>\r\n<br />\r\nThinking about overseas adventure travel? Have you put any thought into the best places to go when it comes to overseas adventure travel? Nepal is one of the most popular places of all, when you visit this magical country you will have the best adventures right there at your doorstep. Only overseas adventure travel in Nepal will give you these kinds of opportunities so if this is not on your list of possible places to visit yet then now is the time to put it on there!<br />\r\n<br />\r\nIn Nepal your overseas adventure travel is going to be fascinating. You will get to see the Himalayan Mountains and experience all that the rich Nepalese culture has to offer. They are an amazing people who have managed to hang on to their own culture and beliefs longer than most other countries. When overseas adventure travel takes you to Nepal you will have the chance to see all of the fantastic and one of a kind lakes and forests and you can even spend days or weeks camping out in their forests with a specialized guide. And the waterfalls in Nepal are to die for, you will never see anything more gorgeous in your life as their waterfalls! This should be at the top of your overseas adventure travel destination list for sure!', '<h3>If you live in New York City</h3>\r\n<br />\r\nThinking about overseas adventure travel? Have you put any thought into the best places to go when it comes to overseas adventure travel? Nepal is one of the most popular places of all, when you visit this magical country you will have the best adventures right there at your doorstep. Only overseas adventure travel in Nepal will give you these kinds of opportunities so if this is not on your list of possible places to visit yet then now is the time to put it on there!<br />\r\n<br />\r\nIn Nepal your overseas adventure travel is going to be fascinating. You will get to see the Himalayan Mountains and experience all that the rich Nepalese culture has to offer. They are an amazing people who have managed to hang on to their own culture and beliefs longer than most other countries. When overseas adventure travel takes you to Nepal you will have the chance to see all of the fantastic and one of a kind lakes and forests and you can even spend days or weeks camping out in their forests with a specialized guide. And the waterfalls in Nepal are to die for, you will never see anything more gorgeous in your life as their waterfalls! This should be at the top of your overseas adventure travel destination list for sure!', '<h3>If you live in New York City</h3>\r\n<br />\r\nThinking about overseas adventure travel? Have you put any thought into the best places to go when it comes to overseas adventure travel? Nepal is one of the most popular places of all, when you visit this magical country you will have the best adventures right there at your doorstep. Only overseas adventure travel in Nepal will give you these kinds of opportunities so if this is not on your list of possible places to visit yet then now is the time to put it on there!<br />\r\n<br />\r\nIn Nepal your overseas adventure travel is going to be fascinating. You will get to see the Himalayan Mountains and experience all that the rich Nepalese culture has to offer. They are an amazing people who have managed to hang on to their own culture and beliefs longer than most other countries. When overseas adventure travel takes you to Nepal you will have the chance to see all of the fantastic and one of a kind lakes and forests and you can even spend days or weeks camping out in their forests with a specialized guide. And the waterfalls in Nepal are to die for, you will never see anything more gorgeous in your life as their waterfalls! This should be at the top of your overseas adventure travel destination list for sure!', 4, 'c5f16b61660b8aa44a1618ea7bc84caf.jpg', 'b400059cf17542585d447906d90bbdea5.jpg', 1),
(44, 'Tremblant In Canada', '<h3>If you live in New York City</h3>\r\n<br />\r\nThinking about overseas adventure travel? Have you put any thought into the best places to go when it comes to overseas adventure travel? Nepal is one of the most popular places of all, when you visit this magical country you will have the best adventures right there at your doorstep. Only overseas adventure travel in Nepal will give you these kinds of opportunities so if this is not on your list of possible places to visit yet then now is the time to put it on there!<br />\r\n<br />\r\nIn Nepal your overseas adventure travel is going to be fascinating. You will get to see the Himalayan Mountains and experience all that the rich Nepalese culture has to offer. They are an amazing people who have managed to hang on to their own culture and beliefs longer than most other countries. When overseas adventure travel takes you to Nepal you will have the chance to see all of the fantastic and one of a kind lakes and forests and you can even spend days or weeks camping out in their forests with a specialized guide. And the waterfalls in Nepal are to die for, you will never see anything more gorgeous in your life as their waterfalls! This should be at the top of your overseas adventure travel destination list for sure!', '<h3>If you live in New York City</h3>\r\n<br />\r\nThinking about overseas adventure travel? Have you put any thought into the best places to go when it comes to overseas adventure travel? Nepal is one of the most popular places of all, when you visit this magical country you will have the best adventures right there at your doorstep. Only overseas adventure travel in Nepal will give you these kinds of opportunities so if this is not on your list of possible places to visit yet then now is the time to put it on there!<br />\r\n<br />\r\nIn Nepal your overseas adventure travel is going to be fascinating. You will get to see the Himalayan Mountains and experience all that the rich Nepalese culture has to offer. They are an amazing people who have managed to hang on to their own culture and beliefs longer than most other countries. When overseas adventure travel takes you to Nepal you will have the chance to see all of the fantastic and one of a kind lakes and forests and you can even spend days or weeks camping out in their forests with a specialized guide. And the waterfalls in Nepal are to die for, you will never see anything more gorgeous in your life as their waterfalls! This should be at the top of your overseas adventure travel destination list for sure!', '<h3>If you live in New York City</h3>\r\n<br />\r\nThinking about overseas adventure travel? Have you put any thought into the best places to go when it comes to overseas adventure travel? Nepal is one of the most popular places of all, when you visit this magical country you will have the best adventures right there at your doorstep. Only overseas adventure travel in Nepal will give you these kinds of opportunities so if this is not on your list of possible places to visit yet then now is the time to put it on there!<br />\r\n<br />\r\nIn Nepal your overseas adventure travel is going to be fascinating. You will get to see the Himalayan Mountains and experience all that the rich Nepalese culture has to offer. They are an amazing people who have managed to hang on to their own culture and beliefs longer than most other countries. When overseas adventure travel takes you to Nepal you will have the chance to see all of the fantastic and one of a kind lakes and forests and you can even spend days or weeks camping out in their forests with a specialized guide. And the waterfalls in Nepal are to die for, you will never see anything more gorgeous in your life as their waterfalls! This should be at the top of your overseas adventure travel destination list for sure!', 4, '3403dd0288a8da230c0373bd881c5baf.jpg', '3bdbfee5e5e31530e82546b055bf8a12.jpg', 1),
(45, 'Tremblantttt In Canadaaaaaa', '<h3>Se voc&ecirc; mora em Nova York</h3>\r\n&nbsp;\r\n\r\n<p>Pensando em viagens de aventura ao exterior? Voc&ecirc; j&aacute; pensou nos melhores lugares para viajar quando se trata de viagens de aventura ao exterior? O Nepal &eacute; um dos lugares mais populares de todos, quando voc&ecirc; visitar este pa&iacute;s m&aacute;gico, ter&aacute; as melhores aventuras ali mesmo &agrave; sua porta. Somente as viagens de aventura ao exterior no Nepal oferecem esse tipo de oportunidade; portanto, se essa ainda n&atilde;o estiver na sua lista de poss&iacute;veis lugares para visitar, agora &eacute; a hora de coloc&aacute;-la l&aacute;!<br />\r\n<br />\r\nNo Nepal, sua viagem de aventura ao exterior ser&aacute; fascinante. Voc&ecirc; ver&aacute; as montanhas do Himalaia e experimentar&aacute; tudo o que a rica cultura nepalesa tem a oferecer. S&atilde;o pessoas incr&iacute;veis que conseguiram manter sua pr&oacute;pria cultura e cren&ccedil;as por mais tempo do que a maioria dos outros pa&iacute;ses. Quando as viagens de aventura ao exterior o levarem ao Nepal, voc&ecirc; ter&aacute; a oportunidade de ver todos os lagos e florestas fant&aacute;sticos e &uacute;nicos e voc&ecirc; pode at&eacute; passar dias ou semanas acampando em suas florestas com um guia especializado. E as cachoeiras no Nepal s&atilde;o de morrer, voc&ecirc; nunca ver&aacute; nada mais lindo em sua vida do que as cachoeiras! Isso deve estar no topo da sua lista de destinos de viagens de aventura no exterior, com certeza!</p>\r\n', '<h3>If you live in New York City</h3>\r\n&nbsp;\r\n\r\n<p>Thinking about overseas adventure travel? Have you put any thought into the best places to go when it comes to overseas adventure travel? Nepal is one of the most popular places of all, when you visit this magical country you will have the best adventures right there at your doorstep. Only overseas adventure travel in Nepal will give you these kinds of opportunities so if this is not on your list of possible places to visit yet then now is the time to put it on there!</p>\r\n\r\n<p>In Nepal your overseas adventure travel is going to be fascinating. You will get to see the Himalayan Mountains and experience all that the rich Nepalese culture has to offer. They are an amazing people who have managed to hang on to their own culture and beliefs longer than most other countries. When overseas adventure travel takes you to Nepal you will have the chance to see all of the fantastic and one of a kind lakes and forests and you can even spend days or weeks camping out in their forests with a specialized guide. And the waterfalls in Nepal are to die for, you will never see anything more gorgeous in your life as their waterfalls! This should be at the top of your overseas adventure travel destination list for sure!</p>\r\n', '<h3>Si vives en la ciudad de Nueva York &iquest;</h3>\r\n&nbsp;\r\n\r\n<p>Pensando en viajes de aventura en el extranjero? &iquest;Has pensado en los mejores lugares para ir cuando se trata de viajes de aventura en el extranjero? Nepal es uno de los lugares m&aacute;s populares de todos, cuando visites este pa&iacute;s m&aacute;gico tendr&aacute;s las mejores aventuras justo en tu puerta. Solo los viajes de aventura en el extranjero en Nepal le dar&aacute;n este tipo de oportunidades, por lo que si a&uacute;n no est&aacute; en su lista de posibles lugares para visitar, &iexcl;ahora es el momento de ponerlo all&iacute;!</p>\r\n\r\n<p>En Nepal, su viaje de aventura al extranjero ser&aacute; fascinante. Podr&aacute;s ver las monta&ntilde;as del Himalaya y experimentar todo lo que la rica cultura nepal&iacute; tiene para ofrecer. Son personas incre&iacute;bles que han logrado conservar su propia cultura y creencias durante m&aacute;s tiempo que la mayor&iacute;a de los otros pa&iacute;ses. Cuando un viaje de aventura en el extranjero lo lleve a Nepal, tendr&aacute; la oportunidad de ver todos los fant&aacute;sticos y &uacute;nicos lagos y bosques e incluso puede pasar d&iacute;as o semanas acampando en sus bosques con un gu&iacute;a especializado. Y las cascadas en Nepal son para morirse, &iexcl;nunca ver&aacute;s nada m&aacute;s hermoso en tu vida como sus cascadas! &iexcl;Esto deber&iacute;a estar en la parte superior de su lista de destinos de viajes de aventura en el extranjero seguro!</p>\r\n\r\n<p><br />\r\n&nbsp;</p>\r\n', 4, '3bdbfee5e5e31530e82546b055bf8a55.jpg', 'a40659cf17542585d447906d90bbdea5.jpg', 1);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `avaliacoes`
--
ALTER TABLE `avaliacoes`
  ADD PRIMARY KEY (`idavaliacao`);

--
-- Índices para tabela `banner_text`
--
ALTER TABLE `banner_text`
  ADD PRIMARY KEY (`idbanner_txt`);

--
-- Índices para tabela `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`idcategoriav`);

--
-- Índices para tabela `contactos`
--
ALTER TABLE `contactos`
  ADD PRIMARY KEY (`idcontacto`);

--
-- Índices para tabela `eventos`
--
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`idevento`);

--
-- Índices para tabela `footer`
--
ALTER TABLE `footer`
  ADD PRIMARY KEY (`idfooter`);

--
-- Índices para tabela `galeria`
--
ALTER TABLE `galeria`
  ADD PRIMARY KEY (`idfoto`);

--
-- Índices para tabela `galeria_visita`
--
ALTER TABLE `galeria_visita`
  ADD PRIMARY KEY (`idfoto_visita`);

--
-- Índices para tabela `mensagens`
--
ALTER TABLE `mensagens`
  ADD PRIMARY KEY (`idmensagem`);

--
-- Índices para tabela `page_reservas`
--
ALTER TABLE `page_reservas`
  ADD PRIMARY KEY (`idpager`);

--
-- Índices para tabela `pais`
--
ALTER TABLE `pais`
  ADD PRIMARY KEY (`idpais`);

--
-- Índices para tabela `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`idreserva`);

--
-- Índices para tabela `reservas_anos`
--
ALTER TABLE `reservas_anos`
  ADD PRIMARY KEY (`idreserva_ano`);

--
-- Índices para tabela `reserva_cancelar`
--
ALTER TABLE `reserva_cancelar`
  ADD PRIMARY KEY (`idreservac`);

--
-- Índices para tabela `reserva_datas`
--
ALTER TABLE `reserva_datas`
  ADD PRIMARY KEY (`idreserva_data`);

--
-- Índices para tabela `resposta_mensagm`
--
ALTER TABLE `resposta_mensagm`
  ADD PRIMARY KEY (`idresposta`);

--
-- Índices para tabela `sobre_casa`
--
ALTER TABLE `sobre_casa`
  ADD PRIMARY KEY (`idsobre_casa`);

--
-- Índices para tabela `sobre_home`
--
ALTER TABLE `sobre_home`
  ADD PRIMARY KEY (`idsobre_home`);

--
-- Índices para tabela `utilizadores`
--
ALTER TABLE `utilizadores`
  ADD PRIMARY KEY (`idutilizador`);

--
-- Índices para tabela `utilizadores_block`
--
ALTER TABLE `utilizadores_block`
  ADD PRIMARY KEY (`iduser_block`);

--
-- Índices para tabela `visitas`
--
ALTER TABLE `visitas`
  ADD PRIMARY KEY (`idvisita`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `avaliacoes`
--
ALTER TABLE `avaliacoes`
  MODIFY `idavaliacao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `banner_text`
--
ALTER TABLE `banner_text`
  MODIFY `idbanner_txt` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `categorias`
--
ALTER TABLE `categorias`
  MODIFY `idcategoriav` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `contactos`
--
ALTER TABLE `contactos`
  MODIFY `idcontacto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `eventos`
--
ALTER TABLE `eventos`
  MODIFY `idevento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `footer`
--
ALTER TABLE `footer`
  MODIFY `idfooter` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `galeria`
--
ALTER TABLE `galeria`
  MODIFY `idfoto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de tabela `galeria_visita`
--
ALTER TABLE `galeria_visita`
  MODIFY `idfoto_visita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT de tabela `mensagens`
--
ALTER TABLE `mensagens`
  MODIFY `idmensagem` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `page_reservas`
--
ALTER TABLE `page_reservas`
  MODIFY `idpager` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `pais`
--
ALTER TABLE `pais`
  MODIFY `idpais` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=253;

--
-- AUTO_INCREMENT de tabela `reservas`
--
ALTER TABLE `reservas`
  MODIFY `idreserva` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de tabela `reservas_anos`
--
ALTER TABLE `reservas_anos`
  MODIFY `idreserva_ano` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `reserva_cancelar`
--
ALTER TABLE `reserva_cancelar`
  MODIFY `idreservac` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `reserva_datas`
--
ALTER TABLE `reserva_datas`
  MODIFY `idreserva_data` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de tabela `resposta_mensagm`
--
ALTER TABLE `resposta_mensagm`
  MODIFY `idresposta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `sobre_casa`
--
ALTER TABLE `sobre_casa`
  MODIFY `idsobre_casa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `sobre_home`
--
ALTER TABLE `sobre_home`
  MODIFY `idsobre_home` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `utilizadores`
--
ALTER TABLE `utilizadores`
  MODIFY `idutilizador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT de tabela `utilizadores_block`
--
ALTER TABLE `utilizadores_block`
  MODIFY `iduser_block` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `visitas`
--
ALTER TABLE `visitas`
  MODIFY `idvisita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
