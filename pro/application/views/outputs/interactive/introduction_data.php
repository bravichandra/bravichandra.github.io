<h1 class="sub-dev-head"><?php echo $parts[$partid]['title'];?></h1>
<div class="scroll-bar_sf introduction">
<h3 class="sub-dev-head-sub2">Gatekeeper:</h3>
<div>
	<h4>If you have the contact's name:</h4>
    Hello, I am trying to connect with <span class="red-area">[Target Prospect]</span>.
</div>
<div>
	<h4>If you have the contact's title:</h4>
    Hello, I am trying to connect with the <span class="red-area">[Target Title]</span>.
</div>
<div>
	<h4>If you don't have the name or title:</h4>
    Hello, I am trying to connect with the person responsible for <span class="red-area">[Target Area]</span>. Can you point me in the right direction?
</div>
<h3 class="sub-dev-head-sub2">Prospect:</h3>
<p>Hello  <span class="red-area">[Contact's Name]</span>, this is  <span><?php echo $aMember['yname'] ?></span> from  <span><?php echo  $company_info->company_name ; ?> </span>, have I caught you in the middle of anything?</p>
</div>