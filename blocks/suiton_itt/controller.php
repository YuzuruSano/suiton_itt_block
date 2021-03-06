<?php
namespace Concrete\Package\SuitonIttBlock\Block\SuitonItt;

defined("C5_EXECUTE") or die("Access Denied.");

use Concrete\Core\Block\BlockController;
use Core;
use Loader;
use \File;
use Page;
use Concrete\Core\Editor\LinkAbstractor;

class Controller extends BlockController
{
    public $helpers = array (
      0 => 'form',
    );
        public $btFieldsRequired = array (
      0 => 'categoryName',
    );
        protected $btExportFileColumns = array (
      0 => 'menuImage',
    );
    protected $btTable = 'btItt';
    protected $btInterfaceWidth = 600;
    protected $btInterfaceHeight = 600;
    protected $btCacheBlockRecord = true;
    protected $btCacheBlockOutput = true;
    protected $btCacheBlockOutputOnPost = true;
    protected $btCacheBlockOutputForRegisteredUsers = true;
    protected $btCacheBlockOutputLifetime = 0;
    protected $btExportPageColumns = array('internalLinkCIDItt');

    public function getBlockTypeDescription()
    {
        return t("タイトル+画像+テキストのセットで登録可能なブロック");
    }

    public function getBlockTypeName()
    {
        return t("Suiton ITT");
    }

    public function getSearchableContent()
    {
        $content = array();
        $content[] = $this->titleItt;
        $content[] = $this->descItt;
        return implode(" ", $content);
    }

    public function br2nl($str)
    {
        $str = str_replace("\r\n", "\n", $str);
        $str = str_replace("<br />\n", "\n", $str);

        return $str;
    }

    public function view()
    {
        $this->set('linkURL', $this->getLinkURL());
    }

    public function getContentEditMode()
    {
        return LinkAbstractor::translateFromEditMode($this->content);
    }

    public function getImportData($blockNode, $page)
    {
        $content = $blockNode->data->record->descItt;
        $content = LinkAbstractor::import($content);
        $args = array('content' => $content);

        return $args;
    }

    public function getFfIDItt()
    {
        return $this->fIDItt;
    }

    public function getFfIDIttObject()
    {
        return File::getByID($this->fIDItt);
    }

    public function getExternalLink()
    {
        return $this->externalLinkItt;
    }

    public function getInternalLinkCID()
    {
        return $this->internalLinkCIDItt;
    }

    public function getLinkURL()
    {
        if (!empty($this->externalLinkItt)) {
            $sec = \Core::make('helper/security');

            return $sec->sanitizeURL($this->externalLinkItt);
        } elseif (!empty($this->internalLinkCIDItt)) {
            $linkToC = Page::getByID($this->internalLinkCIDItt);

            return (empty($linkToC) || $linkToC->error) ? '' : Core::make('helper/navigation')->getLinkToCollection($linkToC);
        } else {
            return '';
        }
    }

    public function export(\SimpleXMLElement $blockNode)
    {
        $data = $blockNode->addChild('data');
        $data->addAttribute('table', $this->btTable);
        $record = $data->addChild('record');
        $cnode = $record->addChild('descItt');
        $node = dom_import_simplexml($cnode);
        $no = $node->ownerDocument;
        $content = LinkAbstractor::export($this->descItt);
        $cdata = $no->createCDataSection($content);
        $node->appendChild($cdata);
    }

    public function save($args) {
        $args = $args + array(
            'fIDItt' => 0,
            'linkType' => 0,
            'externalLinkItt' => '',
            'internalLinkCIDItt' => 0,
        );
        $args['fIDItt'] = ($args['fIDItt'] != '') ? $args['fIDItt'] : 0;

         if(isset($args['descItt'])) {
            $args['descItt'] = LinkAbstractor::translateTo($args['descItt']);
        }
        switch (intval($args['linkType'])) {
            case 1:
                $args['externalLinkItt'] = '';
                break;
            case 2:
                $args['internalLinkCIDItt'] = 0;
                break;
            default:
                $args['externalLinkItt'] = '';
                $args['internalLinkCIDItt'] = 0;
                break;
        }
        unset($args['linkType']); //this doesn't get saved to the database (it's only for UI usage)
        //親クラスのメソッドを呼び出して保存
        parent::save($args);
    }
}