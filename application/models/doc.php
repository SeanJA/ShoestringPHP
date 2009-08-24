<?php
class Doc extends sModel {
	function create($methodName, $comments, $example, $file){
		$q = new sQuery();
		$q->setInto('docs');
		$q->addField('method_name', $methodName);
		$q->addField('comments', $comments);
		$q->addField('example', $example);
		$q->addField('file', $file);
		return $q->insert();
	}
	function getDocs($fileName){
		$q = new sQuery();
		$q->from('docs');
		$q->addWhere('file', $fileName);
		return $q->selectAll();
	}
	function getDoc($id){
		$q = new sQuery();
		$q->from('docs');
		$q->addWhere('id', $id);
		return $q->selectRow();
	}
	function getFiles(){
		$q = new sQuery();
		$q->from('docs');
		$q->addColumn('file');
		$q->addOrder('file', 'ASC');
		$q->addGroupBy('file');
		$result = $q->selectAll();
		foreach($result as $res){
			$return[] = $res['file'];
		}
		return $return;
	}
	function update($id, $methodName, $comments, $example, $file){
		$q = new sQuery();
		$q->setInto('docs');
		$q->addWhere('id', $id);
		$q->addField('method_name', $methodName);
		$q->addField('comments', $comments);
		$q->addField('example', $example);
		$q->addField('file', $file);
		if(!$q->update()){
			return $q->getError();
		}
	}
	function delete($id){
		$q = new sQuery();
		$q->setFrom('docs');
		$q->addWhere('id', $id);
		return $q->delete();
	}
}
