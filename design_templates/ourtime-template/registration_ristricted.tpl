{include(file='header.tpl')}
{if $Voting_Source == "Website"}
<div class="step">
  &nbsp;
</div>
{/if}
<div id="content">
    <div class="content" style="margin: 0px;">
      <div class="step1-main">
        <div class="step1">          
		  {if $Voting_State_id == 51}	
          <div class="step-table" style="padding-top: 12px; padding-bottom: 12px;">
            The state of Wyoming does not accept the National Voter Registration form. For more information on voter registration and a link to a Wyoming voter registration form, please click on the following link: <a href="http://soswy.state.wy.us/Elections/RegisteringToVote.aspx" target="_blank">http://soswy.state.wy.us/Elections/RegisteringToVote.aspx</a>
          </div>
		  {/if}
		  {if $Voting_State_id == 37}	
          <div class="step-table" style="padding-top: 12px; padding-bottom: 12px;">
		  <strong>Apply to your town or city clerk's office.  You will be required to fill out a standard voter registration form and will be required to show proof of age, citizenship and domicile.   
		  <br>Please visit <a href="http://sos.nh.gov/RegVote.aspx" target="_blank">http://sos.nh.gov/RegVote.aspx</a> for further information.</strong>
          </div>
		  {/if}
        </div>
      </div>
    </div>
  </div>
  <div class="step">
  &nbsp;
</div>
{if $issponsers == 1}
{include(file="slider.tpl")}
{/if} 
{include(file='footer.tpl')}  