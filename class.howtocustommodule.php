<?php defined('APPLICATION') or die;

/**
 * A custom module that is displayed in the panel.
 *
 * Instead of using a plugin to add it to an Asset, you can also add
 * {module name="HowToCustomModuleModule"} anywhere in the default.master.tpl.
 * I find naming difficult. Your module should end with the word "Module" and I
 * would prefix it with the plugins name. But if your plugin already ends with
 * "...Module", you would come up with "...ModuleModule". In such a case you
 * might want to simplify the naming like I have done here by using only one
 * "Module" in the name.
 *
 * @package HowToCustomModule
 * @author Robin Jurinka
 * @license MIT
 */
class HowToCustomModule extends Gdn_Module {
    // We will pass our example data to this var in __construct().
    protected $exampleData;

    /**
     * For a simple module, you would not need this. But if you pass data or you
     * would like to use views, you need this function.
     *
     * @param object $sender Garden Controller.
     * @param string $applicationFolder Name of the plugins folder.
     * @package HowToCustomModule
     * @since 0.1
     */
    public function __construct ($sender = '', $applicationFolder = '') {
        // Get the example Data passed with the controller and store it in a
        // local var because otherwise we wouldn't be able to access it easily
        // when we need it.
        $this->exampleData = $sender->data('exampleData');

        // You can use internal functions for fetching the current modules view
        // if you stick to some rules. In order to use this functions, you would
        // have to pass this plugins path to the module.
        $applicationFolder = 'plugins/HowToCustomModule';

        // Pass our information to Gdn_Module so that they will be processed
        parent::__construct($sender, $applicationFolder);
    }

    /**
     * Only purpose is to return the AssetTarget which must be defined in the
     * template like that: {asset name="Panel"} for example.
     * Vanilla normaly has AssetTarget "Head" which is in <head></head>, "Panel"
     * which is the Panel/sidebar whatever you call it, "Foot" which is the
     * footer of the page.
     *
     * @return string Asset which should be defined in default.master.tpl.
     * @package HowToCustomModule
     * @since 0.1
     */
    public function assetTarget () {
        return 'Panel';
    }

    /**
     * The string returned by this function is what is displayed in the
     * AssetTarget.
     *
     * @return string HTML to display in the AssetTarget
     * @package HowToCustomModule
     * @since 0.1
     */
    public function toString () {
        // All output that is echoed in this function are written to the
        // AssetTarget. You can either work with echoing here or you can use a
        // view. If you have set the applicationFolder in __construct(), you
        // would be able to echo the view called like your module in the
        // subfolder /views/modules, but with the "module" stripped from the end
        // (/plugins/HowToCustomModule/views/modules/howtocustom.php in
        // our case).
        // That is where naming really becomes hard. We tried to avoid that
        // "...ModuleModule" madness, and now the name of our view is ridiculous.
        // You either have to choose the name wisely or don't care at all,
        // because in the end it nobody cares for the name of a great plugin ;)
        // Try to uncomment the next line to see the magic.
        // return  $this->FetchView();

        // The function FetchView is called by default by the Gdn_Module so you
        // can also simply use this line:
        return parent::ToString();
        // It will return the content of the file views/modules/howtocustom.php
        // comment it out if you like to see the results of our output below.

        // But we have a real simple module and that's why we simply do the
        // output here in this module.
        // You should wrap your output in a div.Box.YourModuleName, so that its
        // styling fits to other modules. They all should be wrapped inside a
        // div.Box. Your own styling should be done with .YourModuleName {}.
        // The heading of your module should be h4.
        // If you use lists, use.ul.PanelInfo and, if needed li.Active.
        ob_start();
        ?>
        <div class="Box HowToCustomModule">
            <h4>Hello World</h4>
            <ul class="PanelInfo">
                <?php
                foreach ($this->exampleData as $data) {
                    echo Wrap($data['content'], 'li', array('class' => $data['class']));
                }
                ?>
            </ul>
        </div>
        <?php
        return ob_get_clean();
    }
}