<?php
defined("C5_EXECUTE") or die("Access Denied.");
?>
<style>
  #area-tbody {
    border:#ccc solid 1px;
    padding: 6px 10px;
  }
  .form_col {
    margin-bottom: 15px;
  }

  .form-group .description {
    font-size:12px;
  }

  .form_col{
    /*overflow: hidden;*/
    /*margin:0;*/
    display: table;
    table-layout: auto;
  }
  .form_col .form-group{
    width: 40%;
    padding-right: 5px;
    display: table-cell;
    vertical-align: bottom;
  }
  .form_col .form-order-button{
    width: 15%;
    padding-right: 5px;
    display: table-cell;
    vertical-align: bottom;
  }
  .form_col .form-delete-button{
    width: 5%;
    display: table-cell;
    vertical-align: bottom;
  }

  .form_th{
    display: table;
    table-layout: auto;
    width: 100%;
  }
  .form_th >div{
    display: table-cell;
  }
  .form_th .w40{
    width: 40%;
    /*margin-right: 5px;*/
  }
  .form_th .w60{
    width: 60%;
    /*margin-right: 5px;*/
  }
  .form_th .w15{
    width: 15%;
    margin-right: 5px;
  }
  .form_th .w15{
    width: 5%;
  }

  div#ccm-file-manager-upload-prompt {
    position: static;
    text-align: left;
  }
</style>
<?php
$al = Loader::helper("concrete/asset_library");
$bf01 = null;

if ($controller->getFfIDItt() > 0) {
  $bf01 = $controller->getFfIDIttObject();
}
?>
<div class="form-group">
    <?php  echo $form->label("titleItt", t("タイトル")); ?>
    <?php  echo $form->text("titleItt", $titleItt, array ('maxlength' => 255,'placeholder' => NULL,
)); ?>
</div>

<div class="form-group">
  <label class="control-label"><?php echo t('画像')?></label>
  <?php echo $al->image('ccm-b01-image', 'fIDItt', t('Choose Image'), $bf01, $args);?>
</div>

<div class="form-group">
    <label class="control-label"><?php echo t('テキスト');?></label>
    <?php
        $editor = Core::make('editor');
        print $editor->outputStandardEditor('descItt', $descItt);
    ?>
</div>

<div class="form-group">
  <?php echo $form->label('imageLinkType', t('Image Link'))?>
  <select name="linkType" id="imageLinkType" class="form-control" style="width: 60%;">
    <option value="0" <?php echo (empty($externalLinkItt) && empty($internalLinkCIDItt) ? 'selected="selected"' : '')?>><?php echo t('None')?></option>
    <option value="1" <?php echo (empty($externalLinkItt) && !empty($internalLinkCIDItt) ? 'selected="selected"' : '')?>><?php echo t('Another Page')?></option>
    <option value="2" <?php echo (!empty($externalLinkItt) ? 'selected="selected"' : '')?>><?php echo t('External URL')?></option>
  </select>
</div>

<div id="imageLinkTypePage" style="display: none;" class="form-group">
  <?php echo $form->label('internalLinkCIDItt', t('Choose Page:'))?>
  <?php echo Loader::helper('form/page_selector')->selectPage('internalLinkCIDItt', $internalLinkCIDItt); ?>
</div>

<div id="imageLinkTypeExternal" style="display: none;" class="form-group">
  <?php echo $form->label('externalLinkItt', t('URL'))?>
  <?php echo $form->text('externalLinkItt', $externalLinkItt, array('style'=>'width: 60%;')); ?>
</div>

<script type="text/javascript">
refreshImageLinkTypeControls = function() {
  var linkType = $('#imageLinkType').val();
  $('#imageLinkTypePage').toggle(linkType == 1);
  $('#imageLinkTypeExternal').toggle(linkType == 2);
}

$(document).ready(function() {
  $('#imageLinkType').change(refreshImageLinkTypeControls);

    $('div[data-checkbox-wrapper=constrain-image] input').on('change', function() {
        if ($(this).is(':checked')) {
            $('div[data-fields=constrain-image]').show();
        } else {
            $('div[data-fields=constrain-image]').hide();
        }
    }).trigger('change');
  refreshImageLinkTypeControls();
});
</script>