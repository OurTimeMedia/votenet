{include(file='header.tpl')}
<div>
    <div class="content">
        <div class="step1-main">
            <div class="step1" id="pdfgeneration"  style="display:none;">
                {if $mobile_device}
                    <h1 class='generate_h1'>Step 3: Print and Sign</h1>
                    <div class='step-table'>
                        <div style='width:100%; text-align:justify; padding-top:10px; padding-bottom:10px;'><strong>We
                                have emailed a copy of your completed voter registration form to the email address you
                                provided. Please note that are not yet registered. You need to download the form, print
                                it and sign/date it. Instructions are provided along with the form we sent you.</strong>
                        </div>
                        <div style='width:100%; text-align:justify; padding-top:10px; padding-bottom:10px;'>
                            <strong>{$LANG_ADOBE_REQUIRED_TEXT}</strong></div>
                    </div>
                {else}
                    <h1 class="generate_h1">{$LANG_WAIT_FOR_GENERATING_VOTER_REGISTRATION_FORM}</h1>
                    <div class="step-table">
                        <div style="width:100%; text-align:center; height:100px;">
                            <img src="{$image_dir}please_wait.gif" border="0" style="padding-top:40px;">
                        </div>
                    </div>
                {/if}
            </div>

            <div class="step1" id="pdfcreation_success">
                <h1 class="download_h1">Thanks for Completing Your National Voter Registration Form</h1>
                <div class="step-table-container">
                    <div class="step-table">
                        <div style="width:100%; text-align:center; height:100px; padding-top:10px; padding-bottom:10px;">
                            <strong>Please don't forget to mail your form to your election office.</strong><br/><br/>
                            <strong>Adobe is required in order to print the form. If you are a MAC User or do not have Adobe, please click <a href="http://www.adobe.com/support/downloads/product.jsp?platform=macintosh&amp;product=10" target="_blank">HERE</a> to download a free version.</strong><br/><br/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{include(file='registrationform2_db.php')}
{include(file='footer.tpl')}