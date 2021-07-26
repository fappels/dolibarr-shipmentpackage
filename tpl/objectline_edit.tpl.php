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
 * $seller, $buyer
 * $dateSelector
 * $forceall (0 by default, 1 for supplier invoices/orders)
 * $senderissupplier (0 by default, 1 for supplier invoices/orders)
 * $inputalsopricewithtax (0 by default, 1 to also show column with unit price including tax)
 */

// Protection to avoid direct call of template
if (empty($object) || !is_object($object)) {
	print "Error, template page can't be called as URL";
	exit;
}


global $forceall, $lineid;

if (empty($forceall)) $forceall = 0;


// Define colspan for the button 'Add'
$colspan = 3; // Columns: total ht + col edit + col delete

// Lines for extrafield
$line = new ExpeditionPackageLine($this->db);
$line->fetch($lineid);

print "<!-- BEGIN PHP TEMPLATE objectline_edit.tpl.php -->\n";

$coldisplay=0;
print '<tr class="oddeven tredited">';
// Adds a line numbering column
if (! empty($conf->global->MAIN_VIEW_LINE_NUMBER)) {
	print '<td class="linecolnum center">'.($i+1).'</td>';
	$coldisplay++;
}
?>
	<td>
	<div id="line_<?php echo $line->id; ?>"></div>

	<input type="hidden" name="lineid" value="<?php echo $line->id; ?>">
	</td>
<?php

$coldisplay++;
print '<td class="bordertop nobottom linecol">';
$statustoshow = 1;
if (!empty($conf->global->ENTREPOT_EXTRA_STATUS)) {
	// hide products in closed warehouse, but show products for internal transfer
	$form->select_produits($line->fk_product, 'fk_product', $filtertype, $conf->product->limit_size, 0, $statustoshow, 2, '', 1, array(), 0, '1', 0, 'maxwidth500', 0, 'warehouseopen,warehouseinternal');
} else {
	$form->select_produits($line->fkproduct, 'fk_product', $filtertype, $conf->product->limit_size, 0, $statustoshow, 2, '', 1, array(), 0, '1', 0, 'maxwidth500', 0, '');
}
if (!empty($conf->global->MAIN_AUTO_OPEN_SELECT2_ON_FOCUS_FOR_CUSTOMER_PRODUCTS)) {
	?>
<script>
	$(document).ready(function(){
		// On first focus on a select2 combo, auto open the menu (this allow to use the keyboard only)
		$(document).on('focus', '.select2-selection.select2-selection--single', function (e) {
			console.log('focus on a select2');
			if ($(this).attr('aria-labelledby') == 'select2-idprod-container')
			{
				console.log('open combo');
				$('#idprod').select2('open');
			}
		});
	});
</script>
	<?php
}
print '</td>';

$coldisplay++;
print '<td class="bordertop nobottom linecolqty"><input type="text" size="2" name="qty" id="qty" class="flat right" value="'.$line->qty.'">';
print '</td>';

if (!empty($conf->productbatch->enabled)) {
	$coldisplay++;
	if (empty($line->product_lot_batch)) {
		$value = $langs->trans('NA');
	} else {
		$value = $line->product_lot_batch;
	}
	print '<td class="bordertop nobottom linecolqty">' . $value;
	print '</td>';
}


$coldisplay+=$colspan;
print '<td class="nobottom linecoledit center valignmiddle" colspan="'.$colspan.'">';
$coldisplay+=$colspan;
print '<input type="submit" class="button" id="savelinebutton" name="save" value="'.$langs->trans("Save").'">';
print '<br>';
print '<input type="submit" class="button" id="cancellinebutton" name="cancel" value="'.$langs->trans("Cancel").'">';
print '</td>';
print '</tr>';


print "<!-- END PHP TEMPLATE objectline_edit.tpl.php -->\n";
