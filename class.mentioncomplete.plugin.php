<?php
if (!defined('APPLICATION')) {
    exit();
}
/*	Copyright 2015 GyD
*	This program is free software: you can redistribute it and/or modify
*	it under the terms of the GNU General Public License as published by
*	the Free Software Foundation, either version 3 of the License, or
*	(at your option) any later version.
*
*	This program is distributed in the hope that it will be useful,
*	but WITHOUT ANY WARRANTY; without even the implied warranty of
*	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*	GNU General Public License for more details.
*
*	You should have received a copy of the GNU General Public License
*	along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

$PluginInfo['MentionComplete'] = array(
  'Description' => 'Provide an autocomplete for the mentions',
  'Version' => '0.1.0',
  'RequiredApplications' => null,
  'RequiredTheme' => false,
  'RequiredPlugins' => array(
    'Libraries' => '0.0.0'
  ),
  'HasLocale' => false,
  'Author' => "GyD",
  'AuthorEmail' => 'github@gyd.be',
  'AuthorUrl' => 'http://github.com/GyD',
  'Hidden' => false
);

class MentionCompletePlugin extends Gdn_Plugin
{

    /**
     * At Libraries Startup
     * @param LibrariesPlugin $Sender
     */
    public function LibrariesPlugin_Startup_Handler($Sender)
    {
        $Sender->addLibraries(array(
          'jquery-textcomplete' => array(
            'version' => '0.3.9',
            'plugin' => get_class($this),
            'files' => array(
              'js' => "js/jquery-textcomplete/dist/jquery.textcomplete.js",
              'js-min' => "js/jquery-textcomplete/dist/jquery.textcomplete.min.js",
              'css' => "js/jquery-textcomplete/dist/jquery.textcomplete.css",
                //'css-min' => "js/jquery-textcomplete/dist/jquery.textcomplete.css",
            ),
          ),
        ));
    }

    /**
     * @param DiscussionController $Sender
     */
    public function DiscussionController_Render_Before($Sender)
    {
        LibrariesPlugin::AttachLibrary($Sender, 'jquery-textcomplete');
        $Sender->AddJsFile($this->GetResource('js/mentioncomplete.js', false, false));

        $MentionCompleteDefinition = array(
          'start' => '',
          'stop' => ''
        );


        if (C('Plugins.MentionsPlus.MentionStart')) {
            $MentionCompleteDefinition['start'] = C('Plugins.MentionsPlus.MentionStart');
        }
        if (C('Plugins.MentionsPlus.MentionStop')) {
            $MentionCompleteDefinition['stop'] = C('Plugins.MentionsPlus.MentionStop');
        }

        $Sender->AddDefinition('MentionComplete', $MentionCompleteDefinition);
    }

}