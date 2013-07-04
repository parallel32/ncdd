<?
    $sessions = $this->vars['sessions'];
    $user = $this->vars['user'];
?>
<script>
	$(document).ready(function(){        
        $('#form-submit').click(function(){
            var val = $('#userId').val(); 
            if(val != '') {
                window.location = '/admin/utilities/viewusersessions/'+val;
            }
        });
	});  
</script>
<form>
    <label>User Id:</label>
    <input id="userId" type="text" name="userId" style="width:300px;margin:0;"/>
    <button id="form-submit" class="btn btn-primary save" type="button">Submit</button>
</form>

<section id="upload">
    <?if(!empty($sessions)):?>
    <?foreach($sessions as $session):?>
        <?//='session_id: '.$session['session_id']?>    
        <? 
        echo "<pre>";
		echo "mongo id: ".$session['id']."\n";
		echo "session_id: ".$session['session_id']."\n";
		echo "active: ".$session['active']."\n";
		
		$tmp = $_SESSION;
		session_decode($session['data']);
		$data = $_SESSION;
		$_SESSION = $tmp;
		
		print_r($data);
		echo "</pre><br/><br/>";?>
    <?endforeach?>
    <?endif?>
    <?if(!empty($user)):?>
        <? echo "UserId: ".$user['_id']->__toString()."<pre>";print_r($user);echo "</pre><br/><br/><br/><br/>";?>
    <?endif?>    
</section>