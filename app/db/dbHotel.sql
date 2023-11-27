CREATE TABLE reservas (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `tipoCliente` VARCHAR(50),
    `idCliente` VARCHAR(50),
    `fechaEntrada` VARCHAR(50),
    `fechaSalida` VARCHAR(50),
    `tipoHabitacion` VARCHAR(50),
    `importe` INT,
    `activa` bool,
    `ajuste` VARCHAR(120)
);




CREATE TABLE clientes (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
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
