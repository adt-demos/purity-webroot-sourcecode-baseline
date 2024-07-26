<?php

/**
 * @package     Joomla.Site
 * @subpackage  com_contact
 *
 * @copyright   (C) 2009 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;

?>
<?php echo '<dt class="col-3">' . Text::_('TPL_CONTACT_SOCIAL') . '</dt>'; ?>

<dd class="com-contact__links contact-links col-9">
  <div class="d-inline-block">
    <ul class="nav nav-tabs nav-stacked">
      <?php
      // Letters 'a' to 'e'
      foreach (range('a', 'e') as $char) :
        $link = $this->item->params->get('link' . $char);
        $label = $this->item->params->get('link' . $char . '_name');

        if (!$link) :
          continue;
        endif;

        // Add 'http://' if not present
        $link = (0 === strpos($link, 'http')) ? $link : 'http://' . $link;

        // If no label is present, take the link
        $label = $label ?: $link;
      ?>
        <li>
          <a href="<?php echo $link; ?>" itemprop="url" rel="noopener noreferrer">
            <span class="fab fa-<?php echo $label ?>"></span>
          </a>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</dd>