<?php
/**
 * ------------------------------------------------------------------------
 * ja_purity_iv_tpl
 * ------------------------------------------------------------------------
 * Copyright (C) 2004-2018 J.O.O.M Solutions Co., Ltd. All Rights Reserved.
 * @license - Copyrighted Commercial Software
 * Author: J.O.O.M Solutions Co., Ltd
 * Websites:  http://www.joomlart.com -  http://www.joomlancers.com
 * This file may not be redistributed in whole or significant part.
 * ------------------------------------------------------------------------
*/
  defined('_JEXEC') or die;
  $count = $helper->getRows('data-style-2.stats-count');
  $column = $helper->get('columns');
  $colItem = 'col-12 col-sm-6 col-lg-'.(12/$column);

  if($column == 4) {
    $colItem = 'col-12 col-sm-6 col-xl-'.(12/$column);
  } elseif ($column == 3) {
    $colItem = 'col-12 col-md-12 col-lg-'.(12/$column);
  }
?>

  
<div class="acm-stats style-1" >  
  <div class="stats-list">
    <?php for ($i=0; $i<$count; $i++) : ?>
    <?php if ($i%$column==0) :?>
      <div class="row v-gutters cols-<?php echo $column ;?>">
    <?php endif ;?>

    <div class="<?php echo $colItem; ?> stats-asset">
      <div class="stats-count h1 mt-0">      
    		<?php echo $helper->get ('data-style-2.stats-count', $i) ?>
  		</div>

      <div class="stats-title h6"> 
        <?php echo $helper->get ('data-style-2.stats-title', $i) ?>
      </div>

      <?php if ($helper->get ('data-style-2.stats-name', $i)) : ?>
        <span class="stats-subject"><?php echo $helper->get ('data-style-2.stats-name', $i) ?></span>
      <?php endif; ?>
    </div>
    <?php if ( ($i%$column==($column-1)) || $i==($count-1) )  echo '</div>'; ?>
  <?php endfor;?>
  </div>
</div>