{include(file='header.tpl')}
{if $hide_steps == "0"}
{if $Voting_Source == "Website"}
<div class="step">
  <ul>
	<li class="step-act" id="step1">Register</li>
	<li id="step2">Review</li>
	<li id="step3">Share</li>	
  </ul>
</div>
{/if}
{/if}
<div id="content">
    <div class="content">
      <div class="step1-main">
        <div class="step1">
          <h1>{$reg_step} 1: {$reg_registration}</h1>
          <div class="step-table">
            {include(file='registration_step1-test.php')}
          </div>
        </div>
      </div>
    </div>
  </div>
{if $issponsers == 1}
{include(file="slider.tpl")}
{/if} 
{include(file='footer.tpl')}  