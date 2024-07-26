<?php 

defined('_JEXEC') or die;
$count = $helper->getRows('image-decor');
$heroMask = $helper->get('mask');
?>

<div id="acm-hero-wrap-<?php echo $module->id; ?>" class="ja-acm acm-hero style-1" >
  <div class="<?php if($count > 1) echo 'owl-carousel';?> owl-theme">
    <?php for ($i=0; $i<$count; $i++) : ?>
      <div id="acm-hero-<?php echo $module->id; ?>" class="acm-hero-item item-align-<?php echo $helper->get('hero-content-alignment', $i); ?> <?php echo $heroMask ;?><?php echo ($helper->get('image-decor', $i) !='')?' has-bg':'';?>" <?php if($helper->get('image-decor', $i) !=''): ?>style="background-image: url('<?php echo $helper->get('image-decor', $i) ?>');"<?php endif; ?>>

        <div class="item container">
          <div class="row align-items-center justify-content-<?php echo $helper->get('hero-content-alignment', $i); ?> text-<?php echo $helper->get('hero-content-alignment', $i); ?>">
            <div class="col-lg-9 col-xxl-<?php echo ($helper->get('hero-content-alignment', $i) == 'center') ? '7' : '5'; ?>">
              <div class="hero-content d-flex align-items-center">
                <div class="hero-content-inner">
                  <?php if($helper->get('hero-subheading', $i)): ?>
                    <div class="sub-heading mb-2">
                      <h4 class="mt-0 mb-0"><?php echo $helper->get('hero-subheading', $i) ?></h4>
                    </div>
                  <?php endif; ?>

                  <?php if($helper->get('hero-heading', $i)): ?>
                    <h1 class="hero-title mt-0 mb-3">
                      <?php echo $helper->get('hero-heading', $i) ?>
                    </h1>
                  <?php endif; ?>

                  <?php if($helper->get('hero-intro', $i)): ?>
                    <div class="lead hero-desc mt-0 mb-3 md-lg-5"><?php echo $helper->get('hero-intro', $i) ?></div>
                  <?php endif; ?>

                  <?php if($helper->get('button-1', $i) || $helper->get('button-2', $i)): ?>
                    <div class="acm-action text-uppercase">
                      <?php if($helper->get('button-1', $i)): ?>
                        <a href="<?php echo $helper->get('btn-1-link', $i); ?>" class="btn btn-<?php echo $helper->get('btn-1-type', $i) ;?> mb-2 mb-md-0">
                          <?php echo $helper->get('button-1', $i) ?>
                        </a>
                      <?php endif; ?>

                      <?php if($helper->get('button-2', $i)): ?>
                        <a href="<?php echo $helper->get('btn-2-link', $i); ?>" class="btn btn-<?php echo $helper->get('btn-2-type', $i) ;?> ms-lg-3">
                          <?php echo $helper->get('button-2', $i) ?>
                        </a>
                      <?php endif; ?>
                    </div>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php endfor ;?>
  </div>
</div>

<?php if($count > 1) :?>
<script>
  (function($){
    jQuery(document).ready(function($) {
      $("#acm-hero-wrap-<?php echo $module->id; ?> .owl-carousel").owlCarousel({
        addClassActive: true,
        animateOut: 'fadeOut',
        items: 1,
        margin: 0,
        loop: false,
        nav : false,
        smartSpeed: 600,
        dots: <?php echo ($count > 1) ? 'true' : 'false' ;?>,
        autoplay: <?php echo $helper->get('autoplay'); ?>,
        autoplayTimeout: <?php echo $helper->get('auto-time'); ?>,
        rtl: $('html').attr('dir') === 'rtl',
        autoplaySpeed: false
      });
    });
  })(jQuery);
</script>
<?php endif; ?>