<div class="login">
  <div class = "logo"><img src="modules/main/img/killercorp.png"></img></div>
  <div class="info"></div>
<input type="text" placeholder="<? echo $translator->trans("INSERT_CODE") ?>"></input>
<div class = 'loginButton hide'><?php echo utf8_decode($translator->trans('LOGIN'));?></div>
<div class ="reglas"><a href="https://docs.google.com/document/d/1wuwHNX-0Pp1Vux8-e80LhMdOJx_MI6N5xJx_yMecJ0M/edit">Reglas del juego</a></div>
</div>

<div class="infoAssassin hide">

  <div class="assassinImg"></div>
  <div class="assassinName"></div>
  <div clas="clearer"></div>
  <div class="infoVictim">
    <div class="victimIMG"></div>
    <div class="victimName"></div>
    <div class="victimInfo"></div>

    <input type="text" placeholder="<? echo $translator->trans("INSERT_CODE_VICTIM") ?>"></input>
    <div class = 'killButton hide'><?php echo utf8_decode($translator->trans('DESBLOQUEAR'));?></div>
    <div class="info"></div>
    <div class="clearer"></div>
  </div>

</div>