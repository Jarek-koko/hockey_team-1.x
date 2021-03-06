<?php

/*
 * @package Joomla 1.5
 * @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 *
 * @component Hockey Team
 * @copyright Copyright (C) Klich Jarosław
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.view');
JHTML::addIncludePath(JPATH_COMPONENT . DS . 'helpers');

class HockeyViewStats extends JView {

    function display($tpl = null) {

        $document = & JFactory::getDocument ();
        $document->addScript(JURI::base(true) . '/components/com_hockey/assets/jquery.js');
        $document->addScript(JURI::base(true) . '/components/com_hockey/assets/jquery.tools.min.js');
        $document->addScript(JURI::base(true) . '/components/com_hockey/assets/jquery.tablesorter.js');

        $params = &JComponentHelper::getParams( 'com_hockey' );
        $menus = &JSite::getMenu ();
        $menu = $menus->getActive();

        $title = JText::_('HOC_STAT_TITLE');
        if (is_object($menu)) {
            $menu_params = new JParameter($menu->params);
            if (!$menu_params->get('page_title'))
                $params->set('page_title', $title);
        } else {
            $params->set('page_title', $title);
        }
        $document->setTitle($params->get('page_title'));

        $session = &JFactory::getSession();
        $idsezon = (int) $session->get('idsezon', 0);
        $show = (int) $params->get('show_select', 0);
        
        if (($idsezon == 0) || ($show == 0)) {
            $idsezon = $params->get('iddsfp');
        }
        
        $model = &$this->getModel();
        $sezony = $model->getSezonList();

        $lista = JHTML::_('select.genericlist', $sezony, 'sezon', 'class="inputbox" ', 'value', 'text', $idsezon);
        $select_season = JHTML::_('Selectseason.getSelect', $lista, $menu->query['view'], JRoute::_('index.php?option=com_hockey&task=querypost'));

        $this->assignRef('select_season', $select_season);
        $this->assignRef('params', $params);
        $this->assignRef('idsezon', $idsezon);
        parent::display($tpl);
    }
}
?>