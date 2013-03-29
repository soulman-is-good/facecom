<div class="head">        
    <h1>Скидки</h1>
    <div>
        <table cellspacing="0" cellpadding="0" class="officeContent">
                <tr>
                        <td class="leftblock">
                          <input name="Name" type="text" value="" class='qsearch' placeholder="Поиск товаров и услуг"><a href="#" class='qsearchIcon'>&nbsp;</a>
                        </td>
                        <td class="mainblock">
                            <select name="type" id="action_type">
                                <option value="">Категория</option>
                                <option value="1">Развлечения</option>
                                <option value="2">Спорт</option>
                                <option value="3">Туризм</option>
                                <option value="4">Отдых</option>
                                <option value="5">Детям</option>
                            </select>
                            <select name="schema" related="action_type">
                                <option>Все (100500)</option>
                                <option>Мужчинам (100500)</option>
                                <option>Женщинам (100500)</option>
                            </select>
                        </td>
                        <td width="250">
                            <a href="/business/discount/create" class="button">Создать предложение</a>
                        </td>
                </tr>
        </table>            
    </div>
</div>
<div class="content" style="min-height:500px;">
    <table width="100%" class="blocks" >
        <tr>
            <td class="right" width="212">
                <?$this->widget('WAdsBlock',array('mini'=>true));?>
            </td>
            <td class="text">
                <div id="sales" class="loading">
                </div>
                <div class="show_more">
                    <a id="more" href="#" class="button"><?=Yii::t('site','Загрузить еще');?>...</a>
                </div>
            </td>
        </tr>
    </table>
    <div class="clearfix" style="height:50px"><!----></div>
</div>
<script type="text/html" id="discount_tmpl">
    <div class="discount hidden">
        <div class="sale" style="background:url({{image}})">
            <div class="per"><i></i>{{discount}}<b></b></div>
            <?if(Yii::app()->user->role == 'admin'):?>
            <div class="info secret" style="bottom:auto;top:0"><div class="in-info">
                    <a style="float:right;margin-left:10px" class="delete" href="/business/discount/delete/{{id}}"><img src="/static/css/trashcan.gif" /></a>
                    <a style="float:right" href="/business/discount/edit/{{id}}"><img src="/static/css/pencil.gif" /></a>
            </div></div>
            <?endif;?>
            <div class="info"><div class="in-info">
                    <div class="fleft" data-time="{{timestamp}}">{{left}}</div>
                    <div class="fright"><span>{{bought}}</span></div>
                    <div class="clearfix">&nbsp;</div>
                </div></div>
            <a href="{{link}}"><img src="/static/css/_zero.gif" width="208" height="183" /></a>
        </div>
        <div class="desc">
            <div class="title">
                <a href="{{link}}">{{title}}</a>
            </div>
            {{description}}
        </div>
        <div class="more">
            <a href="{{link}}">Подробнее</a>
        </div>
    </div>
</script>