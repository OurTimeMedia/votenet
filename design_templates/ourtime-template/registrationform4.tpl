{include(file='header.tpl')}
<div class="step">
  <ul>
	<li class="step-act" id="step1">Step1</li>
	<li class="step-act" id="step2">Step2</li>
	<li class="step-act" id="step3">Step3</li>
	<li class="step-act" id="step4">Step4</li>
  </ul>
</div>
<div id="content">
    <div class="content">
      <div class="step1-main">
        <div class="step1">
         <h1>Step 4: Add to your Calendar</h1>
          <div class="step-table">
            {include(file='registration_step4.php')}
          </div>
        </div>
      </div>
    </div>
  </div>
{if $issponsers == 1}
{include(file="slider.tpl")}
{/if} 
{include(file='footer.tpl')}  