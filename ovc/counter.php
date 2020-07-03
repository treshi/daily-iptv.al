<?php
/*
 * Online Visitors Counter
 *
 * @copyright  Copyright 2014, Victor Nogueira (http://github.com/felladrin)
 * @link       http://github.com/felladrin/online-visitors-counter
 * @license    MIT License (http://opensource.org/licenses/MIT)
 */

require_once 'config.php';

session_start();

$_SESSION['id'] = (isset($_SESSION['id'])) ? $_SESSION['id'] : uniqid();

try
{
    if (!file_exists($databaseFile))
    {
        $createQuery = "CREATE TABLE 'online' ('id' TEXT PRIMARY KEY NOT NULL, 'page_title' TEXT, 'page_url' TEXT, 'last_activity' INTEGER)";
    }

    $db = new PDO("sqlite:$databaseFile");

    if (isset($createQuery))
    {
        $db->query($createQuery);
    }
}
catch (PDOException $e)
{
    die($e->getMessage());
}

$currentTime = time();

$gracePeriod = $currentTime - $secondsToConsiderOffline;

$id = $_SESSION['id'];

$page_title = (isset($_REQUEST['page_title'])) ? $_REQUEST['page_title'] : '';

$page_url = (isset($_REQUEST['page_url'])) ? $_REQUEST['page_url'] : '';

$delete = $db->prepare("DELETE FROM online WHERE last_activity < :gracePeriod OR id = :id");
$delete->bindValue(':gracePeriod', $gracePeriod, PDO::PARAM_INT);
$delete->bindValue(':id', $id, PDO::PARAM_STR);
$delete->execute();

$insert = $db->prepare("INSERT INTO online (id, page_title, page_url, last_activity) VALUES (:id, :page_title, :page_url, :currentTime)");
$insert->bindValue(':id', $id, PDO::PARAM_STR);
$insert->bindValue(':page_title', $page_title, PDO::PARAM_STR);
$insert->bindValue(':page_url', $page_url, PDO::PARAM_STR);
$insert->bindValue(':currentTime', $currentTime, PDO::PARAM_INT);
$insert->execute();

$count = $db->query('SELECT COUNT() AS visitors, COUNT(DISTINCT page_url) AS pages FROM online')->fetch(PDO::FETCH_ASSOC);

if ($count['visitors'] <= 1)
{
    $visitors = 1;
    $visitorWord = $visitorSingular;
}
else
{
    $visitors = $count['visitors'];
    $visitorWord = $visitorPlural;
}

if ($count['pages'] <= 1)
{
    $pages = 1;
    $pageWord = $pageSingular;
}
else
{
    $pages = $count['pages'];
    $pageWord = $pagePlural;
}

echo sprintf($linkFormat, $visitors, $visitorWord, $pages, $pageWord);
