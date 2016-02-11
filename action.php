<?php
class Document_Tag_Area_IvkResultTable extends Document_Tag_Area_Abstract {

	public function action () {
		if (!$this->view->editmode) {
			$group = $this->_getParam("group");
			$display = $this->_getParam("display");
			if (isset($group)) {
				if (isset($display) && $display == 'results') {
					$html = file_get_html('http://korbball.turnverband.ch/admin/single_ranking.php?gruppe=' . $group);
					$div = $html->find('div[class="single_embedded"]');
					$this->view->results = $div[0];
				} else {
					$jsonTable = json_decode(file_get_contents('http://korbball.turnverband.ch/ws/tableV1.php?group=' . $group), true);
					$this->view->jsonTable = $jsonTable;
				}
			} else {
				$jsonGroups = json_decode(file_get_contents("http://korbball.turnverband.ch/ws/groups.php"), true);
				$this->view->jsonGroups = $jsonGroups;
			}
		}
	}
}