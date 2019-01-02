<?php
/**
 * DbCli
 * 
 * This class is used to make modification to the schema and database values. When new models
 * or fields in a model's schema are added, they can be updated to the database automatically.
 * 
 * php main/helium.php DbCli [functionanme]
 * 
 * Example
 * 
 * php main/helium.php DbCli schemacheck
 */
class DbCli {
	
	/**
	 * This function will iterate through the models and do a schemacheck. Schemachecks is when
	 * it checks the schema defined in the model, and attempts to replicate inside the database.
	 */
	public function schemacheck() {
		foreach(FileManager::getFilesInDirectory(PV_ROOT. DS. 'app/models/basic'.DS) as $key => $value) {
			$class_name = "app\models\basic\\".str_replace('.php', '', $value);
			
			echo $class_name. "\n";
			$object = new $class_name();
			$object -> checkSchema(true);
			
		}
	}

	
}
