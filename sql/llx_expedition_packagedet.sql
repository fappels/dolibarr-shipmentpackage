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
create table llx_expedition_packagedet
(
  rowid                     integer AUTO_INCREMENT PRIMARY KEY,
  fk_expedition_package     integer NOT NULL,
  fk_origin_line            integer,           -- Corresponds with the line of the origin object (shipping)
  fk_origin_batch_line      integer,           -- Corresponds with the lot id line of the origin object (shipping line batch)
  fk_product                integer,           -- product id
  product_lot_batch         varchar(128),      -- product lot batch value
  qty                       real,              -- Quantity
  rang                      integer  DEFAULT 0
)ENGINE=innodb;