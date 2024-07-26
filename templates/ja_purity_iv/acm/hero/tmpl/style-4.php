<?php 

defined('_JEXEC') or die;
  
$count = $helper->getRows('hero-heading');
$modId = $module->id;
?>

<div id="acm-hero-wrap-<?php echo $modId; ?>" class="ja-acm acm-hero style-4" >
  <div class="container">
    <?php for ($i=0; $i<$count; $i++) : ?>
    <div class="row g-0 <?php echo $helper->get('hero-media-alignment', $i)?'flex-row-reverse':'';?>">
      <div class="col-12 col-lg-8 position-relative">
        <div class="hero-media">
          <img src="<?php echo $helper->get('hero-media', $i) ?>" alt="" />
        </div>
      </div>

      <div class="col-12 col-lg-4 d-flex align-items-center">
        <div class="hero-content">
          <h2 class="hero-heading mt-0 mb-4"><?php echo $helper->get('hero-heading',$i);?></h2>
          <p class="lead mt-0"><?php echo $helper->get('hero-desc',$i);?></p>

          <?php if($helper->get('hero-btn-link', $i)) : ?>
          <div class="hero-actions mt-2 mt-lg-5">
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
</div>