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

-- Create table "elements"
CREATE TABLE elements (
	id INT PRIMARY KEY AUTO_INCREMENT,
	name VARCHAR(60) NOT NULL UNIQUE,
	url_img VARCHAR(255) NOT NULL
) ENGINE = InnoDB CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Create table "origins"
CREATE TABLE origins (
	id INT PRIMARY KEY AUTO_INCREMENT,
	name VARCHAR(60) NOT NULL UNIQUE,
	url_img VARCHAR(255) NOT NULL
) ENGINE = InnoDB CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Create table "unit_classes"
CREATE TABLE unit_classes (
	id INT PRIMARY KEY AUTO_INCREMENT,
	name VARCHAR(60) NOT NULL UNIQUE,
	url_img VARCHAR(255) NOT NULL
) ENGINE = InnoDB CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Insert elements into the table
INSERT INTO elements (name, url_img) VALUES
('Pyro', 'https://static.wikia.nocookie.net/genshinimpact/images/7/71/Ic%C3%B4ne_Pyro.png'),
('Hydro', 'https://static.wikia.nocookie.net/genshinimpact/images/2/29/Ic%C3%B4ne_Hydro.png'),
('Dendro', 'https://static.wikia.nocookie.net/genshinimpact/images/b/b9/Ic%C3%B4ne_Dendro.png'),
('Électro', 'https://static.wikia.nocookie.net/genshinimpact/images/8/8d/Ic%C3%B4ne_%C3%89lectro.png'),
('Anémo', 'https://static.wikia.nocookie.net/genshinimpact/images/d/d9/Ic%C3%B4ne_An%C3%A9mo.png'),
('Cryo', 'https://static.wikia.nocookie.net/genshinimpact/images/4/4e/Ic%C3%B4ne_Cryo.png'),
('Géo', 'https://static.wikia.nocookie.net/genshinimpact/images/8/86/Ic%C3%B4ne_G%C3%A9o.png');

-- Insert origins into the table
INSERT INTO origins (name, url_img) VALUES
('Nod-Krai', 'https://static.wikia.nocookie.net/genshinimpact/images/6/65/Embl%C3%A8me_Nod-Krai.png'),
('Sumeru', 'https://static.wikia.nocookie.net/genshinimpact/images/e/ee/Embl%C3%A8me_Sumeru.png'),
('Mondstadt', 'https://static.wikia.nocookie.net/genshinimpact/images/b/bc/Embl%C3%A8me_Mondstadt.png'),
('Gouffre', 'https://static.wikia.nocookie.net/genshinimpact/images/4/44/Gouffre.png'),
('Fôret de jade', 'https://static.wikia.nocookie.net/genshinimpact/images/8/8e/For%C3%AAt_de_jade.png'),
('Liyue', 'https://static.wikia.nocookie.net/genshinimpact/images/2/21/Embl%C3%A8me_Liyue.png'),
('Sources de Jade', 'https://static.wikia.nocookie.net/genshinimpact/images/a/a1/Sources_de_Jade.png'),
('Région mortée', 'https://static.wikia.nocookie.net/genshinimpact/images/9/92/R%C3%A9gion_mort%C3%A9e.png');

-- Insert unit classes into the table
INSERT INTO unit_classes (name, url_img) VALUES
('Sword', 'https://static.wikia.nocookie.net/gensin-impact/images/8/81/Icon_Sword.png'),
('Claymore', 'https://static.wikia.nocookie.net/gensin-impact/images/6/66/Icon_Claymore.png'),
('Polearm', 'https://static.wikia.nocookie.net/gensin-impact/images/6/6a/Icon_Polearm.png'),
('Catalyst', 'https://static.wikia.nocookie.net/gensin-impact/images/2/27/Icon_Catalyst.png'),
('Bow', 'https://static.wikia.nocookie.net/gensin-impact/images/8/81/Icon_Bow.png');

-- Rename "personnages" columns to keep old data
ALTER TABLE personnages
RENAME COLUMN element TO element_tmp,
RENAME COLUMN origin TO origin_tmp,
RENAME COLUMN unit_class TO unit_class_tmp;

-- Change "personnages" columns to support foreign tables
ALTER TABLE personnages
ADD COLUMN element INT DEFAULT NULL AFTER name,
ADD COLUMN origin INT DEFAULT NULL AFTER element,
ADD COLUMN unit_class INT DEFAULT NULL AFTER origin;

-- Add foreign key constraints to the "personnages" table
ALTER TABLE personnages
ADD FOREIGN KEY (element) REFERENCES elements(id) ON UPDATE CASCADE ON DELETE RESTRICT,
ADD FOREIGN KEY (origin) REFERENCES origins(id) ON UPDATE CASCADE ON DELETE RESTRICT,
ADD FOREIGN KEY (unit_class) REFERENCES unit_classes(id) ON UPDATE CASCADE ON DELETE RESTRICT;

-- Update values of the "foreign" columns in the "personnages" table
# noinspection SqlWithoutWhere
UPDATE personnages
INNER JOIN elements ON personnages.element_tmp = elements.name
SET personnages.element = elements.id;
# noinspection SqlWithoutWhere
UPDATE personnages
INNER JOIN origins ON personnages.origin_tmp = origins.name
SET personnages.origin = origins.id;
# noinspection SqlWithoutWhere
UPDATE personnages
INNER JOIN unit_classes ON personnages.unit_class_tmp = unit_classes.name
SET personnages.unit_class = unit_classes.id;

-- Add a not-nullable constraint to the "foreign" columns in the "personnages" table
ALTER TABLE personnages
MODIFY element INT NOT NULL AFTER unit_class,
MODIFY origin INT NOT NULL AFTER element,
MODIFY unit_class INT NOT NULL AFTER origin;

-- Drop temporary columns in the "personnages" table
ALTER TABLE personnages
DROP COLUMN element_tmp,
DROP COLUMN origin_tmp,
DROP COLUMN unit_class_tmp;

-- Create "users" table
CREATE TABLE users (
	id INT PRIMARY KEY AUTO_INCREMENT,
	username VARCHAR(255) UNIQUE NOT NULL,
	hash_pwd VARCHAR(255) NOT NULL
) ENGINE = InnoDB CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Insert some user data
INSERT INTO users (username, hash_pwd) VALUES
('admin', '$2y$12$P5hKMKw/sIxdwcYTlxsLF.kFdf/q11LjiZ.tZOwKUCPsHEgSj5k8e'),
('test', '$2y$12$mOunMLdKB7i39wPZbrFQP.fVHJdWDIfsmqOXydjp7C0c5F4PUlq.O');
