<?php if (!defined('APPLICATION')) exit;

$PluginInfo['styleguide'] = array(
  'Name'        => "Styleguide",
  'Description' => "Living styleguide generator for KSS documented Vanilla themes.",
  'Version'     => '1.0.2',
  'PluginUrl'   => 'https://github.com/kasperisager/vanilla-styleguide',
  'Author'      => "Kasper Kronborg Isager",
  'AuthorEmail' => 'kasperisager@gmail.com',
  'AuthorUrl'   => 'https://github.com/kasperisager',
  'License'     => 'MIT'
);

/**
 * Styleguide Plugin
 *
 * @author    Kasper Kronborg Isager <kasperisager@gmail.com>
 * @copyright Copyright 2015 (c) Kasper Kronborg Isager
 * @license   MIT
 * @since     1.0.0
 */
class StyleguidePlugin extends Gdn_Plugin {
  /**
   * Prioritized list of folders to check.
   *
   * @since   1.0.0
   * @access  private
   */
  private $stylesheetFolders = ['less', 'sass', 'scss', 'design'];

  /**
   * Render menu link in the dashboard sidebar.
   *
   * @since  1.0.1
   * @access public
   * @param  Gdn_Controller $sender
   */
  public function Base_getAppSettingsMenuItems_handler($sender) {
    $menu = $sender->EventArguments['SideMenu'];
    $menu->addLink('Appearance', t('Styleguide'), 'vanilla/styleguide');
  }

  /**
   * Create an endpoint for accessing the styleguide.
   *
   * @since   1.0.0
   * @access  public
   * @param   $sender The Vanilla Controller instance.
   * @param   $args   Supplied URL arguments.
   */
  public function VanillaController_styleguide_create($sender, $args) {
    $pluginFolder = $this->PluginInfo['Folder'];

    require_once combinePaths(['library', 'vendors', 'autoload.php']);

    $sender->addCssFile('styleguide.css', combinePaths([
      'plugins', $pluginFolder
    ]));

    $sender->addJsFile('styleguide.js', combinePaths([
      'plugins', $pluginFolder
    ]));

    $themeInfo = Gdn::themeManager()->getThemeInfo(theme());
    $themeRoot = $themeInfo['ThemeRoot'];

    $stylesheetLocation = '';

    foreach ($this->stylesheetFolders as $folder) {
      $dir = combinePaths([$themeRoot, $folder]);

      if (is_dir($dir)) {
        $stylesheetLocation = $dir;
        break;
      }
    }

    $styleguide = new \Scan\Kss\Parser(realpath($stylesheetLocation));

    $sender->setData('overview', $styleguide->getTopLevelSections());

    $section = (isset($args[0])) ? $args[0] : 0;

    try {
      $sender->setData('section', $styleguide->getSection($section));
      $sender->setData('children', $styleguide->getSectionChildren($section));
    }
    catch (Exception $ex) {
      // Do nothing.
    }

    $sender->MasterView = combinePaths([
      'plugins', $pluginFolder, 'views', 'styleguide'
    ]);

    $sender->render('index', 'styleguide', combinePaths([
      'plugins', $pluginFolder
    ]));
  }
}
