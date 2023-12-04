CREATE TABLE reservas (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `tipoCliente` VARCHAR(50),
    `idCliente` INT,
    `fechaEntrada` DATE,
    `fechaSalida` DATE,
    `tipoHabitacion` VARCHAR(50),
    `importe` INT,
    `activa` bool,
    `ajuste` VARCHAR(120)
);




CREATE TABLE hoteles (
    `id` INT(6) ZEROFILL AUTO_INCREMENT PRIMARY KEY,
    `nombre` VARCHAR(50),
    `apellido` VARCHAR(50),
    `tipoDocumento` VARCHAR(50),
    `nroDocumento` VARCHAR(50),
    `email` VARCHAR(50),
    `tipoCliente` VARCHAR(50),
    `pais` VARCHAR(50),
    `ciudad` VARCHAR(50),
    `telefono` VARCHAR(50),
    `modoPago` VARCHAR(50),
    `activo` bool
);

INSERT INTO hoteles (nombre, apellido, tipoDocumento, nroDocumento, email, tipoCliente, pais, ciudad, telefono, modoPago, activo)
VALUES
    ('Hikaru', 'Sulu', 'DNI', '40111222', 'sulu@enterprise.com', 'CORPO', 'USA', 'New York', '14067051122', 'EFECTIVO', TRUE);

CREATE TABLE usuarios (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `usuario` VARCHAR(50),
    `email` VARCHAR(50),
    `pass` VARCHAR(50),
    `rol` VARCHAR(50)
);

INSERT INTO usuarios (usuario, email, pass, rol)
VALUES
    ('PEPITO-ADMIN', 'pepito-a@hilton.com', 'admin', 'GERENTE'),
    ('PEPITO-RECEPCION', 'pepito-r@hilton.com', 'admin', 'RECEPCIONISTA'),
    ('PEPITO-CLIENTE', 'pepito-chilton.com', 'admin', 'CLIENTE');


CREATE TABLE logs (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `id_usuario` INT,
    `usuario` VARCHAR(50),
    `entidad` VARCHAR(50),
    `operacion` VARCHAR(50),
    `datos_operacion` VARCHAR(5000),
    `datos_resultado_operacion` VARCHAR(1000),
    `fecha_hora` datetime
);
