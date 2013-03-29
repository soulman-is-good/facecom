<div class="chat">
    <div class="title">
        <img src="/static/css/onlineStatus.png" alt="" class="online" />
        <img src="/static/css/arrowInCircle.png" alt="" class="options" />
        <?=$profile->halfName?>
    </div>
    <div class="usersListContainer">
        <div class="chatScroll">
            <div class="item" id="chatuser<?=$profile->user_id?>" style="display:none">
                <img src="<?=$profile->getAvatar('micro')?>" width="32" alt="" />
                <div class="name"><?=$profile->halfName?></div>
            </div>            
            <?
            $friendkeys = array();
            foreach($users as $user):
                $friendkey = $user->user->activation_key.'x1x'.$user->user_id;
                $friendkeys[$friendkey] = $user->user_id;
                ?>
            <div class="item" id="chatuser<?=$user->user_id?>">
                <div class="status" style="display:none"></div>
                <img src="<?=$user->getAvatar('micro')?>" width="32" alt="" />
                <div class="name">
                    <a href="#message" data-key="<?=$friendkey?>" data-id="<?=$user->user_id?>">
                    <span class="online">
                        <?=$user->halfName?>
                    </span>
                    </a>
                </div>
                <div class="unread" style="display:none">
                    <img src="/static/css/unread.png" alt="" /> <span></span>
                </div>
            </div>
            <?endforeach;?>
        </div>
    </div>
</div>
<?php
Yii::app()->clientScript->registerScriptFile('/static/js/jquery.mb.emoticons.js');
Yii::app()->clientScript->registerScriptFile('/static/js/socket.io.js');
$friendkeys = CJSON::encode($friendkeys);
$script = <<<DATA
            var chat = null;
            $(function(){
                
                $('.chatScroll .item').click(function(){
                    var a = $(this).find('.name a');
                    a.openChat();
                    return false;
                    var key = a.data('key');
                    var msg = prompt('Введите сообщение:', '');
                    chat.emit('publish',{key:key,message:msg});
                    return false;
                })
                
                chat = io.connect('http://facecom.local/chat',{port:10010});

                chat.on('connect', function (o) {
                    chat.emit('setup',{key:'{$profile->user->activation_key}x1x{$profile->user_id}',friends:{$friendkeys}});
                });
                chat.on('status',function(data){
                    switch(data.status){
                        case 0:
                            $('#chatuser'+data.id).children('.status').css('display','none');
                        break;
                        case 1:    
                            $('#chatuser'+data.id).children('.status').css('display','block');
                        break;
                        default:
                            $('#chatuser'+data.id).children('.status').css('display','none');
                    }
                    chat.emit('iamonline',{key:'{$profile->user->activation_key}x1x{$profile->user_id}'});
                });
                chat.on('line',function(data){
                    $('#chatuser'+data.id).children('.status').css('display','block');
                });
                chat.on('publish',function(data){
                    if(typeof $.chats[data.key] != 'undefined'){
                        $.chats[data.key].print(data);
                        chat.emit('has read',{id:data.mid});
                    }else{
                        var count = parseInt($('#chatuser'+data.id+' .unread span').text().replace('+','')) || 0;
                        count++;
                        $('#chatuser'+data.id+' .unread span').html('+'+count).parent().css('display','block');
                        $('#chatuser'+data.id).animate({backgroundColor:'#FFF69E'},function(){ $('#chatuser'+data.id).animate({backgroundColor:'#F7F7F7'})})
                    }
                })
                chat.on('messages',function(data){
                    var tmp = null;
                    if(typeof $.chats[data.key] == 'undefined')
                        $('#chatuser'+data.id+' a').openChat()
                    tmp = $('#chatuser'+data.id+' a').data('chat');
                    tmp.clearBody();
                    for(i in data.messages){
                        var msg = data.messages[i];
                        tmp.print({msg:msg.text, time:msg.time, id:msg.from,hasRead:!!msg.hasRead})
                    }
                    $('#chatuser'+data.id+' .unread span').html('').parent().css('display','none');
                })
                chat.on('count',function(data){
                    console.log(data);
                    if(data.count>0){
                        $('#chatuser'+data.id+' .unread span').html('+'+data.count).parent().css('display','block');
                    }else
                        $('#chatuser'+data.id+' .unread span').html('').parent().css('display','none');
                })
            })
DATA;
Yii::app()->clientScript->registerScript('facecom-chat',$script,  CClientScript::POS_END);
?>
<script>
    $.chats = {};
    $.fn.openChat = function(data){
        var self = this;
        if(typeof $('#'+$(this).data('key'))[0] != 'undefined'){
            return this;
        }
        var myId = <?=Yii::app()->user->id?>;
        var div = null;
        var body = null;
        var texter = null;
        var textarea = null;
        var smiles = null;
        this.last_day = 0;
        this.close = function(){
            if(!!smiles.data('smilesIsOpen'))
                smiles.data('smilesBox').removeSmilesBox();
            body.animate({'height':'0px'},function(){
                div.fadeOut(function(){
                    delete $.chats[$(self).data('key')];
                    delete $(self).data('chat');
                    $.chats.length--;
                    self.redraw();
                    $(this).remove();
                })
            })
        }
        this.clearBody = function(){
            body.html('');
        }
        this.print = function(data){
            appendMessage(data.msg,data.time,data.id,!!data.hasRead);
        }
        this.getContents = function(){
            return div;
        }
        this.redraw = function(){
            var i = 0;
            for(x in $.chats){
                if(typeof $.chats[x].getContents == 'function'){
                    $.chats[x].getContents().animate({'left':(i*320 + 10)+'px'},100)
                    i++;
                }
            }
        }
        if(typeof $('#'+$(this).data('key'))[0] != 'undefined'){
            div = $('#'+$(this).data('key'));
            body = div.find('.chatBody');
            texter = div.find('.chatMessenger');
            smiles = texter.find('.chatSmiles');
            textarea = texter.find('.chatArea');
            self.data('chat',this);
            div.fadeIn();
            body.animate({'height':'300px'},function(){body.scrollTop(99999999);})
        }else {
            div = $('<div />').attr({'id':$(this).data('key')}).addClass('chatWindow');
            div.append($('<div />').addClass('chatHeader').append(
                $('<a href="#close"><img src="/static/css/close.png" title="Закрыть" /></a>').click(function(){self.close();return false;})
            ).append('<span>'+$(this).parent().text()+'</span>'));
            body = $('<div />').addClass('chatBody');
            texter = $('<div />').addClass('chatMessenger');
            textarea = $('<textarea />').addClass('chatArea').attr({'cols':'50','rows':'1','maxlength':'256'}).autosize();
            textarea.keydown(function(e){
                if($(this).val().length>256)
                    $(this).val($(this).val().slice(0,255));
                if(e.keyCode == 13 && $(this).val().replace(/^\s+|\s+$/,'')!=''){
                    chat.emit('publish',{key:self.data('key'),message:$(this).val()});
                    appendMessage($(this).val(),null,myId);
                    $(this).val('');
                }
            }).keyup(function(e){
                if(e.keyCode == 13)
                    $(this).val('');
            });
            smiles = $('<div />').addClass('chatSmiles');
            texter.append(textarea);
            texter.append(smiles);
            div.append(body);
            div.append(texter);
            if($.chats.length*320 + 250 > $(window).width()){
                div.css({'left':'10px','z-index':$.chats.length});
            }else
                div.css({'left':($.chats.length*320 + 10)+'px','z-index':$.chats.length})            
            $('body').append(div);
            $(this).data('chat',this);
            self.data('chat',this);
            textarea.focus();
            smiles.mbSmilesBox(textarea);
            chat.emit('get messages',{key:$(this).data('key')});
        }
        function appendMessage(text,time,from,hasRead){
            var msg = $('<div />').addClass('chatMessage');
            var cu = $('#chatuser'+from);
            var ava = cu.find('img').attr('src');
            var name = cu.find('.name').text();
            var d = ((typeof time == 'undefined' || time == null)?new Date():new Date(time));
            var day = d.getFullYear() + (d.getMonth()*30 + d.getDate());
            if(self.last_day<day){
                self.last_day = day;
                body.append($('<div />').addClass('datestamp').append($.i18n.formatDate( d, "dd MMMM yyyy", {region:'<?=Yii::app()->language?>'} )))
            }
            msg.append($('<div />').addClass('chatTime').append('<span>'+('0' + d.getHours()).slice(-2)+':'+('0'+d.getMinutes()).slice(-2)+'</span>'))
            msg.append($('<div />').addClass('chatMessageContent').append(
                '<img class="chatAvatar" src="'+ava+'" alt="" title="'+name+'" />'
            ).append($('<div />').append(text).emoticonize(true)));
            body.append(msg);
            body.scrollTop(99999999);
            if(!hasRead && from != myId)
                msg.animate({backgroundColor:'#FFF69E'},function(){msg.animate({backgroundColor:'#FFFFFF'})})
        }
        if(!!data && data.hasOwnProperty('msg')){
            appendMessage(data.msg,data.time,data.id);
        }
        $.chats[$(this).data('key')] = this;
        $.chats.length++;
        return this;
    }
    $.chats.length = 0;
    $.chats.get = function(i){
        if(i == 'last'){
            var last = false;
            for(k in $.chats)
                last = $.chats[k];
            return last;
        }
        if(i == 'first')
            for(k in $.chats)
                return $.chats[k];
        if(!isNaN(i)){
            var j = 0;
            for(k in $.chats)
                if(j++ == i)
                    return $.chats[k];
        }else
            return $.chats[i] || false;
    }
</script>
















