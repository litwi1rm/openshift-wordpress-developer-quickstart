(function() {  
    function addShadowBox(ed, url){
            ed.addButton('shadowbox', {  
                title : 'Add Shadow Box',  
                image : url+'/shadow-box-icon.png',  
                onclick : function() {  
                     ed.selection.setContent('[shadowbox]' + ed.selection.getContent() + '[/shadowbox]');  
  
                }  
        });  
    }
    function addAudioPlayer(ed, url){
            ed.addButton('audio', {  
                title : 'Add Podcast',  
                image : url+'/audio-player-icon.png',  
                onclick : function() {  
                     ed.selection.setContent('[app_audio src=\"' + ed.selection.getContent() + '\"]');  
  
                }
        });
    }
    function addBlubrryPlayer(ed, url){
            ed.addButton('blubrry', {  
                title : 'Add Blubrry Shortcode',  
                image : url+'/blubrry-icon.png',  
                onclick : function() {  
                     ed.selection.setContent('[powerpress]');  
  
                }
        });
    }
	 /*   function addShareButtons(ed, url){
            ed.addButton('share', {  
                title : 'Add Share Buttons',  
                image : url+'/share-me.png',  
                onclick : function() {  
                     ed.selection.setContent('[share]' + ed.selection.getContent() + '[/share]');  
  
                }
        });
    } */
    tinymce.create('tinymce.plugins.appendipity', {  
        init : function(ed, url) {
            addShadowBox(ed, url);
            addAudioPlayer(ed, url); 
			addBlubrryPlayer(ed, url);
			//addShareButtons(ed, url); 
        },  
        createControl : function(n, cm) {  
            return null;  
        },  
    });  
    tinymce.PluginManager.add('appendipity', tinymce.plugins.appendipity);  
})();