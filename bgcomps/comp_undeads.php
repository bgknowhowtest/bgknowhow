<?php include_once('../header.php'); ?>

<h2 class="page_title">Standard Compositions: Undeads</h2>
<p>
    <?php include_once('intro.php'); ?>
</p>
<br>
<hr>
<br>
<p>
    Undead shine with many Reborn and Deathrattle effects, usually providing you more minions than your opponents. They are able to buff the attack of every Undead permanently and the minion <a class="hoverimage" href="/bgstrategy/minion/?id=444">Disguised Graverobber</a> provides a unique way to alter and buff your warband.
</p>
<div class="comp_wrapper">
    <h3 id="knights">Deathrattle Knight Comp <a tabindex="0" onclick="CopyLink(this);" title="Copy the link to this section to your clipboard"><i class="bi bi-link-45deg"></i></a></h3>
    <?php
    $board   = ['Anub', 'Kel', 'Summoner', 'Summoner', 'Titus', 'Murghoul'];
    $minions = getMinionsForBoard($board);
    drawBoard($minions);
    ?>
    <p>
        Taunt Anub'arak. I want to use this section to explain Archlich Kel'Thuzad, <a class="hoverimage" href="/bgstrategy/minion/?id=444">Disguised Graverobber</a>, and <a class="hoverimage" href="/bgstrategy/minion/?id=441">Grave Gobbler</a>. These cards destroy Undeads during your recruitment phase. What that means is their Deathrattle and abilities will activate permanently. If <strong>Eternal Summoner</strong> gets destroyed when you have a full board you will lose your Summoner and are left with an Eternal Knight. That sounds pretty bad, but there are ways to take advantage of this.
        <br><br>
        If you have only Eternal Summoner with Archlich Kel'Thuzad, then you will permanently now have a regular Eternal Summoner, an <a class="hoverimage" href="/bgstrategy/minion/?id=274">Eternal Knight</a>, and an Eternal Summoner without reborn. If you have <strong>Titus Rivendare</strong>, then you will gain an extra Eternal Knight.
        <br><br>
        If you do this one more time, then you can triple the Eternal Summoner. Of course, this is incredibly risky because your build is weak. Archlich Kel'Thuzad is generally used to activate a Deathrattle that won't ruin your board state like Anub'arak or Mummifier.
        <br><br>
        However, if you do wish to try and get a discovery from a Deathrattle, Harmless Bonehead summons two skeletons. If you are able to destroy him with the aforementioned cards while also having enough board space, then you should be able to get at least one golden Skeleton.
    </p>
    <h3 id="deathrattle">Deathrattle/Reborn Comp <a tabindex="0" onclick="CopyLink(this);" title="Copy the link to this section to your clipboard"><i class="bi bi-link-45deg"></i></a></h3>
    <?php
    $board   = ['Mummifier', 'Anub', 'Handless', 'Handless', 'Summoner', 'Titus', 'Abomination'];
    $minions = getMinionsForBoard($board);
    drawBoard($minions);
    ?>
    <p>
        Taunt the Anub. You can replace Hungering Abomination with Champion of Primus, Moroes Steward of Death, or Relentless Mur'ghoul.
    </p>
    <!--        <h3 id="reborn">Reborn Comp <a tabindex="0" onclick="CopyLink(this);" title="Copy the link to this section to your clipboard"><i class="bi bi-link-45deg"></i></a></h3>-->
    <!--        --><?php
    //        $board   = ['Splitter', 'Handless', 'Handless', 'Summoner', 'Summoner', 'Deathwhisper', 'Champion of the Primus'];
    //        $minions = getMinionsForBoard($board);
    //        drawBoard($minions);
    //        ?>
    <!--        <p>-->
    <!---->
    <!--        </p>-->
    <h3 id="exodia">Exodia Deathrattle Comp <a tabindex="0" onclick="CopyLink(this);" title="Copy the link to this section to your clipboard"><i class="bi bi-link-45deg"></i></a></h3>
    <?php
    $board   = ['Blaster', 'Phaerix', 'Anub', 'Anub', 'Summoner', 'Summoner', 'Titus'];
    $minions = getMinionsForBoard($board);
    drawBoard($minions);
    ?>
    <p>
        <strong>Blaster</strong> and <strong>Titus</strong> are the cornerstones of this build. Don't buff the health of your minions too much, so that Blaster will always kill them.
    </p>
</div>

<br>
<br>
<hr>
<br>
<p>
    <?php include_once('outro.php'); ?>
</p>
<br><br>

<?php include_once('../footer.php'); ?>
