<?
/*echo $trace;
foreach($ivs as $iv){
	$questions=json_decode($iv->questions,true);
	?>
	<div class="ad">
        <span class="title"><?=$iv->title?></span><br /><br />
        <form name="iv<?=$iv->id?>" action="advert/interviews/useranswer" method="post" onSubmit="return ivAnswer('iv<?=$iv->id?>');">
        <?
        $cq=1;
        foreach($questions as $q){?>
        	<span class="text"><?=$q['question']?></span><br />
        	<?
        	foreach($q['answs'] as $ca=>$a){
        		?><input name="q[<?=$cq?>]" type="radio" value="<?=$ca?>" id="a<?=$cq.$ca?>" /><label for="a<?=$cq.$ca?>" class="graytext"><span><span></span></span><?=$a?></label><br /><?
        	}
        	$cq++;
        }
        ?>
        <center><input type="submit" value="отправить"></center>
        </form>
    </div>
<?}*/
?>

<div class="ad">
        <form name="iv" action="#" method="post" onSubmit="return false;">
        <div id="ivc">
        </div>
        </form>
    </div>