<?php 

defined('_JEXEC') or die;
$opaHero = $helper->get('mask', '0');
$count = $helper->getRows('image-decor');
$modId = $module->id;
?>

<div id="acm-hero-wrap-<?php echo $modId; ?>" class="acm-hero style-3" >
  <div id="acm-hero-<?php echo $module->id; ?>" class="acm-hero-item" style="background-image: url('<?php echo $helper->get('image-decor') ?>');">
    <div class="hero-content">
      <div class="hero-content-inner element-light">
      
        <?php if($helper->get('title')): ?>
          <h3 class="hero-title h1">
            <?php echo $helper->get('title') ?>
          </h3>
        <?php endif; ?>

        <?php if($helper->get('sub-title')): ?>
          <div class="sub-title">
            <span><?php echo $helper->get('sub-title') ?></span>    
          </div>
        <?php endif; ?>

        <?php if($helper->get('desc')): ?>
          <div class="description h4"><?php echo $helper->get('desc') ?></div>
        <?php endif; ?>

        <?php if($helper->get('button')): ?>
          <div class="acm-action">
            <?php if($helper->get('button')): ?>
              <a href="<?php echo $helper->get('btn-link'); ?>" class="btn btn-<?php echo $helper->get('btn-type') ;?>">
                <?php echo $helper->get('button') ?>    
              </a>
            <?php endif; ?>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
