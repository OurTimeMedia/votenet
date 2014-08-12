{include(file='header.tpl')}
{if $hide_steps == "0"}
{if $Voting_Source == "Website"}
<div class="step">
  <ul>
	<li id="step1">Register</li>
	<li class="step-act"  id="step2">Review</li>
	<li id="step3">Share</li>	
  </ul>
</div>
{/if}
{/if}
<div>
    <div class="content">
      <div class="step1-main">
        <div class="step1">
          <h1>{$reg_step} 2: {$reg_review_and_download}</h1>
          <div class="step-table">
            {include(file='registration_step2.php')}
          </div>
        </div>
      </div>
    </div>
  </div>
{if $issponsers == 1}
{include(file="slider.tpl")}
{/if} 
{include(file='footer.tpl')}  