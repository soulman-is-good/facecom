
/*******************************************************************************
 jquery.mb.components
 Copyright (c) 2001-2010. Matteo Bicocchi (Pupunzi); Open lab srl, Firenze - Italy
 email: info@pupunzi.com
 site: http://pupunzi.com

 Licences: MIT, GPL
 http://www.opensource.org/licenses/mit-license.php
 http://www.gnu.org/licenses/gpl.html
 ******************************************************************************/

/*
 * Name:jquery.mb.emoticons
 * Version: 1.0
 */


(function($) {
  jQuery.mbEmoticons= {
    author:"Matteo Bicocchi",
    version:"1.0",
    smilesPath:"/static/",
    smiles: {
      "(angel)":      "angel",
      ":@ ":          "angry",
      "(bandit)":     "bandit",
      "(bear)":       "bear",
      "(beer)":       "beer",
      ":D ":          "bigsmile",
      "(bow)":        "bow",
      "(u)":          "brokenheart",
      "(bug)":        "bug",
      "(^)":          "cake",
      "(call)":       "call",
      "(cash)":       "cash",
      "(clap)":       "clapping",
      "(coffee)":     "coffee",
      "8-) ":         "cool",
      ";( ":          "crying",
      "(dance)":      "dance",
      "(devil)":      "devil",
      "(doh)":        "doh",
      "(drink)":      "drink",
      "(drunk)":      "drunk",
      "(dull)":       "dull",
      "(blush)":      "eblush",
      "(emo)":        "emo",
      "(envy)":       "envy",
      "]:) ":         "evilgrin",
      "(F)":          "flower",
      "(fubar)":      "fubar",
      "(giggle)":     "giggle",
      "(handshake)":  "handshake",
      "(happy)":      "happy",
      "(headbang)":   "headbang",
      "(heart)":      "heart",
      "(heidy)":      "heidy",
      "(hi)":         "hi",
      "(inlove)":     "inlove",
      "(wasntme)":    "itwasntme",
      "(kiss)":       "kiss",
      ":x ":          "lipssealed",
      "(mail)":       "mail",
      "(makeup)":     "makeup",
      "(finger)":     "middlefinger",
      "(mmm)":        "mmm",
      "(mooning)":    "mooning",
      "(~)":          "movie",
      "(muscle)":     "muscle",
      "(music)":      "music",
      "(myspace)":    "myspace",
      "8-| ":         "nerd",
      "(ninja)":      "ninja",
      "(no)":         "no",
      "(nod)":        "nod",
      "(party)":      "party",
      "(phone)":      "phone",
      "(pizza)":      "pizza",
      "(poolparty)":  "poolparty",
      "(puke)":       "puke",
      "(punch)":      "punch",
      "(rain)":       "rain",
      "(rock)":       "rock",
      "(rofl)":       "rofl",
      ":( ":          "sadsmile",
      "(shake)":      "shake",
      "(skype)":      "skype",
      "|-) ":         "sleepy",
      "(smile)":      "smile",
      "(smirk)":      "smirk",
      "(smoke)":      "smoke",
      ":| ":          "speechless",
      "(*)":          "star",
      "(sun)":        "sun",
      ":O ":          "surprised",
      "(swear)":      "swear",
      "(sweat)":   "sweating",
      "(talk)":       "talking",
      "(think)":      "thinking",
      "(o)":          "time",
      "(tmi)":        "tmi",
      "(toivo)":      "toivo",
      ":P ":          "tongueout",
      "(wait)":       "wait",
      "(whew)":       "whew",
      "(wink)":       "wink",
      ":^) ":         "wondering",
      ":S ":          "worried",
      "(yawn)":       "yawn",
      "(yes)":        "yes"
    },
    smilesPlusVariations: {
        ":-)": "smile",
        ":)": "smile",
        "0:-)":"angel",
        "0:)":"angel"
    }
    ,
    getRegExp:function(){
      var ret="/";
      $.each($.mbEmoticons.smilesPlusVariations,function(i){
        var emot= i.replace(/\)/g,"\\)").replace(/\(/g, "\\(").replace(/\|/g, "\\|").replace(/\*/g, "\\*").replace(/\^/g, "\\^");
        ret +="("+emot+")|";
      });
      ret+="/g";
      return eval(ret);
    },
    addSmilesBox:function(textarea){
        var wrapper=$(this);

        textarea.data("caret",textarea.caret());
        wrapper.data("smilesIsOpen",false);
        wrapper.data("textarea",textarea);
        var smilesBox=null;
        if(typeof $('.mbSmilesBox')[0] == 'undefined'){
            smilesBox = $("<div/>").addClass("mbSmilesBox").hide();
            $.each($.mbEmoticons.smiles,function(i){
              var emoticon=$("<span/>").addClass("emoticon").html(i).attr("title",i);
              smilesBox.append(emoticon);
              emoticon.emoticonize().data("emoticon",i);
            });
            smilesBox.find(".emoticon").each(function(){
              var icon=$(this);
              $(this)
                .hover(
                    function(){
                        var src= $(this).find("img").attr("src").replace(".png",".gif");
                        $(this).find("img").attr("src",src);
                    },
                    function(){
                        var src= $(this).find("img").attr("src").replace(".gif",".png");
                        $(this).find("img").attr("src",src);
                })
                .click(function(){
                    insertAtCaret.call(smilesBox.data("textarea")," "+icon.data("emoticon")+" ");
                });
            });            
            $('body').append(smilesBox);
        }else {
            smilesBox = $('.mbSmilesBox');
        }
        var smilesButton=$("<span/>").addClass("mbSmilesButton").html(":-)").emoticonize();
        smilesButton.click(function(){
          wrapper.mbOpenSmilesBox();
        });
        wrapper.append(smilesButton);
        wrapper.data("smilesBox",smilesBox);
        textarea.focus();
        textarea.caret(textarea.data("caret"));
      return this;
    },

    openSmileBox:function(){
      var textarea = $(this);
      var smilesBox= textarea.data("smilesBox");
      smilesBox.data('textarea',$(this).data('textarea'))
      $(this).data("smilesIsOpen",true);
      var left= (textarea.parents('.chatWindow').position().left+50);
      smilesBox.css({left:left});
      smilesBox.fadeIn();
      smilesBox.addClass('shown');
      setTimeout(function(){
        $(document).one("click",function(){textarea.mbCloseSmilesBox();});
      },100);
    },

    removeSmilesBox:function(callback){
    $(document).unbind("click");
      $(this).data("smilesIsOpen",false);
      var smilesBox= $(this).data("smilesBox");
      smilesBox.removeClass('shown');
      smilesBox.fadeOut(500,callback);
    }
  };

  var insertAtCaret = function (tagName) {
      if (document.selection) {
        //IE support
        this[0].focus();
        sel = document.selection.createRange();
        sel.text = tagName;
        this[0].focus();
      }else if (this[0].selectionStart || this[0].selectionStart == '0') {
        //MOZILLA/NETSCAPE support
        startPos = this[0].selectionStart;
        endPos = this[0].selectionEnd;
        scrollTop = this[0].scrollTop;
        this[0].value = this[0].value.substring(0, startPos) + tagName + this[0].value.substring(endPos,this[0].value.length);
        this[0].focus();
        this[0].selectionStart = startPos + tagName.length;
        this[0].selectionEnd = startPos + tagName.length;
        this[0].scrollTop = scrollTop;
      } else {
        this[0].value += tagName;
        this[0].focus();
      }
      return this;
  };

    jQuery.fn.caret = function(pos) {
    var target = this[0];
    var range = null;
    if (arguments.length == 0) { //get
      if (target.selectionStart) { //DOM
        var posi = target.selectionStart;
        return posi > 0 ? posi : 0;
      }
      else if (target.createTextRange) { //IE
		target.focus();
		range = document.selection.createRange();
		if (range == null)
			return '0';
		var re = target.createTextRange();
		var rc = re.duplicate();
		re.moveToBookmark(range.getBookmark());
		rc.setEndPoint('EndToStart', re);
		return rc.text.length;
      }
      else return 0;
    } //set
    if (target.setSelectionRange) //DOM
      target.setSelectionRange(pos, pos);
    else if (target.createTextRange) { //IE
      range = target.createTextRange();
      range.collapse(true);
      range.moveEnd('character', pos);
      range.moveStart('character', pos);
      range.select();
    }
  };


  jQuery.fn.emoticonize = function (animate) {
    function convert (text){
      var icons = $.mbEmoticons.getRegExp();
      return text.replace (icons,function(str){
        var ret= $.mbEmoticons.smilesPlusVariations[str];
        var ext=animate?".gif":".png";
        if (ret){
          ret="<img src='"+$.mbEmoticons.smilesPath+"smiley/"+ret+ext+"' title='("+ret+")' alt='("+ret+")' align='absmiddle'>";
          return ret;

        }else
          return str;
      });
    }
    this.each(function() {
      var el = $(this);
      var html = convert(el.html());
      el.html(html);
    });
    return this;
  };

  $.extend($.mbEmoticons.smilesPlusVariations,$.mbEmoticons.smiles);

  jQuery.fn.mbSmilesBox= $.mbEmoticons.addSmilesBox;
  jQuery.fn.mbOpenSmilesBox= $.mbEmoticons.openSmileBox;
  jQuery.fn.mbCloseSmilesBox= $.mbEmoticons.removeSmilesBox;

})(jQuery);