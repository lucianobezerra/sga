drop table config;
CREATE TABLE config
(
   id serial NOT NULL, 
   expira character varying(60), 
   CONSTRAINT pk_config PRIMARY KEY (id) USING INDEX TABLESPACE pg_default
) 
WITH (
  OIDS = FALSE
)

TABLESPACE pg_default;
ALTER TABLE config OWNER TO postgres;

select * from config;

insert into config (expira) values ('=UlVKdFVW50USxGZ1plRoZFZwYVRUtWNXFWMSBlVsR2VSBjWJZFbJhnVGFUP');