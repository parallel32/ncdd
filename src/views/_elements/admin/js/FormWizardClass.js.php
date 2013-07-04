<script type="text/javascript">
(function( FormWizardClass, $, undefined ) {

    FormWizardClass.conf = {};
    
    FormWizardClass.init = function(conf){
        this.conf.elementId = conf.elementId || '#form_wizard_1';
        this.conf.doneModalId = conf.doneModalId || '#save-success';
        this.conf.doneModalLabel = conf.doneModalLabel || 'Wizard Complete.';
        this.conf.doneModalMessage = conf.doneModalMessage || 'You are finised.';
        this.conf.doneModalRedirect = conf.doneModalRedirect || '/';
        this.conf.tabHeadlines = conf.tabHeadlines || [{
            headline:''/*if a headline is empty, setting it will be ignored*/
        }];
        this.conf.onFinish = conf.onFinish || function(){};
        this.conf.onNextProcessQueue = conf.onNextProcessQueue || [
        {
            action:function(index,tab){}
        }
        ,{
            action:function(index,tab){}  
        }
        ,{
            action:function(index,tab){}  
        }
        ];
        // default form wizard
        $(this.conf.elementId).bootstrapWizard({
            'nextSelector': '.button-next',
            'previousSelector': '.button-previous',
            onTabClick: function (tab, navigation, index) {
                return false;
            },
            onNext: function (tab, navigation, index) {
                if($(FormWizardClass.conf.elementId).find('.button-next').hasClass('disabled') == true){
                    return false;
                }
                if(FormWizardClass.onNext(tab,navigation,index) == false){
                    return false;
                }
                var total = navigation.find('li').length;
                var current = index + 1;
                // set wizard title
                $('.step-title', $(FormWizardClass.conf.elementId)).text('Step ' + (index + 1) + ' of ' + total);
                // set done steps
                jQuery('li', $(FormWizardClass.conf.elementId)).removeClass("done");
                var li_list = navigation.find('li');
                for (var i = 0; i < index; i++) {
                    jQuery(li_list[i]).addClass("done");
                }

                if (current == 1) {
                    $(FormWizardClass.conf.elementId).find('.button-previous').hide();
                } else {
                    $(FormWizardClass.conf.elementId).find('.button-previous').show();
                }
                App.scrollTo($('.page-title'));
                
            },
            onPrevious: function (tab, navigation, index) {
                if($(FormWizardClass.conf.elementId).find('.button-previous').hasClass('disabled') == true){
                    return false;
                }
                var total = navigation.find('li').length;
                var current = index + 1;
                // set wizard title
                $('.step-title', $(FormWizardClass.conf.elementId)).text('Step ' + (index + 1) + ' of ' + total);
                // set done steps
                jQuery('li', $(FormWizardClass.conf.elementId)).removeClass("done");
                var li_list = navigation.find('li');
                for (var i = 0; i < index; i++) {
                    jQuery(li_list[i]).addClass("done");
                }

                if (current == 1) {
                    $(FormWizardClass.conf.elementId).find('.button-previous').hide();
                } else {
                    $(FormWizardClass.conf.elementId).find('.button-previous').show();
                }
                if($(FormWizardClass.conf.elementId).find('.button-next').hasClass('green')){
                    $(FormWizardClass.conf.elementId).find('.button-next').removeClass('green').addClass('blue').html('Continue <i class="m-icon-swapright m-icon-white"></i>');
                }
                App.scrollTo($('.page-title'));
            },
            onTabShow: function (tab, navigation, index) {
                var total = navigation.find('li').length;
                var current = index + 1;
                var $percent = (current / total) * 100;
                $(FormWizardClass.conf.elementId).find('.bar').css({
                    width: $percent + '%'
                });
            }
        });

        $(this.conf.elementId).find('.button-previous').hide();
        this.modalInit();
        
    };
    FormWizardClass.modalInit = function(){
        // modal buttons
        $(this.conf.doneModalId+' .done').click(function(e){
            document.location.href=io.saw.FormWizardClass.conf.doneModalRedirect;
        });
        $(this.conf.doneModalId+' .modal-header h3').html(this.conf.doneModalLabel);
        $(this.conf.doneModalId+' .modal-body p').html(this.conf.doneModalMessage);

    };
    FormWizardClass.onNext = function(tab, navigation, index){
        // append the headline
        if(index < this.conf.tabHeadlines.length){
            if(this.conf.tabHeadlines[index].headline.length > 0){
                $(this.conf.elementId).find('#tab'+(index+1)).find('form').html('').append(this.conf.tabHeadlines[index].headline);
            }
        }
        // call the next action on the process Queue
        if(this.conf.onNextProcessQueue[index-1].action(index,this.conf.elementId) == false){
            return false;
        }
        var total = navigation.find('li').length;
        if((total-index) == 1){
            $(this.conf.elementId).find('.button-next').removeClass('blue').addClass('green').html('Click to Finish <i class="m-icon-swapright m-icon-white"></i>');
        }
    };
    

}( io.saw.FormWizardClass = io.saw.FormWizardClass || {}, io.saw.jQuery || jQuery ));
</script>