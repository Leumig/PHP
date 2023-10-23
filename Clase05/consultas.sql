INSERT INTO usuario (nombre, apellido, clave, mail, fecha_de_registro, localidad)
VALUES ('Esteban', 'Madou', '2345', 'dkantor0@example.com', '2021-01-07', 'Quilmes'), 
('German', 'Gerram', '1234', 'ggerram1@hud.gov', '2020-05-08', 'Berazategui'),
('Deloris', 'Fosis', '5678', 'bsharpe2@wisc.edu', '2020-11-28', 'Avellaneda'),
('Brok', 'Neiner', '4567', 'bblazic3@desdev.cn', '2020-12-08', 'Quilmes'),
('Garrick', 'Brent', '6789', 'gbrent4@theguardian.com', '2020-12-17', 'Moron'),
('Bili', 'Baus', '0123', 'bhoff5@addthis.com', '2020-11-27', 'Moreno');


INSERT INTO producto (codigo_de_barra, nombre, tipo, stock, precio, fecha_de_creacion, fecha_de_modificacion)
VALUES ('77900361', 'Westmacott', 'liquido', '33', '15.87', '2021-02-09', '2020-09-26'),
('77900362', 'Spirit', 'solido', '45', '69.74', '2020-11-29', '2021-2-11'),
('77900363', 'Newgrosh', 'polvo', '14', '68.19', '2020-11-29', '2021-02-11'), 
('77900364', 'McNickle', 'polvo', '19', '53.51', '2020-11-28', '2020-04-17'),
('77900365', 'Hudd', 'solido', '68', '26.56', '2020-12-19', '2020-06-19'),
('77900366', 'Schrader', 'polvo', '17', '96.54', '2020-08-02', '2020-04-18'),
('77900367', 'Bachellier', 'solido', '59', '69.17', '2021-01-30', '2020-06-07'),
('77900368', 'Fleming', 'solido', '38', '66.77', '2020-10-26', '2020-10-3'),
('77900369', 'Hurry', 'solido', '44', '43.01', '2020-07-04', '2020-05-30'),
('77900310', 'Krauss', 'polvo', '73', '35.73', '2021-03-03', '2020-08-30');


INSERT INTO venta (id_producto, id_usuario, cantidad, fecha_de_venta)
VALUES ('1001', '101', '2', '2020-7-19'),
('1008', '102', '3', '2020-08-16'),
('1007', '102', '4', '2021-01-24'),
('1006', '103', '5', '2021-01-14'),
('1003', '104', '6', '2021-03-20'),
('1005', '105', '7', '2021-02-22'),
('1003', '104', '6', '2020-12-02'),
('1003', '106', '6', '2020-06-10'),
('1002', '106', '6', '2021-02-04'),
('1001', '106', '1', '2021-05-17');



-- Gil Miguel Ángel

-- 1. Obtener los detalles completos de todos los usuarios, ordenados alfabéticamente.

SELECT * FROM usuario ORDER BY usuario.nombre;

-- 2. Obtener los detalles completos de todos los productos líquidos.

SELECT * FROM producto WHERE producto.tipo = 'liquido';

-- 3. Obtener todas las compras en los cuales la cantidad esté entre 6 y 10 inclusive.

SELECT * FROM venta WHERE venta.cantidad >= 6 AND venta.cantidad <= 10;

-- 4. Obtener la cantidad total de todos los productos vendidos.

SELECT SUM(venta.cantidad) AS cantidad_ventas FROM venta;

-- 5. Mostrar los primeros 3 números de productos que se han enviado.

SELECT producto.codigo_de_barra FROM producto LIMIT 3;

-- 6. Mostrar los nombres del usuario y los nombres de los productos de cada venta.

SELECT u.nombre AS nombre_usuario, p.nombre AS nombre_producto
FROM venta v
JOIN usuario u ON v.id_usuario = u.id
JOIN producto p ON v.id_producto = p.id;

-- 7. Indicar el monto (cantidad * precio) por cada una de las ventas.

SELECT v.id AS id_venta, (v.cantidad * p.precio) AS monto
FROM venta v
JOIN producto p ON v.id_producto = p.id
JOIN usuario u ON v.id_usuario = u.id;

-- 8. Obtener la cantidad total del producto 1003 vendido por el usuario 104.

SELECT SUM(venta.cantidad) AS cantidad FROM venta 
WHERE (venta.id_producto = '1003' AND venta.id_usuario = '104');

-- 9. Obtener todos los números de los productos vendidos por algún usuario de ‘Avellaneda’.

SELECT p.codigo_de_barra FROM venta v
JOIN usuario u ON v.id_usuario = u.id
JOIN producto p ON v.id_producto = p.id
WHERE u.localidad = 'Avellaneda';

-- 10. Obtener los datos completos de los usuarios cuyos nombres contengan la letra ‘u’.

SELECT * FROM usuario WHERE usuario.nombre LIKE '%u%';

-- 11. Traer las ventas entre junio del 2020 y febrero 2021.

SELECT * FROM venta
WHERE venta.fecha_de_venta >= '2020-06-01' AND venta.fecha_de_venta <= '2021-02-01';

-- 12. Obtener los usuarios registrados antes del 2021.

SELECT * FROM usuario
WHERE usuario.fecha_de_registro <= '2021-01-01';

-- 13. Agregar el producto llamado ‘Chocolate’, de tipo Sólido y con un precio de 25,35.

INSERT INTO producto (codigo_de_barra, nombre, tipo, stock, precio, fecha_de_creacion, fecha_de_modificacion) 
VALUES ('77900311', 'Chocolate', 'solido', '50', '25.35', '2023-09-25', '2023-09-27');

-- 14. Insertar un nuevo usuario.

INSERT INTO usuario (nombre, apellido, clave, mail, fecha_de_registro, localidad)
VALUES ('Miguel', 'Gil', '0099', 'junmigue7@gmail.com', '2023-09-27', 'Avellaneda');

-- 15. Cambiar los precios de los productos de tipo sólido a 66,60.

UPDATE producto SET producto.precio = '66.60' WHERE producto.tipo = 'solido';

-- 16. Cambiar el stock a 0 de todos los productos cuyas cantidades de stock sean menores a 20 inclusive.

UPDATE producto SET producto.stock = '0' WHERE producto.stock <= '20';

-- 17.Eliminar el producto número 1010.

DELETE FROM producto WHERE producto.id = '1010';

-- 18. Eliminar a todos los usuarios que no han vendido productos.

DELETE FROM usuario
WHERE usuario.id NOT IN (SELECT DISTINCT id_usuario FROM venta);