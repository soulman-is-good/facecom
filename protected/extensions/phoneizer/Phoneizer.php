<?php
class Phoneizer extends CWidget {

    public $attribute;
    public $value;
    public $alike = null;
    public $node = 'span.aphone';
    public $script = array('delete'=>'.parent("{NODE}")');
    public $tpl = '<div class="template" id="{ID}_tmp">{TPL}</div>';
    public $content = '<span class="aphone">{C_CODE}{T_CODE}{TEL}{INNER}{DELETE}</span>';
    public $inputs = array(
        'C_CODE'=>'<input name="{NAME}[\'+idx+\'][c_code]" type="text" class="c_code" style="width:32px;" />',
        'T_CODE'=>'<input name="{NAME}[\'+idx+\'][t_code]" type="text" class="t_code" style="width:64px;" />',
        'TEL'=>'<input name="{NAME}[\'+idx+\'][tel]" type="text" class="tel" style="width:128px;" />',
        'INNER'=>'<input name="{NAME}[\'+idx+\'][inner]" type="text" class="inner" style="width:32px;" />'
    );
    public $label = array(
        'addphone'=>'Добавить',
        'deletephone'=>'Удалить',
        'addanchor'=>'<div class="navigation"><a class="add" href="javascript:void(0)" id="{ID}_add">{TITLE}</a></div>',
        'delanchor'=>'<a href="javascript:void(0)"><img src="/images/sysimgs/16/delete.png" alt="{TITLE}"></a>'
    );
    public $_label = array(
        'addphone'=>'Добавить',
        'deletephone'=>'Удалить',
        'addanchor'=>'<div class="navigation"><a class="add" href="javascript:void(0)" id="{ID}_add">{TITLE}</a></div>',
        'delanchor'=>'<a href="javascript:void(0)"><img src="/images/sysimgs/16/delete.png" alt="{TITLE}"></a>'
    );

    public function run() {

        $baseDir = dirname(__FILE__);
        $assets = Yii::app()->getAssetManager()->publish($baseDir . DIRECTORY_SEPARATOR . 'source');
        //Yii::app()->clientScript->registerCoreScript('j');
        Yii::app()->clientScript->registerCssFile($assets . '/css/phonizer.css');
        Yii::app()->clientScript->registerScriptFile($assets.'/js/pure.js');
        
        $name = $this->attribute;
        $this->attribute = str_replace("[","_",$this->attribute);
        $this->attribute = str_replace("]","",$this->attribute);
        $i=0;

        if(is_array($this->value) && !empty($this->value))
            $this->value = json_encode(array_merge($this->value));
        elseif(json_decode($this->value)==null)
            $this->value='[{"c_code":"","t_code":"","tel":"","inner":""}]';
        
        if ($this->alike!=null) {
            $alike = $this->alike['id'];
            $lk = "$('<input type=\"checkbox\" id=\"{$this->attribute}_alike\" name=\"{$this->attribute}_alike\" style=\"width:16px\" />').click(function(){
                    var data = data_{$alike};
                    $('#{$this->attribute}_tmp span.aphone:not(:first)').remove();
                    if(this.checked) {
                        $('#{$this->attribute}_tmp span').hide();
                        if (data.phones[0].tel=='') {
                        data.phones = new Array();
                            $('#{$alike}_tmp span').each(function(i){
                                var json = {c_code:'',t_code:'',tel:''};
                                json.c_code = $(this).children('[name*=\"c_code\"]').val();
                                json.t_code = $(this).children('[name*=\"t_code\"]').val();
                                json.tel    = $(this).children('[name*=\"tel\"]').val();
                                json.inner    = $(this).children('[name*=\"inner\"]').val();
                                data.phones.push(json);
                            });
                        }
                        $('#{$this->attribute}_tmp').render(data,directive_{$this->attribute});
                    } else {
                        data_{$this->attribute}.phones= new Array({c_code:'',t_code:'',tel:''});
                        $('#{$this->attribute}_tmp').render(data_{$this->attribute},directive_{$this->attribute});
                       $('#{$this->attribute}_tmp {$this->node}').show();
                    }
                }).insertBefore('#$this->attribute').wrap('<div style=\"display:inline;\"></div>');
                $('<label for=\"{$this->attribute}_alike\">{$this->alike['label']}</label>').insertBefore('#$this->attribute')";
        }
        $this->label=array_replace($this->_label, $this->label);
        $this->inputs['C_CODE']=str_replace('{NAME}', $name, $this->inputs['C_CODE']);
        $this->inputs['T_CODE']=str_replace('{NAME}', $name, $this->inputs['T_CODE']);
        $this->inputs['TEL']=str_replace('{NAME}', $name, $this->inputs['TEL']);
        $this->inputs['INNER']=str_replace('{NAME}', $name, $this->inputs['INNER']);
        
        $this->tpl = str_replace('{ID}',$this->attribute,$this->tpl);
        $this->content = str_replace('{C_CODE}',$this->inputs['C_CODE'],$this->content);
        $this->content = str_replace('{T_CODE}',$this->inputs['T_CODE'],$this->content);
        $this->content = str_replace('{TEL}',$this->inputs['TEL'],$this->content);
        $this->content = str_replace('{INNER}',$this->inputs['INNER'],$this->content);

        $del=str_replace("{TITLE}",$this->label['deletephone'],$this->label['delanchor']);
        $add=str_replace("{TITLE}",$this->label['addphone'],$this->label['addanchor']);
        $add=str_replace("{ID}",$this->attribute,$add);

        $this->content = str_replace('{DELETE}',$del,$this->content);
        $this->tpl = str_replace('{TPL}',$this->content,$this->tpl);
        $this->script['delete']=str_replace('{NODE}',$this->node,$this->script['delete']);
        $js = "
                var idx = 0;

                var directive_{$this->attribute} = {
                    '{$this->node}':{
                        'phone <- phones': {
                            'input.c_code@value':'phone.c_code',
                            'input.c_code@name':function(i){idx = i.pos;return '{$name}['+i.pos+'][c_code]'},
                            'input.t_code@value':'phone.t_code',
                            'input.t_code@name':function(i){return '{$name}['+i.pos+'][t_code]'},
                            'input.tel@value':'phone.tel',
                            'input.tel@name':function(i){return '{$name}['+i.pos+'][tel]'},
                            'input.inner@value':'phone.inner',
                            'input.inner@name':function(i){return '{$name}['+i.pos+'][inner]'}
                        }
                    }
                };
                var data_{$this->attribute} = {phones:$this->value};

                {$lk}

                $('{$this->tpl}')
                                    .insertBefore('#$this->attribute')
                                    .render(data_{$this->attribute},directive_{$this->attribute});
                $('$add').insertAfter('#{$this->attribute}_tmp')
                $('#{$this->attribute}_add').live('click',function(){
                    var nav = $('#{$this->attribute}_tmp')
                    idx++;
                         nav.append('{$this->content}');
                });
                $('#{$this->attribute}_tmp {$this->node} a').live('click',function(){
                    $(this){$this->script['delete']}.remove();
                });
                $('#$this->attribute').remove();
               ";
        Yii::app()->clientScript->registerScript('Yii.' . get_class($this) . '#'.$this->attribute, $js, CClientScript::POS_READY);
    }

    public function getdeletephone() {
        return str_replace("{TITLE}",$this->label['deletephone'],$this->label['delancor']);
    }

    public function getaddphone() {
        return str_replace("{TITLE}",$this->label['addphone'],$this->label['addancor']);
    }

}

?>
