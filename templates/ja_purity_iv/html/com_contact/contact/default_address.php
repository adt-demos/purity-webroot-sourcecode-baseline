<?php

/**
 * @package     Joomla.Site
 * @subpackage  com_contact
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\String\PunycodeHelper;
use Joomla\CMS\Language\Text;

/**
 * Marker_class: Class based on the selection of text, none, or icons
 * jicon-text, jicon-none, jicon-icon
 */
?>
<dl class="contact-address dl-horizontal row" itemprop="address" itemscope itemtype="https://schema.org/PostalAddress">
  <?php if (($this->params->get('address_check') > 0) &&
    ($this->item->address || $this->item->suburb  || $this->item->state || $this->item->country || $this->item->postcode)
  ) : ?>

    <!-- address -->
    <?php if ($this->item->address && $this->params->get('show_street_address')) : ?>
      <dt class="col-3">
        <span class="<?php echo $this->params->get('marker_class'); ?>">
          <?php echo $this->params->get('marker_address'); ?>
          <?php echo Text::_('TPL_CONTACT_ADDRESS'); ?>
        </span>
      </dt>
      <dd class="col-9">
        <span class="contact-street" itemprop="streetAddress">
          <?php echo nl2br($this->item->address); ?>
          <br />
        </span>
      </dd>
    <?php endif; ?>

    <dd>
      <?php if ($this->item->suburb && $this->params->get('show_suburb')) : ?>
        <span class="contact-suburb" itemprop="addressLocality">
          <?php echo $this->item->suburb; ?>
        </span>,
      <?php endif; ?>

      <?php if ($this->item->state && $this->params->get('show_state')) : ?>
        <span class="contact-state" itemprop="addressRegion">
          <?php echo $this->item->state; ?>
        </span>,
      <?php endif; ?>

      <?php if ($this->item->postcode && $this->params->get('show_postcode')) : ?>
        <span class="contact-postcode" itemprop="postalCode">
          <?php echo $this->item->postcode; ?>
        </span>,
      <?php endif; ?>

      <?php if ($this->item->country && $this->params->get('show_country')) : ?>
        <span class="contact-country" itemprop="addressCountry">
          <?php echo $this->item->country; ?>
        </span>
      <?php endif; ?>
    </dd>
  <?php endif; ?>

  <!-- email -->
  <?php if ($this->item->email_to && $this->params->get('show_email')) : ?>
    <dt class="col-3">
      <span class="<?php echo $this->params->get('marker_class'); ?>" itemprop="email">
        <?php echo $this->params->get('marker_email'); ?>
        <?php echo Text::_('TPL_CONTACT_EMAIL'); ?>
      </span>
    </dt>
    <dd class="col-9">
      <span class="contact-emailto">
        <?php echo $this->item->email_to; ?>
      </span>
    </dd>
  <?php endif; ?>

  <!-- telephone -->
  <?php if ($this->item->telephone && $this->params->get('show_telephone')) : ?>
    <dt class="col-3">
      <span class="<?php echo $this->params->get('marker_class'); ?>">
        <?php echo $this->params->get('marker_telephone'); ?>
        <?php echo Text::_('TPL_CONTACT_TELEPHONE'); ?>
      </span>
    </dt>
    <dd class="col-9">
      <span class="contact-telephone" itemprop="telephone">
        <?php echo $this->item->telephone; ?>
      </span>
    </dd>
  <?php endif; ?>
  <?php if ($this->item->fax && $this->params->get('show_fax')) : ?>
    <dt class="col-3">
      <span class="<?php echo $this->params->get('marker_class'); ?>">
        <?php echo $this->params->get('marker_fax'); ?>
      </span>
    </dt>
    <dd class="col-9">
      <span class="contact-fax" itemprop="faxNumber">
        <?php echo $this->item->fax; ?>
      </span>
    </dd>
  <?php endif; ?>
  <?php if ($this->item->mobile && $this->params->get('show_mobile')) : ?>
    <dt class="col-3">
      <span class="<?php echo $this->params->get('marker_class'); ?>">
        <?php echo $this->params->get('marker_mobile'); ?>
      </span>
    </dt>
    <dd class="col-9">
      <span class="contact-mobile" itemprop="telephone">
        <?php echo $this->item->mobile; ?>
      </span>
    </dd>
  <?php endif; ?>
  <?php if ($this->item->webpage && $this->params->get('show_webpage')) : ?>
    <dt class="col-3">
      <span class="<?php echo $this->params->get('marker_class'); ?>">
      </span>
    </dt>
    <dd class="col-9">
      <span class="contact-webpage">
        <a href="<?php echo $this->item->webpage; ?>" target="_blank" rel="noopener noreferrer" itemprop="url">
          <?php echo PunycodeHelper::urlToUTF8($this->item->webpage); ?></a>
      </span>
    </dd>
  <?php endif; ?>
</dl>