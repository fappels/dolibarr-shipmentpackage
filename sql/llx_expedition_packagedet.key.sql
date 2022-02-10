-- Copyright (C) 2021      Francis Appels <francis.appels@z-application.com>
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
-- along with this program.  If not, see https://www.gnu.org/licenses/.

ALTER TABLE llx_expedition_packagedet ADD INDEX idx_expedition_packagedet_fk_shipmentpackage (fk_shipmentpackage);
ALTER TABLE llx_expedition_packagedet ADD INDEX idx_expedition_packagedet_fk_origin_line (fk_origin_line);
ALTER TABLE llx_expedition_packagedet ADD CONSTRAINT fk_expeditiondet_fk_shipmentpackage FOREIGN KEY (fk_shipmentpackage) REFERENCES llx_expedition_package (rowid);
