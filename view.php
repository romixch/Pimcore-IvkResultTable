<?php

function echoBackLink($path) {
	?>
	<p><a href="<?php echo $path;?>">Zur&uuml;ck</a></p>
<?php
}

function echoHeader($groupName, $teams) {
	echo '<thead><tr>';
	echo '<th colspan="2">' . $groupName . '</th>';
	foreach($teams as $team) {
		echo '<td>' . $team . '</td>';
	}
	echo '</tr></thead>';
}

function echoResultLines($rounds, $teams, $games) {
	$countRound = count($rounds);
	foreach ($teams as $Kteam => $Vteam) {
		echo '<tr>';
		echo '<td rowspan="' . $countRound . '">' . $Vteam . '</td>';
		$firstRound = true;
		foreach ($rounds as $Kround => $Vround) {
			if (!$firstRound) {
				$firstRound = false;
				echo '<tr>';
			}
			echoResultLineByRound($Vround, $games[$Kround], $teams, $Kteam);
			echo '</tr>';
		}
	}
}

function echoResultLineByRound($roundName, $roundGames, $teams, $lineTeamKey) {
	echo '<td>' . $roundName . '</td>';
	foreach ($teams as $teamKey => $teamName) {
		if ($teamKey==$lineTeamKey) {
			echo '<td bgcolor="#353535"></td>';
		} else {
			echo '<td class="text-center">' . $roundGames[$lineTeamKey][$teamKey] . '</td>';
		}
	}
}

function echoRates($rates, $teams) {
	echo '<tr>';
	echo '<td colspan="2">K&ouml;rbe</td>';
	foreach ($teams as $teamKey => $teamName) {
		echo '<td class="text-center">' . $rates[$teamKey]['others'] . ' : ' . $rates[$teamKey]['own'] . '</td>';
	}
	echo '</tr>';
	echo '<tr>';
	echo '<td colspan="2">Korbverh&auml;ltnis</td>';
	foreach ($teams as $teamKey => $teamName) {
		echo '<td class="text-center">' . ($rates[$teamKey]['own'] - $rates[$teamKey]['others']) . '</td>';
	}
	echo '</tr>';
}

function echoPoints($points, $teams) {
	echo '<tr>';
	echo '<td colspan="2">Punkte</td>';
	foreach ($teams as $teamKey => $teamName) {
		echo '<td class="text-center">' . $points[$teamKey] . '</td>';
	}
	echo '</tr>';
}

function echoRankings($ranking, $teams) {
	echo '<tr class="active">';
	echo '<td colspan="2">Rang</td>';
	$rankPerTeam = array();
	foreach ($ranking as $rank => $teamKeys) {
		foreach ($teamKeys as $teamKey) {
			$rankPerTeam[$teamKey] = $rank + 1;
		}
	}
	foreach ($teams as $teamKey => $teamName) {
		echo '<th class="text-center">' . $rankPerTeam[$teamKey] . '</th>';
	}
	echo '</tr>';
}

function echoTable($table, $ranking, $points, $rates, $path) {
	$groupName = $table['groupName'];
	$rounds = $table['rounds'];
	$teams = $table['teams'];
	$games = $table['games'];
	echo '<div style="overflow: auto;">';
	echoBackLink($path);
	echo '<table class="table table-condensed table-bordered">';
	echoHeader($groupName, $teams);
	echo '<tbody>';
	echoResultLines($rounds, $teams, $games);
	echoRates($rates, $teams);
	echoPoints($points, $teams);
	echoRankings($ranking, $teams);
	echo '</tbody>';
	echo '</table>';
	echo "</div>";
}

function echoGroups($groups, $path) {
	echo '<ul>';
	foreach ($groups as $groupId => $groupName) {
		echo '<li>';
		echo "<a href=\"$path?group=$groupId&display=results\">$groupName</a>";
		echo " (<a href=\"$path?group=$groupId\">Kreuztabelle</a>)";
		echo '</li>';
	}
	echo '</ul';
}

$groups = $this->jsonGroups;
$path = $this->document->getFullPath();
if (isset($groups)) {
	echoGroups($groups, $path);
}
$jsonTable = $this->jsonTable;
if (isset($this->jsonTable)) {
	$table = $jsonTable['table'];
	$ranking = $jsonTable['ranking'];
	$points = $jsonTable['points'];
	$rates = $jsonTable['rates'];
	echoTable($table, $ranking, $points, $rates, $path);
}
if (isset($this->results)) {
	echoBackLink($path);
	echo $this->results;
}
if ($this->editmode) {
	?>
<p>Dieses Brick stellt eine View zur Verf&uuml;gung, mit der man die Tabellen der Innerschweizer Korbballmeisterschaft darstellen kann. Hier
	gibt's nichts zu konfigurieren.</p>
<?php
}