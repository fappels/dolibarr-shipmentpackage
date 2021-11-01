<?php
/* Copyright (C) 2012       Regis Houssin   <regis.houssin@inodbox.com>
 * Copyright (C) 2014       Marcos García   <marcosgdf@gmail.com>
 * Copyright (C) 2021       Francis Appels  <francis.appels@z-application.com>
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
 */

// Protection to avoid direct call of template
if (empty($conf) || !is_object($conf)) {
	print "Error, template page can't be called as URL";
	exit;
}


print "<!-- BEGIN PHP TEMPLATE -->\n";


global $user, $db;

$langs = $GLOBALS['langs'];
$linkedObjectBlock = $GLOBALS['linkedObjectBlock'];

// Load translation files required by the page
$langs->load("shipmentpackage@shipmentpackage");

$total = 0;
$ilink = 0;
foreach ($linkedObjectBlock as $key => $objectlink) {
	$ilink++;

	$trclass = 'oddeven';
	if ($ilink == count($linkedObjectBlock) && empty($noMoreLinkedObjectBlockAfter) && count($linkedObjectBlock) <= 1) {
		$trclass .= ' liste_sub_total';
	}
	?>
	<tr class="<?php echo $trclass; ?>">
		<td><?php echo $langs->trans("ShipmentPackage"); ?></td>
		<td><?php echo $objectlink->getNomUrl(1); ?></td>
		<td></td>
		<td class="center"><?php echo dol_print_date($objectlink->date_creation, 'day'); ?></td>
		<td class="right"><?php
		// get origin object amount for packaged qty
		if ($user->rights->commande->lire && is_array($objectlink->lines)) {
			$lineTotal = 0;
			foreach ($objectlink->lines as $packageLine) {
				dol_include_once('/expedition/class/expedition.class.php');
				dol_include_once('/commande/class/commande.class.php');
				$shipmentLine = new ExpeditionLigne($db);
				$shipmentLine->fetch($packageLine->fk_origin_line);
				if ($shipmentLine->id > 0) {
					$orderLine = new OrderLine($db);
					$orderLine->fetch($shipmentLine->fk_origin_line);
					if ($orderLine->id > 0) {
						$lineTotal = $lineTotal + ($orderLine->subprice * $packageLine->qty);
					}
				}
			}
			$total = $total + $lineTotal;
			echo price($lineTotal);
		} ?></td>
		<td class="right"><?php echo $objectlink->getLibStatut(3); ?></td>
		<td class="right"></td>
	</tr>
	<?php
}
if (count($linkedObjectBlock) > 1) {
	?>
	<tr class="liste_total <?php echo (empty($noMoreLinkedObjectBlockAfter) ? 'liste_sub_total' : ''); ?>">
		<td><?php echo $langs->trans("Total"); ?></td>
		<td></td>
		<td class="center"></td>
		<td class="center"></td>
		<td class="right"><?php echo price($total); ?></td>
		<td class="right"></td>
		<td class="right"></td>
	</tr>
	<?php
}

print "<!-- END PHP TEMPLATE -->\n";
