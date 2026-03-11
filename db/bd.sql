DROP TABLE IF EXISTS canciones;
DROP TABLE IF EXISTS fechas_tour;
DROP TABLE IF EXISTS albums;
DROP TABLE IF EXISTS tours;
DROP TABLE IF EXISTS eras_musicales;
DROP TABLE IF EXISTS suscriptores;

CREATE TABLE IF NOT EXISTS eras_musicales (
    id                   INT AUTO_INCREMENT PRIMARY KEY,
    nombreEra            VARCHAR(100) NOT NULL,
    paletaColores        VARCHAR(200) NOT NULL,
    tipografiaPrincipal  VARCHAR(100) NOT NULL DEFAULT 'Georgia, serif',
    imagenBanner         VARCHAR(300) DEFAULT NULL,
    activa               TINYINT(1) NOT NULL DEFAULT 0,
    creadoEn             TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS albums (
    id                INT AUTO_INCREMENT PRIMARY KEY,
    titulo            VARCHAR(150) NOT NULL,
    fechaLanzamiento  DATE NOT NULL,
    portadaUrl        VARCHAR(300) DEFAULT NULL,
    descripcion       TEXT DEFAULT NULL,
    eraId             INT DEFAULT NULL,
    spotifyUrl        VARCHAR(300) DEFAULT NULL,
    youtubeUrl        VARCHAR(300) DEFAULT NULL,
    creadoEn          TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (eraId) REFERENCES eras_musicales(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS canciones (
    id                INT AUTO_INCREMENT PRIMARY KEY,
    titulo            VARCHAR(200) NOT NULL,
    albumId           INT NOT NULL,
    duracionSegundos  INT NOT NULL DEFAULT 0,
    letra             TEXT DEFAULT NULL,
    urlVideoMusical   VARCHAR(300) DEFAULT NULL,
    numeroPista       INT NOT NULL DEFAULT 1,
    creadoEn          TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (albumId) REFERENCES albums(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS tours (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    nombreTour   VARCHAR(150) NOT NULL,
    fechaInicio  DATE NOT NULL,
    fechaFin     DATE NOT NULL,
    descripcion  TEXT DEFAULT NULL,
    imagenUrl    VARCHAR(300) DEFAULT NULL,
    activo       TINYINT(1) NOT NULL DEFAULT 1,
    creadoEn     TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS fechas_tour (
    id               INT AUTO_INCREMENT PRIMARY KEY,
    tourId           INT NOT NULL,
    ciudad           VARCHAR(100) NOT NULL,
    pais             VARCHAR(100) NOT NULL,
    recinto          VARCHAR(200) NOT NULL,
    fechaHora        DATETIME NOT NULL,
    estadoTicket     ENUM('disponible','agotado','proximo') NOT NULL DEFAULT 'proximo',
    urlVentaExterna  VARCHAR(300) DEFAULT NULL,
    creadoEn         TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (tourId) REFERENCES tours(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS suscriptores (
    id             INT AUTO_INCREMENT PRIMARY KEY,
    email          VARCHAR(200) NOT NULL UNIQUE,
    pais           VARCHAR(100) NOT NULL,
    fechaRegistro  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    activo         TINYINT(1) NOT NULL DEFAULT 1
);

-- ── DATOS DE EJEMPLO ──────────────────────────────────────────

INSERT INTO eras_musicales (nombreEra, paletaColores, tipografiaPrincipal, activa) VALUES
('Short n Sweet Era',     '{"primario":"#f8c8d8","secundario":"#d1495b"}', 'Georgia, serif',          1),
('emails i cant send Era','{"primario":"#c8d8f8","secundario":"#4966d1"}', 'Helvetica, sans-serif',   0);

INSERT INTO albums (titulo, fechaLanzamiento, descripcion, eraId, spotifyUrl) VALUES
('Short n Sweet',      '2024-08-23', 'Sexto álbum de estudio de Sabrina Carpenter.', 1, 'https://open.spotify.com/album/5ZBm4aRTasaVgAu1JbQ0kl'),
('emails i cant send', '2022-09-23', 'Quinto álbum de estudio.',                     2, 'https://open.spotify.com/album/2HYWBWSY0BFWuqo0UYDdAj'),
('fruitcake',          '2024-11-15', 'EP especial navideño.',                        1,  NULL);

INSERT INTO canciones (titulo, albumId, duracionSegundos, numeroPista) VALUES
('Please Please Please',  1, 173, 1),
('Espresso',              1, 175, 2),
('Taste',                 1, 170, 3),
('because i liked a boy', 2, 193, 1),
('emails i cant send',    2, 230, 2);

INSERT INTO tours (nombreTour, fechaInicio, fechaFin, activo) VALUES
('Short n Sweet Tour', '2024-09-23', '2025-04-30', 1);

INSERT INTO fechas_tour (tourId, ciudad, pais, recinto, fechaHora, estadoTicket, urlVentaExterna) VALUES
(1, 'Miami',            'Estados Unidos', 'Kaseya Center', '2025-01-15 20:00:00', 'disponible', 'https://www.ticketmaster.com'),
(1, 'Ciudad de México', 'México',         'Foro Sol',       '2025-02-20 21:00:00', 'agotado',    'https://www.ticketmaster.com.mx'),
(1, 'Buenos Aires',     'Argentina',      'Movistar Arena', '2025-03-10 21:00:00', 'disponible', 'https://www.passline.com'),
(1, 'Madrid',           'España',         'WiZink Center',  '2025-04-05 20:00:00', 'proximo',    'https://www.ticketmaster.es');
