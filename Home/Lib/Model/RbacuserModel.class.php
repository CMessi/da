<?php
	class RbacuserModel extends RelationModel{
		protected $_link=array(
			'Rbacrole'=>array(
				'mapping_type'=>MANY_TO_MANY,
				'foreign_key'=>'user_id',
				'relation_foreign_key'=>'role_id',
				'relation_table'=>'rbacroleuser',
				'mapping_fields'=>'id,name',
			)
		);		
	}

