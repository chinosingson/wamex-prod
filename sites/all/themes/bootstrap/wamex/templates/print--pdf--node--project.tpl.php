<?php

/**
 * @file
 * Default theme implementation to display a printer-friendly version page.
 *
 * This file is akin to Drupal's page.tpl.php template. The contents being
 * displayed are all included in the $content variable, while the rest of the
 * template focuses on positioning and theming the other page elements.
 *
 * All the variables available in the page.tpl.php template should also be
 * available in this template. In addition to those, the following variables
 * defined by the print module(s) are available:
 *
 * Arguments to the theme call:
 * - $node: The node object. For node content, this is a normal node object.
 *   For system-generated pages, this contains usually only the title, path
 *   and content elements.
 * - $format: The output format being used ('html' for the Web version, 'mail'
 *   for the send by email, 'pdf' for the PDF version, etc.).
 * - $expand_css: TRUE if the CSS used in the file should be provided as text
 *   instead of a list of @include directives.
 * - $message: The message included in the send by email version with the
 *   text provided by the sender of the email.
 *
 * Variables created in the preprocess stage:
 * - $print_logo: the image tag with the configured logo image.
 * - $content: the rendered HTML of the node content.
 * - $scripts: the HTML used to include the JavaScript files in the page head.
 * - $footer_scripts: the HTML  to include the JavaScript files in the page
 *   footer.
 * - $sourceurl_enabled: TRUE if the source URL infromation should be
 *   displayed.
 * - $url: absolute URL of the original source page.
 * - $source_url: absolute URL of the original source page, either as an alias
 *   or as a system path, as configured by the user.
 * - $cid: comment ID of the node being displayed.
 * - $print_title: the title of the page.
 * - $head: HTML contents of the head tag, provided by drupal_get_html_head().
 * - $robots_meta: meta tag with the configured robots directives.
 * - $css: the syle tags contaning the list of include directives or the full
 *   text of the files for inline CSS use.
 * - $sendtoprinter: depending on configuration, this is the script tag
 *   including the JavaScript to send the page to the printer and to close the
 *   window afterwards.
 *
 * print[--format][--node--content-type[--nodeid]].tpl.php
 *
 * The following suggestions can be used:
 * 1. print--format--node--content-type--nodeid.tpl.php
 * 2. print--format--node--content-type.tpl.php
 * 3. print--format.tpl.php
 * 4. print--node--content-type--nodeid.tpl.php
 * 5. print--node--content-type.tpl.php
 * 6. print.tpl.php
 *
 * Where format is the ouput format being used, content-type is the node's
 * content type and nodeid is the node's identifier (nid).
 *
 * @see print_preprocess_print()
 * @see theme_print_published
 * @see theme_print_breadcrumb
 * @see theme_print_footer
 * @see theme_print_sourceurl
 * @see theme_print_url_list
 * @see page.tpl.php
 * @ingroup print
 */

 	$nid = $node->nid;
	$field_body = field_get_items('node',$node,'body');
	$field_author = field_get_items('node',$node,'field_author');
	$field_location = field_get_items('node',$node,'field_location');
	$field_population = field_get_items('node',$node,'field_population');
	$field_ci_cost = field_get_items('node',$node,'field_ci_cost');
	$field_discount_rate = field_get_items('node',$node,'field_discount_rate');
	//$field_om_pct_treatment = field_get_items('node',$node,'field_om_pct_treatment');
	//$field_design_horizon_treatment = field_get_items('node',$node,'field_design_horizon_treatment');
	$field_currency = field_get_items('node',$node,'field_currency');
	$field_exchange_rate_to_usd = field_get_items('node',$node,'field_exchange_rate_to_usd');
	$field_effluent_standard = field_get_items('node',$node,'field_effluent_standard');
	$field_effluent_cod = field_get_items('node',$node,'field_loading_cod');
	$field_effluent_bod5 = field_get_items('node',$node,'field_loading_bod5');
	$field_effluent_totn = field_get_items('node',$node,'field_loading_totn');
	$field_effluent_totp = field_get_items('node',$node,'field_loading_totp');
	$field_effluent_tss = field_get_items('node',$node,'field_loading_tss');
	$field_land_cost = field_get_items('node',$node,'field_land_cost');
  $field_land_area = field_get_items('node',$node,'field_land_area');
  $field_population_density = field_get_items('node',$node,'field_population_density');
  $field_sewerage_type = field_get_items('node',$node,'field_sewerage_type');
  $field_pipe_length = field_get_items('node',$node,'field_pipe_length');
  $field_technology_data = field_get_items('node', $node, 'field_technology_data');

  $field_loading_cod = field_get_items('node', $node, 'field_loading_cod');
  $field_loading_bod5 = field_get_items('node', $node, 'field_loading_bod5');
  $field_loading_totn = field_get_items('node', $node, 'field_loading_totn');
  $field_loading_totp = field_get_items('node', $node, 'field_loading_totp');
  $field_loading_tss = field_get_items('node', $node, 'field_loading_tss');

  $addLoadingPerm = user_access('add loading custom');
	$editProjectPerm = user_access('edit project custom');
	$addScenarioPerm = user_access('add scenario custom');
	//

	$term_currency = taxonomy_term_load($field_currency[0]['tid']);
	$currency_code = $term_currency->field_currency_code[LANGUAGE_NONE][0]['value'];

  $view_loading = views_get_view('loading');
  $view_loading->set_display('view_loading_json');

  $view_scenario = views_get_view('scenario');
  $view_scenario->set_display('view_scenario_json');

  $techdata = json_decode($field_technology_data[0]['value'],TRUE);

  $loading_avg = explode("|",$techdata['args'][0]);
  $popeq = $techdata['args'][2];
  $popeq_data = $techdata['args'][8];
  if (count($popeq_data)>0):
  $popeq_ary = json_decode(strip_tags($popeq_data),TRUE);
  //echo print_r($popeq_ary['param'],1);
  $retic = $techdata['args'][9];

  function scenarioLevel($level){
    $levelText = array(
      1=>"N/A",
      2=>"V. Low",
      3=>"Low",
      4=>"High",
      5=>"V. High"
    );
    if (is_numeric($level)) return $levelText[$level];
    else return $level;
  }

  function effStdDisp($value){
    if (!is_numeric($value) || (is_numeric($value) && $value >= 0)) return $value;
    else return "N/A";
  }

 ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML+RDFa 1.0//EN"
  "http://www.w3.org/MarkUp/DTD/xhtml-rdfa-1.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language; ?>" version="XHTML+RDFa 1.0" dir="<?php print $language->dir; ?>">
  <head>
    <?php print $head; ?>
    <base href='<?php print $url ?>' />
    <title><?php print $site_name ?> - <?php print $print_title; ?></title>
    <?php print $scripts; ?>
    <?php if (isset($sendtoprinter)) print $sendtoprinter; ?>
    <?php print $robots_meta; ?>
    <?php if (theme_get_setting('toggle_favicon')): ?>
      <link rel='shortcut icon' href='<?php print theme_get_setting('favicon') ?>' type='image/x-icon' />
    <?php endif; ?>
    <?php print $css; ?>
  </head>
  <body classes="print print-page print-node-project print-node-<?php print $nid ?> <?php print $classes ?> wamex print-pdf">
		<?php if (!empty($site_name)): ?>
		<div class="print-site_name"><h3 style="position: absolute; float: right"><?php if ($print_logo): ?><span class="print-logo"><?php print $print_logo; ?></span><?php endif; ?><?php print $site_name; ?></h3></div>
		<?php endif; ?>
		<div id="pdf-body-container" style="margin:2.5em">
    <div class="print-content">
      <div id="print-pdf-container">
        <h3 class="print-title">Project: <?php  print $node->title; ?></h3>
        <hr class="print-hr" />
        <div id="print-project-info" class="print-container">
          <h4 class="print-title">Project Information</h4>
          <table class="table">
            <tr><th>Location</th><td class="col-xs-9"><?php print $field_location[0]['value']; ?></td></tr>
            <tr><th>Population</th><td class="col-xs-9"><?php print number_format($field_population[0]['value']); ?></td></tr>
            <tr><th>Description</th><td class="col-xs-9"><?php print $field_body[0]['value']; ?></td></tr>
            <tr><th>Author</th><td class="col-xs-9"><?php print $field_author[0]['value']; ?></td></tr>
          </table>
        </div>
        <hr class="print-hr" />
        <div id="print-financial-info" class="print-container">
          <h4 class="print-title">Financial Information</h4>
          <table class="table">
            <tr><th>Currency</th><td class="col-xs-9"><?php print (isset($field_currency[0]['taxonomy_term']->name) ? $field_currency[0]['taxonomy_term']->name : "-");; ?></td></tr>
            <tr><th>Exchange Rate <span class="label-unit">(<?php print $currency_code?>)</span></th><td class="col-xs-9"><?php print $field_exchange_rate_to_usd[0]['value']; ?></td></tr>
            <!--tr><th>Discount Rate</th><td class="col-xs-9"><?php //print $field_discount_rate[0]['value']; ?></td></tr-->
            <tr><th>Land Cost <span class="label-unit">(<?php print $currency_code." "?>per sq m)</span></th><td class="col-xs-9"><?php print $field_land_cost[0]['value']; ?></td></tr>
          </table>
        </div>

        <hr class="print-hr" />
        <div id="print-technologies">
          <h4 class="print-title">Suitable Technologies</h4>
        <?php
          $techs_json = $field_technology_data[0]['value'];
          $techs_data = json_decode($techs_json,TRUE);
          $techs_table = $techs_data['table'];
          function techFinancialsOnly ($techdata) {
            //$techFinancials[] = $techdata['name'];
            $techFinancials[] = str_replace(" ","<br/>",$techdata['capex']);
            $techFinancials[] = str_replace(" ","<br/>",$techdata['capexPC']);
            $techFinancials[] = str_replace(" ","<br/>",$techdata['opex']);
            $techFinancials[] = str_replace(" ","<br/>",$techdata['opexPC']);
            $techFinancials[] = $techdata['landReqt'];
            $techFinancials[] = str_replace(" ","<br/>",$techdata['landCost']);
            $techFinancials[] = str_replace(" ","<br/>",$techdata['landCostPC']);
            $techFinancials[] = str_replace(" ","<br/>",$techdata['totInv']);
            $techFinancials[] = str_replace(" ","<br/>",$techdata['totInvPC']);
            $techFinancials[] = number_format($techdata['score'],2);

            return $techFinancials;
          }

          if (count($techs_table) > 0) :

            $avg_loadings = explode("|",$techs_data['args'][0]);
            $str_efflstds = explode("|",$techs_data['args'][1]);

            foreach ($str_efflstds as $stdval){
              $eff_standard[] = effStdDisp($stdval);
            }

            $loadings = "<i>ADWF</i>: ".$avg_loadings[0]." &#x2113;/p/d; ";
            $standards = $eff_standard[0]."; ";
            //
            switch($popeq_ary['param']){
              case 'cod':
                $loadings .= "<i>COD</i>: ".$avg_loadings[1];
                $standards .= "<i>COD</i>: ".$eff_standard[1];
                $param_disp = "COD";
                break;
              case 'bod5':
                $loadings .= "<i>BOD5</i>: ".$avg_loadings[2];
                $standards .= "<i>BOD5</i>: ".$eff_standard[2];
                $param_disp = "BOD5";
                break;
              case 'totn':
                $loadings .= "<i>TotN</i>: ".$avg_loadings[3];
                $standards .= "<i>TotN</i>: ".$eff_standard[3];
                $param_disp = "TotN";
                break;
              case 'totp':
                $loadings .= "<i>TotP</i>: ".$avg_loadings[4];
                $standards .= "<i>TotP</i>: ".$eff_standard[4];
                $param_disp = "TotP";
                break;
              case 'tss':
                $loadings .= "<i>TSS</i>: ".$avg_loadings[5];
                $standards .= "<i>TSS</i>: ".$eff_standard[5];
                $param_disp = "TSS";
                break;
            }

            $loadings.= " mg/&#x2113;";
            $standards.= " mg/&#x2113;";
            $param_disp = "<i>".$param_disp."</i>: ";

            //."; <i>COD</i>: ".$eff_standard[1]."; <i>BOD5</i>: ".$eff_standard[2].";  <i>TotN</i>: ".$eff_standard[3].";  <i>TotP</i>: ".$eff_standard[4].";  <i>TSS</i>: ".$eff_standard[5];

            $scenario_ary = explode("|",$techs_data['args'][3]);

            foreach($scenario_ary as $sc_param) {
              $scenario_lvl[] = scenarioLevel($sc_param);
            }


            $scenario = $scenario_ary[0]."; "
              ."<i>Land: </i> ".$scenario_lvl[1]."; "
              ."<i>Chem: </i> ".$scenario_lvl[2]."; "
              ."<i>Energy: </i> ".$scenario_lvl[3]."; "
              ."<i>O&amp;M: </i> ".$scenario_lvl[4]."; "
              ."<i>Shock: </i> ".$scenario_lvl[5]."; "
              ."<i>Flow: </i> ".$scenario_lvl[6]."; "
              ."<i>Toxic: </i> ".$scenario_lvl[7]."; "
              ."<i>Sludge: </i> ".$scenario_lvl[8];

            //print "<pre>".print_r($scenario_lvl,1)."</pre>";
        ?>
        <!--Displaying <?php //print count($techs_table)?> Technology options.<br/-->
        <table id="print-techs" class="table table-print">
          <thead>
            <tr>
              <td id="tech-summary" colspan="12">
                <h5 class="print-title">Sorted by Scenario Score</h5>
                Most effective first<br/>
                <div><span class="tech-summary-header">Population:</span> <span class="tech-summary-value"><?php print number_format($field_population[0]['value']); ?></span></div>
                <div><span class="tech-summary-header">Population Equivalent:</span> <span class="tech-summary-value"><?php print $param_disp.number_format($popeq,2); ?></span></div>
                <div><span class="tech-summary-header">Average Loadings:</span> <span class="tech-summary-value"><?php print $loadings; ?></span></div>
                <div><span class="tech-summary-header">Effluent Standard:</span> <span class="tech-summary-value"><?php print $standards; ?></span></div>
                <div><span class="tech-summary-header">Scenario:</span> <span class="tech-summary-value"><?php print $scenario; ?></span></div>
              </td>
            </tr>
            <tr>
              <!--th>Tech ID</th-->

              <th rowspan="2" colspan="2" class="col-sm-4 col-xs-4">Technology Name</th>
              <th colspan="2">CapEx<br/><span class="label-unit">(<?php echo $currency_code?>)</span></th>
              <th colspan="2">OpEx<br/><span class="label-unit">(<?php echo $currency_code?>/year)</span></th>
              <th rowspan="2">Land Reqt<br/><span class="label-unit">(m<sup>2</sup>)</span></th>
              <th colspan="2">Land Cost<br/><span class="label-unit">(<?php echo $currency_code?>)</span></th>
              <th colspan="2">Total Investment<br/><span class="label-unit">(<?php echo $currency_code?>)</span></th>
              <th rowspan="2">Score</th>
              <!--th>COD<br/>(mg/&#x2113;)</th>
              <th>BOD5<br/>(mg/&#x2113;)</th>
              <th>TotN<br/>(mg/&#x2113;)</th>
              <th>TotP<br/>(mg/&#x2113;)</th>
              <th>TSS<br/>(mg/&#x2113;)</th-->
            </tr>
            <tr>
              <th>Total</th>
              <th>Per cap</th>
              <th>Total</th>
              <th>Per cap</th>
              <th>Total</th>
              <th>Per cap</th>
              <th>Total</th>
              <th>Per cap</th>
            </tr>
          </thead>
          <tbody class="tbody-tech">
        <?php $count = 1;
          foreach ($techs_table as $tech) :?>
            <tr class="tech-row">
              <td><?php print $count; ?></td>
              <td class="tech-name"><?php print $tech['name'] ?></td>
              <td><?php echo implode('</td><td>', techFinancialsOnly($tech)); ?></td>
            </tr>
        <?php  $count++; endforeach; ?>
          </tbody>
        </table>


        <table id="print-techs" class="table table-print">
          <thead>
            <tr>
              <td id="tech-summary" colspan="12">
                <h5 class="print-title">Sorted by Total Investment</h5>
                Least expensive first<br/>
                <div><span class="tech-summary-header">Population:</span> <span class="tech-summary-value"><?php print number_format($field_population[0]['value']); ?></span></div>
                <div><span class="tech-summary-header">Population Equivalent:</span> <span class="tech-summary-value"><?php print $param_disp.number_format($popeq,2); ?></span></div>
                <div><span class="tech-summary-header">Average Loadings:</span> <span class="tech-summary-value"><?php print $loadings; ?></span></div>
                <div><span class="tech-summary-header">Effluent Standard:</span> <span class="tech-summary-value"><?php print $standards; ?></span></div>
                <div><span class="tech-summary-header">Scenario:</span> <span class="tech-summary-value"><?php print $scenario; ?></span></div>
              </td>
            </tr>
            <tr>
              <!--th>Tech ID</th-->

              <th rowspan="2" colspan="2" class="col-sm-4 col-xs-4">Technology Name</th>
              <th colspan="2">CapEx<br/><span class="label-unit">(<?php echo $currency_code?>)</span></th>
              <th colspan="2">OpEx<br/><span class="label-unit">(<?php echo $currency_code?>/year)</span></th>
              <th rowspan="2">Land Reqt<br/><span class="label-unit">(m<sup>2</sup>)</span></th>
              <th colspan="2">Land Cost<br/><span class="label-unit">(<?php echo $currency_code?>)</span></th>
              <th colspan="2">Total Investment<br/><span class="label-unit">(<?php echo $currency_code?>)</span></th>
              <th rowspan="2">Score</th>
              <!--th>COD<br/>(mg/&#x2113;)</th>
              <th>BOD5<br/>(mg/&#x2113;)</th>
              <th>TotN<br/>(mg/&#x2113;)</th>
              <th>TotP<br/>(mg/&#x2113;)</th>
              <th>TSS<br/>(mg/&#x2113;)</th-->
            </tr>
            <tr>
              <th>Total</th>
              <th>Per cap</th>
              <th>Total</th>
              <th>Per cap</th>
              <th>Total</th>
              <th>Per cap</th>
              <th>Total</th>
              <th>Per cap</th>
            </tr>
          </thead>
          <tbody class="tbody-tech">
        <?php $count = 1;

        //sort technologies by score : $techs[$key]['score']
        usort ($techs_table, function($a, $b){
          $a_totInv_ary = explode(" ",str_replace(",","",$a['totInv']));
          $b_totInv_ary = explode(" ",str_replace(",","",$b['totInv']));
          return $b_totInv_ary[2] < $a_totInv_ary[2] ? 1 : -1;
        });
        foreach ($techs_table as $tech) :?>
            <tr class="tech-row">
              <td><?php print $count; ?></td>
              <td class="tech-name"><?php print $tech['name'] ?></td>
              <td><?php echo implode('</td><td>', techFinancialsOnly($tech)); ?></td>
            </tr>
        <?php  $count++; endforeach; ?>
          </tbody>
        </table>
        <?php endif; ?>
        </div>
        </div>

        <hr class="print-hr" />
        <div id="print-loading" class="print-container">
          <h4 class="print-title">Wastewater Characterisation</h4>
          <?php //$view_loading->set_arguments(array($nid)); $view_loading->pre_execute(); $view_loading->execute(); print $view_loading->render(); ?>
        <div>
          <?php
            $view_loading->set_arguments(array($node->nid)); $view_loading->pre_execute(); $view_loading->execute();
            $loading_json = strip_tags($view_loading->render());
            //$loading_json = strip_tags($loading_json);
            $loading_utf8 = utf8_encode($loading_json);
            //echo $loading_utf8;
            //echo print_r($loading_ary,TRUE);
            $loading_ary = json_decode($loading_utf8,TRUE); ?>
          <?php if (count($loading_ary['loadings']) > 0): ?>
            <table class="table table-print">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Type</th>
                  <th>ADWF<br/><span class="label-unit">(&#x2113;/p/d)</span></th>
                  <th>COD<br/><span class="label-unit">(mg/&#x2113;)</span></th>
                  <th>BOD5<br/><span class="label-unit">(mg/&#x2113;)</span></th>
                  <th>TotN<br/><span class="label-unit">(mg/&#x2113;)</span></th>
                  <th>TotP<br/><span class="label-unit">(mg/&#x2113;)</span></th>
                  <th>TSS<br/><span class="label-unit">(mg/&#x2113;)</span></th>
                  <th>%</th>
                </tr>
              </thead>
              <tbody>
              <?php foreach ($loading_ary['loadings'] as $row) : ?>
                <tr>
                  <td><?php echo implode('</td><td>', $row); ?></td>
                </tr>
              <?php endforeach; ?>
                <tr>
                  <td></td>
                  <th>Average Loadings</th>
                  <td><?php echo implode('</td><td>', $loading_avg); ?></td>
                  <td></td>
                </tr>
              </tbody>
            </table>
          <?php endif ?>
        </div>
        </div>

        <hr class="print-hr" />
        <div id="print-standards" class="print-container">
          <h4 class="print-title">Effuent Standards</h4>
          <table class="table table-print">
            <thead>
            <tr><th>Standard</th>
            <th>COD<br/><span class="label-unit">(mg/&#x2113;)</span></th>
            <th>BOD5<br/><span class="label-unit">(mg/&#x2113;)</span></th>
            <th>TotN<br/><span class="label-unit">(mg/&#x2113;)</span></th>
            <th>TotP<br/><span class="label-unit">(mg/&#x2113;)</span></th>
            <th>TSS<br/><span class="label-unit">(mg/&#x2113;)</span></th></tr>
            </thead>
            <tbody>
            <tr><td><?php print $field_effluent_standard[0]['taxonomy_term']->name;?></td>
              <td><?php print $field_loading_cod[0]['value'];?></td>
              <td><?php print $field_loading_bod5[0]['value'];?></td>
              <td><?php print $field_loading_totn[0]['value'];?></td>
              <td><?php print $field_loading_totp[0]['value'];?></td>
              <td><?php print $field_loading_tss[0]['value'];?></td>
            </tr>
            </tbody>
          </table>
        </div>
        <hr class="print-hr" />

        <div id="print-popeq" class="print-container">
          <h4 class="print-title">Population Equivalent</h4>
          <table class="table table-print" border="1">
              <tr>
                <th class="col-sm-5 col-xs-5"></th>
                <th>COD<br/><span class="label-unit">(mg/&#x2113;)</span></th>
                <th>BOD5<br/><span class="label-unit">(mg/&#x2113;)</span></th>
                <th>TotN<br/><span class="label-unit">(mg/&#x2113;)</span></th>
                <th>TotP<br/><span class="label-unit">(mg/&#x2113;)</span></th>
                <th>TSS<br/><span class="label-unit">(mg/&#x2113;)</span></th>
                <th>Vol/C<br/><span class="label-unit">(mg/&#x2113;)</span></th>
              </tr>
            <tbody>
              <tr>
                <th>Person Load Equivalent <span class="label-unit">(POL, gm/capita/day)</span></th>
                <td><?php print $popeq_ary['pol_cod']; ?></td>
                <td><?php print $popeq_ary['pol_bod5']; ?></td>
                <td><?php print $popeq_ary['pol_totn']; ?></td>
                <td><?php print $popeq_ary['pol_totp']; ?></td>
                <td><?php print $popeq_ary['pol_tss']; ?></td>
                <td><?php print $popeq_ary['pol_volc']; ?></td>
              </tr>
              <tr>
                <th>Population Equivalent <span class="label-unit">(PE, persons/day)</span></th>
                <td><?php print number_format($popeq_ary['pe_cod'],4); ?></td>
                <td><?php print number_format($popeq_ary['pe_bod5'],4); ?></td>
                <td><?php print number_format($popeq_ary['pe_totn'],4); ?></td>
                <td><?php print number_format($popeq_ary['pe_totp'],4); ?></td>
                <td><?php print number_format($popeq_ary['pe_tss'],4); ?></td>
                <td><?php print number_format($popeq_ary['pe_volc'],4); ?></td>
              </tr>
              <tr>
                <th>Total Population Equivalent <span class="label-unit"></span></th>
                <td><?php print number_format($popeq_ary['totpe_cod'],2); ?></td>
                <td><?php print number_format($popeq_ary['totpe_bod5'],2); ?></td>
                <td><?php print number_format($popeq_ary['totpe_totn'],2); ?></td>
                <td><?php print number_format($popeq_ary['totpe_totp'],2); ?></td>
                <td><?php print number_format($popeq_ary['totpe_tss'],2); ?></td>
                <td><?php print number_format($popeq_ary['totpe_volc'],2); ?></td>
              </tr>
              <tr>
                <th>Total Effluent Flow <span class="label-unit">(m<sup>3</sup>/day)</span></th>
                <td><?php print number_format($popeq_ary['tot_flow'],2); ?></td>
                <td colspan="5"></td>
              </tr>
            </tbody>
          </table>
          <?php endif; ?>
        </div>
        <hr class="print-hr" />

        <div id="print-scenario" class="print-container">
          <h4 class="print-title">Scenarios</h4>
        <div>
          <?php $view_scenario->set_arguments(array($nid)); $view_scenario->pre_execute(); $view_scenario->execute();
          $scenario_json = strip_tags($view_scenario->render());
          $scenario_utf8 = utf8_encode($scenario_json);
          $scenario_ary = json_decode($scenario_utf8, TRUE);
          //echo print_r($scenario_ary,TRUE);

          ?>
          <?php if (count($scenario_ary['scenarios']) > 0) :?>
            <table class="table table-print">
              <thead>
                <tr>
                  <th class="col-sm-2 col-xs-2">Name</th>
                  <th class="col-sm-1 col-xs-1">Land</th>
                  <th class="col-sm-1 col-xs-1">Chemical</th>
                  <th class="col-sm-1 col-xs-1">Energy</th>
                  <th class="col-sm-1 col-xs-1">O&amp;M</th>
                  <th class="col-sm-1 col-xs-1">Shock</th>
                  <th class="col-sm-1 col-xs-1">Flow</th>
                  <th class="col-sm-1 col-xs-1">Toxic</th>
                  <th class="col-sm-1 col-xs-1">Sludge</th>
                </tr>
              </thead>
              <tbody>
          <?php foreach ($scenario_ary['scenarios'] as $row): ?>
            <?php $row2 = array_map('scenarioLevel', $row); ?>
              <tr>
                <td><?php echo implode('</td><td>', $row2); ?></td>
              </tr>
          <?php endforeach; ?>
              </tbody>
            </table>
          <?php endif; ?>
        </div>

        <hr class="print-hr" />
        <div id="print-reticulation" class="print-container">
          <h4 class="print-title">Collection and Conveyance</h4>
          <?php if (count($retic)>0):
            $retic_ary = json_decode($retic,1);
            //echo "<pre>".print_r($retic_ary,1)."</pre>";
          ?>
            <table class="table table-print">
              <tbody>
                <tr><th class="col-sm-5 col-xs-5">Type of Sewerage</th><td><?php print $retic_ary['type']; ?></td></tr>
                <tr><th>Cost of Sewerage <span class="label-unit">(<?php print $currency_code; ?>)</span></th><td><?php print $retic_ary['cost']; ?></td></tr>
                <tr><th>Cost of Sewerage per Capita <span class="label-unit">(<?php print $currency_code; ?>)</span></th><td><?php print $retic_ary['costPC']; ?></td></tr>
                <tr><th>Land Area  <span class="label-unit">(m<sup>2</sup>)</th><td><?php print $field_land_area[0]['value']; ?></td></tr>
                <tr><th>Pipe Length  <span class="label-unit">(m)</th><td><?php print $retic_ary['pipeLength']; ?></td></tr>
                <tr><th>Type of Terrain</th><td><?php print $retic_ary['terrainType']; ?></td></tr>
                <tr><th>Cost of Pumps <span class="label-unit">(<?php print $currency_code; ?>)</th><td><?php print $retic_ary['costPumps']; ?></td></tr>
                <tr><th>Cost of Pumps per Capita <span class="label-unit">(<?php print $currency_code; ?>)</th><td><?php print $retic_ary['costPumpsPC']; ?></td></tr>
              </tbody>
            </table>
          <?php endif; ?>
        </div>
      </div>
    <?php //print $content; ?>
    </div>
    <div class="print-footer"><?php print theme('print_footer'); ?></div>
    <hr class="print-hr" />
    <?php if ($sourceurl_enabled): ?>
      <div class="print-source_url">
        <?php print theme('print_sourceurl', array('url' => $source_url, 'node' => $node, 'cid' => $cid)); ?>
      </div>
    <?php endif; ?>
    <div class="print-links"><?php print theme('print_url_list'); ?></div>
    <?php //print $footer_scripts; ?>
    </div>
  </body>
</html>