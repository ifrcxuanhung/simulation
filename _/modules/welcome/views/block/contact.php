<div class="portlet box red blocks" style="margin-bottom:5px; position:relative">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa"></i><?php translate('head_box_information_request'); ?></div>
             <div class="tools">
                        <i class="fa fa-arrows-alt fullscreens"></i>
                        <i class="fa fa-compress minscreens"></i>
                    </div>
      
    </div>
    <div class="portlet-body background_portlet">
        <div class="row" style="margin:  0px;">
        <div class="c-contact">
            <!--div class="c-content-title-1">
                <h3 class="uppercase">Keep in touch</h3>
                <div class="c-line-left bg-dark"></div>
                <p class="c-font-lowercase">Our helpline is always open to receive any inquiry or feedback. Please feel free to drop us an email from the form below and we will get back to you as soon as we can.</p>
            </div-->
            <form method="post" action="" class="margin-top-20">
                
                <div class="col-md-6">
                    <div class="form-group" style="padding-right: 20px;">
                        <input type="text" class="form-control input-md" name="name" placeholder="<?php translate('holder_your_name'); ?>"> </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group" style="padding-left: 20px;">
                        <input type="email" class="form-control input-md" name="email" placeholder="<?php translate('holder_your_email'); ?>"> </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <textarea class="form-control input-md" placeholder="<?php translate('holder_ask_a_question'); ?>..." name="message" rows="8"></textarea>
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="form-group">
                        <label class="control-label bold">Capcha
                        </label>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                       <!-- <label class="control-label uppercase bold" style="background-color: #22313f none repeat scroll 0 0; color: #6fb9fc; border: 1px solid #fff; font-size:22px; padding: 5px;"><?php echo substr(md5(microtime()),rand(0,26),7); ?></label>-->
                        <label  for="captcha" class="col-md-3 control-label uppercase bold captcha_image" attr="<?php if(isset($captcha_image)) echo $captcha_image;?>"><?php echo $captcha['image']; ?></label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group" style="padding-right: 40px;">
                        <input type="text" class="form-control input-lg" name="userCaptcha" placeholder="<?php translate('holder_input_capcha_here'); ?>..."> 
                    </div>
                </div>
                <div class="col-md-5" style="text-align: right;">
                    <button class="btn btn-lg green submit_contact" style="width:30%" type="submit"><?php translate('btn_submit'); ?></button>
                </div>
                
                    
                
            </form>
        </div>
        </div>
    </div>
</div>

<style>
.form-control{
    color: #6fb9fc;
    background: #1d2a36  none repeat scroll 0 0;
    
}
</style>