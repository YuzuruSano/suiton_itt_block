<?php
defined("C5_EXECUTE") or die("Access Denied.");
$ih = Core::make('helper/image');
if($fIDItt){
	$fIDItt_obj = File::getByID($fIDItt);
	if($fIDItt_obj) $fIDItt_src = $fIDItt_obj->getThumbnailURL('full');
}
?>
<div id="itt_<?php echo $bID?>" class="item itt_item_<?php echo $bID?>">
	<p class="img"><img src="<?php echo $fIDItt_src;?>" alt="<?php echo $titleItt;?>"></p>
	<p class="title"><?php echo $titleItt;?></p>

	<div class="desc">
		<?php echo $descItt;?>
	</div>
</div>