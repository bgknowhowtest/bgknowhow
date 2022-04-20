<?php
require_once('../config/db.php');

error_reporting(E_ALL);
ini_set('display_errors', 'On');
ini_set('log_errors', 'On');
ini_set('error_log', 'logs/php_errors.log');

const CSV_SEPARATOR         = ';';
const PICTURE_URL_RENDER    = 'https://art.hearthstonejson.com/v1/render/latest/enUS/512x/'; // locale/256or512 (png only)
const PICTURE_URL_RENDER_DE = 'https://art.hearthstonejson.com/v1/render/latest/deDe/512x/';
const PICTURE_URL_TILE      = 'https://art.hearthstonejson.com/v1/tiles/'; // png/webp/jpg
const PICTURE_URL_ORIGINAL  = 'https://art.hearthstonejson.com/v1/orig/'; // png
const PICTURE_URL_MEDIUM    = 'https://art.hearthstonejson.com/v1/256x/'; // webp/jpg
const PICTURE_URL_BIG       = 'https://art.hearthstonejson.com/v1/512x/'; // webp/jpg

$getActiveOnly = 1;

// generate heroes files
if ($stmt = $mysqli->prepare("SELECT bgh.id,
                                     bgh.name,
                                     bgh.health,
                                     bgh.armor_tier,
                                     bgh.id_blizzard,
                                     bgh.hp_cost,
                                     bgh.hp_text,
                                     bgh.hp_id_blizzard,
                                     bgh.flag_active
                                FROM bg_heroes bgh
                               WHERE bgh.flag_active = ?
                            ORDER BY bgh.name ASC")) {
    $stmt->bind_param("i", $getActiveOnly);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $name, $health, $armorTier, $blizzardId, $hpCost, $hpText, $blizzardIdHp, $isActive);

    $row_count = $stmt->num_rows;

    $csvHeader =
        'Name' . CSV_SEPARATOR .
        'Health' . CSV_SEPARATOR .
        'Armor-Tier' . CSV_SEPARATOR .
        'Armor' . CSV_SEPARATOR .
        'Picture link' . CSV_SEPARATOR .
        'Hero Power cost' . CSV_SEPARATOR .
        'Hero Power text' . CSV_SEPARATOR .
        'Hero Power picture link' . CSV_SEPARATOR .
        'Active' . PHP_EOL;
    $csvData   = $csvHeader;

    // json metadata
    $heroes['meta']['date']    = date("Y-m-d");
    $heroes['meta']['version'] = '0.1.0';

    $i = 0;
    while ($stmt->fetch()) {
        $csvData .=
            $name . CSV_SEPARATOR .
            $health . CSV_SEPARATOR .
            $armorTier . CSV_SEPARATOR .
            getArmor($armorTier) . CSV_SEPARATOR .
            PICTURE_URL_RENDER . $blizzardId . '.png' . CSV_SEPARATOR .
            $hpCost . CSV_SEPARATOR .
            $hpText . CSV_SEPARATOR .
            PICTURE_URL_RENDER . $blizzardIdHp . '.png' . CSV_SEPARATOR .
            (bool)$isActive . PHP_EOL;

        $heroes['data'][$i]['name']                  = $name;
        $heroes['data'][$i]['health']                = $health;
        $heroes['data'][$i]['armorTier']             = $armorTier;
        $heroes['data'][$i]['armor']                 = getArmor($armorTier);
        $heroes['data'][$i]['picture']               = PICTURE_URL_RENDER . $blizzardId . '.png';
        $heroes['data'][$i]['heroPowerCost']         = $hpCost;
        $heroes['data'][$i]['heroPowerText']         = $hpText;
        $heroes['data'][$i]['heroPowerPicture']      = PICTURE_URL_RENDER . $blizzardIdHp . '.png';
        $heroes['data'][$i]['websites']['blizzard']  = 'https://playhearthstone.com/battlegrounds/' . $id;
        $heroes['data'][$i]['websites']['bgknowhow'] = 'https://bgknowhow.com/heroes/' . $id;
        $heroes['data'][$i]['websites']['fandom']    = 'https://hearthstone.fandom.com/wiki/Battlegrounds/' . str_replace(' ', '_', $name);
//        $heroes['data'][$i]['websites']['hearthpwn'] = 'https://hearthpwn.com/';
        $heroes['data'][$i]['isActive'] = (bool)$isActive;

        $i++;
    }

    $stmt->close();

    $csvFile = 'output/bg_heroes_all.csv';
//    $csvFile = 'output/bg_heroes_active.csv';
    file_put_contents($csvFile, $csvData);

    $jsonFile = 'output/bg_heroes_all.json';
//    $jsonFile = 'output/bg_heroes_active.json';
    $jsonData = json_encode($heroes);
    file_put_contents($jsonFile, $jsonData);

    if ($row_count > 0) {
        echo 'Written file ' . $csvFile . ' with ' . $row_count . ' entries.<br>' . PHP_EOL;
        echo 'Written file ' . $jsonFile . ' with ' . $row_count . ' entries.<br>' . PHP_EOL;
    } else {
        echo 'ERROR';
    }
} else {
    echo 'Select failed: (' . $mysqli->errno . ') ' . $mysqli->error . '<br>';
}

// generate minions files
if ($stmt = $mysqli->prepare("SELECT bgm.id,
                                     bgm.name,
                                     bgm.name_short,
                                     bgm.type,
                                     bgm.pool,
                                     bgm.text,
                                     bgm.text_golden,
                                     bgm.tier,
                                     bgm.attack,
                                     bgm.health,
                                     bgm.flag_token,
                                     bgm.flag_active,
                                     bgm.flag_battlecry,
                                     bgm.flag_deathrattle,
                                     bgm.flag_taunt,                                     
                                     bgm.flag_shield,                                     
                                     bgm.flag_windfury,                                     
                                     bgm.flag_reborn,                                     
                                     bgm.flag_avenge,                                                                          
                                     bgm.id_blizzard,                                   
                                     bgm.artist                                                                        
                                FROM bg_minions bgm
                               WHERE bgm.flag_active = ?
                            ORDER BY bgm.tier, bgm.name ASC")) {
    $stmt->bind_param("i", $getActiveOnly);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $name, $nameShort, $type, $pool, $text, $textGolden, $tier, $attack, $health, $isToken, $isActive, $hasBattlecry, $hasDeathrattle, $hasTaunt, $hasShield, $hasWindfury, $hasReborn, $hasAvenge, $blizzardId, $artist);

    $row_count = $stmt->num_rows;

    $csvHeader =
        'Name' . CSV_SEPARATOR .
        'Name Short' . CSV_SEPARATOR .
        'Type' . CSV_SEPARATOR .
        'Type Pool' . CSV_SEPARATOR .
        'Tier' . CSV_SEPARATOR .
        'Attack' . CSV_SEPARATOR .
        'Health' . CSV_SEPARATOR .
        'Text' . CSV_SEPARATOR .
        'Attack Golden' . CSV_SEPARATOR .
        'Health Golden' . CSV_SEPARATOR .
        'Text Golden' . CSV_SEPARATOR .
        'Token' . CSV_SEPARATOR .
        'Active' . CSV_SEPARATOR .
        'Battlecry' . CSV_SEPARATOR .
        'Deathrattle' . CSV_SEPARATOR .
        'Taunt' . CSV_SEPARATOR .
        'Divine Shield' . CSV_SEPARATOR .
        'Windfury' . CSV_SEPARATOR .
        'Reborn' . CSV_SEPARATOR .
        'Avenge' . CSV_SEPARATOR .
        'Picture Link' . CSV_SEPARATOR .
        'Artist' . PHP_EOL;
    $csvData   = $csvHeader;

    // json metadata
    $minions['meta']['date']    = date("Y-m-d");
    $minions['meta']['version'] = '0.1.0';

    $i = 0;
    while ($stmt->fetch()) {
        $csvData .=
            $name . CSV_SEPARATOR .
            $nameShort . CSV_SEPARATOR .
            $type . CSV_SEPARATOR .
            $pool . CSV_SEPARATOR .
            $tier . CSV_SEPARATOR .
            $attack . CSV_SEPARATOR .
            $health . CSV_SEPARATOR .
            $text . CSV_SEPARATOR .
            $attack * 2 . CSV_SEPARATOR .
            $health * 2 . CSV_SEPARATOR .
            $textGolden . CSV_SEPARATOR .
            (bool)$isToken . CSV_SEPARATOR .
            (bool)$isActive . CSV_SEPARATOR .
            (bool)$hasBattlecry . CSV_SEPARATOR .
            (bool)$hasDeathrattle . CSV_SEPARATOR .
            (bool)$hasTaunt . CSV_SEPARATOR .
            (bool)$hasShield . CSV_SEPARATOR .
            (bool)$hasWindfury . CSV_SEPARATOR .
            (bool)$hasReborn . CSV_SEPARATOR .
            (bool)$hasAvenge . CSV_SEPARATOR .
            PICTURE_URL_RENDER . $blizzardId . '.png' . CSV_SEPARATOR .
            $artist . PHP_EOL;

        $minions['data'][$i]['name']                        = $name;
        $minions['data'][$i]['nameShort']                   = $nameShort;
        $minions['data'][$i]['type']                        = $type;
        $minions['data'][$i]['pool']                        = $pool;
        $minions['data'][$i]['tier']                        = $tier;
        $minions['data'][$i]['attack']                      = $attack;
        $minions['data'][$i]['health']                      = $health;
        $minions['data'][$i]['text']                        = $text;
        $minions['data'][$i]['attackGolden']                = $attack * 2;
        $minions['data'][$i]['healthGolden']                = $health * 2;
        $minions['data'][$i]['textGolden']                  = $textGolden;
        $minions['data'][$i]['isActive']                    = (bool)$isActive;
        $minions['data'][$i]['isToken']                     = (bool)$isToken;
        $minions['data'][$i]['abilities']['hasBattlecry']   = (bool)$hasBattlecry;
        $minions['data'][$i]['abilities']['hasDeathrattle'] = (bool)$hasDeathrattle;
        $minions['data'][$i]['abilities']['hasTaunt']       = (bool)$hasTaunt;
        $minions['data'][$i]['abilities']['hasShield']      = (bool)$hasShield;
        $minions['data'][$i]['abilities']['hasWindfury']    = (bool)$hasWindfury;
        $minions['data'][$i]['abilities']['hasReborn']      = (bool)$hasReborn;
        $minions['data'][$i]['abilities']['hasAvenge']      = (bool)$hasAvenge;
        $minions['data'][$i]['picture']                     = PICTURE_URL_RENDER . $blizzardId . '.png';
        $minions['data'][$i]['artist']                      = $artist;
        $minions['data'][$i]['websites']['blizzard']        = 'https://playhearthstone.com/battlegrounds/' . $id;
        $minions['data'][$i]['websites']['bgknowhow']       = 'https://bgknowhow.com/minions/' . $id;
        $minions['data'][$i]['websites']['fandom']          = 'https://hearthstone.fandom.com/wiki/Battlegrounds/' . str_replace(' ', '_', $name);
//        $minions['data'][$i]['websites']['hearthpwn'] = 'https://hearthpwn.com/';

        $i++;
    }

    $stmt->close();

    $csvFile = 'output/bg_minions_all.csv';
//    $csvFile = 'output/bg_heroes_active.csv';
    file_put_contents($csvFile, $csvData);

    $jsonFile = 'output/bg_minions_all.json';
//    $jsonFile = 'output/bg_heroes_active.json';
    $jsonData = json_encode($minions);
    file_put_contents($jsonFile, $jsonData);

    if ($row_count > 0) {
        echo 'Written file ' . $csvFile . ' with ' . $row_count . ' entries.<br>' . PHP_EOL;
        echo 'Written file ' . $jsonFile . ' with ' . $row_count . ' entries.<br>' . PHP_EOL;
    } else {
        echo 'ERROR';
    }
} else {
    echo 'Select failed: (' . $mysqli->errno . ') ' . $mysqli->error . '<br>';
}

// generate buddies files
if ($stmt = $mysqli->prepare("SELECT bgb.id,
                                     bgb.name,
                                     bgb.type,
                                     bgb.text,
                                     bgb.text_golden,
                                     bgb.tier,
                                     bgb.attack,
                                     bgb.health,
                                     bgb.id_blizzard,
                                     bgb.flag_active
                                FROM bg_buddies bgb
                               WHERE bgb.flag_active = ?
                            ORDER BY bgb.tier, bgb.name ASC")) {
    $stmt->bind_param("i", $getActiveOnly);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $name, $type, $text, $textGolden, $tier, $attack, $health, $blizzardId, $isActive);

    $row_count = $stmt->num_rows;

    $csvHeader =
        'Name' . CSV_SEPARATOR .
        'Type' . CSV_SEPARATOR .
        'Tier' . CSV_SEPARATOR .
        'Attack' . CSV_SEPARATOR .
        'Health' . CSV_SEPARATOR .
        'Text' . CSV_SEPARATOR .
        'Attack Golden' . CSV_SEPARATOR .
        'Health Golden' . CSV_SEPARATOR .
        'Text Golden' . CSV_SEPARATOR .
        'Active' . CSV_SEPARATOR .
        'Picture Link' . PHP_EOL;

    $csvData = $csvHeader;

    // json metadata
    $buddies['meta']['date']    = date("Y-m-d");
    $buddies['meta']['version'] = '0.1.0';

    $i = 0;
    while ($stmt->fetch()) {
        $csvData .=
            $name . CSV_SEPARATOR .
            $type . CSV_SEPARATOR .
            $tier . CSV_SEPARATOR .
            $attack . CSV_SEPARATOR .
            $health . CSV_SEPARATOR .
            $text . CSV_SEPARATOR .
            $attack * 2 . CSV_SEPARATOR .
            $health * 2 . CSV_SEPARATOR .
            $textGolden . CSV_SEPARATOR .
            (bool)$isActive . CSV_SEPARATOR .
            PICTURE_URL_RENDER . $blizzardId . '.png' . PHP_EOL;

        $buddies['data'][$i]['name']                  = $name;
        $buddies['data'][$i]['type']                  = $type;
        $buddies['data'][$i]['tier']                  = $tier;
        $buddies['data'][$i]['attack']                = $attack;
        $buddies['data'][$i]['health']                = $health;
        $buddies['data'][$i]['text']                  = $text;
        $buddies['data'][$i]['attackGolden']          = $attack * 2;
        $buddies['data'][$i]['healthGolden']          = $health * 2;
        $buddies['data'][$i]['textGolden']            = $textGolden;
        $buddies['data'][$i]['isActive']              = (bool)$isActive;
        $buddies['data'][$i]['picture']               = PICTURE_URL_RENDER . $blizzardId . '.png';
        $buddies['data'][$i]['websites']['blizzard']  = 'https://playhearthstone.com/battlegrounds/' . $id;
        $buddies['data'][$i]['websites']['bgknowhow'] = 'https://bgknowhow.com/buddies/' . $id;
        $buddies['data'][$i]['websites']['fandom']    = 'https://hearthstone.fandom.com/wiki/Battlegrounds/' . str_replace(' ', '_', $name);
//        $buddies['data'][$i]['websites']['hearthpwn'] = 'https://hearthpwn.com/';

        $i++;
    }

    $stmt->close();

    $csvFile = 'output/bg_buddies_all.csv';
//    $csvFile = 'output/bg_buddies_active.csv';
    file_put_contents($csvFile, $csvData);

    $jsonFile = 'output/bg_buddies_all.json';
//    $jsonFile = 'output/bg_buddies_active.json';
    $jsonData = json_encode($buddies);
    file_put_contents($jsonFile, $jsonData);

    if ($row_count > 0) {
        echo 'Written file ' . $csvFile . ' with ' . $row_count . ' entries.<br>' . PHP_EOL;
        echo 'Written file ' . $jsonFile . ' with ' . $row_count . ' entries.<br>' . PHP_EOL;
    } else {
        echo 'ERROR';
    }
} else {
    echo 'Select failed: (' . $mysqli->errno . ') ' . $mysqli->error . '<br>';
}

function getArmor($armorTier)
{
    switch ($armorTier) {
        case 1:
            return "0";
        case 2:
            return "2-5";
        case 3:
            return "3-6";
        case 4:
            return "4-7";
        case 5:
            return "5-8";
        case 6:
            return "6-9";
        case 7:
            return "7-10";
        default:
            return "???";
    }
}