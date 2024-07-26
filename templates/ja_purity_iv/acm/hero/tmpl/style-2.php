<?php 

defined('_JEXEC') or die;
  
$count = $helper->getRows('hero-heading');
$modId = $module->id;
?>

<div id="acm-hero-wrap-<?php echo $modId; ?>" class="ja-acm acm-hero style-2" >
  <?php for ($i=0; $i<$count; $i++) : ?>
  <div class="row g-0 <?php echo $helper->get('hero-media-alignment', $i)?'flex-row-reverse':'';?>">
    <div class="col-12 col-lg-6">
      <div class="hero-media-wrap">
        <div class="hero-media" style="background-image: url(<?php echo $helper->get('hero-media', $i) ?>);"></div>
      </div>
    </div>

    <div class="col-12 col-lg-6">
      <div class="hero-content text-center mx-auto">
        <h2 class="hero-heading mt-0 mb-4"><?php echo $helper->get('hero-heading',$i);?></h2>
        <p class="lead mt-0"><?php echo $helper->get('hero-desc',$i);?></p>

        <?php if($helper->get('hero-btn-link', $i)) : ?>
        <div class="hero-actions">
          <a href="<?php echo $helper->get('hero-btn-link',$i);?>" title="<?php echo $helper->get('hero-btn',$i);?>" class="btn btn-<?php echo $helper->get('hero-btn-type', $i); ?>">
            <?php echo $helper->get('hero-btn',$i);?>  
          </a>
        </div>
        <?php endif ?>

      </div>
    </div>  
  </div>
  <?php endfor;?>
</div>