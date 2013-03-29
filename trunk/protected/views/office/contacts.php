<?php
$this->renderPartial('//office/_info');
?>
<div class="content">
	<table cellspacing="0" cellpadding="0" class="officeContent">
		<tr>
			<td class="mainblock2">
			<div class="contactsPage">
				<h1>Контактная информация</h1>
				<table border="0" cellspacing="13" cellpadding="0" class="contacts">
					<tr>
						<td class="label">Адрес:</td>
						<td class="value"><a href="#"><?=$model->getRegion()?></a></td>
					</tr>
                                        <?php
                                        foreach($model->contactsArray() as $name=>$val):
                                        ?>
					<tr>
						<td class="label"><?=$name?>:</td>
						<td class="value"><?=$val?></td>
					</tr>
                                        <?endforeach;?>
					<tr>
						<td class="label">Сайт:</td>
                                                <td class="value"><a target="_blank" href="<?=$this->createUrl('/my/go',array('url'=>urlencode($model->website)))?>"><?=$model->website?></a></td>
					</tr>
				</table>
                        <?if($model->lat>0):?>
			<h1><?=Yii::t('site','На карте');?></h1>
			<div id="map"><img src="/static/css/preload.gif" /></div>
                        <?endif;?>
			</div>
			</td>
			<td class="rightblock">
			<?$this->renderPartial('//office/_right_table',array());?>
			</td>
		</tr>
	</table>
</div>
<script>
<?if($model->lat>0):?>
var map;
var marker;
function placeMarker(location) {
    if (!marker){
        marker = new google.maps.Marker({
            position: location,
            map: map
        });
    } else {
        marker.setPosition(location);
    }
    return marker;
}
    /////////////////////////////////////////////////
    // DRAW A MAP
    /////////////////////////////////////////////////
$(function(){
    $('#map').height(427).width(427);
    $.getScript('//www.google.com/jsapi', function(G){
        google.load('maps','3',{other_params:'sensor=false','callback':function(){
                var loc = new google.maps.LatLng(<?=$model->lat?>, <?=$model->long?>);
                map = new google.maps.Map(document.getElementById("map"),{
                    zoom: 13,
                    center: loc,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                });
                placeMarker(loc)
            }
        })
    }).error(function(){$('#map').html('<div class="error">Ошибка загрузки карты. Попробуйте позднее.</div>');});
});
<?endif;?>
</script>