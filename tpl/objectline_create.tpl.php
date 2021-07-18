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
 */

// Protection to avoid direct call of template
if (empty($object) || !is_object($object)) {
	print "Error: this template page cannot be called directly as an URL";
	exit;
}

global $forceall, $forcetoshowtitlelines;

if (empty($forceall)) $forceall = 0;


// Define colspan for the button 'Add'
$colspan = 3; // Columns: total ht + col edit + col delete
//print $object->element;

// Lines for extrafield
$objectline = new ExpeditionPackageLine($this->db);

print "<!-- BEGIN PHP TEMPLATE objectline_create.tpl.php -->\n";

$nolinesbefore = (count($this->lines) == 0 || $forcetoshowtitlelines);
if ($nolinesbefore) {
	print '<tr class="liste_titre nodrag nodrop">';
	if (!empty($conf->global->MAIN_VIEW_LINE_NUMBER)) {
		print '<td class="linecolnum center"></td>';
	}
	print '<td class="linecoldescription minwidth200imp">';
	print '<div id="add"></div><span class="hideonsmartphone">'.$langs->trans('AddNewLine').'</span>';
	// echo $langs->trans("FreeZone");
	print '</td>';
	print '<td class="linecol">'.$langs->trans('Product').'</td>';
	print '<td class="linecoldescription minwidth200imp">'.$langs->trans('Quantity').'</td>';
	print '<td class="linecoledit" colspan="'.$colspan.'">&nbsp;</td>';
	print '</tr>';
}
print '<tr class="pair nodrag nodrop nohoverpair'.($nolinesbefore || $object->element == 'contrat') ? '' : ' liste_titre_create">';
$coldisplay = 0;

// Adds a line numbering column
if (!empty($conf->global->MAIN_VIEW_LINE_NUMBER)) {
	$coldisplay++;
	echo '<td class="bordertop nobottom linecolnum center"></td>';
}

$coldisplay++;
print '<td class="bordertop nobottom linecoldescription minwidth200imp"></td>';

$coldisplay++;
print '<td class="bordertop nobottom linecol">';
$statustoshow = 1;
if (!empty($conf->global->ENTREPOT_EXTRA_STATUS)) {
	// hide products in closed warehouse, but show products for internal transfer
	$form->select_produits(GETPOST('fk_product'), 'fk_product', $filtertype, $conf->product->limit_size, 0, $statustoshow, 2, '', 1, array(), 0, '1', 0, 'maxwidth500', 0, 'warehouseopen,warehouseinternal');
} else {
	$form->select_produits(GETPOST('fk_product'), 'fk_product', $filtertype, $conf->product->limit_size, 0, $statustoshow, 2, '', 1, array(), 0, '1', 0, 'maxwidth500', 0, '');
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
print '<td class="bordertop nobottom linecolqty"><input type="text" size="2" name="qty" id="qty" class="flat right" value="'.(isset($_POST["qty"]) ?GETPOST("qty", 'alpha', 2) : 1).'">';
print '</td>';

$coldisplay += $colspan;
print '<td class="bordertop nobottom linecoledit center valignmiddle" colspan="'.$colspan.'">';
print '<input type="submit" class="button" value="'.$langs->trans('Add').'" name="addline" id="addline">';
print '</td>';
print '</tr>';


?>

<script>

/* JQuery stuff */
jQuery(document).ready(function() {
	
});

</script>

<!-- END PHP TEMPLATE objectline_create.tpl.php -->
