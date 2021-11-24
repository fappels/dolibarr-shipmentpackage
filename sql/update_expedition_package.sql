-- Copyright (C) 2021       Francis Appels          <francis.appels@z-application.com>
--
-- This program is free software: you can redistribute it and/or modify
-- it under the terms of the GNU General Public License as published by
-- the Free Software Foundation, either version 3 of the License, or
-- (at your option) any later version.
--
-- This program is distributed in the hope that it will be useful,
-- but WITHOUT ANY WARRANTY; without even the implied warranty of
-- MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
-- GNU General Public License for more details.
--
-- You should have received a copy of the GNU General Public License
-- along with this program.  If not, see http://www.gnu.org/licenses/.

ALTER TABLE llx_expedition_package MODIFY COLUMN rowid integer AUTO_INCREMENT PRIMARY KEY NOT NULL;
ALTER TABLE llx_expedition_package MODIFY COLUMN fk_expedition integer;
ALTER TABLE llx_expedition_package ADD COLUMN entity integer DEFAULT 1 NOT NULL AFTER rowid;
ALTER TABLE llx_expedition_package ADD COLUMN ref varchar(128) DEFAULT '(PROV)' NOT NULL;
ALTER TABLE llx_expedition_package ADD COLUMN ref_supplier varchar(128);
ALTER TABLE llx_expedition_package ADD COLUMN fk_soc integer;
ALTER TABLE llx_expedition_package ADD COLUMN fk_supplier integer;
ALTER TABLE llx_expedition_package ADD COLUMN fk_project integer;
ALTER TABLE llx_expedition_package ADD COLUMN note_public text AFTER tail_lift;
ALTER TABLE llx_expedition_package ADD COLUMN note_private text;
ALTER TABLE llx_expedition_package ADD COLUMN date_creation datetime NOT NULL;
ALTER TABLE llx_expedition_package ADD COLUMN tms timestamp;
ALTER TABLE llx_expedition_package ADD COLUMN fk_user_creat integer NOT NULL;
ALTER TABLE llx_expedition_package ADD COLUMN fk_user_modif integer;
ALTER TABLE llx_expedition_package ADD COLUMN last_main_doc varchar(255);
ALTER TABLE llx_expedition_package ADD COLUMN import_key varchar(14);
ALTER TABLE llx_expedition_package ADD COLUMN model_pdf varchar(255);
ALTER TABLE llx_expedition_package ADD COLUMN status smallint NOT NULL;
ALTER TABLE llx_expedition_package CHANGE COLUMN size length float;
ALTER TABLE llx_expedition_package DROP COLUMN rang;
ALTER TABLE llx_expedition_packagedet DROP COLUMN fk_product_lot;
ALTER TABLE llx_expedition_packagedet ADD COLUMN product_lot_batch varchar(128);
ALTER TABLE llx_expedition_packagedet DROP INDEX idx_expedition_packagedet_fk_expedition_package;
ALTER TABLE llx_expedition_pacakgedet DROP CONSTRAINT fk_expeditiondet_fk_expedition_package;
ALTER TABLE llx_expedition_packagedet CHANGE COLUMN fk_expedition_package fk_shipmentpackage integer NOT NULL;
ALTER TABLE llx_expedition_packagedet ADD INDEX idx_expedition_packagedet_fk_shipmentpackage (fk_shipmentpackage);
ALTER TABLE llx_expedition_pacakgedet ADD CONSTRAINT fk_expeditiondet_fk_shipmentpackage FOREIGN KEY (fk_shipmentpackage) REFERENCES llx_expedition_package (rowid);

UPDATE llx_expedition_package SET dangerous_goods = 0 WHERE dangerous_goods IS NULL;
UPDATE llx_expedition_package SET tail_lift = 0 WHERE tail_lift IS NULL;
