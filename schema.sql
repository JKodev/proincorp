CREATE TABLE ANTENAS.dbo.TB_CAMARAS
(
    id_camara INT,
    nombre VARCHAR(60) NOT NULL,
    ip VARCHAR(18)
);

CREATE TABLE ANTENAS.dbo.TB_LECTOR_CAMARA
(
    id_camara INT,
    id_lector_movimiento INT,
    ruta VARCHAR(60)
);