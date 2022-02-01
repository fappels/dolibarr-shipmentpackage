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
-- along with this program.  If not, see https://www.gnu.org/licenses/.


CREATE TABLE llx_expedition_package(
	rowid integer AUTO_INCREMENT PRIMARY KEY NOT NULL, 
	entity integer DEFAULT 1 NOT NULL, 
	ref varchar(128) DEFAULT '(PROV)' NOT NULL, 
	ref_supplier varchar(128),		-- package ref supplier who handles package (tracking number)
	fk_soc integer, 				-- customer
	fk_supplier,					-- supplier who handles package
	fk_project integer,
	description varchar(255), 		--Description of goods in the package (required by the custom)
	value double(24,8) DEFAULT 0,	--Value (Price of the content, for insurance & custom), 
	fk_package_type integer,			-- parcel type from c_shipment_package_type
	fk_shipping_method integer,		-- shipping method from c_shipment_mode
	height float,					-- height
	width float,					-- width
	length float, 					-- depth
	size_units integer, 				-- unit of all sizes (height, width, depth)
	weight float, 					-- weight
	weight_units integer, 				-- unit of weight
	dangerous_goods smallint DEFAULT 0, -- 0 = no dangerous goods or 1 = Explosives, 2 = Flammable Gases, 3 = Flammable Liquids, 4 = Flammable solids, 5 = Oxidizing, 6 = Toxic & Infectious, 7 = Radioactive, 8 = Corrosives, 9 = Miscellaneous (see https://en.wikipedia.org/wiki/Dangerous_goods). I'm not sure if just register 0 (no) or 1 (yes) is enough.
	tail_lift smallint DEFAULT 0, 	-- 0 = no tail lift required to load/unload package(s), 1 = a tail lift is required to load/unload package(s). Sometime tail lift load can be different than tail lift delivery so maybe adding a new table line.
	note_public text, 
	note_private text, 
	date_creation datetime NOT NULL, 
	tms timestamp, 
	fk_user_creat integer NOT NULL, 
	fk_user_modif integer, 
	last_main_doc varchar(255), 
	import_key varchar(14), 
	model_pdf varchar(255), 
	status smallint NOT NULL
) ENGINE=innodb;
