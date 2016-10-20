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
  if ($node) {
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
    $addLoadingPerm = user_access('add loading custom');
    $editProjectPerm = user_access('edit project custom');
    $addScenarioPerm = user_access('add scenario custom');
    //
    $techdata = json_decode($field_technology_data[0]['value'],TRUE);

    $loading_avg = explode("|",$techdata['args'][0]);
    $popeq = $techdata['args'][8];
    //echo "<pre>".print_r($popeq,1)."</pre>";


    $term_currency = taxonomy_term_load($field_currency[0]['tid']);
    $currency_code = $term_currency->field_currency_code[LANGUAGE_NONE][0]['value'];

    $view_loading = views_get_view('loading');
    $view_loading->set_display('view_loading_json');
    $view_scenario = views_get_view('scenario');
    $view_scenario->set_display('view_scenario_json');
  }

 ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML+RDFa 1.0//EN"
  "http://www.w3.org/MarkUp/DTD/xhtml-rdfa-1.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language; ?>" version="XHTML+RDFa 1.0" dir="<?php print $language->dir; ?>">
  <head>
    <?php print $head; ?>
    <base href='<?php print $url ?>' />
    <title><?php print $site_name ?> - <?php print $print_title; ?> (Printable Version)</title>
    <?php print $scripts; ?>
    <?php if (isset($sendtoprinter)) print $sendtoprinter; ?>
    <?php print $robots_meta; ?>
    <?php if (theme_get_setting('toggle_favicon')): ?>
      <link rel='shortcut icon' href='<?php print theme_get_setting('favicon') ?>' type='image/x-icon' />
    <?php endif; ?>
    <?php print $css; ?>
  </head>
  <body class="wamex-project-print node-type-project">
    <?php print $_GET['arg']; ?>
    <?php if (!empty($message)): ?>
      <div class="print-message"><?php print $message; ?></div><p />
    <?php endif; ?>
    <?php if ($print_logo): ?>
      <div class="print-logo"><?php print $print_logo; ?></div>
    <?php endif; ?>
    <div class="print-site_name"><?php print theme('print_published'); ?></div>
    <p />
    <div class="print-breadcrumb"><?php print theme('print_breadcrumb', array('node' => $node)); ?></div>
    <hr class="print-hr" />
    <?php if (!isset($node->type)): ?>
      <h2 class="print-title"><?php print $print_title; ?></h2>
    <?php endif; ?>
    <div class="print-content">
      <div id="print-pdf-container">
        <h2><?php  print $node->title; ?></h2>
        <div id="">
          <h4 class="print-title">Project Information</h4>
          <table class="table table-print">
          <tr class="row"><th class="col-xs-5">Author</th><td class="col-xs-7"><?php print $field_author[0]['value']; ?></td></tr>
          <tr class="row"><th class="col-xs-5">Location</th><td class="col-xs-7"><?php print $field_location[0]['value']; ?></td></tr>
          <tr class="row"><th class="col-xs-5">Population</th><td class="col-xs-7"><?php print $field_population[0]['value']; ?></td></tr>
          <tr class="row"><th class="col-xs-5">Description</th><td class="col-xs-7"><?php print $field_body[0]['value']; ?></td></tr>
          </table>
        </div>


        <div id=""><h4 class="print-title">Financial Information</h4>
          <table class="table">
            <tr><th class="col-xs-5">Currency</th><td><?php print (isset($field_currency[0]['taxonomy_term']->name) ? $field_currency[0]['taxonomy_term']->name : "-");; ?></td></tr>
            <tr><th class="col-xs-5">Exchange Rate</th><td><?php print $field_exchange_rate_to_usd[0]['value']; ?></td></tr>
            <tr><th class="col-xs-5">Discount Rate</th><td><?php print $field_discount_rate[0]['value']; ?></td></tr>
            <tr><th class="col-xs-5">Land Cost <span class="label-unit">(<?php print $currency_code." "?>per sq m)</span></th><td><?php print $field_land_cost[0]['value']; ?></td></tr>
          </table>
        </div>
        <div id="print-loading"><h4 class="print-title">Wastewater Characterisation</h4></div>
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
                  <th class="col-sm-2 col-xs-2">Name</th>
                  <th class="col-sm-2 col-xs-2">Type</th>
                  <th class="col-sm-1 col-xs-1">ADWF<br/>(mg/&#x2113;)</th>
                  <th class="col-sm-1 col-xs-1">COD<br/>(mg/&#x2113;)</th>
                  <th class="col-sm-1 col-xs-1">BOD5<br/>(mg/&#x2113;)</th>
                  <th class="col-sm-1 col-xs-1">TotN<br/>(mg/&#x2113;)</th>
                  <th class="col-sm-1 col-xs-1">TotP<br/>(mg/&#x2113;)</th>
                  <th class="col-sm-1 col-xs-1">TSS<br/>(mg/&#x2113;)</th>
                  <th class="col-sm-1 col-xs-1">%</th>
                </tr>
              </thead>
              <tbody>
              <?php foreach ($loading_ary['loadings'] as $row) : ?>
                <?php //array_map('htmlentities', $row); ?>
                <tr>
                  <td><?php echo implode('</td><td>', $row); ?></td>
                </tr>
              <?php endforeach; ?>
              </tbody>
            </table>
          <?php endif ?>
        </div>
        <div id=""><h4 class="print-title">Effuent Standards</h4></div>
        <div id=""><h4 class="print-title">Population Equivalent</h4>
        <div></div>
        </div>
        <div id="print-scenario"><h4 class="print-title">Scenario</h4></div>
        <div>
          <?php $view_scenario->set_arguments(array($nid)); $view_scenario->pre_execute(); $view_scenario->execute();
          $scenario_json = strip_tags($view_scenario->render());
          $scenario_utf8 = utf8_encode($scenario_json);
          $scenario_ary = json_decode($scenario_utf8, TRUE);
          //echo print_r($scenario_ary,TRUE);

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

          ?>
          <?php if (count($scenario_ary['scenarios']) > 0) :?>
            <table class="table table-print">
              <thead>
                <tr>
                  <th class="col-sm-4 col-xs-4">Name</th>
                  <th class="col-sm-1 col-xs-1">Land</th>
                  <th class="col-sm-1 col-xs-1">Chemical</th>
                  <th class="col-sm-1 col-xs-1">Energy</th>
                  <th class="nucol-sm-1 col-xs-1">O&amp;M</th>
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
        <div id=""><h4 class="print-title">Suitable Technologies</h4>
        <?php
          $techs_json = $field_technology_data[0]['value'];
          $techs_data = json_decode($techs_json,TRUE);
          $techs_table = $techs_data['table'];
          //echo print_r($techs_table);
          if (count($techs_table) > 0) :
        ?>
        <table id="print-techs" class="table table-print">
          <thead>
            <tr>
              <td id="tech-summary" colspan="12">
                <div><div class="tech-summary-header col-sm-3 col-xs-3"><b>Population</b></div><div class="tech-summary-value"><?php print number_format($field_population[0]['value']); ?></div></div>
                <div><span class="col-sm-3 col-xs-3"><b>Population Equivalent</b></span><span><?php print number_format($popeq,2); ?> (<?php print strtoupper($popeq_ary['param']); ?>)</span></div>
                <span class="col-sm-3 col-xs-3"><b>Average Loadings</b></span><span><?php print $techs_data['args'][0]; ?></span>
                <span class="col-sm-3 col-xs-3"><b>Effluent Standards</b></span><span><?php print $techs_data['args'][1]; ?></span>
                <span class="col-sm-3 col-xs-3"><b>Scenario</b></span><span><?php print $techs_data['args'][3]; ?></span>
              </td>
            </tr>
            <tr>
              <th>Tech ID</th>
              <th>Name</th>
              <th>Score</th>
              <th>CapEx<br/>(<?php echo $currency_code?>)</th>
              <th>CapEx Per Capita<br/>(<?php echo $currency_code?>)</th>
              <th>OpEx<br/>(<?php echo $currency_code?>/year)</th>
              <th>OpEx Per Capita<br/>(<?php echo $currency_code?>)</th>
              <th>Land Reqt<br/>(sq m)</th>
              <th>Land Cost<br/>(<?php echo $currency_code?>)</th>
              <th>Land Cost Per Capita<br/>(<?php echo $currency_code?>)</th>
              <th>Total Investment<br/>(<?php echo $currency_code?>)</th>
              <th>Total Investment Per Capita<br/>(<?php echo $currency_code?>)</th>
              <th>COD<br/>(mg/&#x2113;)</th>
              <th>BOD5<br/>(mg/&#x2113;)</th>
              <th>TotN<br/>(mg/&#x2113;)</th>
              <th>TotP<br/>(mg/&#x2113;)</th>
              <th>TSS<br/>(mg/&#x2113;)</th>
            </tr>
          </thead>
        <?php foreach ($techs_table as $tech) :?>
          <tbody class="tbody-tech">
          <?php //echo print_r($tech)."<br/>"; ?>
            <tr>
              <td><?php echo implode('</td><td>', $tech); ?></td>
            </tr>
          </tbody>
        <?php endforeach; ?>
        </table>
        <?php endif; ?>
        </div>
        <div id=""><h4 class="print-title">Collection and Conveyance</h4></div>

      </div>
    <?php "js:".print drupal_get_js('settings'); ?>
    <?php print $field_technology_data[0]['value']; ?>
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
    <?php print $footer_scripts; ?>
  </body>
</html>