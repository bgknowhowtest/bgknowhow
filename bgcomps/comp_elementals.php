<?php include_once('../header.php'); ?>

<h2 class="page_title">Standard Compositions: Elementals</h2>
<p>
    <?php include_once('intro.php'); ?>
</p>
<br>
<hr>
<br><br>
<p>
    All Elemental builds can be improved by temporarily utilizing <a class="hoverimage" href="/bgstrategy/minion/?id=356">Elemental of Surprise</a> to triple and apply Divine Shield to as many minions as possible while building up your endgame composition.
</p>
<div class="comp_wrapper">
    <!--    <h3 id="nomi">Nomi/Trumpeter Comp <a tabindex="0" onclick="CopyLink(this);" title="Copy the link to this section to your clipboard"><i class="bi bi-link-45deg"></i></a></h3>-->
    <!--        <p>You start by picking up Crackling Cyclone and try to discover a Nomi. Then utilize Recycling Wraith to filter through Elementals to grow the Elementals in the tavern. A Brann can greatly help by improving the effect of Smogger and Tempest. Later Cyclone and Wildfire will be tripled.</p>-->
    <!--    --><?php
    //    $board   = ['Bramblewitch', 'Wildfire', 'Wraith', 'Trumpeter', 'Trumpeter', 'Nomi', 'Nomi'];
    //    $minions = getMinionsForBoard($board);
    //    drawBoard($minions);
    //    ?>
    <!--    <p>-->
    <!--        Buffs the tavern.-->
    <!--    </p>-->
    <!--    <h3 id="magma">Brann + Magma Battlecry Comp <a tabindex="0" onclick="CopyLink(this);" title="Copy the link to this section to your clipboard"><i class="bi bi-link-45deg"></i></a></h3>-->
    <!--    --><?php
    //    $board   = ['Brann', 'Magma', 'Magma', 'Wraith', 'Rock Rock', 'Rock Rock', 'Upstart'];
    //    $minions = getMinionsForBoard($board);
    //    drawBoard($minions);
    //    ?>
    <!--    <p>-->
    <!--        Buffs the board. Better with Murlocs available, mostly due to <a class="hoverimage" href="/bgstrategy/minion/?id=93">Primalfin Lookout</a>. Upstart should be tripled, or it is usually not worth it.-->
    <!--    </p>-->
    <h3 id="rockrock">RockRock Comp <a tabindex="0" onclick="CopyLink(this);" title="Copy the link to this section to your clipboard"><i class="bi bi-link-45deg"></i></a></h3>
    <?php
    $board   = ['Bramblewitch', 'Wildfire', 'Frostling', 'Wraith', 'Djinni', 'Rock Rock', 'Rock Rock'];
    $minions = getMinionsForBoard($board);
    drawBoard($minions);
    ?>
    <p>
        <a class="hoverimage" href="/bgstrategy/minion/?id=256">Titus</a> also helps out with Gentle Djinni. <a class="hoverimage" href="/bgstrategy/minion/?id=384">Emergency Flame</a>, <a class="hoverimage" href="/bgstrategy/minion/?id=125">Tavern Tempest</a>, <a class="hoverimage" href="/bgstrategy/minion/?id=398">Transmuted Bramblewitch</a> are other good cards to help.
    </p>
    <h3 id="master">Master of Realities Comp <a tabindex="0" onclick="CopyLink(this);" title="Copy the link to this section to your clipboard"><i class="bi bi-link-45deg"></i></a></h3>
    <?php
    $board   = ['Sandstone', 'Sandstone', 'Smuggler', 'Smuggler', 'Master', 'Master', 'Enchanter'];
    $minions = getMinionsForBoard($board);
    drawBoard($minions);
    ?>
    <p>
        Do not triple Sandstone Drake or <strong>Master Realities</strong>, they become less effective when put together.
    </p>
    <h3 id="spells">Spell Comp <a tabindex="0" onclick="CopyLink(this);" title="Copy the link to this section to your clipboard"><i class="bi bi-link-45deg"></i></a></h3>
    <?php
    $board   = ['Barnstormer', 'Frostling', 'Sandstone', 'Seafarer', 'Lubber', 'Lubber', 'Azerite'];
    $minions = getMinionsForBoard($board);
    drawBoard($minions);
    ?>
    <p>
        Cards like Wildfire Elemental and Flourish Frostling are ideal. Felemental, Master of Realities, Ignition Specialist, Mystic Sporebat, and Ensorcelled Fungus are all good cards to add to the build.
    </p>
    <h3 id="deathrattle">Barnstormer Deathrattle Comp <a tabindex="0" onclick="CopyLink(this);" title="Copy the link to this section to your clipboard"><i class="bi bi-link-45deg"></i></a></h3>
    <?php
    $board   = ['Macaw', 'Barnstormer', 'Barnstormer', 'Phalanx', 'Phalanx', 'Felbat', 'Titus'];
    $minions = getMinionsForBoard($board);
    drawBoard($minions);
    ?>
    <p>
        Needs the availability of Demons. Improves by the availability of Beasts.
    </p>
</div>

<br><br>
<hr>
<br>
<p>
    <?php include_once('outro.php'); ?>
</p>
<br><br>

<?php include_once('../footer.php'); ?>
