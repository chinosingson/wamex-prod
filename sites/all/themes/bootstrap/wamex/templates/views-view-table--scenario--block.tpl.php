<?php
/**
 * @file
 * Template to display a view as a table.
 *
 * - $title : The title of this group of rows.  May be empty.
 * - $header: An array of header labels keyed by field id.
 * - $caption: The caption for this table. May be empty.
 * - $header_classes: An array of header classes keyed by field id.
 * - $fields: An array of CSS IDs to use for each field id.
 * - $classes: A class or classes to apply to the table, based on settings.
 * - $row_classes: An array of classes to apply to each row, indexed by row
 *   number. This matches the index in $rows.
 * - $rows: An array of row items. Each row is an array of content.
 *   $rows are keyed by row number, fields within rows are keyed by field ID.
 * - $field_classes: An array of classes to apply to each field, indexed by
 *   field id, then row number. This matches the index in $rows.
 * @ingroup views_templates
 */
 $editProjectPerm = user_access('edit project custom');
 $scenario_value_display = array(
	"","N/A", "V. Low", "Low", "High", "V. High"
 );
?><table <?php if ($classes) { print 'class="'. $classes . '" '; } ?><?php print $attributes; ?> id="view-project-scenarios">
   <?php if (!empty($title) || !empty($caption)) : ?>
     <caption><?php print $caption . $title; ?></caption>
  <?php endif; ?>
  <?php if (!empty($header)) : ?>
    <thead>
      <tr>
        <?php foreach ($header as $field => $label): $header_classes[$field].=" views-scenario-field-header" ?>
					<?php if ($field != "nid"):?>
          <th <?php if ($header_classes[$field]) { print 'class="'. $header_classes[$field] . '" '; } ?> scope="col">
            <?php print $label; ?>
          </th>
					<?php else: ?>
					<th>&nbsp;</th>
					<?php endif; ?>
        <?php endforeach; ?>
      </tr>
    </thead>
  <?php endif; ?>
  <tbody>
    <?php foreach ($rows as $row_count => $row): 
				$row_classes[$row_count][] = 'view-field-display';
	?><tr <?php if ($row_classes[$row_count]) { print 'class="' . implode(' ', $row_classes[$row_count]) .'"';  } ?> id="<?php print 'scenario-row-'.$row['nid']; ?>">
					<!--td><?php //echo print_r($row_classes,1); ?></td-->
        <?php foreach ($row as $field => $content): $field_classes[$field][$row_count] .= ' views-scenario-field-value' ?>
          <td <?php if ($field_classes[$field][$row_count]) { print 'class="'. $field_classes[$field][$row_count] . '" '; } ?><?php print drupal_attributes($field_attributes[$field][$row_count]); ?>>
						<?php //echo $field;?>
					<?php if ($field == 'title'): ?>
					<label class="scenario-title-label" id="scenario-title-label-<?php print $row['nid']?>" for="scenario-radio-<?php print $row['nid']; ?>"><?php print $content; ?></label>
					<?php elseif ($field != "nid"):?>
            <?php 
							if (is_numeric($content))
							print $scenario_value_display[$content]."<span class='scenario-field-value-hidden' id='".$field."_hidden_".$row['nid']."'>".$content."</span>";
							else
							print $content; 
						?>
          </td>
					<?php else: ?>
					<input class="scenario-radio" name="scenario_nid" id="scenario-radio-<?php print $content; ?>" type="radio" value="<?php print $content; ?>"  <?php print ($row_count==0 ? 'checked="checked"': "" ) ?>/>
					<?php endif; ?>
					</td>
        <?php endforeach; ?>
				<?php if ($editProjectPerm && arg(0)!="printpdf"): ?>
					<td class="views-field views-field-nothing views-scenario-field-value"><a class="btn btn-default btn-xs project-edit-scenario-btn" id="edit-scenario-<?php print $row['nid']; ?>"><span class="glyphicon glyphicon-pencil"></span>&nbsp;Edit</a></td>
					<td class="views-field views-field-nothing views-scenario-field-value"><a class="btn btn-danger btn-xs project-delete-scenario-btn" id="delete-scenario-<?php print $row['nid']; ?>"><span class="glyphicon glyphicon-trash"></span>&nbsp;Delete</a></td>
				<?php endif; ?>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>