<?php defined('APPLICATION') or die;

$PluginInfo['HowToCustomModule'] = array(
    'Name' => 'HowTo: Custom Module',
    'Description' => 'Example for creating your own module.',
    'Version' => '0.1',
    'RequiredApplications' => array('Vanilla' => '>= 2.1'),
    'RequiredTheme' => false,
    'MobileFriendly' => true,
    'HasLocale' => false,
    'Author' => 'Robin Jurinka',
    'AuthorUrl' => 'http://vanillaforums.org/profile/44046/R_J',
    'License' => 'MIT'
);



/**
 * Shows how to create a custom module.
 *
 * You'll need two files: the plugin that inserts the module to the panel
 * and the module class. This file is the plugin which doesn't do much...
 *
 * @package HowToCustomModule
 * @author Robin Jurinka
 * @license MIT
 */
class HowToCustomModulePlugin extends Gdn_Plugin {
    const DISPLAY_CONTROLLERS = 'discussionscontroller,categoriescontroller';

    /**
     * This function is called every time before a controller is rendered.
     *
     * We will add our module here but restrict it to only be attached to
     * discussionsController and categoriesController.
     *
     * @param object $sender Garden Controller.
     * @return void.
     * @package HowToCustomModule
     * @since 0.1
     */
    public function base_render_before ($sender) {
        // Don't display if there is no panel or we are at the dashboard or
        // current controller is not in our list.
        if (
            !isset($sender->Assets['Panel']) ||
            $sender->MasterView == 'admin' ||
            !in_array(strtolower($sender->ControllerName), explode(',', self::DISPLAY_CONTROLLERS))
        ) {
            return;
        }

        // Add something to display to our module
        $exampleData = array(
            'first' => array(
                'content' => '<a href="#">Useless counter<span class="Aside"> <span class="Count">99</span></span></a>',
                'class' => ''
            ),
            'second' => array(
                'content' => 'Some list entry',
                'class' => ''
            ),
            'third' => array (
                'content' => '<a href="#">Look! A link!</a>',
                'class' => ''
            ),
            'forth' => array (
                'content' => 'This line is active',
                'class' => 'Active'
            )
        );
        $sender->setData('exampleData', $exampleData);

        // Get an instance of our module.
        $howToCustomModule = new HowToCustomModule($sender);

        // And now we simply add it!
        $sender->addModule($howToCustomModule);


        // We are ready here but there is something more to learn, if you like.
        // You can add as many modules as you like from your plugin and if you
        // look at the template (the default.master.tpl file) of your theme, you
        // normally will see {asset name="Head"}, {asset name="Panel"} and
        // {asset name="Foot"}. That's where you can place your modules.
        // While "Head" is in the head tag of the page and thus will not be
        // shown, you could decide to use "Foot" or the CategoriesModule, by
        // adding an "AssetTarget" to the addModule call:
        $categoriesModule = new CategoriesModule($sender);
        $sender->addModule($categoriesModule, 'Foot');

        // Great, but now we have it twice: in the Panel and in the Footer. So
        // lets delete it from the Panel:
        unset($sender->Assets['Panel']['CategoriesModule']);
    }
}
