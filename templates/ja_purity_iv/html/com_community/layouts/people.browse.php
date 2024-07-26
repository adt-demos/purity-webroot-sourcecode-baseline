<?php
/**
* @copyright (C) 2013 iJoomla, Inc. - All rights reserved.
* @license GNU General Public License, version 2 (http://www.gnu.org/licenses/gpl-2.0.html)
* @author iJoomla.com <webmaster@ijoomla.com>
* @url https://www.jomsocial.com/license-agreement
* The PHP code portions are distributed under the GPL license. If not otherwise stated, all images, manuals, cascading style sheets, and included JavaScript *are NOT GPL, and are released under the IJOOMLA Proprietary Use License v1.0
* More info at https://www.jomsocial.com/license-agreement
*/
defined('_JEXEC') or die();
if (!isset($pageTitle)) {
    $task = JFactory::getApplication()->input->getCmd('task');
    $pageTitle = JText::_($task === 'display' ? 'COM_COMMUNITY_ADVANCESEARCH_SEARCH_RESULTS' : 'COM_COMMUNITY_ALL_MEMBERS');
}
?>
    <!-- Advanced Search Results -->
    <div class="joms-page">
        <?php if(isset($isAdvanceSearch) && $isAdvanceSearch){ ?>
            <h3 class="joms-page__title"><?php echo JText::_('COM_COMMUNITY_ADVANCESEARCH_SEARCH_RESULTS')?></h3>

            <?php
            $address = CUser::getAddress();
            if ($config->get('advanced_search_radius') && !CMapping::validateAddress($address) && $my->id > 0) {
            ?>
                <div id="notice" class="alert alert-notice">
                    <a class="close" data-dismiss="alert" onclick="jsAdvanceSearchResultsNotice();">×</a>
                    <div id="notice-message"><?php echo JText::sprintf('COM_COMMUNITY_ADVANCESEARCH_LOCATION_NOT_SET', CRoute::_('index.php?option=com_community&view=profile&task=edit&userid=' . $my->id)); ?></div>
                </div>
            <?php } ?>

        <?php }else{ ?>
        <div class="joms-list__search">
            <div class="joms-list__search-title">
                <h3 class="joms-page__title"><?php echo $pageTitle; ?></h3>
            </div>

            <div class="joms-list__utilities">
                <form method="post" class="joms-inline--desktop" action="<?php echo CRoute::_('index.php?option=com_community&view=search&task=advancesearch') ?>">
                    <span>
                        <input type="text" name="q" class="joms-input--search" value="<?php echo (isset($searchQuery)) ? $searchQuery : ''; ?>"
                           placeholder="<?php echo JText::_('COM_COMMUNITY_SEARCH_PEOPLE_PLACEHOLDER'); ?>">
                    </span>
                    <span>
                        <button class="joms-button--neutral"><?php echo JText::_('COM_COMMUNITY_SEARCH_GO'); ?></button>
                    </span>
                    <input type="hidden" name="search" value="friends">
                </form>
                <div onclick="window.location='<?php echo CRoute::_('index.php?option=com_community&view=friends&task=invite'); ?>';" class="joms-button--add">
                    <?php echo JText::_('COM_COMMUNITY_INVITE_FRIENDS'); ?>
                    <svg class="joms-icon" viewBox="0 0 16 16">
                        <use xlink:href="<?php echo CRoute::getURI(); ?>#joms-icon-plus"></use>
                    </svg>
                </div>
            </div>
        </div>
        <?php } ?>

        <?php echo isset($submenu) ? $submenu : ""; ?>

        <?php if ( $sortings ) { ?>
            <div class="joms-sortings">
                <?php echo $sortings; ?>
                
                <?php if (isset($hasMultiprofile) && $hasMultiprofile && !isset($isAdvanceSearch) && count($multiprofileArr)> 0): ?>
                    <select class="joms-select" onchange="window.location=this.value;">
                        <?php foreach ($multiprofileArr as $key => $value) { ?>
                        <option value="<?php echo $value['url']; ?>" <?php if ($value['selected']) echo 'selected="selected"'; ?>>
                        <?php echo $value['name']; ?>
                        </option>
                        <?php } ?>
                    </select>
                <?php endif; ?>
                <?php echo $alphabet; ?>
                <?php echo $byRadius; ?>
            </div>
            <div class="joms-gap"></div>
        <?php } ?>

        <ul class="joms-list--friend">
        <?php
        $blockModel = CFactory::getModel('block');
        foreach( $data as $row ) : ?>
            <?php $displayname = $row->user->getDisplayName(); ?>
            
            <?php if(!empty($row->user->id) && !empty($displayname)) : ?>
            <li class="joms-list__item">
                <?php  if (is_array($featuredList) && in_array($row->user->id, $featuredList)) { ?>
                <div class="joms-ribbon__wrapper">
                    <span class="joms-ribbon"><?php echo JText::_('COM_COMMUNITY_FEATURED'); ?></span>
                </div>
                <?php } ?>
                <!-- avatar -->
                <div class="joms-list__avatar <?php echo CUserHelper::onlineIndicator($row->user); ?>">
                    <a href="<?php echo $row->profileLink; ?>" class="joms-avatar">
                        <img data-author="<?php echo $row->user->id; ?>" src="<?php echo $row->user->getThumbAvatar(); ?>" alt="<?php echo $row->user->getDisplayName(); ?>" />
                    </a>
                </div>
                <div class="joms-list__body">
                    <!-- name -->
                    <a href="<?php echo $row->profileLink; ?>"><h4 class="joms-text--username"><?php echo $row->user->getDisplayName(false, true); ?></h4></a>

                    <!-- friends count -->
                    <div class="joms-list__details">
                        <?php if($config->get('memberlist_show_profile_info')) { ?>
                        <p>
                            <span class="joms-text--title">
                                <?php  echo nl2br(JHTML::_('string.truncate', str_replace("&quot;",'"',CUserHelper::showProfileInfo($row->user->id)), 140));?>
                            </span>
                        </p>
                        <?php } ?>

                        <?php if($config->get('memberlist_show_friends_count')) { ?>
                        <span class="joms-text--title">
                            <?php echo $row->friendsCount;?> <?php  echo JText::sprintf( (CStringHelper::isPlural($row->friendsCount)) ? 'COM_COMMUNITY_FRIENDS_COUNT_MANY' : 'COM_COMMUNITY_FRIENDS_COUNT', $row->friendsCount);?>
                        </span>
                        <?php } ?>

                        <!-- distances -->
                        <?php
                        $units = ($config->get('advanced_search_units') == 'metric') ? JText::_('COM_COMMUNITY_SORT_BY_DISTANCE_METRIC') : JText::_('COM_COMMUNITY_SORT_BY_DISTANCE_IMPERIAL') ;
                        $distance = CMapsHelper::getRadiusDistance($my->latitude, $my->longitude, $row->user->latitude,
                                    $row->user->longitude, $units, $row->user->id);
                        if($config->get('memberlist_show_distance') && ($distance !== false) && ($my->id !== $row->user->id) && ($my->id !== 0)) {
                        ?>
                        <span class="joms-list__distance">
                            <svg class="joms-icon" viewBox="0 0 16 16">
                                <use xlink:href="<?php echo CRoute::getURI(); ?>#joms-icon-location"></use>
                            </svg>
                            <?php
                                if ($distance === 0) {
                                    //0 indicates very near, false otherwise means some people doesnt have a proper longitude or latitude
                                    echo JText::_(($config->get('advanced_search_units') == 'metric') ? 'COM_COMMUNITY_LESS_THAN_A_KM' : 'COM_COMMUNITY_LESS_THAN_A_MILE') ;
                                } elseif ($distance) {
                                    echo JText::sprintf('COM_COMMUNITY_MILES_AWAY', $distance, $units);
                                }
                            ?>
                        </span>
                        <?php } ?>

                        <?php if ($config->get('memberlist_show_last_visit') == 1) { ?>
                        <p>
                            <span class="joms-text--title">
                                <?php
                                    $lastLogin = JText::_('COM_COMMUNITY_PROFILE_NEVER_LOGGED_IN');
                                    if ($row->user->lastvisitDate != '0000-00-00 00:00:00') {
                                        $userLastLogin = new JDate($row->user->lastvisitDate);
                                        $lastLogin = CActivityStream::_createdLapse($userLastLogin);
                                    }
                                ?>
                                <?php echo JText::_('COM_COMMUNITY_LAST_LOGIN') . $lastLogin; ?>
                            </span>
                        </p>
                        <?php } ?>
                    </div>

                </div>
                <div class="joms-list__actions">

                    <?php echo CFriendsHelper::getUserCog($row->user->id,null,null,null,true); ?>

                    <?php echo CFriendsHelper::getUserFriendDropdown($row->user->id); ?>

                </div>
            </li>
            <?php endif; ?>
        <?php endforeach; ?>

        </ul>

        <?php if(empty($data)){ ?>
            <div class="joms-gap"></div>
            <span class="joms-text--title"><?php echo JText::_('COM_COMMUNITY_SEARCH_NO_RESULT');?></span>
        <?php } ?>

<?php if (isset($pagination) && is_object($pagination) && method_exists($pagination,'getPagesLinks') && $pagination->getPagesLinks() && ($pagination->pagesTotal > 1 || $pagination->total > 1) ) { ?>
    <div class="joms-pagination">
        <?php echo $pagination->getPagesLinks(); ?>
    </div>
<?php } ?>
</div>
