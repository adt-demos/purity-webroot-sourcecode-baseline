<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 *
 * html5 (chosen html5 tag and font header tags)
 */

defined('_JEXEC') or die;

$module  = $displayData['module'];
$params  = $displayData['params'];
$attribs  = $displayData['attribs'];


$badge          = preg_match ('/badge/', $params->get('moduleclass_sfx',''))? '<span class="badge">&nbsp;</span>' : '';
$moduleTag      = htmlspecialchars($params->get('module_tag', 'div'));
$headerTag      = htmlspecialchars($params->get('header_tag', 'h4'));
$headerClass    = $params->get('header_class');
$bootstrapSize  = $params->get('bootstrap_size');
$moduleClass    = !empty($bootstrapSize) ? ' span' . (int) $bootstrapSize . '' : '';
$moduleClassSfx = htmlspecialchars($params->get('moduleclass_sfx',''));

// Section heading alignment
$moduleAli = $params->get('sub-align','left');
$headingCols = $params->get('heading-columns');
$contentCols = 12;

if($headingCols < 12) {
	$contentCols = (12 - $headingCols);
}

if(($headingCols == 12) && $moduleAli == 'center') {
	$moduleAli = 'text-'. $moduleAli . ' mx-auto';
} else {
	$moduleAli = 'text-' . $moduleAli;
}

// Module Title
$modTitle = '';

if($module->showtitle != 0) {
	$modTitle = '<'.$headerTag.' class="my-0 mod-title text-'.$headerClass.'"><span>'.$module->title.'</span></'.$headerTag.'>';
}

// Main Heading
$moduleMain = '';

if($params->get('main-heading')) {
	$moduleMain = '<p class="mod-desc lead mt-4 mb-0">'.$params->get('main-heading').'</p>';
}

// Sub Heading
$moduleSub = '';

if($params->get('sub-heading')) {
	$moduleSub = '<h4 class="mt-0 mb-3 text-uppercase">'.$params->get('sub-heading').'</h4>';
}

// Section BG Color
$bgSection = $params->get('bg-color', 'bg-default');
$darkBgcolor = 'color-dark-normal';

if($bgSection == 'bg-default' || $bgSection == 'bg-light') {
	$darkBgcolor = 'color-dark-active';
}

// Section Space
$topSpace = 'top-'.$params->get('top-space', 'large');

// Section Space
$bottomSpace = 'bottom-'.$params->get('bottom-space', 'large');

// Button params
$btnMore = '';
$btnShow = 'd-none';
$btnMoreText = $params->get('btn-more-text');
$btnMoreLink = $params->get('btn-more-link');
$btnMoreType = $params->get('btn-more-type','default');

if($btnMoreText && $btnMoreLink) {
	$btnMore = '<a href="'.trim($btnMoreLink).'" class="btn btn-'.$btnMoreType.'">'.$btnMoreText.'</a>';
	$btnShow = 'd-block';
}

if (!empty ($module->content)) {
	$html = "<{$moduleTag} data-bg-color=\"{$bgSection}\" class=\"t4-mod-wrap {$moduleClassSfx} {$moduleClass} {$topSpace} {$bottomSpace} {$darkBgcolor}\" id=\"Mod{$module->id}\">" .
				"<div class=\"section-inner\">" . $badge;

	if ($module->showtitle != 0) {

		if($headingCols == 12) {
			$html .= "<div class=\"container\"><div class=\"row\">
			<div class=\"section-heading col-12 col-md-8 col-lg-6 mb-4 mb-lg-5 {$moduleAli}\">
				{$moduleSub}{$modTitle}{$moduleMain}
			</div>
			</div></div>";

			$html .= "<div class=\"section-ct\">{$module->content}</div><div class=\"text-center {$btnShow}\"><div class=\"mt-3 mt-lg-5 text-uppercase\">{$btnMore}</div></div>";
		} else {
			$html .= "<div class=\"row\">
			<div class=\"col-12 col-lg-{$headingCols}\"><div class=\"section-heading mb-3 mb-lg-0 {$moduleAli}\">{$moduleSub}{$modTitle}{$moduleMain}</div><div class=\"text-uppercase mt-3 mt-lg-5 mb-5 mb-lg-0 {$btnShow}\">{$btnMore}</div></div>
			<div class=\"col-12 col-lg-{$contentCols}\"><div class=\"section-ct\">{$module->content}</div></div>
			</div>";
		}

	} else {
		$html .= "<div class=\"section-ct\">{$module->content}</div><div class=\"text-uppercase mb-5 mb-lg-0 {$btnShow}\">{$btnMore}</div>";
	}

	$html .= "</div></{$moduleTag}>";

	echo $html;
}