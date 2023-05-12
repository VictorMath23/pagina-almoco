CREATE TABLE `almoco_manufatura` (
  `id` int NOT NULL,
  `LINHA` varchar(45) DEFAULT NULL,
  `HORARIO` time DEFAULT NULL,
  `REVEZAMENTO` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO almoco_manufatura (LINHA, HORARIO) VALUES 
('LINHA 1', '11:00:00'),
('LINHA 2', '11:00:00'),
('LINHA 3', '11:00:00'),
('LINHA 4', '11:00:00'),
('LINHA 5', '11:00:00'),
('LINHA 6', '11:00:00'),
('LINHA 7', '11:00:00'),
('LINHA 8', '11:00:00'),
('LINHA 9', '11:00:00'),
('LINHA 10', '11:00:00'),
('HIBRIDA', '11:00:00'),
('SERVIDOR', '11:00:00'),
('TREINAMENTO', '11:00:00');

DELIMITER //

CREATE PROCEDURE reset_horarios()
BEGIN
    DECLARE horario_atual TIME;
    SET horario_atual = NOW();
    IF HOUR(horario_atual) = '15:00:00' OR HOUR(horario_atual) = '22:00:00' THEN
        UPDATE mfg.almoco_manufatura SET horario = '11:00:00', revezamento = '-';
    END IF;
END //

DELIMITER ;

SELECT * FROM mfg.almoco_manufatura;