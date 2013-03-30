<?php
$office = Yii::app()->params['office'];
$cats = Yii::app()->db->createCommand("
    SELECT c.name, c.title, COUNT(i.id) cnt FROM category c INNER JOIN items_category ic ON ic.category_id=c.id INNER JOIN items i ON i.id=ic.item_id WHERE i.office_id='$office->id' GROUP BY c.id
    ")->queryAll();

function isActive($tag){
    static $tags = 0;
    if($tags === 0)
        $tags = isset($_GET['tags']) ? explode('+', urldecode($_GET['tags'])) : array();
    return in_array($tag, $tags);
}
function append($tag){
    static $tags = 0;
    if($tags === 0)
        $tags = isset($_GET['tags']) ? explode('+', urldecode($_GET['tags'])) : array();
    if (false !== ($k = array_search($tag, $tags))) {
        $x = $tags;
        unset($x[$k]);
        return urlencode(implode('+', $x));
    }
    $x = $tags;
    $x[] = $tag;
    return urlencode(implode('+', $x));
}
$contacts = explode(';',$office->contacts);
foreach ($cats as $cat):
    ?>
    <a class="<?=isActive($cat['name'])?'active':''?>" href="<?= $this->createUrl('office/items/index', array('oid' => $office->id, 'tags' => append($cat['name']))) ?>"><?= $cat['title'] ?></a> <span class="count">(<?= $cat['cnt'] ?>)</span><br />
    <br />
<? endforeach; ?>
<h5>Контакты</h5>
<p>
    <b>Контактное лицо:</b><br />
<?= $office->user->profile->halfName ?>
</p>
<?foreach($contacts as $contact):
    $contact = explode(':',$contact);
if(isset(Office::$contacts[$contact[0]])):?>
<p>
    <b><?=Office::$contacts[$contact[0]]?>:</b><br />
    <?=$contact[1]?><br />
</p>
<?endif;endforeach;?>
<p>
    <b>Адрес:</b><br />
    <?=$office->region?>, <?=$office->address?>
</p>
<h5>Карта</h5>
<p>
    <div id="map" data-latlong="<?=$office->lat?>,<?=$office->long?>"></div>
</p>
