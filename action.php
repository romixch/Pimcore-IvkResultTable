<?php
class Document_Tag_Area_IvkResultTable extends Document_Tag_Area_Abstract {

	public function action () {
		if (!$this->view->editmode) {
			$group = $this->_getParam("group");
			if (isset($group)) {
				$jsonTable = json_decode(file_get_contents('http://korbball.turnverband.ch/ws/tableV1.php?group=' . $group), true);
				$this->view->jsonTable = $jsonTable;
			} else {
				$jsonGroups = json_decode(file_get_contents("http://korbball.turnverband.ch/ws/groups.php"), true);
				$this->view->jsonGroups = $jsonGroups;
			}
		}
	}
}