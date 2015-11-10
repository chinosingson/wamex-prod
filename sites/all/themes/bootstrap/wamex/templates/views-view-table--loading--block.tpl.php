﻿<?php 	$node = menu_get_object(); ?><div class="table-responsive"><table <?php if ($classes) { print 'class="'. $classes . '" '; } ?><?php print $attributes; ?> id="view-project-loadings">
   <?php if (!empty($title) || !empty($caption)) : ?>
     <caption><?php print $caption . $title; ?></caption>
  <?php endif; ?>
  <?php if (!empty($header)) : ?>
    <thead>
      <tr>
        <?php foreach ($header as $field => $label):
					$aryStrHeaderClasses = explode('-',$header_classes[$field]); 
					$headerName = end($aryStrHeaderClasses);
					?>
          <th <?php if ($header_classes[$field]) { print 'class="'. $header_classes[$field] . ' col-'.$headerName.'" '; } ?>>
            <?php 
							if ($label == 'ADWF') $unit = '(l/p/d)'; else $unit = '(mg/l)';
							if (in_array($label, array('Name', 'Type','%'))) $unit = '';
							if ($label == '') $label = ''; else $label = '<span class="label-name">'.$label.'</span><br/><span class="label-unit">'.$unit.'</span>';
							print $label; 
						?>
          </th>
        <?php endforeach; ?>
      </tr>
    </thead>
  <?php endif; ?>
  <tbody>
    <?php foreach ($rows as $row_count => $row): 
			$row_classes[] = 'view-field-display';
		?>
      <tr id="loading-<?php print $row['nid']; ?>" <?php if ($row_classes[$row_count]) { print 'class="' . implode(' ', $row_classes[$row_count]) .'"';  } ?>>
        <?php foreach ($row as $field => $content): 
					$aryStrFieldClasses = explode('-',$field_classes[$field][$row_count]);
					$colname = end($aryStrFieldClasses); 
					?>
          <td <?php if ($field_classes[$field][$row_count]) { print 'class="'. $field_classes[$field][$row_count] . ' col-'.$colname.'" '; } ?><?php print drupal_attributes($field_attributes[$field][$row_count]); ?>>
            <?php print $content; ?>
          </td>
        <?php endforeach; ?>
      </tr>
    <?php endforeach; ?>
  </tbody>
	<tfoot>
		<tr id="#average-loadings" class="active">
			<td>&nbsp;</td>
			<td>Average Loadings</td>
			<td class="average-loading" id="ave_adwf"></td>
			<td class="average-loading col-cod" id="ave_cod"></td>
			<td class="average-loading col-bod5" id="ave_bod5"></td>
			<td class="average-loading col-totn" id="ave_totn"></td>
			<td class="average-loading col-totp" id="ave_totp"></td>
			<td class="average-loading col-tss" id="ave_tss"></td>
			<td class="average-loading" id="tot_weight"></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
	</tfoot>
</table></div>