<?php
namespace Concrete\Package\SuitonIttBlock;

use Package;
use BlockType;
use Loader;
use Core;
use User;
use Page;
use UserInfo;
use Exception;
use Concrete\Core\Block\BlockController;
use Route;
use Router;
use Database;

defined('C5_EXECUTE') or die("Access Denied.");

class Controller extends Package
{

    protected $pkgDescription = "Image + Title + RichText block";
    protected $pkgName = "Suiton ITT Block";
    protected $pkgHandle = 'suiton_itt_block';
    protected $appVersionRequired = '5.7.3.1';
    protected $pkgVersion = '1.0.0';


    public function install()
    {
        // Run default install process
        $pkg = parent::install();
        $bt = BlockType::getByHandle('suiton_itt');
        if (!is_object($bt)) {
            $bt = BlockType::installBlockType('suiton_itt', $pkg);
        }
    }

    public function upgrade()
    {
        $pkg = $this->getByID($this->getPackageID());
        parent::upgrade();
    }

    public function uninstall() {
        parent::uninstall();
        $db = Loader::db();
        //$db->Execute('DROP TABLE btFormSuitonForm');
    }
}
