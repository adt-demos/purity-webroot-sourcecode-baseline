<?

/**
 * @package     DOCman
 * @copyright   Copyright (C) 2011 Timble CVBA. (http://www.timble.net)
 * @license     GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://www.joomlatools.com
 */
defined('KOOWA') or die;

$multi_download = object('com://site/docman.controller.behavior.compressible')->isSupported(); ?>

<?= helper('ui.load'); ?>
<?= helper('com://site/docman.behavior.modal'); ?>
<?= helper('com://site/docman.behavior.thumbnail_modal'); ?>

<? if ($multi_download) : ?>
  <?= helper('com://site/docman.behavior.multidownload'); ?>
  <?= helper('com://site/docman.behavior.multiselect', [
    'selector' => '.koowa_media__item__options__select'
  ]); ?>
<? endif; ?>

<? if ($params->track_downloads) : ?>
  <?= helper('com://site/docman.behavior.download_tracker'); ?>
<? endif; ?>

<?= helper('translator.script', array('strings' => array(
  'Download'
))) ?>

<meta itemprop="contentUrl" content="<?= $document->image_download_path ?>">

<? if ($document->isPreviewableImage()) : ?>
  <? if ($document->storage->width) : ?>
    <meta itemprop="width" content="<?= $document->storage->width; ?>">
  <? endif; ?>
  <? if ($document->storage->height) : ?>
    <meta itemprop="height" content="<?= $document->storage->height; ?>">
  <? endif; ?>
  <!-- <meta itemprop="contentUrl" content="<?= $document->image_download_path ?>"> -->
  <? if ($multi_download || ((!isset($manage) || $manage === true) && ($document->canPerform('delete') || $document->canPerform('edit')))) : ?>
    <div class="koowa_media__item__options">
      <? if ($document->canPerform('delete') || $multi_download) : ?>
        <span class="koowa_media__item__options__select">
          <input id="document-select-<?= $count; ?>" name="item-select" type="checkbox" class="k-js-item-select" data-can-download="<?= $document->canPerform('download') ?>" data-storage-type="<?= $document->storage_type ?>" data-id="<?= $document->id ?>" data-url="<?= $document->document_link ?>" />
          <label for="document-select-<?= $count; ?>" class="k-visually-hidden">Select an item</label>
        </span>
      <? endif ?>

      <? if ($document->canPerform('delete')) : ?>
        <?
        $data = array(
          'url'    => (string)helper('route.document', array('entity' => $document), true, false),
          'params' => array(
            '_method'    => 'delete',
          )
        );
        ?>
        <a href="#" data-action="delete-item" class="koowa_media__item__options__delete" aria-label="<?= translate('Delete document') ?>" data-params="<?= escape(json_encode($data['params'])) ?>" data-url="<?= escape($data['url']) ?>">
          <span class="k-icon-trash k-icon--size-default"></span>
        </a>
      <? endif; ?>

      <? if ($document->canPerform('edit')) : ?>
        <a href="<?= helper('route.document', array('entity' => $document, 'layout' => 'form')); ?>" class="koowa_media__item__options__edit" aria-label="<?= translate('Edit document') ?>">
          <span class="k-icon-pencil k-icon--size-default"></span>
        </a>
      <? endif ?>
    </div>
  <? endif; ?>
  <a class="koowa_media__item__link k-js-gallery-item <?= $params->document_title_link === 'download' ? 'docman_track_download' : ''; ?>" data-path="<?= $document->image_path ?>" data-title="<?= escape($document->title); ?>" data-id="<?= $document->id; ?>" data-width="<?= $document->storage->width; ?>" data-height="<?= $document->storage->height; ?>" href="<?= $document->title_link ?>" title="<?= escape($document->title) ?>" <?= $params->document_title_link === 'download'  ? 'type="' . $document->mimetype . '"' : ''; ?>>
  <? else : ?>
    <a class="koowa_media__item__link <?= $params->document_title_link === 'download' ? 'docman_track_download' : ''; ?>" <?= $params->download_in_blank_page ? 'target="_blank"' : ''; ?> data-title="<?= escape($document->title); ?>" data-id="<?= $document->id; ?>" href="<?= $document->title_link ?>" title="<?= escape($document->title) ?>" <?= $params->document_title_link === 'download'  ? 'type="' . $document->mimetype . '"' : ''; ?>>
    <? endif; ?>

    <div class="koowa_media__item__content-holder">
      <? if ($document->image_path) : ?>
        <div class="koowa_media__item__thumbnail">
          <img itemprop="thumbnail" src="<?= $document->image_path ?>" alt="<?= escape($document->title) ?>">
        </div>
      <? else : ?>
        <div class="koowa_media__item__icon">
          <?= import('com://site/docman.document.icon.html', array(
            'icon'  => $document->icon,
            'class' => ' k-icon--size-xlarge' . (strlen($document->extension) ? ' k-icon-type-' . $document->extension : '')
          )); ?>

          <? if ($params->show_document_title) : ?>
            <span class="koowa_header koowa_media__item__label">
              <?= escape($document->title) ?>


              <? // Label new 
              ?>
              <? if ($params->show_document_recent && isRecent($document)) : ?>
                <span class="label label-success badge bg-success"><?= translate('New'); ?></span>
              <? endif; ?>
            </span>
          <? endif; ?>
        </div>
      <? endif; ?>

      <? if ($params->show_document_description) : ?>
        <div class="koowa_wrapped_content--document_desc"><?= $document->description ?></div>
      <? endif; ?>
    </div>
    </a>