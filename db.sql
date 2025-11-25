USE db;

-- Create table "personnages"
CREATE TABLE personnages (
	id VARCHAR(255) PRIMARY KEY,
	name VARCHAR(255) NOT NULL,
	element VARCHAR(255) NOT NULL,
	unit_class VARCHAR(255) NOT NULL,
	origin VARCHAR(255) NOT NULL,
	rarity INT NOT NULL,
	url_image VARCHAR(255) NOT NULL
) ENGINE = InnoDB CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Insert sample character data
INSERT INTO personnages (id, name, element, unit_class, origin, rarity, url_image) VALUES
('690a21938f4e03.77345231', 'Aino', 'Hydro', 'Claymore', 'Nod-Krai', 4, 'https://static.wikia.nocookie.net/gensin-impact/images/a/a3/Aino_Icon.png'),
('690a219b956ed6.60563743', 'Ineffa', 'Electro', 'Polearm', 'Nod-Krai', 5, 'https://static.wikia.nocookie.net/gensin-impact/images/0/0b/Ineffa_Icon.png'),
('690a219c1293b4.38536441', 'Chongyun', 'Cryo', 'Claymore', 'Liyue', 4, 'https://static.wikia.nocookie.net/gensin-impact/images/3/35/Chongyun_Icon.png');
