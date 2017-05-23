<?php
	class RbacnodeModel extends RelationModel{		
		protected $_link=array(
			'Rbacnode'=>array(
				'mapping_type'=>HAS_MANY,
				'mapping_name'=>'node',
				'relation_order'=>'sort',
				'parent_key'=>'pid',
				'condition'=>'type=1',
			)
		);		
	}
