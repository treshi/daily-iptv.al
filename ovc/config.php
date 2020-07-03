<?php
// Time, in seconds, till a visitor is considered offline.
$secondsToConsiderOffline = 60;

// Singular word to represent the visitor.
$visitorSingular = "Visitor";

// Plural word to represent the visitor.
$visitorPlural = "Visitors";

// Singular word to represent the page which visitor is.
$pageSingular = "Page";

// Plural word to represent the page which visitor is.
$pagePlural = "Pages";

// Format of the text from conter link.
// %1$d represents de quantity of visitors.
// %2$s represents the "visitor" word, on plural form if there's more than one.
// %3$d represents de quantity of distinct pages they are visiting.
// %4$s represents the "page" word, on plural form if there's more than one.
$linkFormat = '%1$d %2$s in %3$d %4$s';

// Name of database file.
$databaseFile = 'counter.sqlite';

// Title of the page that lists where is each visitor.
$visitorsPageTitle = 'Online Visitors';

// Name to show for pages without title.
$unknownPages = 'Unknown Page';