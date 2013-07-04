<?
// use like this in a view file:  
//<?=$this->element('form-elements', array('elements'=>$this->vars['elements']));?>
?>
<? foreach($elements as $key=>$value): ?>
	<div class="control-group">
	  <label class="control-label"><?=$key?></label>
	  <div class="controls">
	     <input type="text" name="doc[<?=$key?>]" class="span6 m-wrap <?=$key?>" value="<?=$value?>">
	  </div>
	</div>
<? endforeach; ?>