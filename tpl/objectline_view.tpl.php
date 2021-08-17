<?php
/* Copyright (C) 2019      Francis Appels <francis.appels@z-application.com>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 *
 * Need to have following variables defined:
 * $object (invoice, order, ...)
 * $conf
 * $langs
 * $forceall (0 by default, 1 for supplier invoices/orders)
 * $element     (used to test $user->rights->$element->creer)
 * $permtoedit  (used to replace test $user->rights->$element->creer)
 * $inputalsopricewithtax (0 by default, 1 to also show column with unit price including tax)
 * $object_rights->creer initialized from = $object->getRights()
 * $disableedit, $disablemove, $disableremove
 *
 * $type, $text, $description, $line
 */

// Protection to avoid direct call of template
if (empty($object) || !is_object($object)) {
	print "Error, template page can't be called as URL";
	exit;
}


global $forceall, $senderissupplier, $inputalsopricewithtax, $outputalsopricetotalwithtax, $permissiontoadd;

if (empty($dateSelector)) $dateSelector = 0;
if (empty($forceall)) $forceall = 0;
if (empty($senderissupplier)) $senderissupplier = 0;
if (empty($inputalsopricewithtax)) $inputalsopricewithtax = 0;
if (empty($outputalsopricetotalwithtax)) $outputalsopricetotalwithtax = 0;

$disablemove = 1; // TODO debug line move

// add html5 elements
$domData  = ' data-element="'.$line->element.'"';
$domData .= ' data-id="'.$line->id.'"';

// Lines for extrafield
$objectline = new ShipmentPackageLine($object->db);

$coldisplay = 0;
print "<!-- BEGIN PHP TEMPLATE objectline_view.tpl.php -->\n";
print '<tr id="row-'.$line->id.'" class="drag drop oddeven" '.$domData.' >';
if (!empty($conf->global->MAIN_VIEW_LINE_NUMBER)) {
	print '<td class="linecolnum center">'.($i + 1).'</td>';
	$coldisplay++;
}
$coldisplay++;
print '<td class="linecoldescription minwidth200imp"></td>';
$coldisplay++;
print '<td class="linecol">';
if ($line->fk_product > 0) {
	print $objectline->showOutputField($objectline->fields['fk_product'], 'fk_product', $line->fk_product);
} else {
	// free product
	if ($user->rights->commande->lire) {
		dol_include_once('/expedition/class/expedition.class.php');
		dol_include_once('/commande/class/commande.class.php');
		$shipmentLine = new ExpeditionLigne($object->db);
		$result = $shipmentLine->fetch($line->fk_origin_line);
		if ($result > 0) {
			$orderLine = new OrderLine($object->db);
			$result = $orderLine->fetch($shipmentLine->fk_origin_line);
			if ($result > 0) {
				print $orderLine->desc;
			}
		}
	}
}

print '</td>';

$coldisplay++;
print '<td class="linecolqty minwidth200imp">' . $line->qty;
print '</td>';

if (!empty($conf->productbatch->enabled)) {
	$coldisplay++;
	if (empty($line->product_lot_batch)) {
		$value = $langs->trans('NA');
	} else {
		$value = $line->product_lot_batch;
	}
	print '<td class="linecolqty minwidth200imp">' . $value;
	print '</td>';
}

print '<td class="linecol nowrap right">';
$coldisplay++;
print '</td>';



if ($this->status == 0 && ($permissiontoadd) && $action != 'selectlines' ) {
	print '<td class="linecoledit center">';
	$coldisplay++;
	if (($line->info_bits & 2) == 2 || ! empty($disableedit)) {
	} else {
		print '<a href="'.$_SERVER["PHP_SELF"].'?id='.$this->id.'&amp;action=editline&amp;lineid='.$line->id.'#line_'.$line->id.'">'.img_edit().'</a>';
	}
	print '</td>';

	print '<td class="linecoldelete center">';
	$coldisplay++;
	if (($line->fk_prev_id == null) && empty($disableremove)) {
		//La suppression n'est autorisée que si il n'y a pas de ligne dans une précédente situation
		print '<a href="'.$_SERVER["PHP_SELF"].'?id='.$this->id.'&amp;action=deleteline&amp;lineid='.$line->id.'">';
		print img_delete();
		print '</a>';
	}
	print '</td>';

	if ($num > 1 && $conf->browser->layout != 'phone' && empty($disablemove)) {
		print '<td class="linecolmove tdlineupdown center">';
		$coldisplay++;
		if ($i > 0) {
			print '<a class="lineupdown" href="'.$_SERVER["PHP_SELF"].'?id='.$this->id.'&amp;action=up&amp;rowid='.$line->id.'">';
			echo img_up('default', 0, 'imgupforline');
			print '</a>';
		}
		if ($i < $num - 1) {
			print '<a class="lineupdown" href="'.$_SERVER["PHP_SELF"].'?id='.$this->id.'&amp;action=down&amp;rowid='.$line->id.'">';
			echo img_down('default', 0, 'imgdownforline');
			print '</a>';
		}
		print '</td>';
	} else {
		//print '<td '.(($conf->browser->layout != 'phone' && empty($disablemove)) ? ' class="linecolmove tdlineupdown center"' : ' class="linecolmove center"').'></td>';
		//$coldisplay++;
	}
} else {
	print '<td colspan="3"></td>';
	$coldisplay = $coldisplay + 3;
}

if ($action == 'selectlines') {
	print '<td class="linecolcheck center">';
	print '<input type="checkbox" class="linecheckbox" name="line_checkbox['.($i + 1).']" value="'.$line->id.'" >';
	print '</td>';
}

print '</tr>';

print "<!-- END PHP TEMPLATE objectline_view.tpl.php -->\n";
