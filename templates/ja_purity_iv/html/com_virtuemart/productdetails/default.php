<?php

/**
 *
 * Show the product details page
 *
 * @package	VirtueMart
 * @subpackage
 * @author Max Milbers, Eugen Stranz, Max Galt
 * @link https://virtuemart.net
 * @copyright Copyright (c) 2004 - 2014 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: default.php 10777 2022-12-19 20:53:24Z Milbo $
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
JHtml::_('bootstrap.tab');

/* Let's see if we found the product */
if (empty($this->product)) {
  echo vmText::_('COM_VIRTUEMART_PRODUCT_NOT_FOUND');
  echo '<br /><br />  ' . $this->continue_link_html;
  return;
}

echo shopFunctionsF::renderVmSubLayout('askrecomjs', array('product' => $this->product));

//vmdebug('My product',$this->product->loadFieldValues());

if (vRequest::getInt('print', false)) { ?>

  <body onload="javascript:print();">
  <?php } ?>

  <div class="product-container productdetails-view productdetails vm-product-details">
    <?php
    // Product Navigation
    if (VmConfig::get('product_navigation', 1)) {
    ?>
      <div class="product-neighbours">
        <?php
        if (!empty($this->product->neighbours['previous'][0])) {
          $prev_link = JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $this->product->neighbours['previous'][0]['virtuemart_product_id'] . '&virtuemart_category_id=' . $this->product->virtuemart_category_id, FALSE);
          echo JHtml::_('link', $prev_link, $this->product->neighbours['previous'][0]['product_name'], array('rel' => 'prev', 'class' => 'previous-page', 'data-dynamic-update' => '1'));
        }
        if (!empty($this->product->neighbours['next'][0])) {
          $next_link = JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $this->product->neighbours['next'][0]['virtuemart_product_id'] . '&virtuemart_category_id=' . $this->product->virtuemart_category_id, FALSE);
          echo JHtml::_('link', $next_link, $this->product->neighbours['next'][0]['product_name'], array('rel' => 'next', 'class' => 'next-page', 'data-dynamic-update' => '1'));
        }
        ?>

      </div>
    <?php } // Product Navigation END
    ?>

    <div class="row large-gutters">
      <div class="col-12 col-md-6 position-relative vm-product-media">
        <div class="vm-product-media-container">
          <?php
          echo $this->loadTemplate('images');
          $count_images = count($this->product->images);
          if ($count_images > 1) {
            echo $this->loadTemplate('images_additional');
          }
          ?>
        </div>
      </div>
      <div class="col-12 col-md-6 vm-product-info">

        <?php // Back To Category Button
        if ($this->product->virtuemart_category_id) {
          $catURL =  JRoute::_('index.php?option=com_virtuemart&view=category&virtuemart_category_id=' . $this->product->virtuemart_category_id, FALSE);
          $categoryName = vmText::_($this->product->category_name);
        } else {
          $catURL =  JRoute::_('index.php?option=com_virtuemart');
          $categoryName = vmText::_('COM_VIRTUEMART_SHOP_HOME');
        }
        ?>

        <?php
        // PDF - Print - Email Icon
        if (VmConfig::get('show_emailfriend') || VmConfig::get('show_printicon') || VmConfig::get('pdf_icon')) {
        ?>
          <div class="icons">
            <?php

            $link = 'index.php?tmpl=component&option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $this->product->virtuemart_product_id;

            echo $this->linkIcon($link . '&format=pdf', 'COM_VIRTUEMART_PDF', 'pdf_button', 'pdf_icon', false);
            //echo $this->linkIcon($link . '&print=1', 'COM_VIRTUEMART_PRINT', 'printButton', 'show_printicon');
            echo $this->linkIcon($link . '&print=1', 'COM_VIRTUEMART_PRINT', 'printButton', 'show_printicon', false, true, false, 'class="printModal"');
            $MailLink = 'index.php?option=com_virtuemart&view=productdetails&task=recommend&virtuemart_product_id=' . $this->product->virtuemart_product_id . '&virtuemart_category_id=' . $this->product->virtuemart_category_id . '&tmpl=component';
            echo $this->linkIcon($MailLink, 'COM_VIRTUEMART_EMAIL', 'emailButton', 'show_emailfriend', false, true, false, 'class="recommened-to-friend"');
            ?>
            <div class="clear"></div>
          </div>
        <?php } // PDF - Print - Email Icon END
        ?>

        <span class="vm-edit-product">
        <?php
        // Product Edit Link        
        echo $this->edit_link;
        // Product Edit Link END
        ?></span>

        <div class="back-to-category">
          <a href="<?php echo $catURL ?>" class="" title="<?php echo $categoryName ?>"><?php echo $categoryName ?></a>
        </div>

        <?php // Product Title   
        ?>
        <h2 class="vm-product-title"><?php echo $this->product->product_name ?></h2>

        <?php echo shopFunctionsF::renderVmSubLayout('rating', array('showRating' => $this->showRating, 'product' => $this->product));
        ?>

        <!-- Price -->
        <?php echo shopFunctionsF::renderVmSubLayout('prices', array('product' => $this->product, 'currency' => $this->currency)); ?>

        <?php // afterDisplayTitle Event
        echo $this->product->event->afterDisplayTitle ?>

        <?php
        // Product Short Description
        if (!empty($this->product->product_s_desc)) {
        ?>
          <div class="vm-product-short-desc">
            <?php
            /** @todo Test if content plugins modify the product description */
            echo nl2br($this->product->product_s_desc);
            ?>
          </div>
        <?php
        } // Product Short Description END

        echo shopFunctionsF::renderVmSubLayout('customfields', array('product' => $this->product, 'position' => 'ontop'));
        ?>

        <div class="spacer-buy-area">
          <?php
          // TODO in Multi-Vendor not needed at the moment and just would lead to confusion
          /* $link = JRoute::_('index2.php?option=com_virtuemart&view=virtuemart&task=vendorinfo&virtuemart_vendor_id='.$this->product->virtuemart_vendor_id);
        $text = vmText::_('COM_VIRTUEMART_VENDOR_FORM_INFO_LBL');
        echo '<span class="bold">'. vmText::_('COM_VIRTUEMART_PRODUCT_DETAILS_VENDOR_LBL'). '</span>'; ?><a class="modal" href="<?php echo $link ?>"><?php echo $text ?></a><br />
       */
          ?>

          <?php
          foreach ($this->productDisplayTypes as $type => $productDisplayType) {

            foreach ($productDisplayType as $productDisplay) {

              foreach ($productDisplay as $virtuemart_method_id => $productDisplayHtml) { ?>
                <div class="<?php echo substr($type, 0, -1) ?> <?php echo substr($type, 0, -1) . '-' . $virtuemart_method_id ?>">
                  <?php echo $productDisplayHtml; ?>
                </div>
          <?php
              }
            }
          }

          //In case you are not happy using everywhere the same price display fromat, just create your own layout
          //in override /html/fields and use as first parameter the name of your file
          ?>
          <?php
          echo shopFunctionsF::renderVmSubLayout('addtocart', array('product' => $this->product));

          echo shopFunctionsF::renderVmSubLayout('stockhandle', array('product' => $this->product));

          // Ask a question about this product
          if (VmConfig::get('ask_question', 0) == 1) {
            $askquestion_url = JRoute::_('index.php?option=com_virtuemart&view=productdetails&task=askquestion&virtuemart_product_id=' . $this->product->virtuemart_product_id . '&virtuemart_category_id=' . $this->product->virtuemart_category_id . '&tmpl=component', FALSE);
          ?>
            <div class="ask-a-question">
              <a class="ask-a-question" href="<?php echo $askquestion_url ?>" rel="nofollow"><?php echo vmText::_('COM_VIRTUEMART_PRODUCT_ENQUIRY_LBL') ?></a>
            </div>
          <?php
          }
          ?>

          <div class="vm-product-other-info">

            <div class="sku-product">
              <?php echo '<span>' . JText::_('TPL_SKU') . '</span>';  ?>
              <div class="number-sku"><?php echo $this->product->product_sku; ?></div>
            </div>

            <?php if (!empty($this->product->virtuemart_manufacturer_id)) { ?>
              <div class="manufacturer-product">
                <?php echo '<span>' . JText::_('TPL_MANUFACTURER') . '</span>';  ?>
                <?php
                // Manufacturer of the Product
                if (VmConfig::get('show_manufacturers', 1) && !empty($this->product->virtuemart_manufacturer_id)) {
                  echo $this->loadTemplate('manufacturer');
                }
                ?>
              </div>
            <?php } ?>

            <?php
            // Product Packaging
            $product_packaging = '';
            if ($this->product->product_box) {
            ?>
              <div class="product-box">
                <?php echo vmText::_('COM_VIRTUEMART_PRODUCT_UNITS_IN_BOX') . $this->product->product_box; ?>
              </div>
            <?php
            } // Product Packaging END 
            ?>

            <?php if (!empty($this->product->categoryItem)) { ?>
              <div class="category-pd">
                <?php echo '<span>' . JText::_('TPL_CATEGORY') . '</span>';  ?>
                <?php
                foreach ($this->product->categoryItem as $category) {
                  $catUrl = JRoute::_('index.php?option=com_virtuemart&view=category&virtuemart_category_id=' . $category['virtuemart_category_id'], FALSE);
                ?>
                  <a href="<?php echo $catUrl; ?>" title=""><?php echo $category['category_name']; ?></a>
                <?php }
                ?>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>

    <div class="section-tabs">
      <?php
      $db = JFactory::getDbo();
      $query = "SELECT COUNT(virtuemart_rating_review_id) 
            FROM `#__virtuemart_rating_reviews` 
            WHERE `published` = 1 
            AND `virtuemart_product_id` = {$db->q($this->product->virtuemart_product_id)}";
      $reviewCount = $db->setQuery($query)->loadResult();
      ?>
      <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" data-bs-toggle="tab" href="#nav-desc"><?php echo '<span>' . JText::_('TPL_DESCRIPTION') . '</span>';  ?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="tab" href="#nav-addtional"><?php echo '<span>' . JText::_('TPL_ADDITIONAL') . '</span>';  ?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="tab" href="#nav-review"><?php echo '<span>' . JText::_('TPL_REVIEW') . '</span>';  ?>
            <?php echo '<span class="number">(' . $reviewCount . ')</span>'; ?>
          </a>
        </li>
      </ul>

      <div class="tab-content" id="nav-tabContent">
        <!-- Description -->
        <div class="tab-pane fade show active" id="nav-desc" role="tabpanel" aria-labelledby="nav-desc-tab">
          <?php echo $this->product->product_desc; ?>
        </div>
        <!-- Description -->

        <!-- Addtional -->
        <div class="tab-pane fade" id="nav-addtional" role="tabpanel" aria-labelledby="nav-addtional-tab">
          <?php if (shopFunctionsF::renderVmSubLayout('customfields', array('product' => $this->product, 'position' => 'additional_information'))) : ?>
            <div id="more-information">
              <?php // More Information
              echo shopFunctionsF::renderVmSubLayout('customfields', array('product' => $this->product, 'position' => 'additional_information', 'class' => 'more-information'));
              ?>
            </div>
          <?php endif; ?>
        </div>
        <!-- Addtional -->

        <!-- Review -->
        <div class="tab-pane fade" id="nav-review" role="tabpanel" aria-labelledby="nav-review-tab">
          <?php echo $this->loadTemplate('reviews'); ?>
        </div>
        <!-- Review -->
      </div>

    </div>

    <?php
    // event onContentBeforeDisplay
    echo $this->product->event->beforeDisplayContent;
    ?>

    <?php
    echo shopFunctionsF::renderVmSubLayout('customfields', array('product' => $this->product, 'position' => 'normal'));
    ?>

    <?php
    echo shopFunctionsF::renderVmSubLayout('customfields', array('product' => $this->product, 'position' => 'onbot'));
    echo shopFunctionsF::renderVmSubLayout('customfields', array('product' => $this->product, 'position' => 'related_products', 'class' => 'product-related-products', 'customTitle' => true));
    echo shopFunctionsF::renderVmSubLayout('customfields', array('product' => $this->product, 'position' => 'related_categories', 'class' => 'product-related-categories'));
    ?>

    <?php // onContentAfterDisplay event
    echo $this->product->event->afterDisplayContent;

    // Show child categories
    if ($this->cat_productdetails) {
      echo $this->loadTemplate('showcategory');
    }

    $j = 'jQuery(document).ready(function($) {
    $("form.js-recalculate").each(function(){
      if ($(this).find(".product-fields").length && !$(this).find(".no-vm-bind").length) {
        var id= $(this).find(\'input[name="virtuemart_product_id[]"]\').val();
        Virtuemart.setproducttype($(this),id);
      }
      });
    });';
    //vmJsApi::addJScript('recalcReady',$j);

    if (VmConfig::get('jdynupdate', TRUE)) {

      /** GALT
       * Notice for Template Developers!
       * Templates must set a Virtuemart.container variable as it takes part in
       * dynamic content update.
       * This variable points to a topmost element that holds other content.
       */
      /*	$j = "Virtuemart.container = jQuery('.productdetails-view');
      Virtuemart.containerSelector = '.productdetails-view';
      //Virtuemart.recalculate = true;	//Activate this line to recalculate your product after ajax
      ";

	vmJsApi::addJScript('ajaxContent',$j);*/

      $j = "jQuery(document).ready(function($) {
      Virtuemart.stopVmLoading();
      var msg = '';
      $('a[data-dynamic-update=\"1\"]').off('click', Virtuemart.startVmLoading).on('click', {msg:msg}, Virtuemart.startVmLoading);
      $('[data-dynamic-update=\"1\"]').off('change', Virtuemart.startVmLoading).on('change', {msg:msg}, Virtuemart.startVmLoading);
    });";

      vmJsApi::addJScript('vmPreloader', $j);
    }

    echo vmJsApi::writeJS();

    if ($this->product->prices['salesPrice'] > 0) {
      echo shopFunctionsF::renderVmSubLayout('snippets', array('product' => $this->product, 'currency' => $this->currency, 'showRating' => $this->showRating));
    }

    ?>
  </div>