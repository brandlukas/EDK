<div id="kl-detail-comments">
<div class="block-header">Comments</div>
<table class="kb-table" width="100%" border="0" cellspacing="1">
  <tr>
    <td width="100%" align="left" valign="top">
      <table width="100%" border="0" cellspacing="0">
{cycle reset=true print=false name=ccl values="kb-table-row-even,kb-table-row-odd"}{section name=i loop=$comments}
        <tr class="{cycle name=ccl}">
          <td>
            <div style="position: relative;"><a href="?a=search&amp;searchtype=pilot&amp;searchphrase={$comments[i].name}">{$comments[i].name}</a>:
{if $comments[i].time}
            <span style="position:absolute; right: 0px;">{$comments[i].time}</span>
{/if}
            <p>{$comments[i].comment}</p>
{if $page->isAdmin()}
<a href="javascript:openWindow('?a=admin_comments_delete&amp;c_id={$comments[i].id}', null, 480, 350, '' );">Delete Comment</a>
<span style="position:absolute; right: 0px;"><u>Posters IP:{$comments[i].ip}</u></span>
{/if} 
          </div></td>
        </tr>
{/section}
		{if $commenthtml}
		        <tr><td>
		{$commenthtml}
		</td></tr>
		{/if}
        <tr><td>
		{if $canpost}
		<form id="postform" name="postform" method="post" action=""><table><tr>
          <td align="center">
		<textarea class="comment" name="tsm_comment" cols="55" rows="5" style="width: 97%" onkeyup="limitText(this.form.tsm_comment,document.getElementById('countdown'),500);" onkeypress="limitText(this.form.tsm_comment,document.getElementById('countdown'),500);"></textarea>
          </td>
        </tr>
        <tr>
          <td>
            <br/>
            <span title="countdown" id="countdown">500</span> Letters left<br/>
            <b>Name:</b>
            {$name}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input class="comment-button" name="submit" type="submit" value="Add Comment">
            
          </td></tr></table></form>
		  {/if}
		  	{if !$canpost}
			You need to be Logged in on the Forum to Post Comments.
		{/if}
		  	{if !$is_guest and !$canpost}
			You do not have Access to post Comments.
		{/if}
		  
		  </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</div>
